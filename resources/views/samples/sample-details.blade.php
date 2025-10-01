@php

/*
 * Note:
 *
 * This file is no longer used and only remains at the time of writing 
 * because we have not yet added a repo for this project.
 *
 * See: sample-details-modal.blade.php
 */

@endphp

@extends('layouts.samples')

@section('content')

<!--
<div class="container">
	<div class="row">
        <div class="col">
            @if ($data['error'])
                <div class="alert alert-danger"><strong>Error</strong>: This inventory item could not be found.</div>
            @else

                <h3>{{ $data['sample']->description }}</h3>

                @if (count($data['slideshow']) > 0)
                    <div id="sampleSlideshow" class="carousel slide" data-ride="carousel" style="margin-top: 1rem; margin-bottom: 1rem;">
                        <ol class="carousel-indicators">
                            @foreach ($data['slideshow'] as $key => $url)
                                @if ($key == 0)
                                    <li data-target="#sampleSlideshow" data-slide-to="{{ $key }}" class="active"></li>
                                @else
                                    <li data-target="#sampleSlideshow" data-slide-to="{{ $key }}"></li>
                                @endif
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($data['slideshow'] as $key => $url)
                                @if ($key == 0)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ $url }}" alt="Image #{{ $key + 1 }}">
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ $url }}" alt="Image #{{ $key + 1 }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#sampleSlideshow" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#sampleSlideshow" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt>Stock Number</dt>
                            <dd>{{ $data['sample']->stock_number }}</dd>

                            <dt>GTIN14</dt>
                            <dd>{{ $data['sample']->gtin14 }}</dd>

                            <dt>Brand</dt>
                            <dd>{{ $data['sample']->brand }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <dt>Category</dt>
                            <dd>{{ $data['sample']->product_sales_category }}</dd>

                            <dt>Package</dt>
                            <dd>{{ $data['sample']->package_count }} x {{ $data['sample']->container_net_weight }} {{ $data['sample']->container_net_weight_uom }} CAN(S)</dd>

                        </dl>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-6">
                        
                        <div class="d-flex align-items-center">
                            <div class="mr-2">
                                In Cart:
                            </div>
                            <div class="cart-quantity-label mr-2" data-inventory-id="{{ $data['inventory_id'] }}">
                                <input type="text" class="cart-input sample-units form-control form-control-text" value="{{ isset($data['cart'][$data['inventory_id']]) ? $data['cart'][$data['inventory_id']] : 0 }}" data-inventory-id="{{ $data['inventory_id'] }}" />
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary add-to-cart" data-inventory-id="{{ $data['inventory_id'] }}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        
                        <div class="d-flex align-items-center">
                            <div class="mr-2">
                                Display Units Only:
                            </div>
                            <div class="cart-quantity-label mr-2" data-inventory-id="{{ $data['inventory_id'] }}">
                                <input type="text" class="cart-input display-units form-control form-control-text" value="{{ isset($data['display'][$data['inventory_id']]) ? $data['display'][$data['inventory_id']] : 0 }}" data-inventory-id="{{ $data['inventory_id'] }}" />
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary add-to-cart display-units" data-inventory-id="{{ $data['inventory_id'] }}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
        </div>        
    </div>
</div>
-->

@endsection

@section('scripts')

<style>
    dd {
        margin-bottom: 0;
    }

    #sampleSlideshow {
        background-color: #6c757d;
    }

    #sampleSlideshow img {
        max-height: 400px !important;
        width: fit-content !important;
        background-size: auto !important;
        text-align: center;
        margin: auto;
        padding-bottom: 1.85rem;
        padding-top: 0.35rem;
    }

    .carousel-indicators li {
        border-bottom: 0 !important;
    }
</style>

<script>
    /*
    $(document).ready(function() {
        // Highlight text on input click.
        $(".cart-input").focus(function() {
            $(this).select();
        });

        // Modify Cart Value
        $(".cart-input").change(function() {
			let inventoryId = $(this).data("inventory-id");
            let newQty = parseInt($(this).val());
            let displayUnits = $(this).hasClass("display-units") ? 1 : 0;

			$.post("/cart/modify", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : newQty, "displayUnits" : displayUnits }, function (qty) {
                if (qty !== newQty) {
                    if (displayUnits)
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                    else
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                }
			});
		});

        // Add to Cart
		$(".add-to-cart").click(function() {
			let inventoryId = $(this).data("inventory-id");
            let displayUnits = $(this).hasClass("display-units") ? 1 : 0;

			$.post("/cart/add", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : 1, "displayUnits" : displayUnits }, function (qty) {
                if (displayUnits)
                    $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                else
				    $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
			});

            return false;
		});
    });
    */
</script>

@endsection
