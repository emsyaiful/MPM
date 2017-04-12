@extends('layouts.admin')

@section('header-title')
	<h1>
		My Questionare
		<small>Optional description</small>
	</h1>
@endsection

@section('content')
@include('sweet::alert')
<div class="container" style="padding-left: 5%; padding-right: 10%">
	<form action="/questionare/{{ $questionare->id_questionare }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-danger">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-2" for="title">Title:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title" id="title" value="{{ $questionare->judul_questionare }}">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="date">Deadline:</label>
								<div class="col-sm-10"> 
									<input type="text" class="form-control" name="date" id="date" value="{{ $questionare->deadline_questionare }}">
								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
		<br>
		<div class="row">
			<div class="panel panel-danger">
				<div class="panel-body">
					<div class="form-horizontal">
						@foreach($details as $key=>$value)
							@if($value->jenis_pertanyaan === 1)
								<div class="form-group">
									<label class="control-label col-sm-2" for="pertanyaan">Pertanyaan {{ $value->urutan }}:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="pertanyaan[]" value="{{ $value->pertanyaan }}">
										<input type="hidden" name="detail[]" value="{{ $value->id_detail_questionare }}">
									</div>
								</div>
							@elseif($value->jenis_pertanyaan === 2)
								<div class="form-group">
									<label class="control-label col-sm-2" for="pertanyaan">Pertanyaan {{ $value->urutan }}:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="gambar[]" value="{{ $value->pertanyaan }}">
										<input type="hidden" name="detail[]" value="{{ $value->id_detail_questionare }}">
									</div>
									<div class="col-sm-2">
										<select class="form-control" name="jumlah[]" id="jumlah">				
										    @for ($i = 1; $i <= 6; $i++)
										    	@if($value->jumlah === $i)
										        	<option value="{{ $i }}" selected>Max: {{ $i }}</option>
										        @else
										      		<option value="{{ $i }}">Max: {{ $i }}</option>
										      	@endif
										    @endfor
										</select>
									</div>
								</div>
							@endif
						@endforeach
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
$(document).ready(function(){
	var date_input=$('input[name="date"]'); //our date input has the name "date"
	var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	var options={
		format: 'mm/dd/yyyy',
		container: container,
		todayHighlight: true,
		autoclose: true,
	};
	date_input.datepicker(options);
});
</script>
@endsection