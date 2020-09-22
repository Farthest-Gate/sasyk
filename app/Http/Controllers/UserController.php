<?php

namespace App\Http\Controllers;

use Auth;
use App\Invites;
use App\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class UserController extends Controller
{
    //
    public function __construct() {
//        $this->middleware('auth');
    }
    
    public function index(Request $request){
        if(Auth::user() == null){
            $token = $request->token;
            return view('view_invite', compact($token));
        }
        return view('invite');
    }
    
    public function send_invite(Request $request){
        $email = $request->email;
        $exists = false;
        $sent = false;
        
        // CHECK IF EMAIL EXIST
        
        if(Users::where('email','=', $email)->exists()) {
            $exists = true;
            return view('invite', compact('exists', 'sent', 'email'));
        }
        // create row in user_invite table
        
        $previous_invite = Invites::where("email", $email)->first();
        if($previous_invite != null){
            $previous_invite->deleted_at = Carbon::now();
            $previous_invite->save();
        }
        
        $token = Hash::make($email . Carbon::now());
        $expires = (new Carbon())->addDays(1);
        Invites::create([
            'email' => $email,
            'token' => $token,
            'company_id' => Auth::user()->company_id,
            'expires' => $expires,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
        
        // send email
        $sent = true;
        
        return view('invite', compact('exists', 'sent', 'email'));
    }
    
    public function accept_invite(Request $request){
        
        $request = Validator::validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $name = $request->name;
        $email = $request->email;
        $token = $request->token;
        $password = $request->password;
        $password_confirm = $request->password_confirm;
        
        
        
        $invite = Invites::where("email", $email)->where("token", $token)-first();
        if($invite == null){
            
        }
        if($invite->expires < Carbon::now()){
            
        }
        if($password != $password_confirm){
            
        }
        
        //register
        return view('view_invite');
    }
    
    public function generate()
    {
        try {
        
            $client = new Client();

            
            $url = 'https://secure.authenticator.uk.experian.com/WASPAuthenticator/TokenService.asmx/LoginWithCertificate';
            $url_test = 'https://secure.authenticator.uat.uk.experian.com/WASPAuthenticator/TokenService.asmx/LoginWithCertificate';
            
            \Log::debug("--------------- START -----------");
            \Log::debug("--------------- url = $url");
            $response = $client->post($url_test,
                [
                    'form_params' => [
                        'application' => 'GetWaspToken',
                        'checkIP' => 'false' 
                    ],
                     'cert' => [config_path('cert2.pem'), 'qwerty'],
                ]
            );
            
            \Log::debug("--------------- GOT RESPONSE -----------");
        
            if ($response->getStatusCode() === 200) {
               
                // Success!           
                $xmlResponse = simplexml_load_string($response->getBody()); // Convert response into object for easier parsing
                \Log::debug("TOKEN = " . $xmlResponse[0]);
                
                return $xmlResponse[0];
            } else {
                echo 'Response Failure !!!';
            }     
        } catch (Exception $e) {
            
        }
    }
    
}
