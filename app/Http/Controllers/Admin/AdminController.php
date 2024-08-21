<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Mail;
use App\Models\Admin;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

// use Auth;

class AdminController extends Controller
{
  
    public function dashboard()
    {
        return view('admin.dashboard');
     }

     public function login()
     {
        return view('admin.login');
      }

      public function login_submit(Request $request)
      {
       $validated = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]); 
        if(Auth::guard('admin')->attempt($validated)){

            return redirect()->route('admin.dashboard')->with('success', 'conexion reussie');
        // }
    }
        
            return redirect()->route('admin.login')->with('error', 'conexion echoué');
            
        }
         
        public function logout()
        {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('success', 'deconnexion reussie');
       }

       public function forget_password()
       {
        return view('admin.forget-password');
        }

       public function forget_password_submit(Request $request)
       {
        $request->validate([
            'email'=>'required|email',
        ]);

        $admin_data= Admin::where('email', $request->email)->first();
        if(!$admin_data){
            return redirect()->back()->with('error', 'Email not found');
        }

        $token = hash('sha256', time());
        $admin_data->token=$token;
        $admin_data->update();
        $reset_link = url("admin/reset-password/$token/$request->email");
        $subjet = "Reinitialiser le mot de passe";
        $message = "Cliquer siur le lien ci dessous pour reinitialiser votre mot de passe<br><br>";
        $message = "<a href=$reset_link>Clique ici</a>";
        
        Mail::to($request->email)->send(new Websitemail($subjet, $message));

        return redirect()->back()->with('success','Un lien vous a été envoyé par mail');
    }

    public function reset_password($token, $email )
    {
        $admin_data = Admin::where('email', $email)->where('token', $token)->first();
        if(!$admin_data){
            return redirect()->route('admin.login')->with('error', 'Invalid token or email');
        }

        return view('admin.reset-password', compact('token', "email"));
     }

    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password'=>'required',
            'password_confirmation'=>'required|same:password',
        ]);
        
        $admin_data = Admin::where('email', $request->email)->where('token', $request->token)->first();
        // dd($request->all(   ));
        $admin_data->password = Hash::make($request->password);
        $admin_data->token="";
        $admin_data->update();
        
        return redirect()->route('admin.login')->with('success', 'password reset successfuly');
        die;       
     }
}
