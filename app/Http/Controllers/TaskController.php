<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use App\Model\UserRole;
use App\Model\Questionare;
use App\Model\DetailPenerima;
use App\Model\DetailQuestionare;
use App\Model\ResponsPenerima;
use App\User;
use Alert;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $data['tasks'] = DetailPenerima::with('questionare', 'user')->where(array('user_id' => $id))->get();
        return view('task.listTask', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // $input = $request->all();
        $detail_questionare = $request->input('id_detail_questionare');
        $answer = $request->input('answer');
        $incrementImg = 1;
        $incrementAns = 0;

        foreach ($detail_questionare as $key => $value) {
            $response = new ResponsPenerima;
            $response->id_respons_penerima = Uuid::generate();
            $response->user_id = Auth::id();
            $response->questionare_id = $request->input('questionare_id');
            $response->detail_questionare_id = $value;
            $detail = DetailQuestionare::where(array('id_detail_questionare' => $value))->first();
            if ($detail->jenis_pertanyaan == 1) {
                $response->response = $answer[$incrementAns];
                $incrementAns++;
            }elseif ($detail->jenis_pertanyaan == 2) {
                for ($i=1; $i <= 6; $i++) {
                    $temp = $value.'_'.$i; 
                    if (!is_null($request->file($temp))) {
                        $imageName = Carbon::now()->toDateString()."_".Carbon::now()->toTimeString()."_".$request->file($temp)->getClientOriginalName();
                        $request->file($temp)->move(public_path('images/upload'), $imageName);
                        $response->{'image'.$incrementImg} = $imageName;
                        $incrementImg++;
                    }
                }
            }
            $incrementImg = 1;
            $response->save();
        }

        $where = array(
            'questionare_id' => $request->input('questionare_id'),
            'user_id' => Auth::id(),
        );
        $status = DetailPenerima::where($where)->first();
        $status->status = 1;
        $status->save();

        Alert::success('Success', 'Questionare answered');
        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['questions'] = DetailQuestionare::with('questionare')->where(array('questionare_id' => $id))->orderBy('urutan')->get();
        $questionare = Questionare::where(array('id_questionare' => $id))->first();
        $now = Carbon::now();
        $temp = new Carbon($questionare->deadline_questionare);
        if ($now->toDateString() < $temp->toDateString()) {
            $data['expired'] = 1;
        }else {
            $data['expired'] = 0;
        }
        return view('task.responseTask', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['questions'] = DetailQuestionare::where(array('questionare_id' => $id))->orderBy('urutan')->get();
        $data['answer'] = ResponsPenerima::where(array('questionare_id' => $id))->get();
        $questionare = Questionare::where(array('id_questionare' => $id))->first();
        $now = Carbon::now();
        $temp = new Carbon($questionare->deadline_questionare);
        if ($now->toDateString() < $temp->toDateString()) {
            $data['expired'] = 1;
        }else {
            $data['expired'] = 0;
        }
        return view('task.editTask', $data);
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
        $detail_questionare = $request->input('id_detail_questionare');
        $answer = $request->input('answer');
        $incrementImg = 1;
        $incrementAns = 0;

        foreach ($detail_questionare as $key => $value) {
            $response = ResponsPenerima::where(array('questionare_id' => $request->input('questionare_id')))->get();
            $detail = DetailQuestionare::where(array('id_detail_questionare' => $value))->first();
            if ($detail->jenis_pertanyaan == 1) {
                $response[$key]->response = $answer[$incrementAns];
                $incrementAns++;
            }elseif ($detail->jenis_pertanyaan == 2) {
                for ($i=1; $i <= 6; $i++) {
                    $temp = $value.'_'.$i; 
                    if (!is_null($request->file($temp))) {
                        $imageName = Carbon::now()->toDateString()."_".Carbon::now()->toTimeString()."_".$request->file($temp)->getClientOriginalName();
                        $request->file($temp)->move(public_path('images/upload'), $imageName);
                        $response[$key]->{'image'.$i} = $imageName;
                        $incrementImg++;
                    }
                }
            }
            $incrementImg = 1;
            $response[$key]->save();
        }

        Alert::success('Success', 'Questionare answered');
        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
