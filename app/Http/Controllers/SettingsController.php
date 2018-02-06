<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Session;
use DB;
use App\User;
use App\Bank;
use View;
use Response;
use Illuminate\Support\Facades\Input;
use Mail;
use File;

class SettingsController extends Controller {

    public function __construct(Request $request, Validator $validator, Bank $bank) {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->validator = $validator;
        $this->bank = $bank;
    }

    public function index() {
        $banks = DB::table('banks')
                ->select('*')
                ->paginate(5);

        return View::make('crm.settings.bank.banksview', compact('banks'));
    }

    public function addbank() {
        return View::make('crm.settings.bank.addbank', compact('banks'));
    }

    public function savebank() {
        $data = array(
            'bank_name' => $this->request->bank_name,
            'bk_account_number' => $this->request->bk_account_number,
        );
        $rules = array(
            'bank_name' => 'required|max:255',
            'bk_account_number' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            $this->bank->bank_name = $this->request->bank_name;
            $this->bank->bk_account_number = $this->request->bk_account_number;
            $this->bank->user_id = Auth::id();
            $this->bank->user_name = Auth::user()->name;
            $this->bank->save();
            Session::flash('success', 'Banco agregado con éxito');
            return redirect('/banksview');
        }
    }

}
