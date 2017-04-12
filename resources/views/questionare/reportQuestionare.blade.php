@extends('layouts.admin')

@section('header-title')
  <h1>
    Report Questionare
    <small>Optional description</small>
  </h1>
@endsection

@section('content')
@include('sweet::alert')

<div class="row" style="margin-left: 1%; margin-right: 1%">
  <div class="panel panel-danger">
    <div class="panel-heading"></div>
    <div class="panel-body">      
      <table class="table table-bordred">
        <thead class="thead-inverse">
          <tr>
            <th>#</th>
            <th>Penerima</th>
          @foreach ($questions as $key => $question)
            <th>{{ $question->pertanyaan }}</th>
          @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($recipients as $key => $recipient)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $recipient->user->name }}</td>
              @foreach ($responses as $key2 => $response)
                @if ($response->user_id === $recipient->user_id)
                  @if ($response->detailQuestionare->jenis_pertanyaan === '2')
                    <td><img src="/images/upload/{{ $response->response }}" width="50px"></td>
                  @elseif ($response->detailQuestionare->jenis_pertanyaan === '1')
                    <td>{{ $response->response }}</td>
                  @endif
                @endif
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection