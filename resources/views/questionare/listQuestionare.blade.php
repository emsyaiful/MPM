@extends('layouts.admin')

@section('header-title')
	<h1>
		My Questionare
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
						<th>Title</th>
						<th>Owner</th>
						<th>Deadline</th>
						<th colspan="2" class="text-center">Report</th>
						{{-- <th>Edit</th> --}}
						<th></th>
						
					</tr>
		  		</thead>
		  		<tbody>
			  		@foreach ($questionares as $key => $questionare)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $questionare->judul_questionare }}</td>
							<td>{{ $questionare->user->name }}</td>
							<td>{{ $questionare->deadline_questionare }}</td>
							<td><a href="/questionare/{{ $questionare->id_questionare }}" class="btn btn-success pull-right btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
							<td><a href="/reportExcel/{{ $questionare->id_questionare }}" class="btn btn-danger btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Download</a></td>
							<td><a class="btn btn-primary btn-xs" href="/questionare/{{ $questionare->id_questionare }}/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a></td>
							<td><button class="btn btn-danger btn-xs" onclick="deleteModal('{{ $questionare->id_questionare }}')"><i class="fa fa-trash-o fa-lg"></i></span> Delete</button></td>
						</tr>
					@endforeach
		  		</tbody>
			</table>
		</div>
	</div>
</div>

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

<script>
	var id_questionare;
	function deleteModal(id) {
		id_questionare = id;
		$('#delete').modal();
	}
	$('#delYes').click(function (e) {
	    e.preventDefault();
	    $('#formDelete').attr('action', '/questionare/'+id_questionare).submit();
	});
</script>
@endsection