<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Support\Facades\Input;
use Validator;
use File;
use Response;

class emailController extends Controller
{
    public function __construct()
    {
        
    }

    public function getIndex()
    {
        return View::make('email.index')->withTitle('Question 1');
    }

    public function sendEmail()
    {
        $input = Input::all();

        $rules = [
            'subject' => 'required|max:255',
            'content' => 'required|max:255'
        ];

        $messages = array();

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->passes())
        {
            $data = array('content' => $input['content']);
            $subject = $input['subject'];
            $to_mail = 'donlahiru@gmail.com';


            \Mail::send('mail', $data, function($msg) use ($subject,$to_mail) {

                $msg->to($to_mail, 'infoseek')->subject($subject);

            });

            $data   = 'subject : '.$input['subject'].' Body : '.$input['content'];
            $fileName = time() . 'mail.txt';
            File::put(public_path('/upload/'.$fileName),$data);
            
            return Response::download(public_path('/upload/'.$fileName));
        }

        return redirect('/Q1')->with('error', $validator->messages());
    }
}
