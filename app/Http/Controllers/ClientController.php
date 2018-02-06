<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Session;
use DB;
use App\Policy;
use App\Dependant;
use App\User;
use View;
use Response;
use Illuminate\Support\Facades\Input;
use Mail;
use File;

class ClientController extends Controller {

    public function __construct(Request $request, Validator $validator, Policy $policy, Dependant $dependant) {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->validator = $validator;
        $this->policy = $policy;
        $this->dependant = $dependant;
    }

    public function index() {
        $dependants = DB::table('dependants')
                ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                ->select('policies.policy_no', 'dependants.*', 'policies.policy_payment_type', 'policies.policy_end_date')
                ->paginate(25);
        return View::make('crm.client.index', compact('dependants'));
    }

    public function addpolicy() {
        return View::make('crm.client.addpolicy');
    }

    public function savepolicy() {
        $data = array(
            'type_of_policy' => $this->request->type_of_policy,
            'policy_no' => $this->request->policy_no,
            'insurance_company' => $this->request->insurance_company,
            'total_payment_amount' => $this->request->total_payment_amount
        );
        $rules = array(
            'type_of_policy' => 'required|max:255',
            'policy_no' => 'required',
            'insurance_company' => 'required',
            'total_payment_amount' => 'required|between:1,10000000.99'
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            $date = date('Y-m-d');
            if ($this->request->policy_payment_type == 'Mensual') {
                $date = date("Y-m-d", strtotime("+1 month"));
            } else if ($this->request->policy_payment_type == 'Trimestral') {
                $date = date("Y-m-d", strtotime("+3 month"));
            } else if ($this->request->policy_payment_type == 'Semestral') {
                $date = date("Y-m-d", strtotime("+6 month"));
            } else if ($this->request->policy_payment_type == 'Anual') {
                $date = date("Y-m-d", strtotime("+1 year"));
            }

            $this->policy->type_of_policy = $this->request->type_of_policy;
            $this->policy->policy_no = $this->request->policy_no;
            $this->policy->insurance_company = $this->request->insurance_company;
            $this->policy->total_payment_amount = $this->request->total_payment_amount;
            $this->policy->policy_end_date = $date;
            $this->policy->user_id = Auth::id();
            $this->policy->policy_payment_type = $this->request->policy_payment_type;
            $this->policy->save();
            Session::flash('success', 'La poliza ha sido agregada correctamente');
            return redirect('/home-client');
        }
    }

    public function adddependant() {
        $policies = $this->policy->get();
        return View::make('crm.client.adddependant', compact('policies'));
    }

    public function savedependant() {
        $data = array(
            'name' => $this->request->name,
            'surname' => $this->request->surname,
            'affiliate_no' => $this->request->affiliate_no,
            'nss' => $this->request->nss,
            'registry_date' => $this->request->registry_date,
            'end_contract_date' => $this->request->end_contract_date,
            'plan_type' => $this->request->plan_type,
            'payment_type' => $this->request->payment_type,
            'policy_id' => $this->request->policy_id,
            'policy_amount' => $this->request->policy_amount,
            'relation' => $this->request->relation,
            'file_attachment' => Input::file('file_attachment')
        );
        $rules = array(
            'name' => 'required|max:255',
            'surname' => 'required',
            'affiliate_no' => 'required',
            'nss' => '',
            'registry_date' => '',
            'end_contract_date' => 'required',
            'plan_type' => 'required',
            'payment_type' => 'required',
            'policy_id' => 'required',
            'policy_amount' => 'required|between:1,10000000.99',
            'relation' => 'required',
            'file_attachment' => 'ng-required|file|mimes:jpeg,jpg,png,doc,pdf,html,gif,docx,xls,xlsx,ppt,pptx,|max:40000',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            if ($this->request->policy_id) {
                $destinationPath = 'attachments/';
                if (Input::file('file_attachment')) {
                    $filename = mt_rand() . '.' . Input::file('file_attachment')->getClientOriginalExtension();
                    Input::file('file_attachment')->move($destinationPath, $filename);
                } else {
                    $filename = 'noinmage123.png';
                }

                $this->dependant->name = $this->request->name;
                $this->dependant->surname = $this->request->surname;
                $this->dependant->affiliate_no = $this->request->affiliate_no;
                $this->dependant->nss = $this->request->nss;
                $this->dependant->user_id = Auth::id();
                $this->dependant->registry_date = $this->request->registry_date;
                $this->dependant->end_contract_date = $this->request->end_contract_date;
                $this->dependant->plan_type = $this->request->plan_type;
                $this->dependant->payment_type = $this->request->payment_type;
                $this->dependant->policy_id = $this->request->policy_id;
                $this->dependant->policy_amount = $this->request->policy_amount;
                $this->dependant->relation = $this->request->relation;
                $this->dependant->amount_left = 0;
                $this->dependant->file_attachment = $destinationPath . $filename;
                $this->dependant->status = 1;
                $this->dependant->save();
                Session::flash('success', 'Dependiente agregado con éxito');
                return redirect('/home-client');
            } else {
                Session::flash('errors', 'Es necesario agregar la póliza primero');
                return redirect('/home-client');
            }
        }
    }

    public function listclient() {
        $policy = '';
        if (isset($_GET['list_policy']) && !empty($_GET['list_policy'])) {
            $policy = ($_GET['list_policy']) ? trim($_GET['list_policy']) : '';
        }
        if ($policy != '') {
            $listclients = DB::table('dependants')
                    ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                    ->select('policies.*', 'dependants.*')
                    ->where('policies.id', '=', $policy)
                    ->where('dependants.status', '=', 1)
                    ->get();
        } else {
            $listclients = DB::table('dependants')
                    ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                    ->select('policies.*', 'dependants.*')
                    ->where('dependants.status', '=', 1)
                    ->get();
        }

        $policy_type = Policy::pluck('type_of_policy', 'id')->all();
        return View::make('crm.client.listclient', compact('listclients', 'policy_type'));
    }

    public function viewclient($id) {
        $viewclient = DB::table('dependants')
                ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                ->select('policies.*', 'dependants.*')
                ->where('dependants.id', '=', $id)
                ->where('dependants.status', '=', 1)
                ->first();
        $user = User::find($viewclient->user_id);
        return View::make('crm.client.viewclient', compact('viewclient', 'user'));
    }

    public function showattachment() {
        $viewattachemnt = Dependant::find($this->request->id);
        return Response::json(['success' => true, 'res' => url('/') . '/' . $viewattachemnt->file_attachment]);
    }

    public function policyamount() {
        if ($this->request->policyid != '') {
            $policyamount = DB::table('policies')
                    ->select('total_payment_amount')
                    ->where('id', '=', $this->request->policyid)
                    ->first();
            $dependants_no = DB::table('dependants')
                    ->select('*')
                    ->where('policy_id', '=', $this->request->policyid)
                    ->where('status', '=', 1)
                    ->get();
            $count = count($dependants_no);
            $count = ($count == 0) ? 1 : $count;
            $amount = $policyamount->total_payment_amount / $count;
            if (is_object($policyamount) && !empty($policyamount)) {
                return Response::json(['success' => true, 'data' => $amount]);
            } else {
                return Response::json(['success' => false, 'data' => 'failed']);
            }
        }
    }

    public function listuser() {
        $users = DB::table('dependants')
                ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                ->select('policies.*', 'dependants.*')
                ->get();
		return View::make('crm.client.listuser', compact('users'));
    }

    public function viewuser($id) {
        $policies = Policy::pluck('policy_no', 'id')->all();
        $user = DB::table('dependants')
                ->select('*')
                ->where('id', '=', $id)
                ->first();
        return View::make('crm.client.viewuser', compact('user', 'policies'));
    }

    public function edituser() {
        $data = array(
            'name' => $this->request->name,
            'surname' => $this->request->surname,
            'affiliate_no' => $this->request->affiliate_no,
            'nss' => $this->request->nss,
            'registry_date' => $this->request->registry_date,
            'end_contract_date' => $this->request->end_contract_date,
            'plan_type' => $this->request->plan_type,
            'payment_type' => $this->request->payment_type,
            'policy_id' => $this->request->policy_id,
            'policy_amount' => $this->request->policy_amount,
            'relation' => $this->request->relation
        );
        $rules = array(
            'name' => 'required|max:255',
            'surname' => 'required',
            'affiliate_no' => 'required',
            'nss' => '',
            'registry_date' => '',
            'end_contract_date' => 'required',
            'plan_type' => 'required',
            'payment_type' => 'required',
            'policy_id' => 'required',
            'policy_amount' => 'required|between:1,10000.99',
            'relation' => 'required'
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            if ($this->request->policy_id) {
                $newflname = '';
                if (Input::file('file_attachment')) {
                    $destinationPath = 'attachments/';
                    $filename = mt_rand() . '.' . Input::file('file_attachment')->getClientOriginalExtension();
                    $newflname = $destinationPath . $filename;
                    Input::file('file_attachment')->move($destinationPath, $filename);
                } else {
                    $newflname = $this->request->old_attachment;
                }
                DB::table('dependants')
                        ->where('id', $this->request->dependant_id)
                        ->update([
                            'name' => $this->request->name,
                            'surname' => $this->request->surname,
                            'affiliate_no' => $this->request->affiliate_no,
                            'nss' => $this->request->nss,
                            'user_id' => Auth::id(),
                            'registry_date' => $this->request->registry_date,
                            'end_contract_date' => $this->request->end_contract_date,
                            'plan_type' => $this->request->plan_type,
                            'payment_type' => $this->request->payment_type,
                            'policy_id' => $this->request->policy_id,
                            'policy_amount' => $this->request->policy_amount,
                            'relation' => $this->request->relation,
                            'file_attachment' => $newflname,
                            'status' => 1
                ]);
                Session::flash('success', 'El dependiente ha sido editado con éxito');
                return redirect('/listuser');
            } else {
                Session::flash('errors', 'Debe agregar primero la póliza');
                return redirect('/listuser');
            }
        }
    }

    public function deactivateuser() {
        if ($this->request->ajax()) {
            $dependant_id = $this->request->dependant_id;
            DB::table('dependants')
                    ->where('id', $dependant_id)
                    ->update([
                        'status' => 0
            ]);
            Session::flash('success', 'Dependiente Anulado');
            echo json_encode(array('success' => TRUE, 'redirect_url' => url('/listuser')));
            die();
        } 
        return "HTTP";
    }

    public function activateuser() {
        if ($this->request->ajax()) {
            $dependant_id = $this->request->dependant_id;
            DB::table('dependants')
                    ->where('id', $dependant_id)
                    ->update([
                        'status' => 1
            ]);
            Session::flash('success', 'Dependiente reactivado');
            echo json_encode(array('success' => TRUE, 'redirect_url' => url('/listuser')));
            die();
        }
        return "HTTP";
    }

    public function viewpayment($id) {
        $viewpayments = DB::table('point_of_sales')
                ->join('policies', 'policies.id', '=', 'point_of_sales.pos_policy_id')
                ->join('dependants', 'dependants.id', '=', 'point_of_sales.pos_dependant_id')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'point_of_sales.user_id');
                })
                ->select('point_of_sales.*', 'policies.policy_no', 'policies.total_payment_amount', 'dependants.affiliate_no', 'users.name as username')
                ->where('point_of_sales.pos_dependant_id', $id)
                ->where('dependants.status', '=', 1)
                ->paginate(25);
        return View::make('crm.client.viewpayments', compact('viewpayments'));
    }

}
