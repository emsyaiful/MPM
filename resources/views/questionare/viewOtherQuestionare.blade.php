@extends('layouts.admin')

@section('header-title')
	<h1>
		Create Questionare
		<small>Optional description</small>
	</h1>
@endsection

@section('content')
@include('sweet::alert')

<div class="container">
	<form style="margin-right: 7%" action="/task" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
		<div class="panel panel-danger">
			<div class="panel-body">
				@foreach ($questions as $key => $question)
					<label>{{ $question->urutan }}. {{ $question->pertanyaan }}</label>
					@if($question->jenis_pertanyaan == 1)
						<div class="form-group">
							<input type="text" name="answer[]" class="form-control" placeholder="Answer" disabled> 
							<input type="hidden" name="id_detail_questionare[]" class="form-control" value="{{ $question->id_detail_questionare }}">
							{{-- <input type="hidden" name="type[]" value="1"> --}}
						</div>
					@elseif($question->jenis_pertanyaan == 2)
						<div class="form-group">
						    <input type="hidden" class="form-control" name="id_detail_questionare[]" class="form-control" value="{{ $question->id_detail_questionare }}" disabled>
						    Image upload Max: {{ $question->jumlah }}
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</form>
</div>
@endsection