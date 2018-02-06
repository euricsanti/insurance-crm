<?php
/* Copyright © To Atul Sharma, all logic and code development belongs to his person and all involved in this proyect.
This code can be used to public or private proyects, with Creative Commons Law
Proyect belongs to Celeste Multimedia ©, for more information contact at www.celestemultimedia.com.do
*/
/*This is the whole controler for the accounting functions */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Session;
use DB;
use App\Payment;
use App\Manage_pos;
use App\User;
use App\POS;
use App\Bankaccounts;
use DateTime;
use View;
use Response;
use Illuminate\Support\Facades\Input;
use Mail;

class AccountingController extends Controller {

    public function __construct(Request $request, Validator $validator, Payment $payment, POS $pos, Manage_pos $Manage_pos) {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->validator = $validator;
        $this->payment = $payment;
        $this->pos = $pos;
        $this->manage_pos = $Manage_pos;
    }

    public function homepos() {
        $banks = DB::table('banks')
                ->select('*')
                ->get();

		$manage_pos = DB::table('manage_pos')->latest()->first();
        return View::make('crm.accounting.pos', compact('banks','manage_pos'));
    }

	public function bkaccno(){
		$bk_account_no = DB::table('banks')
							->select('bk_account_number')
							->where('id', '=',$this->request->bank_id)
							->first();
		if (isset($bk_account_no) && !empty($bk_account_no)) {
            return Response::json(['success' => true, 'res' => $bk_account_no]);
        } else {
            return Response::json(['success' => false, 'res' => 'No account number']);
        }
	}

    public function searchpos() {
        $searchObj = DB::table('dependants')
                        ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                        ->select('policies.*', 'dependants.*')
                        ->where('policies.policy_no', 'like', '%' . $this->request->policy_no . '%')
                        ->where('dependants.affiliate_no', 'like', '%' . $this->request->affiliate_no . '%')
                        ->where('dependants.name', 'like', '%' . $this->request->name . '%')
                        ->where('dependants.surname', 'like', '%' . $this->request->surname . '%')
                        //->whereDate('policies.policy_end_date', '>=', date('Y-m-d'))
                        ->where('dependants.status', '=', 1)
                        ->get()->toArray();
        if (isset($searchObj) && !empty($searchObj)) {
            return Response::json(['success' => true, 'res' => $searchObj]);
        } else {
            return Response::json(['success' => false, 'res' => 'No Match Found']);
        }
    }

	public function openpos(){
		if(isset($this->request->open_pos) && !empty($this->request->open_pos)){
			if($this->request->open_pos_id == '' && empty($this->request->open_pos_id)){
				$manage_pos = DB::table('manage_pos')
									->where('created', '=', date('Y-m-d'))
									->count();

				if($manage_pos<= 4){
					$manage_pos = DB::table('manage_pos')->latest()->first();
					if(isset($manage_pos) && !empty($manage_pos)){
						if($manage_pos->status == 'open'){
							Session::flash('errors', 'La caja ya fue abierta');
							return redirect('/home-pos');
						}else{
							$this->manage_pos->open_pos_id = 'POS-open-d-'.md5(uniqid(rand(), true));
							$this->manage_pos->user_id = Auth::id();
							$this->manage_pos->created = date('Y-m-d');
							$this->manage_pos->wake_time = date("H:i");
							$this->manage_pos->sleep_time = '';
							$this->manage_pos->status = 'open';
							$this->manage_pos->save();
							Session::flash('success', 'Movimiento editado exitosamente');
							return redirect('/home-pos');
						}
					}else{
						$this->manage_pos->open_pos_id = 'POS-open-d-'.md5(uniqid(rand(), true));
						$this->manage_pos->user_id = Auth::id();
						$this->manage_pos->created = date('Y-m-d');
						$this->manage_pos->wake_time = date("H:i");
						$this->manage_pos->sleep_time = '';
						$this->manage_pos->status = 'open';
						$this->manage_pos->save();
						Session::flash('success', 'Movimiento editado exitosamente');
						return redirect('/home-pos');
					}

				}else{
					Session::flash('errors', 'Ha alcanzado el límite de cajas de abiertas en 24 horas');
					return redirect('/home-pos');
				}
			}
		}
	}

	public function closepos(){
		if(isset($this->request->close_pos) && !empty($this->request->close_pos)){
			if(isset($this->request->open_pos_id) && !empty($this->request->open_pos_id)){
				$manage_pos = DB::table('manage_pos')
									->where('created', '=', date('Y-m-d'))
									->count();

				if($manage_pos<= 4){
					$manage_pos = DB::table('manage_pos')->latest()->first();
					if(isset($manage_pos) && !empty($manage_pos)){
						if($manage_pos->status == 'close'){
							Session::flash('errors', 'Debe abrir la caja antes de cerrarla :-)');
							return redirect('/home-pos');
						}else{
							$manage_pos_id = DB::table('manage_pos')
											->select('id')
											->where('open_pos_id', '=', $this->request->open_pos_id)
											->first();
							if($manage_pos_id){
								DB::table('manage_pos')
										->where('id', $manage_pos_id->id)
										->update([
											'sleep_time' => date('H:i'),
											'status' => 'close',
								]);
								DB::table('point_of_sales')
										->where('open_pos_id', $this->request->open_pos_id)
										->update([
											'status' => 1,
								]);
								Session::flash('success', 'La caja ha sido cerrada exitosamente');
								return redirect('/home-pos');
							}
						}
					}

				}else{
					Session::flash('errors', 'Límite de cajas cerradas alcanzado en 24 horas');
					return redirect('/home-pos');
				}
			}else{
				Session::flash('errors', 'Por favor, primero abra la caja');
				return redirect('/home-pos');
			}
		}
	}

    public function pospay() {
		if($this->request->open_pos_id){
			$data = array(
				'pos_type_of_payment' => $this->request->pos_type_of_payment,
				'pos_refrence' => $this->request->pos_refrence,
				'pos_date' => $this->request->pos_date,
				'pos_input_amount' => $this->request->pos_input_amount,
				'pos_amount_due' => $this->request->pos_amount_due
			);
			$rules = array(
				'pos_type_of_payment' => 'required',
				'pos_refrence' => 'required',
				'pos_date' => 'required',
				'pos_input_amount' => 'required|between:1,1000000.99',
				'pos_amount_due' => 'required|between:1,1000000.99'
			);
			$validator = Validator::make($data, $rules);
			if ($validator->fails()) {
				Session::flash('error', 'Algo ha fallado, por favor llene todo correctamente');
				//print_r($validator->getMessageBag()->toArray());
				return Response::json(['success' => false, 'redirect_url' => route('homepos')]);
				//return Response::json(['success' => false, 'message' => $validator->getMessageBag()->toArray()]);
			} else {
				$dependants = DB::table('dependants')
						->join('policies', 'dependants.policy_id', '=', 'policies.id')
						->select('policies.policy_no', 'policies.total_payment_amount', 'dependants.*')
						->where('dependants.policy_id', '=', $this->request->pos_policy_id)
						->where('dependants.status', '=', 1)
						->get();
				$income = $this->request->pos_input_amount;
				$amount_left = (int) $this->request->pos_amount_due - (int) $income;
				DB::table('dependants')
						->where('id', $this->request->pos_dependant_id)
						->update([
							'amount_left' => $amount_left
				]);
				$policy = DB::table('policies')
						->where('id', $this->request->pos_policy_id)
						->first();
				$date = $policy->policy_end_date;
				if ($policy->policy_payment_type == 'Mensual') {
					$date = $this->add_date($policy->policy_end_date, 1);
				} else if ($policy->policy_payment_type == 'Trimestral') {
					$date = $this->add_date($policy->policy_end_date, 3);
				} else if ($policy->policy_payment_type == 'Semestral') {
					$date = $this->add_date($policy->policy_end_date, 6);
				} else if ($policy->policy_payment_type == 'Anual') {
					$date = $this->add_date($policy->policy_end_date, 12);
				}
				DB::table('policies')
						->where('id', $this->request->pos_policy_id)
						->update([
							'policy_end_date' => $date
				]);
				if ($this->request->pos_type_of_payment == 'Efectivo') {
					$this->pos->pos_dependant_id = $this->request->pos_dependant_id;
					$this->pos->pos_policy_id = $this->request->pos_policy_id;
					$this->pos->open_pos_id = $this->request->open_pos_id;
					$this->pos->pos_type_of_payment = $this->request->pos_type_of_payment;
					$this->pos->pos_amount = $this->request->pos_amount;
					$this->pos->pos_input_amount = $this->request->pos_input_amount;
					$this->pos->pos_status = 'Income';
					$this->pos->pos_income = $income;
					$this->pos->pos_outcome = 0;
					$this->pos->pos_refrence = $this->request->pos_refrence;
					$this->pos->pos_date = $this->request->pos_date;
					$this->pos->status = 0;
					$this->pos->user_id = Auth::id();
					$this->pos->save();
				} else if ($this->request->pos_type_of_payment == 'Depósito-Bancario') {
					$array = array(
						'id' => $this->request->pos_bank_info,
						'bank_acc' => $this->request->bank,
					);
					$bankjson = json_encode($array);
					$this->pos->pos_dependant_id = $this->request->pos_dependant_id;
					$this->pos->pos_policy_id = $this->request->pos_policy_id;
					$this->pos->open_pos_id = $this->request->open_pos_id;
					$this->pos->pos_input_amount = $this->request->pos_input_amount;
					$this->pos->pos_status = 'Income';
					$this->pos->pos_income = $income;
					$this->pos->pos_outcome = 0;
					$this->pos->pos_type_of_payment = $this->request->pos_type_of_payment;
					$this->pos->posbankinfo = $bankjson;
					$this->pos->pos_refrence = $this->request->pos_refrence;
					$this->pos->pos_date = $this->request->pos_date;
					$this->pos->status = 0;
					$this->pos->user_id = Auth::id();
					$this->pos->save();
					$balance = DB::table('banks')
							->select('balance')
							->where('id', $this->request->pos_bank_info)
							->first();
					$total = (int) $balance->balance + (int) $income;
					DB::table('banks')
							->where('id', $this->request->pos_bank_info)
							->update([
								'balance' => $total
					]);
				} else {
					$this->pos->pos_dependant_id = $this->request->pos_dependant_id;
					$this->pos->pos_policy_id = $this->request->pos_policy_id;
					$this->pos->open_pos_id = $this->request->open_pos_id;
					$this->pos->pos_input_amount = $this->request->pos_input_amount;
					$this->pos->pos_status = 'Income';
					$this->pos->pos_income = $income;
					$this->pos->pos_outcome = 0;
					$this->pos->pos_type_of_payment = $this->request->pos_type_of_payment;
					$this->pos->pos_refrence = $this->request->pos_refrence;
					$this->pos->pos_date = date('Y-m-d');
					$this->pos->status = 0;
					$this->pos->user_id = Auth::id();
					$this->pos->save();
				}

				Session::flash('success', 'Pago Asignado');
				return Response::json([ 'success' => true, 'redirect_url' => route(
									'homepos')]);
			}
		}

    }

    public function homeaccounting() {
        return View::make('crm.accounting.movementaccounts');
    }

    public function showposmovements() {
        $point_of_sales = DB::table('point_of_sales')
                        ->join('policies', 'policies.id', '=', 'point_of_sales.pos_policy_id')
                        ->join('dependants', 'dependants.id', '=', 'point_of_sales.pos_dependant_id')
                        ->join('users', function ($join) {
                            $join->on('users.id', '=', 'point_of_sales.user_id');
                        })
                        ->select('point_of_sales.*', 'policies.policy_no', 'policies.total_payment_amount', 'dependants.affiliate_no', 'users.name as username')
                        ->whereBetween('point_of_sales.pos_date', array($this->request->start, $this->request->end))
                        ->where('dependants.status', '=', 1)
                        ->where('point_of_sales.status', '=', 1)
                        ->get()->toArray();
        if (isset($point_of_sales) && !empty($point_of_sales)) {
            return Response::json([ 'success' => true, 'res' => $point_of_sales, 'url' => url('/')]);
        } else {
            return Response::json([ 'success' => false, 'res' =>
                        'No data found']);
        }
    }

    public function viewmovement($id) {
        $movement = $point_of_sales = DB::table('point_of_sales')
                ->join('policies', 'policies.id', '=', 'point_of_sales.pos_policy_id')
                ->join('dependants', 'dependants.id', '=', 'point_of_sales.pos_dependant_id')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'point_of_sales.user_id');
                })->select('point_of_sales.*', 'policies.*', 'dependants.*', 'users.name as username')
                ->where('point_of_sales.id', $id)
                ->where('dependants.status', '=', 1)
                ->first();
        return View::make('crm.accounting.viewmovement', compact('movement'));
    }

    public function editmovement($id) {
        $movement = $point_of_sales = DB::table('point_of_sales')
                ->join('policies', 'policies.id', '=', 'point_of_sales.pos_policy_id')
                ->join('dependants', 'dependants.id', '=', 'point_of_sales.pos_dependant_id')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'point_of_sales.user_id');
                })->select('point_of_sales.*', 'policies.*', 'dependants.*', 'users.name as username')
                ->where('point_of_sales.id', $id)
                ->where('dependants.status', '=', 1)
                ->first();
        return View::make('crm.accounting.editmovement', compact('movement'));
    }

    public function saveeditmovement($id) {
        $user = Auth::user();
        if ($user->hasRole('super_user')) {
            $data = array(
                'pos_refrence' => $this->request->edit_pos_refrence,
                'pos_date' => $this->request->edit_pos_date,
            );
            $rules = array(
                'pos_refrence' => 'required|max:255',
                'pos_date' => 'required',
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
            } else {
                DB::table('point_of_sales')
                        ->where('id', $id)
                        ->update([
                            'pos_refrence' => $this->request->edit_pos_refrence,
                            'pos_date' => $this->request->edit_pos_date,
                            'user_id' => Auth::id(),
                ]);
                Session::flash('success', 'Movimiento editado exitosamente');
                return redirect('/home-accounting');
            }
        } else {
            Session::flash('errors', 'No esta autorizado a realizar este movimiento');
            return redirect('/home-accounting');
        }
    }

    /* public function todaytotal() {
      $data = array(
      'date' => $this->request->date
      );
      $rules = array(
      'date' => 'required'
      );
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
      return Response::json([ 'success' => false, 'res' => $validator->getMessageBag()->toArray()]);
      } else {
      $total = DB::table('due_payments')
      ->whereDate('duedate', '<=', $this->request->date)
      ->get()->toArray();
      if (!empty($total) && isset($total)) {
      return Response::json([ 'success' => true, 'res' => $total]);
      } else {
      return Response::json([ 'success' => false, 'res' => 'No due payment balance found']);
      }
      }
      } */

    public function duepayment() {
        $duepayments = $this->payment->paginate(5);
        return View::make('crm.accounting.duepayment', compact('duepayments'));
    }

    public function deleteduepayment() {
        $duepayment = $this->payment->findOrFail($this->request->id);
        $duepayment->delete();
        Session::flash('success', 'Eliminado exitosamente');
        return redirect('/duepayment');
    }

    public function addduepayment() {
        return View::make('crm.accounting.addduepayment');
    }

    public function saveduepayment() {
        $data = array(
            'title' => $this->request->title,
            'duedate' => $this->request->duedate,
            'reference' => $this->request->reference,
        );
        $rules = array(
            'title' => 'required|max:255',
            'duedate' => 'required',
            'reference' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            $this->payment->title = $this->request->title;
            $this->payment->duedate = $this->request->duedate;
            $this->payment->reference = $this->request->reference;
            $this->payment->user_id = Auth::id();
            $this->payment->user_name = Auth::user()->name;
            $this->payment->save();
            Session::flash('success', 'Pago agregado con exito');
            return redirect('/duepayment');
        }
    }

    public function editduepayment($id) {
        $edit_payment = $this->payment->find($id);
        return View::make('crm.accounting.editduepayment', compact('edit_payment'));
    }

    public function saveeditduepayment($id) {
        $user = Auth::user();
        if ($user->hasRole('super_user')) {
            $data = array(
                'edit_title' => $this->request->edit_title,
                'edit_duedate' => $this->request->edit_duedate,
                'edit_reference' => $this->request->edit_reference,
            );
            $rules = array(
                'edit_title' => 'required|max:255',
                'edit_duedate' => 'required',
                'edit_reference' => 'required',
            );
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
            } else {
                DB::table('due_payments')
                        ->where('id', $id)
                        ->update([
                            'title' => $this->request->edit_title,
                            'duedate' => $this->request->edit_duedate,
                            'reference' => $this->request->edit_reference,
                            'user_id' => Auth::id(),
                            'user_name' => Auth::user()->name
                ]);
                Session::flash('success', 'Pago editado con exito');
                return redirect('/duepayment');
            }
        } else {
            Session::flash('errors', 'No esta autorizado a editar este pago');
            return redirect('/duepayment');
        }
    }

    public function duedepandants() {
        $pendingdues = DB::table('dependants')
                ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                ->select('policies.*', 'dependants.*')
                ->whereDate('policies.policy_end_date', '<', date('Y-m-d'))
                ->paginate(5);
        $banks = DB::table('banks')
                ->select('*')
                ->get();
        return View::make('crm.accounting.pendingdues', compact('pendingdues', 'banks'));
    }

    public function pendingdueoutcome() {
        $data = array(
            'outcome_refrence' => $this->request->outcome_refrence,
            'outcome_date' => $this->request->outcome_date,
            'outcome_input_amount' => $this->request->outcome_input_amount,
            'outcome_bank_info' => $this->request->outcome_bank_info,
        );
        $rules = array(
            'outcome_refrence' => 'required',
            'outcome_date' => 'required',
            'outcome_input_amount' => 'required',
            'outcome_bank_info' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            Session::flash('errors', 'Algo anda mal, por favor llena todos los campos');
            return Response::json(['success' => false, 'redirect_url' => route('duedepandants')]);
            //return Response::json(['success' => false, 'message' => $validator->getMessageBag()->toArray()]);
        } else {
            $array = array(
                'bank_name' => $this->request->outcome_bank_info
            );
            $bankjson = json_encode($array);
            $dependants = DB::table('dependants')
                    ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                    ->select('policies.policy_no', 'policies.total_payment_amount', 'dependants.*')
                    ->where('dependants.policy_id', '=', $this->request->outcome_policy_id)
                    ->where('dependants.status', '=', 1)
                    ->get();
            $policy = DB::table('policies')
                    ->where('id', $this->request->outcome_policy_id)
                    ->first();
            $date = $policy->policy_end_date;
            if ($policy->policy_payment_type == 'Mensual') {
                $date = $this->add_date($policy->policy_end_date, 1);
            } else if ($policy->policy_payment_type == 'Trimestral') {
                $date = $this->add_date($policy->policy_end_date, 3);
            } else if ($policy->policy_payment_type == 'Semestral') {
                $date = $this->add_date($policy->policy_end_date, 6);
            } else if ($policy->policy_payment_type == 'Anual') {
                $date = $this->add_date($policy->policy_end_date, 12);
            }
            DB::table('policies')
                    ->where('id', $this->request->outcome_policy_id)
                    ->update([
                        'policy_end_date' => $date
            ]);
            $outcome = $this->request->outcome_input_amount;
            $this->pos->pos_dependant_id = $this->request->outcome_dependant_id;
            $this->pos->pos_policy_id = $this->request->outcome_policy_id;
            $this->pos->pos_status = 'Outcome';
            $this->pos->pos_income = 0;
            $this->pos->pos_outcome = $outcome;
            $this->pos->posbankinfo = $bankjson;
            $this->pos->pos_refrence = $this->request->outcome_refrence;
            $this->pos->pos_date = $this->request->outcome_date;
            $this->pos->user_id = Auth::id();
            $this->pos->save();
            $balance = DB::table('banks')
                    ->select('balance')
                    ->where('bank_name', $this->request->outcome_bank_info)
                    ->first();
            $total = $balance->balance - $outcome;
            DB:: table('banks')
                    ->where('bank_name', $this->request->outcome_bank_info)
                    ->update([
                        'balance' => $total
            ]);
            Session::flash('success', 'Outcome Assigned');
            return Response::json([ 'success' => true, 'redirect_url' => route(
                                'duedepandants')]);
        }
    }

    public function add_date($date_str, $months) {
        $date = new DateTime($date_str);

        // We extract the day of the month as $start_day
        $start_day = $date->format('Y-m-d');

        // We add 1 month to the given date
        $date->modify("+{$months} month");

        // We extract the day of the month again so we can compare
        $end_day = $date->format('Y-m-d');

        if ($start_day != $end_day) {
            // The day of the month isn't the same anymore, so we correct the date
            $date->modify('last day of last month');
        }

        return $end_day;
    }

}
