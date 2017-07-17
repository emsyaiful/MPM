@extends('layouts.admin')

@section('header-title')
	<h1>
		Other Questionare
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
						<!-- <th>Report</th> -->
						{{-- <th>Edit</th> --}}
						<th></th>
						
					</tr>
		  		</thead>
		  		<tbody>
			  		@foreach ($questionares as $key => $questionare)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $questionare->questionare->judul_questionare }}</td>
							<td>{{ $questionare->owner->name }}</td>
							<td>{{ $questionare->questionare->deadline_questionare }}</td>
							<td><a href="/questionare/other/{{ $questionare->questionare_id }}" class="btn btn-success pull-left btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
						</tr>
					@endforeach
		  		</tbody>
			</table>
		</div>
	</div>
</div>
@endsection