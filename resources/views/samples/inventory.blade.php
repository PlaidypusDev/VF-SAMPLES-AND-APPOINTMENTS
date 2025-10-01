@php

/*
 * Note:
 *
 * This file is no longer used and only remains at the time of writing 
 * because we have not yet added a repo for this project.
 *
 * See: inventory-table.blade.php
 */

@endphp

@extends('layouts.samples')

@section('content')

<!--
<div class="container">
	<div class="row">

		@foreach ($data['inventory'] as $item)
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">

				<div class="card" style="">
					<img class="card-img-top"
					src="{{ $item->product_image_url_1 }}"
					alt="Canned Chili">
					<div class="card-body">
						<h5 class="card-title">{{ $item->description }}</h5>
						<p class="card-text">{{ $item->description }}</p>
						<p class="card-text">{{ $item->package_count }} x {{ $item->container_net_weight }} {{ $item->container_net_weight_uom }}</p>

						<a href="#" class="btn btn-primary add-to-cart" data-inventory-id="{{ $item->id }}">
							<i class="fa-solid fa-cart-shopping"></i>
						</a>

						<p class="card-text text-right"><small class="text-muted cart-quantity-label" data-inventory-id="{{ $item->id }}">{{ isset($data['cart'][$item->id]) ? $data['cart'][$item->id] . " in your cart" : '' }}</small></p>
					</div>
				</div>

			</div>
		@endforeach
		
	</div>
</div>
-->

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
		$(".add-to-cart").click(function() {
			let inventoryId = $(this).data("inventory-id");

			$.post("/cart/add", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : 1 }, function (qty) {
				$(".cart-quantity-label[data-inventory-id=" + inventoryId + "]").html(qty + " in your cart");
			});
		});

        console.log("Ready...");
    });
</script>

@endsection
