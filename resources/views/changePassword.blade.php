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
		<div class="panel-heading">
			@if (isset($status))
				{{ $status }}
			@endif
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" method="POST" action="/change">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="email" class="col-md-4 control-label">E-Mail Address</label>
					<div class="col-md-6">
                        <input id="email" type="email" class="form-control" value="{{ $user->email }}" disabled>
                        <input id="email" type="hidden" class="form-control" name="email" value="{{ $user->email }}">
                    </div>
				</div>
				<div class="form-group">
                    <label for="password" class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-danger">
                            Change Password
                        </button>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>

@endsection