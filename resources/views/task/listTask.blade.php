@extends('layouts.admin')

@section('header-title')
	<h1>
		List Task
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
					{{-- <th>Owner</th> --}}
					<th>Deadline</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
	  		</thead>
	  		<tbody>
		  		@foreach ($tasks as $key => $task)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $task->questionare->judul_questionare }}</td>
						{{-- <td>{{ $task->user->name }}</td> --}}
						<td>{{ $task->questionare->deadline_questionare }}</td>
						<td>@if($task->status == 1)Complete @else Incomplete @endif</td>
						<td>@if($task->status != 1)
								<a class="btn btn-success btn-xs" href="/task/{{ $task->questionare_id }}"><i class="fa fa-pencil" aria-hidden="true"></i> Open</a>
							@else
								<a class="btn btn-primary btn-xs" href="/task/{{ $task->questionare_id }}/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
							@endif
						</td>
					</tr>
				@endforeach
	  		</tbody>
		</table>
	</div>
</div>
	
</div>
@endsection