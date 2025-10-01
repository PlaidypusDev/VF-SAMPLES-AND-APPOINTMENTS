@extends('layouts.samples')

@section('content')

<div class="container-fluid">
	<div class="row">
        <div class="col">
            @if ($data['error'])
                <div class="alert alert-danger"><strong>Error</strong>: This order could not be found.</div>
            @else
                <div class="d-flex align-items-center justify-content-between">
                    <h4 style="margin-bottom: 0;">Order #{{ $data['order_id'] }}</h4>
                    <div>
                        Reason: {!! (strlen($data['order']->reason) > 0) ? "<strong>" . $data['order']->reason . "</strong>" : "None" !!}
                    </div>
                    @if ($data['order']->priority)
                        <div class="alert alert-danger" style="font-weight: bold; margin-bottom: 0;">
                            PRIORITY ORDER
                        </div>
                    @endif
                </div>

                <hr />

                <div class="d-flex justify-content-between align-items-top">

                    @if ($data['order']->status == 3)
                    <div class="col-3">
                        <dl>
                            <dt>Shipping Info</dt>
                            <dd>Shipped on: {{ date("m/d/Y h:i A", strtotime($data['order']->shipping_time)) }}</dd>
                            <dd>Ship Via: {{ $data['order']->ship_method_description }}</dd>
                            <dd>Shipping Cost: ${{ $data['order']->total_shipping_cost }}</dd>
                            <dd>{{ $data['order']->ups_shipping_info }}</dd>

                            @if (isset($data['order']->ups_tracking_url))
                                <dd><a target="tab" href="{{ $data['order']->ups_tracking_url }}">Click Here to Track</a></dd>
                            @endif
                        </dl>
                    </div>
                    @endif
                    
                    <div class="{{ $data['order']->status == 1 ? 'col-6' : 'col-3' }}">
                        <dl>
                            <dt>Ship To</dt>
                            <dd>{{ $data['order']->ship_to_company }}</dd>
                            <dd>ATTN: {{ $data['order']->ship_to_attention }}</dd>
                            <dd>
                                <address>
                                    {{ $data['order']->ship_to_address_1 }}
                                    @if ($data['order']->ship_to_address_2)
                                        <br />{{ $data['order']->ship_to_address_2 }}
                                    @endif
                                    <br />{{ $data['order']->ship_to_city }}, {{ $data['order']->ship_to_state }}&nbsp;&nbsp;{{ $data['order']->ship_to_zipcode }}
                                    <br />{{ $data['order']->ship_to_loc_type }}
                                </address>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-3">
                        <dl>
                            <dd>Must Receive by: {{ ($data['order']->need_by == "0000-00-00") ? "N/A" : $data['order']->need_by }}</dd>
                            <dd>UPS Account: {{ $data['order']->ups_account_description }}</dd>
                            <dd>Insured Value: ${{ $data['order']->insured_value }}</dd>
                            <dd>Current Status: {{ $data['order']->status_description }}</dd>
                        </dl>
                    </div>
                    <div class="col-3">
                        <dl>
                            <dd>Order Date: {{ date("m/d/Y", strtotime($data['order']->created_date)) }}</dd>
                            <dd>Receiver Phone: {{ $data['order']->phone_number }}</dd>
                        </dl>
                    </div>
                </div>

                <hr />

                @if ($data['sample_quantity'] > 0)

                    <h5>Products Requested</h5>

                    <table class="table table-bordered table-striped table-hover datatable-order-details">

                        <thead class="thead-light">
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Category</th>
                            <th scope="col">Stock Number</th>
                            <th scope="col">Container</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Order Qty</th>
                        </thead>

                        <tbody>
                            @forelse ($data['sample_details'] as $item)
                                @if (isset($data['stock'][$item->stock_number]))
                                    <tr role="row" data-inventory-id="{{ $item->id }}" class="inventory-row">
                                        <td>{{ $data['counter'] ++ }}</td>
                                        <td class="show-slideshow" id="inventory-id-{{ $data['stock'][$item->stock_number]->id }}" data-inventory-id="{{ $data['stock'][$item->stock_number]->id }}"><a href="#" id="anchor-id-{{ $data['stock'][$item->stock_number]->id }}" data-toggle="modal" data-target="#itemModal" onClick="LoadModal({{ $data['stock'][$item->stock_number]->id }});" data-href="cart/{{ $data['stock'][$item->stock_number]->id }}">{{ $item->description }}</a></td>
                                        <td>{{ $data['stock'][$item->stock_number]->product_sales_category }}</td>
                                        <td>{{ $item->stock_number }}</td>
                                        <td>{{ $data['stock'][$item->stock_number]->packaging_container_description }}</td>
                                        <td>{{ $data['stock'][$item->stock_number]->brand }}</td>
                                        <td class="cart-quantity-label" data-inventory-id="{{ $item->id }}">
                                            {{ $item->quantity }}
                                        </td>
                                    </tr>
                                @else
                                    <tr role="row" data-inventory-id="{{ $item->id }}" class="inventory-row">
                                        <td>{{ $data['counter'] ++ }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td><strong>[ITEM NOT FOUND]</strong></td>
                                        <td>{{ $item->stock_number }}</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td class="cart-quantity-label" data-inventory-id="{{ $item->id }}">
                                            {{ $item->quantity }}
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="7">No inventory items found.</td>
                                </tr>
                            @endforelse

                            <tfoot>
                                <tr>
                                    <td colspan="6">Total:</td>
                                    <td colspan="1">{{ $data['sample_quantity'] }}</td>
                                </tr>
                            </tfoot>
                        </tbody>

                    </table>

                @endif

                @if ($data['display_quantity'] > 0)

                    <h5 class="mt-4">Display Units Requested</h5>

                    <table class="table table-bordered table-striped table-hover datatable-order-details">

                        <thead class="thead-light">
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Category</th>
                            <th scope="col">Stock Number</th>
                            <th scope="col">Container</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Order Qty</th>
                        </thead>

                        <tbody>
                            @forelse ($data['display_details'] as $item)
                                @if (isset($data['stock'][$item->stock_number]))
                                    <tr role="row" data-inventory-id="{{ $item->id }}" class="inventory-row">
                                        <td>{{ $data['counter'] ++ }}</td>
                                        <td class="show-slideshow" id="inventory-id-{{ $data['stock'][$item->stock_number]->id }}" data-inventory-id="{{ $data['stock'][$item->stock_number]->id }}"><a href="#" id="anchor-id-{{ $data['stock'][$item->stock_number]->id }}" data-toggle="modal" data-target="#itemModal" onClick="LoadModal({{ $data['stock'][$item->stock_number]->id }});" data-href="cart/{{ $data['stock'][$item->stock_number]->id }}">{{ $item->description }}</a></td>
                                        <td>{{ $data['stock'][$item->stock_number]->product_sales_category }}</td>
                                        <td>{{ $item->stock_number }}</td>
                                        <td>{{ $data['stock'][$item->stock_number]->package_count . " X " . $data['stock'][$item->stock_number]->packaging_container_description }}</td>
                                        <td>{{ $data['stock'][$item->stock_number]->brand }}</td>
                                        <td class="cart-quantity-label" data-inventory-id="{{ $item->id }}">
                                            {{ $item->quantity }}
                                        </td>
                                    </tr>
                                @else
                                    <tr role="row" data-inventory-id="{{ $item->id }}" class="inventory-row">
                                        <td>{{ $data['counter'] ++ }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td><strong>[ITEM NOT FOUND]</strong></td>
                                        <td>{{ $item->stock_number }}</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td class="cart-quantity-label" data-inventory-id="{{ $item->id }}">
                                            {{ $item->quantity }}
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tf>
                                    <td colspan="7">No inventory items found.</td>
                                </tf>
                            @endforelse

                            <tfoot>
                                <tr class="table-foot">
                                    <td colspan="6">Total:</td>
                                    <td colspan="1">{{ $data['display_quantity'] }}</td>
                                </tr>
                            </tfoot>
                        </tbody>

                    </table>

                @endif

                <!--table class="table table-bordered table-striped table-hover overall">
                    <tr>
                        <td>Overall Total Quantity:</td>
                        <td>{{ $data['quantity'] }}</td>
                    </tr>
                </table-->

                @if (strlen($data['order']->shipment_notes))
                    <div class="alert alert-secondary"><strong>Order Notes:</strong> {{ $data['order']->shipment_notes }}</div>
                @endif

            @endif
        </div>        
    </div>
</div>

@endsection

@section('scripts')

<style>
    dd {
        margin-bottom: 0;
    }

    tfoot td, .overall td {
        font-size: larger;
        font-weight: bold;
    }
</style>

<script>
    var cart = {!! json_encode($data['cart']) !!};
    var display = {!! json_encode($data['display']) !!};

    function LoadModal(item_id) {
        $("#modal-src").attr("src", "../cart/modal/" + item_id);

        let name = $("#anchor-id-" + item_id).html();
        let cart_qty = cart[item_id] ? cart[item_id] : 0;
        let display_qty = display[item_id] ? display[item_id] : 0;

        $("#item-name").html(name);
        $(".modal-inventory-id").attr("data-inventory-id", item_id);

        $("#modal-qty").val(cart_qty);
        $("#modal-display").val(display_qty);
    }
    
    $(document).ready(function() {
        // Initialize DataTable :: Order Details
        $(".datatable-order-details").DataTable({
            "bFilter": false,
            "bPaginate": false,
            "sDom": "lfrt",
            "order": [[ 1, "asc" ]],
            "columnDefs" : [
                { "visible" : false, "targets" : [0] }
            ]
        });

        // Highlight text on input click.
        $(".cart-input").focus(function() {
            $(this).select();
        });

        // Modify Cart Value
        $("body").on("change", ".cart-input", function() {
			let inventoryId = $(this).attr("data-inventory-id");
            let newQty = parseInt($(this).val());
            let displayUnits = $(this).hasClass("display-units") ? 1 : 0;

			$.post("/cart/modify", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : newQty, "displayUnits" : displayUnits }, function (qty) {
                if (qty !== newQty) {
                    if (displayUnits) {
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                        $("#modal-display").val(qty);

                        display[inventoryId] = qty;

                        if (!$("#display-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                            location.reload();
                        }
                    } else {
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                        $("#modal-qty").val(qty);

                        cart[inventoryId] = qty;

                        if (!$("#sample-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                            location.reload();
                        }
                    }
                }

                $("#checkout-btn").show();
			});
		});

        // Add to Cart
        $("body").on("click", ".add-to-cart", function() {
            //$(".add-to-cart").click(function() {
			let inventoryId = $(this).attr("data-inventory-id");
            let displayUnits = $(this).hasClass("display-units") ? 1 : 0;

			$.post("/cart/add", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : 1, "displayUnits" : displayUnits }, function (qty) {
                if (displayUnits) {
                    $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                    $("#modal-display").val(qty);

                    display[inventoryId] = qty;

                    if (!$("#display-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                        location.reload();
                    }
                } else {
				    $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                    $("#modal-qty").val(qty);

                    cart[inventoryId] = qty;

                    if (!$("#sample-sidebar-items .list-group-item[data-inventory-id=" + inventoryId + "]").length) {
                        location.reload();
                    }
                }

                $("#checkout-btn").show();
			});

            return false;
		});
    });
</script>

@endsection
