<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Session;
use DB;
use App\User;
use App\Policy;
use App\Rating;
use View;
use Response;
use Illuminate\Support\Facades\Input;
use Mail;

class HumanResourceController extends Controller {

    public function __construct(Request $request, Validator $validator, Rating $rating) {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->validator = $validator;
        $this->rating = $rating;
    }

    public function index() {
        $users = DB::table('dependants')
                ->join('policies', 'dependants.policy_id', '=', 'policies.id')
                ->select('policies.*', 'dependants.*')
                ->where('dependants.status', '=', 1)
                ->paginate(5);
        return View::make('crm.humanresource.index', compact('users'));
    }

    public function rating($id) {
        return View::make('crm.humanresource.ratingview', compact('id'));
    }

    public function rateuser() {
        $data = array(
            'rating' => $this->request->rating,
            'rating_note' => $this->request->rating_note,
            'dependant_id' => $this->request->dependant_id
        );
        $rules = array(
            'rating' => 'required|integer',
            'rating_note' => 'required',
            'dependant_id' => 'required'
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            $this->rating->dependant_id = $this->request->dependant_id;
            $this->rating->rating = $this->request->rating;
            $this->rating->rating_note = $this->request->rating_note;
            $this->rating->save();
            Session::flash('success', 'Rating Added');
            return redirect('/humanresource');
        }
    } 

	public function pendingtasks(){
		$pending_tasks = DB::table('tasks')
						->select('tasknote','due_date','status')
                        ->where('user_id', Auth::id())
                        ->where('status', 'pending')
                        ->paginate(5);
        return View::make('crm.humanresource.pendingtasks', compact('pending_tasks'));
	}

}
