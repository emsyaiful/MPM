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
	<form style="margin-right: 7%" action="/task/{{ $answer[0]->questionare_id }}" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
		<div class="panel panel-danger">
			<div class="panel-body">
				@foreach ($questions as $key => $question)
					<label>{{ $question->urutan }}. {{ $question->pertanyaan }}</label>
					@if($question->jenis_pertanyaan == 1)
						<div class="form-group">
							<input type="text" name="answer[]" class="form-control" value="{{ $answer[$key]->response }}"> 
							<input type="hidden" name="id_detail_questionare[]" class="form-control" value="{{ $question->id_detail_questionare }}">
							{{-- <input type="hidden" name="type[]" value="1"> --}}
						</div>
					@elseif($question->jenis_pertanyaan == 2)
						<div class="form-group">
							@for ($i = 1; $i <= 6; $i++)
								<div class="col-md-4">
									<div class="form-group row">
									@if($question->jumlah < $i)
										{{--<input type="file" name="{{ $question->id_detail_questionare }}_{{ $i }}" class="form-control" placeholder="Answer" disabled>--}}
									@else
										@if(!empty($answer[$key]->{'image'.$i}))
											<img src="/images/upload/{{ $answer[$key]->{'image'.$i} }}" width="50px">
										@endif
										<input type="file" name="{{ $question->id_detail_questionare }}_{{ $i }}" class="form-control" placeholder="Answer">
									@endif
									</div>
								</div>    	
						    @endfor
						    <input type="hidden" class="form-control" name="id_detail_questionare[]" class="form-control" value="{{ $question->id_detail_questionare }}">
						</div>
					@endif
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