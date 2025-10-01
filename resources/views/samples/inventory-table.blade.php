@extends('layouts.samples')

@section('content')

<div class="container-fluid">
	<div class="row">
        <div class="col">

            <div class="row">
                <div class="col">
                    <h4 style="margin-bottom: 1rem;">Samples</h4>
                </div>
            </div>

            <div id="inv-loading">
                <p style="font-size: smaller;">Data is loading...</p>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <table id="inv-table" class="table table-bordered table-striped table-hover datatable-standard datatable-inventory" style="display: none;">
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
                    @forelse ($data['all_inventory'] as $item)
                        <tr role="row" data-inventory-id="{{ $item->id }}" class="inventory-row">
                            <td>{{ $data['counter'] ++ }}</td>
                            <td class="show-slideshow" id="inventory-id-{{ $item->id }}" data-inventory-id="{{ $item->id }}"><a href="#" id="anchor-id-{{ $item->id }}" data-toggle="modal" data-target="#itemModal" onClick="LoadModal({{ $item->id }});" data-href="cart/{{ $item->id }}">{{ $item->description }}</a></td>
                            <td>{{ $item->product_sales_category }}</td>
                            <td>{{ $item->stock_number }}</td>
                            <td>{{ $item->packaging_container_description }}</td>
                            <td>{{ $item->brand }}</td>
                            <td class="cart-quantity-label" data-inventory-id="{{ $item->id }}">

                                <div class="d-flex">
                                    <select name="" style="flex: 2;" class="cart-input sample-units form-control form-control-select" value="{{ isset($data['cart'][$item->id]) ? $data['cart'][$item->id] : 0 }}" data-inventory-id="{{ $item->id }}">
                                        <option value="0" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 0 ? "selected" : "" }}>0</option>
                                        <option value="1" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 1 ? "selected" : "" }}>1</option>
                                        <option value="2" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 2 ? "selected" : "" }}>2</option>
                                        <option value="3" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 3 ? "selected" : "" }}>3</option>
                                        <option value="4" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 4 ? "selected" : "" }}>4</option>
                                        <option value="5" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 5 ? "selected" : "" }}>5</option>
                                        <option value="6" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 6 ? "selected" : "" }}>6</option>
                                        <option value="7" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 7 ? "selected" : "" }}>7</option>
                                        <option value="8" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 8 ? "selected" : "" }}>8</option>
                                        <option value="9" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] == 9 ? "selected" : "" }}>9</option>
                                        <option value="10" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 10 ? "selected" : "" }}>10</option>
                                        <option value="11" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 11 ? "selected" : "" }}>11</option>
                                        <option value="12" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 12 ? "selected" : "" }}>12</option>
                                        <option value="13" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 13 ? "selected" : "" }}>13</option>
                                        <option value="14" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 14 ? "selected" : "" }}>14</option>
                                        <option value="15" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 15 ? "selected" : "" }}>15</option>
                                        <option value="16" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 16 ? "selected" : "" }}>16</option>
                                        <option value="17" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 17 ? "selected" : "" }}>17</option>
                                        <option value="18" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 18 ? "selected" : "" }}>18</option>
                                        <option value="19" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 19 ? "selected" : "" }}>19</option>
                                        <option value="20" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 20 ? "selected" : "" }}>20</option>

                                        <option value="21" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 21 ? "selected" : "" }}>21</option>
                                        <option value="22" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 22 ? "selected" : "" }}>22</option>
                                        <option value="23" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 23 ? "selected" : "" }}>23</option>
                                        <option value="24" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 24 ? "selected" : "" }}>24</option>
                                        <option value="25" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 25 ? "selected" : "" }}>25</option>
                                        <option value="26" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 26 ? "selected" : "" }}>26</option>
                                        <option value="27" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 27 ? "selected" : "" }}>27</option>
                                        <option value="28" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 28 ? "selected" : "" }}>28</option>
                                        <option value="29" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 29 ? "selected" : "" }}>29</option>
                                        <option value="30" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 30 ? "selected" : "" }}>30</option>

                                        <option value="31" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 31 ? "selected" : "" }}>31</option>
                                        <option value="32" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 32 ? "selected" : "" }}>32</option>
                                        <option value="33" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 33 ? "selected" : "" }}>33</option>
                                        <option value="34" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 34 ? "selected" : "" }}>34</option>
                                        <option value="35" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 35 ? "selected" : "" }}>35</option>
                                        <option value="36" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 36 ? "selected" : "" }}>36</option>
                                        <option value="37" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 37 ? "selected" : "" }}>37</option>
                                        <option value="38" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 38 ? "selected" : "" }}>38</option>
                                        <option value="39" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 39 ? "selected" : "" }}>39</option>
                                        <option value="40" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 40 ? "selected" : "" }}>40</option>

                                        <option value="41" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 41 ? "selected" : "" }}>41</option>
                                        <option value="42" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 42 ? "selected" : "" }}>42</option>
                                        <option value="43" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 43 ? "selected" : "" }}>43</option>
                                        <option value="44" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 44 ? "selected" : "" }}>44</option>
                                        <option value="45" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 45 ? "selected" : "" }}>45</option>
                                        <option value="46" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 46 ? "selected" : "" }}>46</option>
                                        <option value="47" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 47 ? "selected" : "" }}>47</option>
                                        <option value="48" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 48 ? "selected" : "" }}>48</option>
                                        <option value="49" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 49 ? "selected" : "" }}>49</option>
                                        <option value="50" {{ isset($data['cart'][$item->id]) && $data['cart'][$item->id] >= 50 ? "selected" : "" }}>50</option>
                                    </select>

                                    <a href="#" class="btn btn-danger trash-can sample-units ml-1" data-inventory-id="{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>

                            </td>
                            <!--
                            <td>
                                <a href="#" class="btn btn-primary add-to-cart" data-inventory-id="{{ $item->id }}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>

                                <a href="#" class="btn btn-danger add-to-cart sample-units" data-inventory-id="{{ $item->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                            -->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No inventory items found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

<!--
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="item-name"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="modal-src" class="embed-responsive-item" src=""></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100 d-flex align-items-center justify-content-between px-3">
                    <div class="d-flex align-items-center">
                        <div class="mr-2">
                            In Cart:
                        </div>
                        <div class="modal-inventory-id cart-quantity-label mr-2" data-inventory-id="">
                            <input type="text" id="modal-qty" class="modal-inventory-id cart-input sample-units form-control form-control-text" value="" data-inventory-id="" />
                        </div>
                        <div>
                            <a href="#" class="btn btn-primary modal-inventory-id add-to-cart" data-inventory-id="">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="mr-2">
                            Display Units Only:
                        </div>
                        <div class="cart-quantity-label modal-inventory-id mr-2" data-inventory-id="">
                            <input type="text" id="modal-display" class="cart-input display-units modal-inventory-id form-control form-control-text" value="" data-inventory-id="" />
                        </div>
                        <div>
                            <a href="#" class="btn btn-primary modal-inventory-id add-to-cart display-units" data-inventory-id="">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>

        </div>
    </div>
</div>
-->

@endsection

@section('scripts')

<script>
    var cart = {!! json_encode($data['cart']) !!};
    var display = {!! json_encode($data['display']) !!};

    var searchString = "{{ str_replace('"', '', $data['search']) }}";
    var searchTimeout;

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

    // Trigger a request to store the user's search string in the session.
    function UpdateSearch() {
        let newSearchString = $("input[type=search]").val();

        // If the new search string differs from the value stored in the session...
        if (newSearchString !== searchString) {
            searchString = newSearchString;

            console.log("Search String", searchString, newSearchString);

            $.post("/cart/search", { "_token" : "{{ csrf_token() }}", "search" : searchString }, function (response) {
                console.log(response);
            });
        }
    }

    $(document).ready(function() {
        $("#menu-toggle").click();

        // Store the user's search string in the session.
        $("body").on("keyup", "input[type=search]", function() {
            let newSearchString = $(this).val();

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(UpdateSearch, 1500);
        });

        // When a click is made, clear the timer and trigger the update function.
        $("body").click(function() {
            clearTimeout(searchTimeout);
            UpdateSearch();
        });
        
        // Initialize DataTable.
        $(".datatable-inventory").DataTable({
            "bPaginate": true,
            "pageLength": 50,
            "bFilter": true,
            "oSearch" : { "sSearch" : searchString },
            "order": [[ 1, "asc" ]],
            "columnDefs" : [
                { "visible" : false, "targets" : [0] }
            ]
        });

        // Show the inventory table once finished loading.
        $("#inv-loading").hide();
        $("#inv-table").show();

        /*
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
		});*/


        console.log("Ready...");

    });
</script>

@endsection
