<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Session;
use Twitter;
use Illuminate\Support\Facades\Input;
use Exception;
use Validator;


class TwitterPostController extends Controller
{
    public function __construct()
    {

    }

    public function getIndex()
    {
        $access_token = Session::get('access_token');
//        $user_id        = Session::get('fb_user_id');
//        $post_id        = Session::get('fb_post_id');
        $login_url = '';
//        $postMessage    = '';
//        $postBy         = '';
//        $commentBody    = '';
        $sign_in_twitter = true;
        $force_login = false;

        if ($access_token == null) {
            $token = Twitter::getRequestToken(route('twitter.callback'));
            $login_url = Twitter::getAuthorizeURL($token, $sign_in_twitter, $force_login);
        }
        else
        {
//            if($post_id!=null)
//            {
//                $this->fb->setDefaultAccessToken($access_token);
//
//                $profile = $this->fb->get('/'.$post_id.'/comments',$access_token);
//                $postfb = $this->fb->get('/'.$post_id,$access_token);
//
//                $user   = $this->user->find($user_id);
//
//                $postBody       = $postfb->getDecodedBody();
//                $postMessage    = $postBody['message'];
//                $postBy         = $user->name;
//
//                $commentBody    = $profile->getDecodedBody()['data'];
//            }

        }

        return View::make('twitter.index', compact('login_url'))->withTitle('Twitter Post');
    }
    public function post()
    {
        try
        {
            $input = Input::all();

            $rules = [
                'twPost' => 'required|max:255'
            ];

            $messages = array();

            $validator = Validator::make($input, $rules, $messages);

            if ($validator->passes()) {

                $result = Twitter::postTweet(['status' => 'Laravel is beautiful', 'format' => 'json']);

                return redirect('/twitter')->with('message', 'post Successfully');
            }

            return redirect('/twitter')->with('error', $validator->messages());
        }
        catch(Exception $e)
        {
            dd(Twitter::logs());
        }

    }
}
