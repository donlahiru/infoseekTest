<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Session;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Illuminate\Support\Facades\Input;
use Exception;
use Validator;
use App\User;

class FacebookPostController extends Controller
{
    protected $fb;
    protected $user;

    public function __construct(LaravelFacebookSdk $fb,User $user)
    {
        $this->fb   = $fb;
        $this->user = $user;
    }

    public function getIndex()
    {
        $access_token   = Session::get('fb_user_access_token');
        $user_id        = Session::get('fb_user_id');
        $post_id        = Session::get('fb_post_id');
        $login_url      = '';
        $postMessage    = '';
        $postBy         = '';
        $commentBody    = '';

        if($access_token==null)
        {
           $login_url = $this->fb->getLoginUrl(['email','publish_actions']);
        }
        else
        {
            if($post_id!=null)
            {
                $this->fb->setDefaultAccessToken($access_token);

                $profile = $this->fb->get('/'.$post_id.'/comments',$access_token);
                $postfb = $this->fb->get('/'.$post_id,$access_token);

                $user   = $this->user->find($user_id);

                $postBody       = $postfb->getDecodedBody();
                $postMessage    = $postBody['message'];
                $postBy         = $user->name;

                $commentBody    = $profile->getDecodedBody()['data'];
            }

        }

        return View::make('facebook.index',compact('login_url',
                                                    'postMessage',
                                                    'postBy',
                                                    'commentBody'))->withTitle('Facebook Post');
    }

    public function post()
    {
        try 
        {
            $input = Input::all();

            $token = Session::get('fb_user_access_token');
            $this->fb->setDefaultAccessToken($token);

            $rules = [
                'fbPost' => 'required|max:255'
            ];

            $messages = array();

            $validator = Validator::make($input, $rules, $messages);

            if ($validator->passes()) {
                $result = $this->fb->post('/me/feed', ['message' => $input['fbPost']],$token);

                Session::put('fb_post_id', $result->getDecodedBody()['id']);

                return redirect('/facebook')->with('message', 'post Successfully');
            }

            return redirect('/facebook')->with('error', $validator->messages());
        }
        catch(\Facebook\Exceptions\FacebookSDKException $e)
        {
            return redirect('/facebook')->with('error', $e->getMessage());
        }
    }
}
