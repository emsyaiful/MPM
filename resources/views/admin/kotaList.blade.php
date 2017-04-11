@extends('layouts.admin')

@section('header-title')
	<h1>
		Kota
		<small>Optional description</small>
	</h1>
@endsection
@section('content')
@include('sweet::alert')

<div class="row" style="margin-left: 1%">
	<button class="btn btn-danger" data-toggle="modal" data-target="#create">Create</button>
</div>
<br>
<div class="row" style="margin-left: 1%; margin-right: 1%">
	<div class="panel panel-danger">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<table class="table table-bordred">
				<thead class="thead-inverse">
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Kares Name</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($kotas as $key=>$value)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $value->nama_kota }}</td>
							<td>{{ $value->kares->nama_kares }}</td>
							<td class="hidden">{{ $value->id_kota }}</td>
							<td class="hidden">{{ $value->kares_id }}</td>
							<td><button class="btn btn-default pull-right btn-xs" onClick="edit(this)" data-toggle="modal" data-target="#edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
							<td><button class="btn btn-danger pull-right btn-xs" onClick="hapus(this)" data-toggle="modal" data-target="#delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

{{-- modal create --}}
<div class="modal fade" id="create" role="dialog">
	<div class="modal-dialog">
		<form action="/kota" method="POST">
		{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        		<h4 class="modal-title custom_align" id="Heading">Create new kota</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name">
					</div>
					<div class="form-group">
						<label for="kares">Kares Name</label>
						<select name="kares" class="form-control">
							@foreach($kares as $key2=>$value2)
								<option value="{{ $value2->id_kares }}">{{ $value2->nama_kares }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>

{{-- modal Edit --}}
<div class="modal fade" id="edit" role="dialog">
	<div class="modal-dialog">
		<form action="/karesEdit" method="POST">
		{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        		<h4 class="modal-title custom_align" id="Heading">Edit division</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" value="name" id="name">
						<input type="hidden" class="form-control" name="id_kota" value="id_kota" id="id_kota">
					</div>
					<div class="form-group">
						<label for="kares">Kares Name</label>
						<select name="kares" class="form-control" id="kares">
							@foreach($kares as $key2=>$value2)
								<option value="{{ $value2->id_kares }}">{{ $value2->nama_kares }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>

{{-- modal delete --}}
<div class="modal fade" id="delete" role="dialog">
	<div class="modal-dialog">
		<form action="/kota" method="POST" id="formDelete">
		{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        		<h4 class="modal-title custom_align" id="Heading">Delete division</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<h4>Are you sure to delete this entry?</h4>
						<input type="hidden" name="_method" value="DELETE">
						{{-- <input type="text" class="form-control" name="name" value="name" id="name"> --}}
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	function edit(element) {
		var array = [];
    	for (var i = 0 ;i < element.parentNode.parentNode.cells.length; i++) {
    		// console.log(element.parentNode.parentNode.cells[i].innerHTML);
    		array.push(element.parentNode.parentNode.cells[i].innerHTML);
    	}
    	// console.log(array);
    	$('#name').val(array[1]);
    	$('#id_kota').val(array[3]);
    	$('#kares').val(array[4]);

	}
	function hapus(element) {
		var array = [];
    	for (var i = 0 ;i < element.parentNode.parentNode.cells.length; i++) {
    		array.push(element.parentNode.parentNode.cells[i].innerHTML);
    	}
    	var link = '/kota/'+array[3];
    	$('#formDelete').attr('action', link);
	}

</script>
@endsection