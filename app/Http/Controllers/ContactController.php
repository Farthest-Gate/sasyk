<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Redirect; 

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function submit(Request $request)
    {   
        
        Contact::create([
            'email' => $request['email'],
        ]);
        $message = "Thanks for leaving you email. We'll keep you up to date";
        return redirect()->route('register', array("message"=>$message));    
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }
}
