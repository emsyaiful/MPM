<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Webpatser\Uuid\Uuid;
use View;
use Carbon\Carbon;
// use App\Mail\verificationMail;
use App\Model\StatusDealer;
use App\Model\UserRole;
use App\Model\Division;
use App\Model\Dealer;
use App\Model\Kares;
use App\Model\Kota;
use App\Model\Md;
use App\Model\Mailer;
use App\User;
use Alert;

class AdminController extends Controller
{
    public function getUserDetail() {
    	$id = Auth::user();
    	if ($id->user_status == 1) {
            return redirect()->route('userDivision');
        }elseif ($id->user_status == 3) {
            return redirect()->route('questionare.index');
        }elseif ($id->user_status == 2) {
            return redirect()->route('task.index');
        }
    }

    //Division
    public function divisionList() {
    	$data['divisions'] = Division::get();
    	return view('admin.divisionList', $data);
    }

    public function divisionEdit(Request $request) {
        $division = Division::where(array('id_division' => $request->input('id_division')))->first();
        $division->kode_divisi = $request->input('code');
        $division->nama = $request->input('name');
        $division->divisi = $request->input('name');
        $division->save();

        Alert::success('Success', 'Division updated');
        return redirect()->route('division');
    }

    public function divisionCreate(Request $request) {
        $division =  new Division;
        $division->id_division = Uuid::generate();
        $division->kode_divisi = $request->input('code');
        $division->nama = $request->input('name');
        $division->divisi = $request->input('name');
        $division->save();

        Alert::success('Success', 'Division created');
        return redirect()->route('division');
    }

    public function divisionDelete($id) {
        Division::where(array('id_division' => $id))->delete();

        Alert::success('Success', 'Division deleted');
        return redirect()->route('division');
    }

    // Kares
    public function karesList() {
        $data['kares'] = Kares::get();
        return view('admin.karesList', $data);
    }

    public function karesEdit(Request $request) {
        $kares = Kares::where(array('id_kares' => $request->input('id_kares')))->first();
        $kares->nama_kares = $request->input('name');
        $kares->save();

        Alert::success('Success', 'Kares updated');
        return redirect()->route('kares');
    }

    public function karesDelete($id) {
        Kares::where(array('id_kares' => $id))->delete();

        Alert::success('Success', 'Kares deleted');
        return redirect()->route('kares');
    }

    public function karesCreate(Request $request) {
        $kares = new Kares;
        $kares->id_kares = Uuid::generate();
        $kares->nama_kares = $request->input('name');
        $kares->save();

        Alert::success('Success', 'Kares created');
        return redirect()->route('kares');
    }

    // Kota
    public function kotaList() {
        $data['kotas'] = Kota::with('kares')->get();
        $data['kares'] = Kares::get();
        return view('admin.kotaList', $data);
    }

    public function kotaCreate(Request $request) {
        $kota = new Kota;
        $kota->id_kota = Uuid::generate();
        $kota->nama_kota = $request->input('name');
        $kota->kares_id = $request->input('kares');
        $kota->save();

        Alert::success('Success', 'Kota created');
        return redirect()->route('kota');
    }

    public function kotaDelete($id) {
        // echo $id;
        Kota::where(array('id_kota' => $id))->delete();

        Alert::success('Success', 'Kota deleted');
        return redirect()->route('kota');
    }

    // MD
    public function mdList() {
        $data['mds'] = Md::get();
        return view('admin.mdList', $data);
    }

    public function mdCreate(Request $request) {
        $kares = new Md;
        $kares->id_md = Uuid::generate();
        $kares->nama_md = $request->input('name');
        $kares->save();

        Alert::success('Success', 'MD created');
        return redirect()->route('md');
    }

    public function mdDelete($id) {
        Md::where(array('id_md' => $id))->delete();

        Alert::success('Success', 'MD deleted');
        return redirect()->route('md');
    }

    public function mdEdit(Request $request) {
        $kares = Md::where(array('id_md' => $request->input('id_md')))->first();
        $kares->nama_md = $request->input('name');
        $kares->save();

        Alert::success('Success', 'MD updated');
        return redirect()->route('md');
    }

    // Status Dealer
    public function statusList() {
        $data['statuses'] = StatusDealer::get();
        return view('admin.statusList', $data);
    }

    public function statusCreate(Request $request) {
        $status = new StatusDealer;
        $status->id_status_dealer = Uuid::generate();
        $status->nama_status = $request->input('name');
        $status->save();

        Alert::success('Success', 'Status created');
        return redirect()->route('status');
    }

    public function statusDelete($id) {
        StatusDealer::where(array('id_status_dealer' => $id))->delete();

        Alert::success('Success', 'Status deleted');
        return redirect()->route('status');
    }

    public function statusEdit(Request $request) {
        $kares = StatusDealer::where(array('id_status_dealer' => $request->input('id_status_dealer')))->first();
        $kares->nama_status = $request->input('name');
        $kares->save();

        Alert::success('Success', 'Status updated');
        return redirect()->route('status');
    }

    // Dealer
    public function dealerList() {
        $data['users'] = User::with(['dealer' => function($query) {
            $query->with('status', 'md', 'kota');
        }])->where(array('user_status' => 2))->get();
        $data['dealers'] = Dealer::with('md', 'kota', 'status')->get();
        $data['kotas'] = Kota::get();
        $data['mds'] = Md::get();
        $data['statuses'] = StatusDealer::get();
        // dd($data);
        return view('admin.dealerList', $data);
    }

    public function dealerCreate(Request $request) {
        if (User::where('email', '=', $request->input('email'))->exists()) {
            Alert::error('Error', 'Email address already exist');
            return redirect()->route('dealer');
        }else{
            $password = str_random(8);
            $id_dealer = Uuid::generate();
            // $password = 'initpass';
            
            $user = new User;
            $user->id = Uuid::generate();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($password);
            $user->user_status = 2;
            $user->dealer_id = $id_dealer;
            $user->save();

            $dealer = new Dealer;
            $dealer->id_dealer = $id_dealer;
            $dealer->kode_dealer = $request->input('code');
            $dealer->nama = $request->input('dealer');
            $dealer->alamat = $request->input('address');
            $dealer->status_dealer_id = $request->input('status');
            $dealer->md_id = $request->input('md');
            $dealer->kota_id = $request->input('city');
            $dealer->save();


            $mail = new Mailer;
            $mail->email = $request->input('email');
            $mail->name = $request->input('name');
            $mail->subject = 'MPM System verification email';
            $mail->is_sent = 0;
            $mail->body = 'Pendaftaran user baru sudah berhasil. Anda dapat masuk kedalam sistem dengan akun<br><br>Username:'.$request->input('email').'<br>Password:'.$password.'<br>Lakukan penggantian password pada menu yang tersedia demi keamanan dengan membuka tautan <a href="http://mpm-dev.net">berikut</a> atau http://mpm-dev.net/.<br>Terima Kasih<br>Admin MPM<br>';
            $mail->save();
            // $data = array(
            //     'email' => $request->input('email'),
            //     'password' => $password,
            //     'name' => $request->input('name'),
            // );

            // $res = $this->verificationMail($data);

            Alert::success('Success', 'Dealer created');
            return redirect()->route('dealer');               
        }
    }

    public function dealerDelete($id) {
        $user = User::where(array('id' => $id))->first();
        Dealer::where(array('id_dealer' => $user->dealer_id))->delete();
        $user->delete();

        Alert::success('Success', 'Dealer deleted');
        return redirect()->route('dealer');
    }

    public function dealerEdit(Request $request) {
        $user = User::where(array('id'=> $request->input('id')))->first();
        $user->name = $request->input('name');
        $user->save();

        $dealer = Dealer::where(array('id_dealer' => $request->input('id_dealer')))->first();
        $dealer->kode_dealer = $request->input('code');
        $dealer->nama = $request->input('dealer');
        $dealer->alamat = $request->input('address');
        $dealer->status_dealer_id = $request->input('status');
        $dealer->md_id = $request->input('md');
        $dealer->kota_id = $request->input('city');
        $dealer->save();

        Alert::success('Success', 'Dealer updated');
        return redirect()->route('dealer');
    }


    // User Division
    public function userDivisionList() {
        $data['users'] = User::with('division')->where(array('user_status' => 3))->get();
        $data['divisions'] = Division::get();

        return view('admin.userDivisionList', $data);
    }

    public function userDivisionCreate(Request $request) {
        if (User::where('email', '=', $request->input('email'))->exists()) {
            Alert::error('Error', 'Email address already exist');
            return redirect()->route('userDivision');
        }else{
            $password = str_random(8);
            // $password = 'initpass';

            $user = new User;
            $user->id = Uuid::generate();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($password);
            $user->user_status = 3;
            $user->division_id = $request->input('division');
            $user->save();

            $mail = new Mailer;
            $mail->email = $request->input('email');
            $mail->name = $request->input('name');
            $mail->subject = 'MPM System verification email';
            $mail->is_sent = 0;
            $mail->body = 'Pendaftaran user baru sudah berhasil. Anda dapat masuk kedalam sistem dengan akun<br><br>Username:'.$request->input('email').'<br>Password:'.$password.'<br>Lakukan penggantian password pada menu yang tersedia demi keamanan.<br>Terima Kasih<br>Admin MPM<br>';
            $mail->save();

            // $data = array(
            //     'email' => $request->input('email'),
            //     'password' => $password,
            //     'name' => $request->input('name'),
            // );

            // $res = $this->verificationMail($data);

            Alert::success('Success', 'User division created');
            return redirect()->route('userDivision');
        }
    }

    public function userDivisionDelete($id) {
        User::where(array('id' => $id))->delete();

        Alert::success('Success', 'User division deleted');
        return redirect()->route('userDivision');
    }

    public function userDivisionEdit(Request $request) {
        $user = User::where(array('id' => $request->input('id')))->first();
        $user->name = $request->input('name');
        $user->division_id = $request->input('division');
        $user->save();

        Alert::success('Success', 'User division updated');
        return redirect()->route('userDivision');
    }

    public function verificationMail($data) {
        // dd($data);
    	Mail::send(['text' => 'mails.verification'], $data, function($message) use($data) {
    		$message->to($data['email'], $data['name'])
    				->subject('Laravel verification email');
    	});
    	return 200;
        // return view('mails.verification', $data);
    }

    public function changeForm($id) {
        $data['user'] = User::find($id);
        // echo "string";
        return view('changePassword', $data);
    }

    public function changePass(Request $request) {
        $data['user'] = User::where(array('email' => $request->input('email')))->first();
        if ($request->input('password') != $request->input('password_confirmation')) {
            // $data['status'] = 'Password did not match';

            Alert::error('Error', 'Password mismatch');
            return view('changePassword', $data);
        } else {
            $data['user']->password = bcrypt($request->input('password'));
            $data['user']->save();
            Alert::success('Success', 'Password changed');
        }
        
        return redirect()->route('home');
        // $user = User::where(array('email' => $request->input('email')));
    }
}
