@extends('layouts.admin')

@section('header-title')
	<h1>
		Create Questionare
		<small>Optional description</small>
	</h1>
@endsection

@section('content')
<div class="row" style="margin-left: 1%">
	<p data-placement="top" data-toggle="tooltip" title="Create"><button class="btn btn-danger" data-title="Create" data-toggle="modal" data-target="#create" >Create</button></p>
</div>
<div class="row" style="margin-left: 1%; margin-right: 1%">
	<div class="panel panel-danger">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<table id="tableData" class="table table-bordred">
				<thead class="thead-inverse">
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Address</th>
						<th>Position</th>
						<th>Division</th>
						<th></th>
						<th></th>
					</tr>
		  		</thead>
		  		<tbody>
			  		@foreach ($users as $key => $user)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->alamat }}</td>
							<td>{{ $user->role->nama }}</td>
							<td>{{ $user->role->divisi }}</td>
							<td class="hidden">{{ $user->role_id }}</td>
							<td class="hidden" id="{{ $key+1 }}">{{ $user->id }}</td>
							<td><button class="btn btn-primary btn-xs editData" onClick="edit(this)"><i class="fa fa-edit" aria-hidden="true"></i> Edit</button></td>
							<td><button class="btn btn-danger btn-xs deleteData"><i class="fa fa-trash-o fa-lg"></i> Delete</button></td>
						</tr>
					@endforeach
		  		</tbody>
			</table>			
		</div>
	</div>
</div>
<div class="row">
	<ul class="pagination pull-right" style="margin-right: 5%">
		<li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
		<li class="active"><a href="#">1</a></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#">4</a></li>
		<li><a href="#">5</a></li>
		<li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
	</ul>
</div>

{{-- modal delete --}}
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        		<h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      		</div>
        	<div class="modal-body">
       			<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
      		</div>
	        <div class="modal-footer ">
	        	<form id="formDelete" action="user" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" >
					<input type="hidden" name="_method" value="DELETE" >
			        <button type="submit" class="btn btn-danger" id="delYes"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
		        </form>
	      	</div>
        </div>
 	</div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <form action="update" method="POST" id="formUpdate">
	        	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
		        	<h4 class="modal-title custom_align" id="Heading">Edit user</h4>
		      	</div>
		      	<div class="modal-body">
		      		<div class="form-group">
		      			<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			       		<input class="form-control " type="text" id="name" value="name" name="name">
		      		</div>
		      		<div class="form-group">
		      			<input class="form-control " type="text" id="id" name="id" hidden>
		      		</div>
		      		<div class="form-group">
		      			<input class="form-control " type="email" id="email" value="email" name="email" disabled>
		      		</div>
		      		<div class="form-group">
			        	<select name="role" id="role" class="form-control">
			        		@foreach ($roleList as $key => $role)
			        			<option value="{{ $role->id_role }}">{{ $role->nama }}</option>
			        		@endforeach
			        	</select>
			        </div>
			        <div class="form-group">
			        	<textarea rows="2" class="form-control" id="address" value="address" name="address"></textarea>
			        </div>
			        <div class="modal-footer ">
		        		<button type="submit" id="update" class="btn btn-success btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
		      		</div>
		      	</div>
	        </form>
	    </div>
  	</div>
</div>

{{-- modal create --}}
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
	    <div class="modal-content">
	    	<form action="create" method="POST">
	    		<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
		        	<h4 class="modal-title custom_align" id="Heading">Create new user</h4>
		      	</div>
		        <div class="modal-body">
		        	<div class="form-group">
		        		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
			       		<input class="form-control " type="text" placeholder="Name" name="name">
			        </div>
			        <div class="form-group">
			       		<input class="form-control " type="email" placeholder="Email" name="email">
			        </div>
			        <div class="form-group">
			        	<select name="role" class="form-control">
			        		@foreach ($roleList as $key => $role)
			        			<option name="role" value="{{ $role->id_role }}">{{ $role->nama }}</option>
			        		@endforeach
			        	</select>
			        </div>
			        <div class="form-group">
			        	<textarea rows="2" class="form-control" placeholder="Address" name="address"></textarea>
			        </div>
		      	</div>
		        <div class="modal-footer ">
		        	<button type="submit" class="btn btn-success btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Create</button>
		      	</div>
	    	</form>    
	    </div>
  	</div>
</div>

<script>
	// delete Data
	$('button.deleteData').on('click', function(e) {
		e.preventDefault();

		var array = [];

		var $row = $(this).closest('tr')
		$id = $row.find("td:nth-child(8)");

		$.each($id, function() {
	    	$pass = $(this).text();         
		});
		$('#delete').data('id', $id).modal('show');
	});
	$('#delYes').click(function (e) {
	    e.preventDefault();
	    $pass = 'delete/'+$pass
	    $('#formDelete').attr('action', $pass).submit();
	});
	function edit( element ) {
    	var array = [];
    	for (var i = 0 ;i < element.parentNode.parentNode.cells.length; i++) {
    		// console.log(element.parentNode.parentNode.cells[i].innerHTML);
    		array.push(element.parentNode.parentNode.cells[i].innerHTML);
    	}
    	console.log(array);
    	$('#name').val(array[1]);
    	$('#email').val(array[2]);
    	$('#address').val(array[3]);
    	$('#role').val(array[6]);
 		$('#id').val(array[7]);
  //   	pass = 'user/'+array[7];
		// $('#formUpdate').attr('action', pass);
    	$('#edit').data('user', array).modal('show');
	}
	$('#update').click(function (e) {
		e.preventDefault();
		$('#formUpdate').submit();
	});
</script>
@endsection