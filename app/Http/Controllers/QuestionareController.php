<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use App\Model\UserRole;
use App\Model\Questionare;
use App\Model\DetailPenerima;
use App\Model\DetailQuestionare;
use App\Model\ResponsPenerima;
use App\Model\Mailer;
use App\Model\Viewers;
use App\User;
use Alert;

class QuestionareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // list my questionare

        $data['questionares'] = Questionare::with('user')->where(array('user_id' => Auth::id()))->orderBy('deadline_questionare', 'desc')->get();
        return view('questionare.listQuestionare', $data);
    }

    public function otherQuestionare(){
        $data['questionares'] = Viewers::with('user', 'questionare')->where(array('user_id' => Auth::id()))->get();
        foreach ($data['questionares'] as $key => $value) {
            $data['questionares'][$key]['owner'] = User::where(array('id' => $value->owner))->first();
        }
        // dd($data);
        return view('questionare.listOtherQuestionare', $data);
    }

    public function viewOtherQuestionare($id){
        $data['questions'] = DetailQuestionare::where(array('questionare_id' => $id))->orderBy('urutan')->get();
        return view('questionare.viewOtherQuestionare', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['users'] = User::with('dealer')->where(array('user_status' => 2))->get();
        $data['viewers'] = User::with('division')->where(array('user_status' => 3))->get();
        foreach ($data['users'] as $key => $value) {
            if ($value->dealer == null) {
                unset($data['users'][$key]);
            }
        }
        // dd($data['users'][0]);
        return view('questionare.createQuestionare', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id_questionare = Uuid::generate();
        $input = $request->all();
        $recipient = $request->input('recipient');
        if ($recipient == null) {
            Alert::error('Error', 'Recipient cannot be null');
            return Redirect::back();
        }
        $question = $request->input('question');
        if ($question == null) {
            Alert::error('Error', 'Question cannot be null');
            return Redirect::back();
        }
        if ($request->input('title') == null) {
            Alert::error('Error', 'Title cannot be null');
            return Redirect::back();
        }
        if ($request->input('date') == null) {
            Alert::error('Error', 'Date cannot be null');
            return Redirect::back();
        }
        $type = $request->input('type');
        $jumlah = $request->input('jumlah');
        $incrTy = 0;
        $incrGb = 0;
        // dd($input);

        $data = array();
        for ($i=0; $i < count($type); $i++) { 
            if (isset($input[$i])) {
                $data[$i] = array(
                    'jumlah' => $jumlah[$incrGb],
                    'gambar' => $input[$i],
                );
                $incrGb++;
            }else {
                $data[$i] = array('pertanyaan' => $question[$incrTy]);
                $incrTy++;
            }
        }
        // dd($input);

        // tabel Questionare
        $questionare = new Questionare;
        $questionare->id_questionare = $id_questionare;
        $questionare->user_id = Auth::id();
        $questionare->judul_questionare = $request->input('title');
        $questionare->deadline_questionare = Carbon::createFromFormat('m/d/Y', $request->input('date'));
        $questionare->created_at = Carbon::now();
        $questionare->save();
        // tabel detailPenerima
        // dd($questionare);

        $viewer = $request->input('viewer');
        if ($viewer != null) {
            foreach ($viewer as $key => $value) {
                $view = new Viewers;
                $view->id_viewers = Uuid::generate();
                $view->questionare_id = $id_questionare;
                $view->user_id = $value;
                $view->owner = Auth::id();
                $view->save();
            }
        }

        foreach ($recipient as $key => $value) {
            $penerima = new DetailPenerima;
            $penerima->id_detail_penerima = Uuid::generate();
            $penerima->questionare_id = $id_questionare;
            $penerima->user_id = $value;
            $penerima->save();
            $temp = User::where(array('id' => $value))->first();
            // $recipient[$key] = array('name' => $temp['name'], 'email' => $temp['email']);
            $mail = new Mailer;
            $mail->email = $temp['email'];
            $mail->name = $temp['name'];
            $mail->subject = 'MPM System Notification';
            $mail->is_sent = 0;
            $mail->body = 'Anda baru saja mendapatkan kiriman tugas untuk mengisi kuisioner.<br>Silahkan masuk dengan username dan password anda untuk mengisi kuisioner berjudul:'.$request->input('title').'<br>Silahkan klik tautan <a href="http://mpm-dev.net/task'.$id_questionare.'">berikut</a> atau http://mpm-dev.net/task/'.$id_questionare.'<br>';
            $mail->save();
        }


        // tabel detailQuestionare
        $incr = 1;
        foreach ($type as $key => $value) {
            $detail = new DetailQuestionare;
            $detail->id_detail_questionare = Uuid::generate();
            $detail->questionare_id = $id_questionare;
            if ($value == 1) {
                $detail->pertanyaan = $data[$key]['pertanyaan'];
            }elseif ($value == 2) {
                $detail->pertanyaan = $data[$key]['gambar'];
                $detail->jumlah = $data[$key]['jumlah'];
            }
            $detail->jenis_pertanyaan = $value;
            $detail->urutan = $incr;
            $detail->save();
            $incr++;
        }

        Alert::success('Success', 'Questionare created');
        return redirect()->route('questionare.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Download report questionare
        $data['questions'] = DetailQuestionare::where(array('questionare_id' => $id))->get();
        $data['recipients'] = DetailPenerima::with('user')->where(array('questionare_id' => $id))->get();
        $data['responses'] = ResponsPenerima::with('detailQuestionare')->where(array('questionare_id' => $id))->get();
        // dd($data['responses']);
        return view('questionare.reportQuestionare', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['questionare'] = Questionare::where(array('id_questionare' => $id))->first();
        $data['questionare']->deadline_questionare = date('d/m/Y', strtotime($data['questionare']->deadline_questionare));
        $data['details'] = DetailQuestionare::where(array('questionare_id' => $id))->get();

        return view('questionare.editQuestionare', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $detail = $request->input('detail');
        $questions = $request->input('pertanyaan');
        $gambar = $request->input('gambar');
        $jumlah = $request->input('jumlah');
        $incrTy = 0;
        $incrGb = 0;

        $questionare = Questionare::where(array('id_questionare' => $id))->first();
        $questionare->judul_questionare = $request->input('title');
        $questionare->deadline_questionare = Carbon::createFromFormat('d/m/Y', $request->input('date'));
        $questionare->save();

        foreach ($detail as $key => $value) {
            $detail_questionare = DetailQuestionare::where(array('id_detail_questionare' => $value))->first();
            if ($detail_questionare->jenis_pertanyaan == 1) {
                $detail_questionare->pertanyaan = $questions[$incrTy];
                $incrTy++;
            }elseif ($detail_questionare->jenis_pertanyaan == 2) {
                $detail_questionare->pertanyaan = $gambar[$incrGb];
                $detail_questionare->jumlah = $jumlah[$incrGb];
                $incrGb++;
            }
            $detail_questionare->save();
        }
        Alert::success('Success', 'Questionare updated');
        return redirect()->route('questionare.index');
    }
    public function destroy($id)
    {
        Questionare::where(array('id_questionare' => $id))->delete();
        DetailQuestionare::where(array('questionare_id' => $id))->delete();
        DetailPenerima::where(array('questionare_id' => $id))->delete();
        Viewers::where(array('questionare_id' => $id))->delete();

        return redirect()->route('questionare.index');
    }

    public function reportExcel($id) {
        $title = Questionare::where(array('id_questionare' => $id))->first();
        $title = 'Report Questionare - '.$title->judul_questionare;
        Excel::create($title, function($excel) use ($id){
            $data['questions'] = DetailQuestionare::where(array('questionare_id' => $id))->get();
            $data['recipients'] = DetailPenerima::with('user')->where(array('questionare_id' => $id))->get();
            $data['responses'] = ResponsPenerima::with('detailQuestionare')->where(array('questionare_id' => $id))->get();
            $excel->sheet('Report Questionare', function($sheet) use ($data) {
                $sheet->loadView('questionare.excelReport')->with('questions', $data['questions'])->with('recipients', $data['recipients'])->with('responses', $data['responses']);
            });
        })->download('xls');
    }

    public function notificationMail($recipient, $title) {
        // dd($recipient);
        $data = array('title' => $title);
        Mail::send(['text' => 'mails.notification'], $data, function($message) use($recipient) {
            foreach ($recipient as $key => $value) {
                $message->to($value['email'], $value['name'])
                    ->subject('Notification email');
            }
        });
        return 200;
    }
}
