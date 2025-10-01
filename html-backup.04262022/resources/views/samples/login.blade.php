@extends('layouts.samples')

@section('content')

	<form method="post">
		@csrf
		<div class="form-group">
			<label for="inputUsername">Username</label>
			<input type="text" class="form-control" name="username" id="inputUsername" aria-describedby="usernameHelp" placeholder="Enter username" />
			<small id="usernameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
		</div>
		<div class="form-group">
			<label for="inputPassword">Password</label>
			<input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" />
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>

@endsection

@section('scripts')

@endsection
