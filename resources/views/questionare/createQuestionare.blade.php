@extends('layouts.admin')

@section('header-title')
	<h1>
		Create Questionare
		<small>Creating new questionare</small>
	</h1>
@endsection

@section('content')
@include('sweet::alert')

<div class="container">
	<form style="margin-right: 7%" action="/questionare" method="POST">
	{{ csrf_field() }}
	<div class="row">
    	<div class="col-md-6">
			<div class="panel panel-danger">
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-2" for="title">Title:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="date">Deadline:</label>
							<div class="col-sm-10"> 
								<input type="text" class="form-control" name="date" id="date" placeholder="MM/DD/YYY">
							</div>
						</div>
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>	
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-6">
			<div class="panel panel-danger">
				<div class="panel-heading">Add recipient</div>
				<div class="panel-body">
					<div class="col-sm-9 form-group">
						<select class="form-control" id="recipient" onkeyup="searchSel()">
							@foreach ($users as $key => $user)
								<option value="{{ $user->id }}">{{ $user->dealer->kode_dealer }} - {{ $user->name }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<button type="button" class="btn btn-success" onclick="recipientAdd()">Add</button>
						<button type="button" class="btn btn-success" onclick="allRecipient()">All</button>
					</div>

					<div class="col-sm-12" style="padding: 1em">
						<div class="add-recipient">
							
						</div>
					</div>
				</div>
			</div>
    	</div>
    	<div class="col-md-6">
    		<div class="panel panel-danger">
				<div class="panel-heading">Add question</div>
				<div class="panel-body" id="question">
					<div class="btn-group inline pull-right">
						<button type="button" class="btn btn-success" onclick="formAdd(1)">Form</button>
						<button type="button" class="btn btn-danger" onclick="formAdd(2)">Image</button>
					</div>
					<div class="col-sm-12" style="padding: 1em">
						<div class="add-form form-group">
							
						</div>
					</div>
				</div>
			</div>
    	</div>
    </div>
	</form>
</div>

<script>
	var counter = 0;
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
	var renderInput = function(inputType) {
		var dom = ''
		switch(inputType) {
			case 1:
				dom = '<input class="form-control" placeholder="Pertanyaan" type="text" name="question[]"/>';
				break;
			case 2:
				dom = '<input class="form-control" type="text" placeholder="Keterangan Gambar" name="'+counter+'"/> <select class="form-control" id="jumlah[]" name="jumlah[]"><option value="1">Max: 1</option><option value="2">Max: 2</option><option value="3">Max: 3</option><option value="4">Max: 4</option><option value="5">Max: 5</option><option value="6">Max: 6</option></select>';
				break;
			default: 
				break;
		}
		return dom+'<input style="margin-bottom: 1em" class="form-control" type="hidden" value="'+inputType+'" name="type[]"/><span class="input-group-addon remove_field"><a href="#">X</a></span>'
	}
	var formAdd = function(inputType) {
        $('.add-form').append('<div class="input-group">'+renderInput(inputType)+'</div>');
        counter++;
	};
	$(document).on('click', '.remove_field', function(e) {
		e.preventDefault(); $(this).parent('div').remove();
	});

	var recipientAdd = function(e) {
		var nameUser = $('#recipient').find(':selected').text();
		var idUser = $('#recipient').find(':selected').val();
		// console.log(idUser);
		$('.add-recipient').append('<div class="input-group"><input type="text" class="form-control" value="'+nameUser+'" disabled><input type="hidden" class="form-control" name="recipient[]" value="'+idUser+'"><span class="input-group-addon remove_recipient"><a href="#">X</a></span></div>')
	}
	$(document).on('click', '.remove_recipient', function(e) {
		e.preventDefault(); $(this).parent('div').remove();
	});

	var allRecipient = function(e) {
		var optionValues = [];
		var optionNames = [];

		$('#recipient option').each(function() {
		    optionValues.push($(this).val());
		    optionNames.push($(this).text());
		});
		for (var i = 0; i < optionNames.length; i++) {
			$('.add-recipient').append('<div class="input-group"><input type="text" class="form-control" value="'+optionNames[i]+'" disabled><input type="hidden" class="form-control" name="recipient[]" value="'+optionValues[i]+'"><span class="input-group-addon remove_recipient"><a href="#">X</a></span></div>')
		}
		// alert(optionNames)
	}

	$("#recipient").chosen()
</script>
@endsection
