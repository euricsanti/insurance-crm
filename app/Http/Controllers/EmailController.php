<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Session;
use DB;
use App\User;
use View;
use Response;
use Illuminate\Support\Facades\Input;
use Mail;
use App\PhpImap\Mailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;

class EmailController extends Controller {

    public function __construct(Request $request, Validator $validator) {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->validator = $validator;
    }

    public function email_inbox() {
        $mailbox = new \PhpImap\Mailbox('{imap.gmail.com:993/imap/ssl}INBOX', '*******', '**********', __DIR__);
        $mailsIds = $mailbox->searchMailbox('ALL');
        $mailarray = array();
        if (!$mailsIds) {
            die('Su bandeja de correos está vacía');
        }
        foreach ($mailsIds as $key => $mail) {
            $mailobj = $mailbox->getMail($mail);
            $mailarray[$key]['subject'] = $mailobj->subject;
            $mailarray[$key]['fromName'] = $mailobj->fromName;
            $mailarray[$key]['toString'] = $mailobj->toString;
            $mailarray[$key]['messageId'] = $mailobj->messageId;
            $mailarray[$key]['mailid'] = $mail;
            if ($key == 1) {
                break;
            }
        }
        $mailobject = (object) $mailarray;
        //var_dump($mail->getAttachments());
        return View::make('crm.email.inbox', compact('mailobject'));
    }

    public function viewemail($mailid) {
        $mailbox = new \PhpImap\Mailbox('{imap.gmail.com:993/imap/ssl}INBOX', '******', '******', __DIR__);
        $viewemail = $mailbox->getMail($mailid);
        return View::make('crm.email.viewmail', compact('viewemail'));
    }

    public function sendemail() {
        return View::make('crm.email.sendemail');
    }

    public function dispatchemail() {
        $data = array(
            'toemail' => $this->request->toemail,
            'subject' => $this->request->subject,
            'message' => $this->request->message,
        );
        $rules = array(
            'toemail' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            $emailcontent = array(
                'subject' => $this->request->subject,
                'emailmessage' => $this->request->message
            );
            Mail::send('emails.contactemail', $emailcontent, function($message) {
                $message->to($this->request->toemail, $this->request->toemail)
                        ->subject($this->request->subject);
            });
            Session::flash('success', 'Email Sent');
            return 'Message sent!!';

        }
    }

}
