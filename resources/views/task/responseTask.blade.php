@extends('layouts.admin')

@section('header-title')
	<h1>
		Create Questionare
		<small>Optional description</small>
	</h1>
@endsection

@section('content')
<div class="container">
	<form style="margin-right: 7%" action="/task" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
		<div class="panel panel-danger">
			<div class="panel-body">
				@foreach ($questions as $key => $question)
					<div class="form-group">
					{{-- {{ $question }} --}}
						<label>{{ $question->urutan }}. {{ $question->pertanyaan }}</label>
						@if($question->jenis_pertanyaan === '1')
							<input type="text" name="answer[]" class="form-control" placeholder="Answer"> 
							<input type="hidden" name="id_detail_questionare[]" class="form-control" value="{{ $question->id_detail_questionare }}">
							<input type="hidden" name="type[]" value="1">
						@elseif($question->jenis_pertanyaan === '2')
							<input type="file" name="image[]" class="form-control" placeholder="Answer">
							<input type="hidden" name="id_detail_questionare[]" class="form-control" value="{{ $question->id_detail_questionare }}">
							<input type="hidden" name="type[]" value="2">
						@endif
					</div>
				@endforeach
				<div class="form-group"> 
					<div class="col-sm-10">
						<input type="hidden" name="questionare_id" class="form-control" value="{{ $question->questionare_id }}">
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection