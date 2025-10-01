@extends('layouts.samples')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8">
			<form method="post">
				@csrf

				<div class="form-group">
					<label for="inputUsername">Username</label>
					<input type="text" class="form-control" name="username" id="inputUsername" aria-describedby="usernameHelp" placeholder="Enter username" value="{{ isset($data['username']) ? $data['username'] : old('username') }}" />
					<small id="usernameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				</div>

				<div class="form-group">
					<label for="inputPassword">Password</label>
					<input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" />
				</div>

				@if ($errors->any())
					<div class="alert alert-danger">
							@foreach ($errors->all() as $error)
								<div>{{ $error }}</div>
							@endforeach
					</div>
				@endif

				@if ($data['error'])
					<div class="alert alert-danger">
						{{ $data['error_message'] }}
					</div>
				@endif

				
				<div style="display: inline-block;">
					<button type="submit" class="btn btn-primary">Submit</button>

					<small class="ml-3">
						... or, sign in via a secure third party ...
					</small>

					<div class="btn btn-outline-primary ml-2" onClick="OAuth();">
						<i class="fa-solid fa-key"></i> <div class="ml-1" style="display: inline-block; position: relative;">Secure Sign In</div>
					</div>
				</div>
			</form>


		</div>
	</div>
</div>

@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			// Automatically place the cursor in the username box and highlight any text (if present).
			$("#inputUsername").focus().select();
		});

		function OAuth() {
			document.location = "/login/oauth?action=login";
			return false;
		}
	</script>
@endsection