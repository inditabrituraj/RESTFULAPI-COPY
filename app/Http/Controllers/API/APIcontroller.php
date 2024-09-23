<?php

namespace App\Http\Controllers\API;



use App\Models\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIcontroller extends Controller
{
    // we will use user table of the default db to create the user
    //this method will hit by post method which will contain [email and password] 
    public function register(Request $request){
        
    }
    //post method which will contain the registerd email and password and will return the api key
    public function login(Request $request){

    }
    //these 2 are protected method and need token
    public function profile(Request $request){

    }
    public function logout(Request $request){

    }
    
}
