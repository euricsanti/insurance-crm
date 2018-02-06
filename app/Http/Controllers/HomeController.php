<?php
/* Copyright © To Atul Sharma, all logic and code development belongs to his person and all involved in this proyect.
This code can be used to public or private proyects, with Creative Commons Law
Proyect belongs to Celeste Multimedia ©, for more information contact at www.celestemultimedia.com.do
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Session;
use DB;
use App\Task;
use App\Taskassign;
use App\User;
use App\Payment;
use App\Policy;
use App\Dependant;
use App\POS;
use App\Bankaccounts;
use View;
use Response;
use Illuminate\Support\Facades\Input;
use Mail;

class HomeController extends Controller {

    /**
     * Instance that controls the home dashboard
     *
     * @return void
     */
    public function __construct(Request $request, Validator $validator, Task $task, Taskassign $taskassign, Payment $payment, Policy $policy, POS $pos, Bankaccounts $bankaccounts, Dependant $dependant) {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->validator = $validator;
        $this->task = $task;
        $this->taskassign = $taskassign;
        $this->payment = $payment;
        $this->policy = $policy;
        $this->pos = $pos;
        $this->banksaccounts = $bankaccounts;
        $this->dependant = $dependant;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tasks = $this->task->orderBy('id', 'desc')->take(5)->get();
        $policies = $this->policy->count();
        $total_income = $this->pos->sum('pos_income');
        $last_month_total_income = $this->pos->whereMonth('created_at', date('m'))->sum('pos_income');
        $total_income_perc = ($total_income != 0) ? ($last_month_total_income / $total_income) * 100 : 0;
        $total_outcome = $this->pos->sum('pos_outcome');
        $last_month_total_outcome = $this->pos->whereMonth('created_at', date('m'))->sum('pos_outcome');
        $total_outcome_perc = ($total_outcome != 0) ? ($last_month_total_outcome / $total_outcome) * 100 : 0;
        $new_policies_reg = $this->policy->whereMonth('created_at', date('m'))->count();
        $policy_percentage = ($policies != 0) ? ($new_policies_reg / $policies) * 100 : 0;
        $total_payment = $this->policy->sum('total_payment_amount');
        $last_month_total_payment = $this->policy->whereMonth('created_at', date('m'))->sum('total_payment_amount');
        $total_payment_perc = ($total_payment != 0) ? ($last_month_total_payment / $total_payment) * 100 : 0;

        $bank_accounts = $this->banksaccounts->get();
        $policy_incomeindex = $this->policy->orderBy('id', 'desc')->take(5)->get();
        $dependantgraph = $this->dependant->orderBy('id', 'desc')->take(5)->get();
        return view('crm.dashboard', compact('tasks', 'policies', 'total_income', 'new_policies_reg', 'total_payment', 'policy_percentage', 'total_income_perc', 'total_payment_perc', 'total_outcome', 'total_outcome_perc', 'bank_accounts', 'policy_incomeindex', 'dependantgraph'));
    }

    public function homedaily() {
        $users = array();
        $tasks = $this->task->where('assigned', '=', 0)->paginate(5);
        $role = DB::table('roles')->where('name', '=', 'super_user')->select('id')->first();
        $role_user = DB::table('role_user')->where('role_id', '!=', $role->id)->select('user_id')->get();
        foreach ($role_user as $key => $r_user) {
            $usersobj = DB::table('users')->where('id', '=', $r_user->user_id)->first();
            $users[$usersobj->id] = $usersobj->name;
        }
        return View::make('crm.home.homedaily', compact('tasks', 'users'));
    }
/* This functions allows to select and asign tasks to users. */
    public function addtask() {
        return view('crm.home.addtask');
    }

    public function savetask() {
        $data = array(
            'tasknote' => $this->request->tasknote,
            'due_date' => $this->request->due_date
        );
        $rules = array(
            'tasknote' => 'required|max:350',
            'due_date' => 'required'
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            $this->task->tasknote = $this->request->tasknote;
            $this->task->user_id = Auth::id();
            $this->task->assigned = (int) 0;
            $this->task->due_date = $this->request->due_date;
            $this->task->status = 'pending';
            $this->task->save();
            Session::flash('success', 'La tarea ha sido agregada y asignada correctamente');
            return redirect('/home-daily');
        }
    }
/* Asign tasks to every user in the interface */

    public function assigntasks() {
        $data = array(
            'task_id' => $this->request->task_id,
            'assigned_user_id' => $this->request->assigned_user_id
        );
        $rules = array(
            'task_id' => 'required|integer',
            'assigned_user_id' => 'required|integer'
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Response::json(['success' => false, 'message' => $validator->getMessageBag()->toArray()]);
        } else {
            $this->taskassign->task_id = $this->request->task_id;
            $this->taskassign->assignee_user_id = Auth::id();
            $this->taskassign->assigned_user_id = $this->request->assigned_user_id;
            $this->taskassign->status = (int) 0;
            $this->taskassign->save();
            DB::table('tasks')->where('id', $this->request->task_id)->update(['assigned' => (int) 1]);
            /* $assign_user = User::findOrFail($this->request->assigned_user_id);

              Mail::send('emails.reminder', ['user' => $assign_user], function ($m) use ($user) {
              $m->from('hello@app.com', 'Your Application');

              $m->to($assign_user->email, $assign_user->name)->subject('La siguiente tarea ha sido asignada');
              }); */
            Session::flash('success', 'Tarea asignada con éxito');
            return Response::json(['success' => true, 'redirect_url' => url('/home-daily')]);
        }
    }

    public function assignedtasks() {
        $assignedtasks = DB::table('taskassign')->join('tasks', 'taskassign.task_id', '=', 'tasks.id')->join('users', 'taskassign.assigned_user_id', '=', 'users.id')->select('tasks.tasknote', 'taskassign.*', 'users.name')->paginate(5);
        return View::make('crm.home.assignedtasks', compact('assignedtasks'));
    }

    public function deletenote() {
        if ($this->request->user_id == Auth::id()) {
            $task = $this->task->findOrFail($this->request->id);
            $task->delete();
            Session::flash('success', 'Tarea eliminada con éxito');
            return redirect('/home-daily');
        } else {
            Session::flash('errors', 'No tiene permiso para eliminar esta tarea');
            return redirect('/home-daily');
        }
    }

    public function markcomplete() {
        $data = array(
            'task_id' => $this->request->task_id
        );
        $rules = array(
            'task_id' => 'required|integer'
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Response::json(['success' => false, 'message' => $validator->getMessageBag()->toArray()]);
        } else {
            $assigned_user_id = DB::table('taskassign')->where('id', '=', $this->request->task_id)->value('assigned_user_id');
            //if (Auth::id() == $assigned_user_id) {
				$task_id = DB::table('taskassign')->where('id', '=', $this->request->task_id)->value('task_id');
                DB::table('taskassign')->where('id', $this->request->task_id)->update(['status' => (int) 1]);
				DB::table('tasks')->where('id', $task_id)->update(['status' => 'completed']);
                Session::flash('success', 'Tarea completada');
                return Response::json(['success' => true, 'redirect_url' => url('/home-daily')]);

        }
    }

    public function homecalender() {
        $events = [];
        //$payments = $this->payment->get();
        $payments = DB::table('policies')
                ->join('dependants', 'dependants.policy_id', '=', 'policies.id')
                ->select('policies.*', 'dependants.*')
                ->get();
        foreach ($payments as $key => $payment) {
            $duedate = strtotime($payment->policy_end_date);
            $todaydate = strtotime(date('Y-m-d H:i:s'));
            $color = ($duedate >= $todaydate) ? '#B1F140' : '#F3684A';

            $events[] = \Calendar::event(
                            $payment->policy_no, true, new \DateTime($payment->policy_end_date), new \DateTime($payment->policy_end_date), $payment->id, [
                        'url' => 'javascript:void(0)',
                        'color' => $color,
                        'backgroundColor' => $color,
                        'textColor' => 'white',
                        'className' => 'calender-event',
                            ]
            );
        }

        $calendar = \Calendar::addEvents($events);

        return view('crm.home.homecalender', compact('calendar'));
    }

}
