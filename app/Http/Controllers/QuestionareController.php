<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use App\Model\UserRole;
use App\Model\Questionare;
use App\Model\DetailPenerima;
use App\Model\DetailQuestionare;
use App\Model\ResponsPenerima;
use App\User;

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

        $data['questionares'] = Questionare::with('user')->where(array('user_id' => Auth::id()))->get();
        return view('questionare.listQuestionare', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['users'] = User::get();
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
        $question = $request->input('question');
        $type = $request->input('type');

        for ($i=0; $i < count($input); $i++) { 
            if (isset($input[$i])) {
                $question[$i] = $input[$i];
            }
        }

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

        foreach ($recipient as $key => $value) {
            $penerima = new DetailPenerima;
            $penerima->id_detail_penerima = Uuid::generate();
            $penerima->questionare_id = $id_questionare;
            $penerima->user_id = $value;
            $penerima->save();
        }

        // tabel detailQuestionare
        $incr = 1;
        foreach ($question as $key => $value) {
            $detail = new DetailQuestionare;
            $detail->id_detail_questionare = Uuid::generate();
            $detail->questionare_id = $id_questionare;
            $detail->pertanyaan = $value;
            $detail->jenis_pertanyaan = $type[$key];
            $detail->urutan = $incr;
            $detail->save();
            $incr++;
        }
        
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
        echo $id;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Questionare::where(array('id_questionare' => $id))->delete();
        DetailQuestionare::where(array('questionare_id' => $id))->delete();
        DetailPenerima::where(array('questionare_id' => $id))->delete();

        return redirect()->route('questionare.index');
    }

    public function reportExcel($id) {
        Excel::create('Report Questionare', function($excel) use ($id){
            $data['questions'] = DetailQuestionare::where(array('questionare_id' => $id))->get();
            $data['recipients'] = DetailPenerima::with('user')->where(array('questionare_id' => $id))->get();
            $data['responses'] = ResponsPenerima::with('detailQuestionare')->where(array('questionare_id' => $id))->get();
            $excel->sheet('Report Questionare', function($sheet) use ($data) {
                $sheet->loadView('questionare.excelReport')->with('questions', $data['questions'])->with('recipients', $data['recipients'])->with('responses', $data['responses']);
            });
        })->download('xls');
    }
}
