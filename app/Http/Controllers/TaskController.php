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
        // $input = $request->all();
        $detail_questionare = $request->input('id_detail_questionare');
        $type = $request->input('type');
        $incrementImg = 0;
        $incrementAns = 0;

        foreach ($detail_questionare as $key => $value) {
            $response = new ResponsPenerima;
            $response->id_respons_penerima = Uuid::generate();
            $response->user_id = Auth::id();
            $response->questionare_id = $request->input('questionare_id');
            $response->detail_questionare_id = $value;
            if ($type[$key] == 2) {
                $imageName = Carbon::now()->toDateString()."_".Carbon::now()->toTimeString()."_".$request->file('image.'.$incrementImg)->getClientOriginalName();
                $request->file('image.'.$incrementImg)->move(public_path('images/upload'), $imageName);
                $response->response = $imageName;
                $incrementImg++;
            }else {
                $response->response = $request->input('answer.'.$incrementAns);
                $incrementAns++;
            }
            $response->created_at = Carbon::now();
            $response->save();
        }
        // dd($request->all());

        $where = array(
            'questionare_id' => $request->input('questionare_id'),
            'user_id' => Auth::id(),
        );
        $status = DetailPenerima::where($where)->first();
        $status->status = 1;
        $status->save();

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
        $data['questions'] = DetailQuestionare::where(array('questionare_id' => $id))->orderBy('urutan')->get();

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
        //
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
        //
    }
}
