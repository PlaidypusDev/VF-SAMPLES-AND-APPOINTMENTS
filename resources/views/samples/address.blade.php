@extends('layouts.samples')

@section('content')

<div class="container">

    @php
    /*
     * Note:
     * 
     * I originally displayed currently selected address information at the top of the page. This 
     * is being removed, but as of now, a repo does not yet track version history, so I'm commenting 
     * this out instead.
     * 
     */
    @endphp

    <!--
    @if ($data['current_address'])
        <div class="row">
            <div class="col-6">
                <h6>Your Currently Assigned Address:</h6>
            </div>
            <div class="col-6" style="text-align: right;">
                <a href="/cart" class="button btn btn-primary">Next</a>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <address>
                    <strong style="text-decoration: underline;">{{ $data['current_address']['company_name'] }}</strong>
                    <br /><strong>ATTN: {{ $data['current_address']['attn'] }}</strong>
                    <br />{{ ($data['current_address']['type'] == "residential") ? "Residential" : "Business" }}

                    <br />{{ $data['current_address']['address_1'] }}
                    
                    @if (strlen($data['current_address']['address_2']) > 0)
                        <br />{{ $data['current_address']['address_2'] }}
                    @endif

                    <br />{{ $data['current_address']['city'] }}, {{ $data['current_address']['state'] }}&nbsp;&nbsp;{{ $data['current_address']['zip'] }}
                </address>
            </div>
            <div class="col-6">
                Reason for Request:
                <p>{{ $data['current_address']['reason'] }}</p>

                @if ($data['current_address']['by'])
                    Receive by:
                    <p>{{ $data['current_address']['by'] }}</p>
                @endif
            </div>
        </div>
    @endif
    -->

    @if (count($data['options']) > 0)
        <div class="row mb-4">
            @foreach ($data['options'] as $key => $option)

                <div class="card mr-3 {{ ($option['status'] != 'auto') ? 'demote' : '' }}" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="">
                            @if ($option['status'] == "auto")
                                USPS Recommended
                            @else
                                Submitted Address
                            @endif
                        </h5>
                        
                        <h6>{{ strtolower($option['type']) == "residential" ? "Residential" : "Business" }}</h6>

                        <address>
                            {{ $option['address_1'] }}<br />

                            @if (strlen($option['address_2']) > 0)
                                {{ $option['address_2'] }}<br />
                            @endif

                            {{ $option['city'] }}, {{ $option['state'] }}&nbsp;&nbsp;{{ $option['zip'] }}
                        </address>
                        
                        @if ($option['status'] == "manual" && $data['error'])
                            <a href="#" data-address-id="{{ $key }}" class="btn address-selection btn-danger btn-sm">Use this Address Anyways</a>
                        @elseif ($option['status'] == "manual" && $data['warning'])
                            <a href="#" data-address-id="{{ $key }}" class="btn address-selection btn-warning btn-sm">Use this Address Anyways</a>
                        @elseif ($option['status'] == "manual")
                            <a href="#" data-address-id="{{ $key }}" class="btn address-selection btn-primary btn-sm">Use this Address</a>
                        @else
                            <a href="#" data-address-id="{{ $key }}" class="btn address-selection btn-success">Use Recommended Address</a>
                        @endif
                    </div>
                </div>

            @endforeach
        </div>
    @endif

    @if (!$data['current_address'])
        <div class="row mb-3">
            <div class="col">
                <div id="btn-new" class="btn btn-primary">Enter a New Address</div>

                @if (count($data['orders']) > 0)
                    <button id="btn-existing" class="btn btn-primary">Use an Existing Address</button>
                @else
                    <button id="btn-existing" class="btn btn-primary" disabled>Use an Existing Address</button>
                @endif
            </div>
        </div>
    @endif

    @if (count($data['orders']) > 0)
        <div class="row" id="existing-address-form" style="display: none;">
            <div class="col">
                <div class="d-flex">
                    <select class="form-control form-control-select" id="existing-address-select" name="existing-address">
                        <option value='0'>Select a Previously Used Address</option>

                        @foreach ($data['orders'] as $key => $value)
                            <option value='{{ $key }}'>
                                {{ $value->ship_to_company }} ({{ $value->ship_to_attention }}) - {{ $value->ship_to_address_1 }} {{ $value->ship_to_city }}, {{ $value->ship_to_state }} {{ $value->ship_to_zipcode }}
                            </option>
                        @endforeach
                    </select>

                    <button id="select-existing-address" class="btn btn-primary ml-3">Use this Address</button>
                </div>

                <div class="form-group mt-3">
                    <label for="inputReasonExisting">Reason for Request</label>
                    <input type="text" class="form-control" id="inputReasonExisting" name="reason_existing" value="{{ isset($data['reason']) ? $data['reason'] : old('reason_existing') }}" placeholder="">
                </div>

                <div class="form-group mt-3">
                    <label for="inputByExisting">Date Needed By</label>
                    <input id="inputByExisting" type="text" class="form-control by-datepicker" name="by_existing" value="{{ isset($data['by']) ? $data['by'] : old('by_existing') }}" placeholder="mm/dd/yyyy" autocomplete="no">
                </div>
            </div>
        </div>
    @endif

	<div class="row" id="new-address-form">
        <div class="col">
            <form action="/address" method="post">
                @csrf

                @if ($data['error'])
                    <div class="alert alert-danger">
                        The address you entered could not be located. Ensure everything was entered correctly.
                    </div>
                @elseif ($data['warning'])
                    <div class="alert alert-danger">
                        Multiple addresses were identified. Ensure everything was entered correctly before proceeding.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputAttn">Company Name</label>
                            <input type="text" class="form-control" id="inputCompanyName" name="company_name" value="{{ (isset($data['company_name']) && strlen($data['company_name']) > 0) ? $data['company_name'] : old('company_name') }}" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputAttn">ATTN</label>
                            <input type="text" class="form-control" id="inputAttn" name="attn" value="{{ (isset($data['attn']) && strlen($data['attn']) > 0) ? $data['attn'] : old('attn') }}" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputAttn">Email Address</label>
                            <input type="text" class="form-control" id="inputEmail" name="email" value="{{ (isset($data['email']) && strlen($data['email']) > 0) ? $data['email'] : old('email') }}" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPhone">Phone</label>
                            <input type="text" class="form-control" id="inputPhone" name="phone" value="{{ (isset($data['phone']) && strlen($data['phone']) > 0) ? $data['phone'] : old('phone') }}" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <input type="text" class="form-control" id="inputAddress" name="address_1" value="{{ (isset($data['address_1']) && strlen($data['address_1']) > 0) ? $data['address_1'] : old('address_1') }}" placeholder="1234 Main St">
                </div>
                <div class="form-group">
                    <label for="inputAddress2">Address 2</label>
                    <input type="text" class="form-control" id="inputAddress2" name="address_2" value="{{  (isset($data['address_2']) && strlen($data['address_2']) > 0) ? $data['address_2'] : old('address_2') }}" placeholder="Apartment, studio, or floor">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" name="city" id="inputCity" value="{{ (isset($data['city']) && strlen($data['city']) > 0) ? $data['city'] : old('city') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select id="inputState" name="state" class="form-control">
                            <option selected>Choose...</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Zip</label>
                        <input type="text" value="{{ (isset($data['zip']) && strlen($data['zip']) > 0) ? $data['zip'] : old('zip') }}" name="zip" class="form-control" id="inputZip">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" id="inputTypeBusiness" type="radio" name="type" value="business" {{ (isset($data['type']) && (strlen($data['type']) > 0) && strtolower($data['type']) == "business") ? "checked" : (old('type') == "residential" ? "" : "checked") }} />
                        <label class="form-check-label" for="inputTypeBusiness">Business</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" id="inputTypeResidential" type="radio" name="type" value="residential" {{ (isset($data['type']) && (strlen($data['type']) > 0) && strtolower($data['type']) == "residential") ? "checked" : (old('type') == "residential" ? "checked" : "") }} />
                        <label class="form-check-label" for="inputTypeResidential">Residential</label>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputReason">Reason for Request</label>
                    <input type="text" class="form-control" id="inputReason" name="reason" value="{{ (isset($data['reason']) && strlen($data['reason']) > 0) ? $data['reason'] : old('reason') }}" placeholder="">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="inputBy">Date Needed By</label>
                            <input id="inputBy" type="text" class="form-control by-datepicker" name="by" value="{{ (isset($data['by']) && strlen($data['by']) > 0) ? $data['by'] : old('by') }}" placeholder="mm/dd/yyyy" autocomplete="no">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="inputCRMCompanyID">CRM Company ID</label>
                            <input id="inputCRMCompanyID" type="text" class="form-control form-control-plaintext" name="crm_company_id" value="{{ (isset($data['crm_company_id']) && strlen($data['crm_company_id']) > 0) ? $data['crm_company_id'] : old('crm_company_id') }}" autocomplete="no" readonly>
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary my-2">Validate Address</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        var addresses = {!! json_encode($data['options']) !!};

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
        
        $("#btn-new").click(function() {
            $("#new-address-form").show();
            $("#existing-address-form").hide();
        });

        $("#btn-existing").click(function() {
            $("#new-address-form").hide();
            $("#existing-address-form").show();
        });

        $("#select-existing-address").click(function() {
            let orderId = $("#existing-address-select").val();
            let reason = $("#inputReasonExisting").val();
            let by = $("#inputByExisting").val();

            $.post("/address/existing/" + orderId, { "_token" : "{{ csrf_token() }}", "reason" : reason, "by" : by }, function (response) {
                if (response)
                    document.location = "./cart";
            });
        });



        // https://stackoverflow.com/questions/30058927/format-a-phone-number-as-a-user-types-using-pure-javascript

        const isNumericInput = (event) => {
            const key = event.keyCode;
            return ((key >= 48 && key <= 57) || // Allow number line
                (key >= 96 && key <= 105) // Allow number pad
            );
        };

        const isModifierKey = (event) => {
            const key = event.keyCode;
            return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
                (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
                (key > 36 && key < 41) || // Allow left, up, right, down
                (
                    // Allow Ctrl/Command + A,C,V,X,Z
                    (event.ctrlKey === true || event.metaKey === true) &&
                    (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
                )
        };

        const enforceFormat = (event) => {
            // Input must be of a valid number format or a modifier key, and not longer than ten digits
            if(!isNumericInput(event) && !isModifierKey(event)){
                event.preventDefault();
            }
        };

        const formatToPhone = (event) => {
            if(isModifierKey(event)) {return;}

            const input = event.target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
            const areaCode = input.substring(0,3);
            const middle = input.substring(3,6);
            const last = input.substring(6,10);

            if(input.length > 6){event.target.value = `(${areaCode}) ${middle} - ${last}`;}
            else if(input.length > 3){event.target.value = `(${areaCode}) ${middle}`;}
            else if(input.length > 0){event.target.value = `(${areaCode}`;}
        };

        const inputElement = document.getElementById('inputPhone');
        inputElement.addEventListener('keydown',enforceFormat);
        inputElement.addEventListener('keyup',formatToPhone);

		$(document).ready(function() {
            $(".by-datepicker").datepicker();

			// Automatically place the cursor in the address box and highlight any text (if present).
			$("#inputAddress").focus().select();

            // Assign the `state` form field.
            let state = "{{ (isset($data['state']) && strlen($data['state']) > 0) ? $data['state'] : old('state') }}";

            if (state)
                $("#inputState").val(state);

            $(".address-selection").click(function() {
                let addressId = $(this).data("address-id");
                let selectedAddress = addresses[addressId];

                $.post("/address/update", { "_token" : "{{ csrf_token() }}", "address_1" : selectedAddress.address_1, "address_2" : selectedAddress.address_2, "city" : selectedAddress.city, "state" : selectedAddress.state, "zip" : selectedAddress.zip, "type" : selectedAddress.type, "reason" : selectedAddress.reason, "attn" : selectedAddress.attn, "company_name" : selectedAddress.company_name, "email" : selectedAddress.email, "phone" : selectedAddress.phone, "by" : selectedAddress.by, "status" : selectedAddress.status, "crm_company_id" : selectedAddress.crm_company_id }, function (response) {
                    if (response)
                        document.location = "./cart";
                });
            });
		});

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

                    if (typeof display[inventoryId] == 'undefined') {
                        location.reload();
                    } else {
                        display[inventoryId] = qty;
                    }
                } else {
				    $(".cart-quantity-label[data-inventory-id=" + inventoryId + "] .sample-units").val(qty);
                    $("#modal-qty").val(qty);

                    if (typeof cart[inventoryId] == 'undefined') {
                        location.reload();
                    } else {
                        cart[inventoryId] = qty;
                    }
                }
			});

            return false;
		});
	</script>
@endsection
