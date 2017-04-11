@extends('layouts.admin')

@section('header-title')
	<h1>
		Dealer
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
						<th>Email</th>
						<th>Dealer Code</th>
						<th>Dealer Name</th>
						<th>Address</th>
						<th>Status</th>
						<th>MD</th>
						<th>City</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $key=>$value)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $value->name }}</td>
							<td>{{ $value->email }}</td>
							<td>{{ $value->dealer->kode_dealer }}</td>
							<td>{{ $value->dealer->nama }}</td>
							<td>{{ $value->dealer->alamat }}</td>
							<td>{{ $value->dealer->status->nama_status }}</td>
							<td>{{ $value->dealer->md->nama_md }}</td>
							<td>{{ $value->dealer->kota->nama_kota }}</td>
							<td class="hidden">{{ $value->id }}</td>
							<td class="hidden">{{ $value->dealer->id_dealer }}</td>
							<td class="hidden">{{ $value->dealer->status->id_status_dealer }}</td>
							<td class="hidden">{{ $value->dealer->md->id_md }}</td>
							<td class="hidden">{{ $value->dealer->kota->id_kota }}</td>
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
		<form action="/dealer" method="POST">
		{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        		<h4 class="modal-title custom_align" id="Heading">Create new dealer</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email">
					</div>
					<div class="form-group">
						<label for="dealer">Dealer</label>
						<input type="text" class="form-control" name="dealer">
					</div>
					<div class="form-group">
						<label for="code">Dealer Code</label>
						<input type="text" class="form-control" name="code">
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" class="form-control" name="address">
					</div>
					<div class="form-group">
						<label for="status">Status Dealer</label>
						<select name="status" class="form-control">
							@foreach($statuses as $key=>$value)
								<option value="{{ $value->id_status_dealer }}">{{ $value->nama_status }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="md">MD</label>
						<select name="md" class="form-control">
							@foreach($mds as $key=>$value)
								<option value="{{ $value->id_md }}">{{ $value->nama_md }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="city">City</label>
						<select name="city" class="form-control">
							@foreach($kotas as $key=>$value)
								<option value="{{ $value->id_kota }}">{{ $value->nama_kota }}</option>
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
		<form action="/dealerEdit" method="POST">
		{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        		<h4 class="modal-title custom_align" id="Heading">Create new dealer</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" id="name">
						<input type="hidden" name="id" value="id" id="id">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" disabled="">
					</div>
					<div class="form-group">
						<label for="dealer">Dealer</label>
						<input type="text" class="form-control" name="dealer" id="dealer">
						<input type="hidden" name="id_dealer" value="id_dealer" id="id_dealer">
					</div>
					<div class="form-group">
						<label for="code">Dealer Code</label>
						<input type="text" class="form-control" name="code" id="code">
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" class="form-control" name="address" id="address">
					</div>
					<div class="form-group">
						<label for="status">Status Dealer</label>
						<select name="status" class="form-control" id="status">
							@foreach($statuses as $key=>$value)
								<option value="{{ $value->id_status_dealer }}">{{ $value->nama_status }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="md">MD</label>
						<select name="md" class="form-control" id="md">
							@foreach($mds as $key=>$value)
								<option value="{{ $value->id_md }}">{{ $value->nama_md }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="city">City</label>
						<select name="city" class="form-control" id="city">
							@foreach($kotas as $key=>$value)
								<option value="{{ $value->id_kota }}">{{ $value->nama_kota }}</option>
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
		<form action="/division" method="POST" id="formDelete">
		{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        		<h4 class="modal-title custom_align" id="Heading">Delete Dealer</h4>
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
    	console.log(array);
    	$('#id').val(array[9]);
    	$('#code').val(array[3]);
    	$('#name').val(array[1]);
    	$('#email').val(array[2]);
    	$('#dealer').val(array[4]);
    	$('#address').val(array[5]);
    	$('#id_dealer').val(array[10]);
    	$('#status').val(array[11]);
    	$('#md').val(array[12]);
    	$('#city').val(array[13]);
	}
	function hapus(element) {
		var array = [];
    	for (var i = 0 ;i < element.parentNode.parentNode.cells.length; i++) {
    		array.push(element.parentNode.parentNode.cells[i].innerHTML);
    	}
    	var link = '/dealer/'+array[9];
    	$('#formDelete').attr('action', link);
	}

</script>
@endsection