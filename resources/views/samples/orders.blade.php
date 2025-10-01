@extends('layouts.samples')

@section('content')

<div class="container-fluid">
	<div class="row">
        <div class="col">

            @if ($data['successful_order'])
                <div class="alert alert-success">
                    Your order has been submitted and is now pending approval.
                </div>
            @endif

            <div class="row">
                <div class="col-6">
                    <h4 style="margin-bottom: 1rem;">Orders Pending Approval</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    @if (session('address_1'))
                        <a href="/cart" class="button btn btn-primary">Current Order</a>
                    @else
                        <a href="/address" class="button btn btn-primary">Create New Order</a>
                    @endif
                </div>
            </div>

            <div class="inv-loading">
                <p style="font-size: smaller;">Data is loading...</p>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <table class="inv-table table table-bordered table-striped table-hover {{ (count($data['pending']) ? 'datatable-orders-pending' : '') }}" style="display: none;">
                <thead class="thead-light">
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Company</th>
                    <th scope="col">Attention</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Need By</th>
                    <th scope="col">&nbsp;</th>
                </thead>
                <tbody>
                    @forelse ($data['pending'] as $order)
                        <tr role="row" data-order-id="{{ $order->id }}" class="order-row">
                            <td>{{ $order->id }}</td>
                            <td>{{ date("m/d/Y", strtotime($order->created_date)) }}</td>
                            <td>{{ $order->ship_to_company }}</td>
                            <td>{{ $order->ship_to_attention }}</td>
                            <td>{{ $order->ship_to_city }}</td>
                            <td>{{ $order->ship_to_state }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ ($order->need_by == "0000-00-00" ? "" : date("m/d/Y", strtotime($order->need_by))) }}</td>
                            <td>
                                <a href="#" class="btn btn-primary edit-order" data-order-id="{{ $order->id }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No pending orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <h4 style="margin-top: 1rem; margin-bottom: 1rem;">Orders Getting Packed & Shipped</h4>

            <div class="inv-loading">
                <p style="font-size: smaller;">Data is loading...</p>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <table class="inv-table table table-bordered table-striped table-hover {{ (count($data['packing']) ? 'datatable-orders-packing' : '') }}" style="display: none;">
                <thead class="thead-light">
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Company</th>
                    <th scope="col">Attention</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Need By</th>
                    <th scope="col">Ship Via</th>
                </thead>
                <tbody>
                    @forelse ($data['packing'] as $order)
                        <tr role="row" data-order-id="{{ $order->id }}" class="order-row">
                            <td>{{ $order->id }}</td>
                            <td>{{ date("m/d/Y", strtotime($order->created_date)) }}</td>
                            <td>{{ $order->ship_to_company }}</td>
                            <td>{{ $order->ship_to_attention }}</td>
                            <td>{{ $order->ship_to_city }}</td>
                            <td>{{ $order->ship_to_state }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ ($order->need_by == "0000-00-00" ? "" : date("m/d/Y", strtotime($order->need_by))) }}</td>
                            <td>{{ $order->ship_method_description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No orders getting packed.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <h4 style="margin-top: 1rem; margin-bottom: 1rem;">Orders Shipped / In Transit</h4>

            <div class="inv-loading">
                <p style="font-size: smaller;">Data is loading...</p>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <table class="inv-table table table-bordered table-striped table-hover {{ (count($data['shipping']) ? 'datatable-orders-shipping' : '') }}" style="display: none;">
                <thead class="thead-light">
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Company</th>
                    <th scope="col">Attention</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Ship Time</th>
                    <th scope="col">Ship Cost</th>
                    <th scope="col">Ship Via</th>
                </thead>
                <tbody>
                    @forelse ($data['shipping'] as $order)
                        <tr role="row" data-order-id="{{ $order->id }}" class="order-row">
                            <td>{{ $order->id }}</td>
                            <td>{{ date("m/d/Y", strtotime($order->created_date)) }}</td>
                            <td>{{ $order->ship_to_company }}</td>
                            <td>{{ $order->ship_to_attention }}</td>
                            <td>{{ $order->ship_to_city }}</td>
                            <td>{{ $order->ship_to_state }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ (strlen($order->shipping_time > 0) ? date("m/d/Y", strtotime($order->shipping_time)) : "Unknown") }}</td>
                            <td>${{ $order->shipping_cost }}</td>
                            <td>{{ $order->ship_method_description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No orders shipped or in transit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        
    </div>
</div>

@endsection

@section('scripts')

<style>
    .order-row:hover {
        cursor: pointer;
    }
</style>

<script>
    var cart = {!! json_encode($data['cart']) !!};
    var display = {!! json_encode($data['display']) !!};

    function LoadModal(item_id) {
        $("#modal-src").attr("src", "cart/modal/" + item_id);

        let name = $("#anchor-id-" + item_id).html();
        let cart_qty = cart[item_id] ? cart[item_id] : 0;
        let display_qty = display[item_id] ? display[item_id] : 0;

        $("#item-name").html(name);
        $(".modal-inventory-id").attr("data-inventory-id", item_id);

        $("#modal-qty").val(cart_qty);
        $("#modal-display").val(display_qty);
    }

    $(document).ready(function() {

        // Edit Order
        $(".edit-order").click(function() {
            // Prevent the click event from propagating to the view order subroutine.
            event.stopPropagation();

            // Get the Order ID.
            let orderId = $(this).data("order-id");

            // Send a request to edit a pending order.
            $.post("/orders/edit", { "_token" : "{{ csrf_token() }}", "id" : orderId }, function (response) {
                console.log(response);

                let json = $.parseJSON(response);

                if (json.status == 0) {
                    alert(json.message);
                } else {
                    document.location = "/cart";
                }
            });
        });

        // Click an order to go to the details view.
        $(".order-row").click(function() {
            let orderId = $(this).data("order-id");

            document.location = "/orders/" + orderId;
        });

        // Initialize DataTable :: Pending Approval Orders
        $(".datatable-orders-pending").DataTable({
            "bPaginate": true,
            "pageLength": 10,
            "order" : [[ 0, "desc" ]],
            "bFilter": true
        });

        // Initialize DataTable :: Packing Orders
        $(".datatable-orders-packing").DataTable({
            "bPaginate": true,
            "pageLength": 10,
            "order" : [[ 0, "desc" ]],
            "bFilter": true
        });

        // Initialize DataTable :: Shipped / In Transit Orders
        $(".datatable-orders-shipping").DataTable({
            "bPaginate": true,
            "pageLength": 10,
            "order" : [[ 0, "desc" ]],
            "bFilter": true
        });

        // Initialize DataTable.
        $(".datatable-inventory").DataTable({
            "bPaginate": true,
            "pageLength": 50,
            "bFilter": true,
            "columnDefs" : [
                { "visible" : false, "targets" : [0] }
            ]
        });

        // Show the inventory table once finished loading.
        $(".inv-loading").hide();
        $(".inv-table").show();

        // Highlight text on input click.
        $(".cart-input").focus(function() {
            $(this).select();
        });

        // Modify Cart Value
        $(".cart-input").change(function() {
			let inventoryId = $(this).attr("data-inventory-id");
            let newQty = parseInt($(this).val());
            let displayUnits = $(this).hasClass("display-units") ? 1 : 0;

			$.post("/cart/modify", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : newQty, "displayUnits" : displayUnits }, function (qty) {
                if (qty !== newQty) {
                    if (displayUnits) {
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                        $("#modal-display").val(qty);

                        display[inventoryId] = qty;
                    } else {
                        $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                        $("#modal-qty").val(qty);

                        cart[inventoryId] = qty;
                    }
                }

                $("#checkout-btn").show();
			});
		});

        // Add to Cart
        $(".add-to-cart").click(function() {
			let inventoryId = $(this).attr("data-inventory-id");
            let displayUnits = $(this).hasClass("display-units") ? 1 : 0;

			$.post("/cart/add", { "_token" : "{{ csrf_token() }}", "inventory_id" : inventoryId, "quantity" : 1, "displayUnits" : displayUnits }, function (qty) {
                if (displayUnits) {
                    $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .display-units").val(qty);
                    $("#modal-display").val(qty);

                    display[inventoryId] = qty;
                } else {
				    $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                    $("#modal-qty").val(qty);

                    cart[inventoryId] = qty;
                }

                $("#checkout-btn").show();
			});

            return false;
		});

        console.log("Ready...");
    });
</script>

@endsection
