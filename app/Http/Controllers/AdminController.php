<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Webpatser\Uuid\Uuid;
use View;
use Carbon\Carbon;
use App\Mail\verificationMail;
use App\Model\UserRole;
use App\User;

class AdminController extends Controller
{
    public function getUserDetail() {
    	$id = Auth::id();
    	$data['user'] = User::with('role')->where(array('id' => $id))->first();
    	// print_r($user);

    	return redirect()->route('questionare.index');
    }

    public function getAllUser() {
    	$data['users'] = User::with('role')->whereNull('deleted_at')->get();
    	// $data['users'] = User::with('role')->where('role_id', '!=', '1')->whereNull('deleted_at')->get();
    	$data['roleList'] = UserRole::get();
    	// print_r($roleList);
    	// return View::make('userManagement')->with('users', $user)->with('role', $roleList);
    	return view('userManagement', $data);
    }

    public function deleteUser($id) {
    	$user = User::find($id);
    	$user->deleted_at = Carbon::now();
    	$user->save();
    	// Redirect::route('home', array('status' => 200, 'msg' => 'Success'));
    	// print_r($user);
    	return redirect()->route('user');
    }

    public function updateUser(Request $request) {
    	$user = User::with('role')->where(array('id' => $request->input('id')))->first();
    	$user->name = $request->input('name');
    	$user->alamat = $request->input('address');
    	$user->role_id = $request->input('role');

    	// print_r($user);
    	$user->save();
    	return redirect()->route('user');
    }

    public function createUser(Request $request) {
    	$user = new User;
    	$user->id = Uuid::generate();
    	$user->name = $request->input('name');
    	$user->email = $request->input('email');
    	$user->alamat = $request->input('address');
    	$user->role_id = $request->input('role');
    	$user->password = bcrypt(str_random(8));
    	$user->created_at = Carbon::now();
    	$user->save();
    	// print_r($user);
    	return redirect()->route('user');
    }

    public function cobaMail() {
    	$data = array('name' => 'testing' );
    	Mail::send(['text' => 'mails.test'], $data, function($message) {
    		$message->to('bonggol.pring@gmail.com', 'Bonggol')
    				->subject('Laravel test mail')
    				->from('arkandita.ra@gmail.com', 'Rara Arkandita');
    	});
    	echo "Email sent";
    }

    public function changeForm($id) {
        $data['user'] = User::find($id);
        // echo "string";
        return view('changePassword', $data);
    }

    public function changePass(Request $request) {
        $data['user'] = User::where(array('email' => 'tes@mail.com'))->first();
        if ($request->input('password') != $request->input('password_confirmation')) {
            $data['status'] = 'Password did not match';

            return view('changePassword', $data);
        } else {
            $data['user']->password = bcrypt($request->input('password'));
        }
        
        return redirect()->route('questionare.index');
        // $user = User::where(array('email' => $request->input('email')));
    }
}
