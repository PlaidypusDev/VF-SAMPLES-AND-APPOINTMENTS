@extends('layouts.samples')

@section('content')

	@foreach ($data['inventory'] as $item)
		<div class="item">
			<div class="item-description">{{ $item->description }}</div>
			<div class="item-brand">{{ $item->brand }}</div>
			<div class="item-category">{{ $item->product_sales_category }}</div>
			<button class="btn btn-primary">Add to Cart</button>
		</div>
	@endforeach

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        console.log("Ready...");

//$.post("/samples/login", { "_token" : "{{ csrf_token() }}", "username" : "duckbill", "password" : "savemyconor" }, function (response) {
//    console.log(response);
//});

    });
</script>

@endsection
