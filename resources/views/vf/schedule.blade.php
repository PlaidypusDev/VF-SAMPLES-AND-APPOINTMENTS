@extends('layouts.vf')

@section('content')

<!--img src="{{ asset('public/images/logo.png') }}" id="vanee-logo" class="mb-2 smaller-logo" style="max-width: 65%;" /-->

<div class="row justify-content-center" style="text-align: center;">
    <div class="col-xl-6 col-lg-7 col-md-8 col-sm-12 col-xs-12" style="margin-top: 3.5rem; margin-bottom: 4rem;">
        <img src="{{ asset('public/images/logo.png') }}" id="vanee-logo" class="mb-2 smaller-logo" style="max-width: 65%;" />
        <div id="global-alerts" class="mt-3"></div> 

<div class="progress" style="margin-top: 1rem !important; height: 2rem; font-size: 0.9rem;">
  <div id="pbar-1" class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Orders</div>
  <div id="pbar-2" class="progress-bar pbar-disabled bg-success" role="progressbar" style="width: 34%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Schedule</div>
  <div id="pbar-3" class="progress-bar pbar-disabled bg-info" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Contact</div>
</div>


	<div id="success-view" class="view" style="display: none; margin-top: 0.8rem !important;">

                <!-- Duplicate List of Orders (QoL) -->
                <div class="orders-container mt-3"></div>

		<p class="confirmation-data my-3">Your confirmation number: <span id="confirmation-number" style="font-weight: bold;">{CONFIRMATION_NUMBER}</span></p>

		<p class="confirmation-data my-3"><span id="appointment-string"></span><br /><i class="far fa-calendar-alt"></i> <span id="confirmation-time" style="font-weight: bold;"></span></p>

		<p class="confirmation-data my-3 font-weight-normal" style=""><span id="location-string"></span><br />
			<span id="confirmation-location" style="font-weight: bold;"></span>
		</p>

		<div id="cancel-appointment" class="btn btn-danger btn-lg mt-3">Cancel Appointment</div>
		<div id="update-order" class="btn btn-primary btn-lg mt-3">Update Order</div>

		<button class="btn btn-primary btn-lg mt-3" onClick="document.location='/';">New Order</button>
	</div>

	<div id="information-view" class="view" style="display: none; margin-top: 0.8rem !important;">

		<h1 class="h3 mt-4 mb-3 font-weight-normal" style="">Please validate your information:</h1>

		<!-- Validate Information -->
		<div id="information-error"></div>

		<!-- Email -->
		<div class="input-group input-group-lg">
		    <div class="input-group-prepend">
			<span class="input-group-text" id="inputGroup-email"><i class="fa fa-envelope" aria-hidden="true"></i></span>
		    </div>
		    <input id="email" placeholder="Email" type="text" class="form-control" aria-label="Email" aria-describedby="inputGroup-email">
		</div>

		<!-- Phone -->
                <div class="input-group input-group-lg my-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-phone"><i class="fa fa-phone" aria-hidden="true"></i></span>
                    </div>
		    <input id="phone" placeholder="Phone" type="text" class="form-control" aria-label="Phone" aria-describedby="inputGroup-phone">
		</div>


		<!-- Carrier -->
                <div class="input-group input-group-lg my-3">
                    <div class="input-group-prepend" style="width: 54px;">
                        <span class="input-group-text" style="width: 100%; justify-content: center;" id="inputGroup-carrier"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                    </div>
                    <input id="carrier" placeholder="Carrier" type="text" class="form-control" aria-label="Carrier" aria-describedby="inputGroup-carrier">
                </div>

		@if (isset($data['view']) && $data['view'] == "update")
			<div id="create-order" style="" class="btn btn-primary btn-lg btn-block mt-3">Update</div>
		@else
			<div id="create-order" style="" class="btn btn-primary btn-lg btn-block mt-3">Schedule</div>
		@endif

	</div>

	<div id="order-search-view" class="view">
		<div id="load-selection" class="mb-4">
	            <h1 class="h3 mb-3 mt-4 font-weight-normal" style="">I have a load to:</h1>

	            <!-- Pick Up / Deliver -->
	            <div class="btn-group btn-group-toggle" data-toggle="buttons">
	                <label id="pick-up-button" class="btn btn-lg btn-secondary">
	                    <input class="select-type" type="radio" name="options" value="pick-up" id="pick-up" autocomplete="off">
	                    <span class="px-3">Pick Up</span>
	                </label>
	                <label id="deliver-button" class="btn btn-lg btn-secondary">
	                    <input class="select-type" type="radio" name="options" value="deliver" id="deliver" autocomplete="off">
	                    <span class="px-3">Deliver</span>
	                </label>
	            </div>
		</div>

	        <!-- Enter Order ID -->
	        <div class="input-group mt-4" style="margin-bottom: 0.75rem !important;">
	            <input name="order-id" id="order-id" type="text" class="form-control form-control-lg" placeholder="Enter Order ID" aria-label="Enter Order ID" aria-describedby="basic-addon2" style="font-size: 1.5rem;">
	            <div class="input-group-append">
	                <button id="add-order" class="btn btn-lg btn-outline-secondary" type="button">Add</button>
	            </div>
	        </div>

	        <!-- List of Orders -->
		<div id="orders-error"></div>
		<div class="orders-container"></div>
	        <div class="orders" style="display: none;"></div>
	</div>

	<div id="schedule-view" class="view" style="display: none; margin-top: 0.8rem !important;">

		<!--div class="earliest-date mt-2"></div-->

                <!-- Duplicate List of Orders (QoL) -->
                <div class="orders-container"></div>

		<!--h1 class="h3 my-4 font-weight-normal" style="">
			I want to <span id="schedule-order-type">Pick Up</span> on (after <span class="earliest-date"></span>):
		</h1-->

		<div id="select-date">

		    <div class="input-group input-group-lg">
			<div class="input-group-prepend">
			  <div class="input-group-text" id="inputGroup-date"><span id="schedule-order-type">Pick Up</span>&nbsp;Date</div>
			</div>
			<input data-provide="datepicker" id="select-datepicker" type="text" class="form-control" aria-label="Date" aria-describedby="inputGroup-date" autocomplete="no">
		    </div>

		</div>

		<div id="select-time" style="display: none;">
			<h1 class="h3 my-4 font-weight-normal" style="font-size: 1.25rem;" id="time-string">The following times are available on <span id="select-time-var" style="font-weight: bold;"></span> - please select:</h1>

			<div id="select-time-data"></div>
		</div>

		<div id="schedule-next" style="display: none;" class="btn btn-primary btn-lg btn-block mt-3">
		    Next
		    <span style="float: right;"><i class="fas fa-arrow-circle-right"></i></span>
		</div>

	</div>

	<div id="select-location" class="view" style="display: none;">
		<h1 class="h3 mt-4 mb-4 font-weight-normal" id="select-location-order-string" style="">Please confirm the delivery location:<!--<span id="select-location-order-type">Pick Up</span>?--></h1>

		<div id="select-location-data"></div>
	</div>

	<div id="orders-next" style="display: none;" class="btn btn-primary btn-lg btn-block mt-3">
	    Next
	    <span style="float: right;"><i class="fas fa-arrow-circle-right"></i></span>
	</div>

	<!--div id="back-button" style="display: none;" class="btn btn-warning btn-lg btn-block mt-3"><i class="fas fa-arrow-left"></i> Back</div-->

    </div>
</div>


@endsection


@section('scripts')

<script>
    // Default datepicker settings.
    $.fn.datepicker.defaults.format = "mm/dd/yyyy";
    $.fn.datepicker.defaults.autoclose = true;
    $.fn.datepicker.defaults.startDate = '+0d';

    var step = 1;

    var selected_order_id = "";
    var selected_order_type = "";
    var selected_date = "";

    var selected_email = "";
    var selected_phone = "";
    var selected_carrier = "";

    var selected_time = "";

    var confirmation_code = "";
    var confirmation_status = "";

    var vanee_token = "<?php echo isset($_GET['token']) ? $_GET['token'] : ""; ?>";

    var last_order_count = 0;
    var latest_ship_date = null;
    var latest_ship_date_raw = null;
    var lastRenderSig = null;

    function friendlyOrderType() {
        return (selected_order_type === "DELIVER") ? "Delivery" : "Pick Up";
    }

    function refreshOrderTypeLabels() {
        // Update any UI badges that show the friendly type
        $("#schedule-order-type").text(friendlyOrderType());
    }

    function getDateHeader() {
    function normalizeDate(d) {
        var x = new Date(d);
        x.setHours(0,0,0,0);
        return x;
    }

    function enforcePickupMinDateOrAbort(tempDate) {
        // Only enforce for PICKUP and when we have a computed latest_ship_date
        if (selected_order_type === "PICKUP" && latest_ship_date instanceof Date) {
            var chosen = normalizeDate(tempDate);
            var min    = normalizeDate(latest_ship_date);
            if (chosen < min) {
                showAlert("warning", "For pickups, choose a date on or after the latest pickup date.");
                $("#schedule-next").hide();
                $("#select-time").hide();
                return false; 
            }
        }
        return true; 
    }

    function showAlert(type, msg) {
        // type: 'success' | 'danger' | 'warning' | 'info'
        var html = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${msg}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>`;
        $("#global-alerts").html(html);
    }


    function GetTableHead() {
	return `
		<table class='orders-table table table-hover table-bordered'>
			<thead class='thead-light'>
				<tr>
					<th scope="col">PO</th>
					<th scope="col">Weight</th>
					<th scope="col">Pallets</th>
                    <th scope="col">${getDateHeader()}</th>
					<th scope="col">City</th>
					<!--th scope="col" class="mobile-collapse">State</th-->
					<th scope="col" class="mobile-collapse">Action</th>
				</tr>
			</thead>
			<tbody>
	`
    }

    function GetTableFoot() {
	return `
			</tbody>
		</table>
	`
    }

    $(document).ready(function() {

	@if (isset($data['json']))
	  var json = $.parseJSON("{!! $data['json'] !!}");

	  if (json['view'] == "update") {

		$.each(json['orders'], function(key, value) {
			var customer_po = value.customer_po;
			var depositor_po = value.depositor_po;
			var order_number = value.order_number;
			var weight = Math.round(value.weight);
                        var notes = value.notes;
                        var city = value.city;
                        var state = value.state;
			var pallet_count = value.pallet_count;
			var ship_date = value.ship_date;

			var depositor_po_html = (depositor_po == '') ? '' : '<br />' + depositor_po;

			weight = weight.toLocaleString('en');

	                // Initialize order notes.
	                //var html_notes = "<li class='list-group-item'>" + city + ", " + state + "</li>";
			var html_notes = "";

	                // Loop through the order notes.
	                $.each(notes, function(key, value) {
	                    html_notes += "<li class='list-group-item'>" + value + "</li>";
	                });

			// Concatenate the strings.
			var nested_html = `
				<div class='collapse expand-collapse-info expand-collapse-${order_number}' style='padding-top: 0.75rem;'>
				    <ul class='list-group'>
					${html_notes}
				    </ul>
				</div>
			`;

	                var html = `
	                    <div data-pallet-count="${pallet_count}" data-po="${customer_po}" data-depositor="${depositor_po}" data-city="${city}" data-state="${state}" data-ship-date="${ship_date}" data-target=".expand-collapse-${order_number}" data-toggle="collapse" data-weight="${value.weight}" data-order-number="${order_number}" class="order-item alert alert-warning alert-dismissible fade show" role="alert" style="padding-right: 1.25rem;">
				${order_number}<br />${customer_po} ${depositor_po_html} / ${weight} LBS / ${pallet_count} pallets
	                        <button type="button" class="close remove-order" data-dismiss="alert" aria-label="Close" onClick="$('.order-item[data-order-number=${value.order_number}]').remove();">
	                            <span aria-hidden="true">&times;</span>
	                        </button>
				${nested_html}
	                    </div>
			`;


			$(".orders").append(html);
		});

	    	if (json['order_type'] == "PICKUP") {
		    $("#pick-up").click();
		    selected_order_type = "PICKUP";
		} else {
		    $("#deliver").click();
		    selected_order_type = "DELIVER";
		}

		// Hide the Pick Up / Deliver option.
		$("#load-selection").hide();

		$("#select-datepicker").val(json['date']);
		selected_date = json['date'];

		window.setTimeout(function() {
		    $("#select-datepicker").change();
		}, 300);

		$("#phone").val(json['phone']);
		$("#email").val(json['email']);
		$("#carrier").val(json['carrier']);

		$(".view").hide();
		//("#information-view").show();
		$("#schedule-view").show();
        forceRepaint();
		//$("#back-button").show();

		step = 4;
		UpdatePB();

		if (!$("#vanee-logo").hasClass("smaller-logo"))
			$("#vanee-logo").addClass("smaller-logo");

		selected_time = json['time'];

	  } else {
	    $(".view").hide();
	    $("#schedule-view").show();
        forceRepaint();
	    //$("#back-button").show();

	    var step = 3;
	    UpdatePB();

            if (!$("#vanee-logo").hasClass("smaller-logo"))
                    $("#vanee-logo").addClass("smaller-logo");

	    // Loop through the orders to build the page.
	    $.each(json['orders'], function(key, value) {

		var customer_po = value.customer_po;
		var depositor_po = value.depositor_po;
		var order_number = value.order_number;
		var weight = Math.round(value.weight);

		weight = weight.toLocaleString('en');

                var notes = value.notes;
                var city = value.city;
                var state = value.state;
		var pallet_count = value.pallet_count;
		var ship_date = value.ship_date;

		var depositor_po_html = (depositor_po == '') ? '' : '/ ' + depositor_po;

                // Initialize order notes.
                //var html_notes = "<li class='list-group-item'>" + city + ", " + state + "</li>";
		var html_notes = "";

                // Loop through the order notes.
                $.each(notes, function(key, value) {
                    html_notes += "<li class='list-group-item'>" + value + "</li>";
                });

		// Concatenate the strings.
		var nested_html = `
			<div class='collapse expand-collapse-info expand-collapse-${order_number}' style='padding-top: 0.75rem;'>
			    <ul class='list-group'>
				${html_notes}
			    </ul>
			</div>
		`;

                var html = `
                    <div data-pallet-count="${pallet_count}" data-ship-date="${ship_date}" data-po="${customer_po}" data-depositor="${depositor_po}" data-city="${city}" data-state="${state}" data-target=".expand-collapse-${order_number}" data-toggle="collapse" data-weight="${value.weight}" data-order-number="${order_number}" class="order-item alert alert-warning alert-dismissible fade show" role="alert" style="padding-right: 1.25rem;">
			${customer_po} ${depositor_po_html} / ${weight} LBS / ${pallet_count} pallets
                        <button type="button" class="close remove-order" data-dismiss="alert" aria-label="Close" onClick="$('.order-item[data-order-number=${value.order_number}]').remove();">
                            <span aria-hidden="true">&times;</span>
                        </button>
			${nested_html}
                    </div>
		`;

		$(".orders").append(html);
	    });

	    if (json['order_type'] == "PICKUP") {
		$("#pick-up").click();
		selected_order_type = "PICKUP";
	    } else {
		$("#deliver").click();
		selected_order_type = "DELIVER";
	    }

	    if (json['phone'].length)
	        $("#phone").val(json['phone']);

	    if (json['email'].length)
		$("#email").val(json['email']);

	    if (json['carrier'].length)
		$("#carrier").val(json['carrier']);

	    // Hide the Pick Up / Deliver option.
	    $("#load-selection").hide();

	    $("#select-datepicker").val(json['date']);
	    selected_date = json['date'];

	    window.setTimeout(function() {
		$("#select-datepicker").change();
	    }, 300);

	  }
	@else

	    // Use localStorage to populate information if we are not updating or editing.
	    $("#email").val(localStorage.getItem("vf.email"));
	    $("#phone").val(localStorage.getItem("vf.phone"));
	    $("#carrier").val(localStorage.getItem("vf.carrier"));

	@endif

    $("#pick-up").on("click", function () {
        selected_order_type = "PICKUP";
        refreshOrderTypeLabels();
    });

    $("#deliver").on("click", function () {
        selected_order_type = "DELIVER";
        refreshOrderTypeLabels();
    });

	// Button to update a completed order...
	$("#update-order").click(function() {
		var confirmation = $("#confirmation-number").html();

		window.location = "?update=" + confirmation + "&token=" + vanee_token;
	});

	// Schedule Order
	$("#create-order").click(function() {
	    if ($(this).hasClass("already-clicked"))
			return;

	    $(this).addClass("already-clicked");

	    var email = $("#email").val();
	    var phone = $("#phone").val();
	    var carrier = $("#carrier").val();

	    localStorage.setItem("vf.email", email);
	    localStorage.setItem("vf.phone", phone);
	    localStorage.setItem("vf.carrier", carrier);

	    // Basic validation.
	    if (email.length > 6 && phone.length >= 7 && carrier.length > 1) {
			var selected_email = email;
			var selected_phone = phone;
			var selected_carrier = carrier;

			var orders = "";

			// Loop through the orders.
			$.each($("#order-search-view .order-item"), function(key, value) {
				var order_number = $(value).data("order-number");

				if (orders)
					orders += "," + order_number;
				else
					orders = order_number;
			});

			var formatted_date = selected_date.replace(/\//g, "-");
			selected_time = $(".select-time-button.btn-success").data("time");

			// Create Order
			$.get("/vf/create-order/", { "_token" : "{{ csrf_token() }}", "order_type" : selected_order_type, "orders" : orders, "date" : formatted_date, "email" : selected_email, "phone" : selected_phone, "carrier" : selected_carrier, "time" : selected_time, "id" : "{{ isset($data['id']) ? $data['id'] : '' }}", "token" : vanee_token }, function(response) {
				var response = $.parseJSON(response);

				if (response.success) {

					confirmation_code = response.id;
					confirmation_status = response.status;

					if (response.token)
						vanee_token = response.token;

					var day = response.day;
					var time = $(".select-time-button.btn-success").data("time");
					var confirmation_time = day + "<br />" + time;

					if (selected_order_type == "PICKUP")
						var friendly = "Pickup";
					else
						var friendly = "Deliver";

					$(".view").hide();
					$("#create-order").hide();
					$("#success-view").show();

					// After completion,  hide the back button.
					//$("#back-button").hide();

							if (!$("#vanee-logo").hasClass("smaller-logo"))
									$("#vanee-logo").addClass("smaller-logo");

					$("#confirmation-number").html(confirmation_code);
					$("#confirmation-time").html(confirmation_time);
					$("#appointment-string").html(friendly + " Appointment:");
					$("#location-string").html(friendly + " At:");
					$("#confirmation-location").html(response.vanee_location);

					step = 4;
					UpdatePB();

					$(".progress").hide();

				} else {
					// Failure
					var html = `
						<div id="order-error" class="alert alert-danger alert-dismissible fade show" role="alert">
							Unexpected error occurred.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					`;

					$("#information-error").html(html);
				}

			});

	    } else {
			// Failure
			var html = `
				<div id="order-error" class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
					Invalid form data. Valid email and phone number must be provided.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			`;

			$("#information-error").html(html);
	    }
	});

    $("#cancel-appointment").on("click", function () {
        var $btn = $(this);

        var id = $("#confirmation-number").text().trim() || confirmation_code;
        var token = vanee_token;

        if (!id || !token) {
            alert("Missing appointment id or token — cannot cancel.");
            return;
        }

        if (!confirm("Are you sure you want to cancel this appointment?")) return;

        // Prevent double-clicks
        if ($btn.hasClass("busy")) return;
        $btn.addClass("busy").prop("disabled", true).text("Cancelling…");

        $.get("/vf/cancel-appointment/", { id, token })
            .done(function (res) {
                if (res.http_status === 200) {
                    $("#appointment-string").text("Status:");
                    $("#confirmation-time").html("Appointment canceled");
                    $("#location-string").text("");
                    $("#confirmation-location").text("");
                    $("#cancel-appointment, #update-order").hide();

                    showAlert("success", "Appointment canceled. Redirecting to home…")

                    setTimeout(function () {
                        window.location = "/";
                    }, 1600);
                } else {
                    showAlert("danger", "Could not cancel appointment (status " + res.http_status + ").");
                    $("#cancel-appointment").removeClass("already-clicked");
                }
            })
            .fail(function () {
                showAlert("danger", "Network error while canceling appointment.");
                $("#cancel-appointment").removeClass("already-clicked");
            });
    });


	// When a time is selected.
	$("body").on("click", ".select-time-button", function() {
		// Validation: Get the selected date.
		var date = $("#select-datepicker").val();

	    if (date.length != 10) {
			$("#schedule-next").hide();
			$("#select-time").hide();
			return;
		}

        // block too-early dates for PICKUP
        var tempDate = new Date(date);
        if (!enforcePickupMinDateOrAbort(tempDate)) return;

		selected_time = $(this).data("time");

		$(".select-time-button.selected").removeClass("btn-success");
		$(".select-time-button.selected").addClass("btn-secondary");
		$(".select-time-button.selected").removeClass("selected");

		$(this).removeClass("btn-secondary");
		$(this).addClass("btn-success");
		$(this).addClass("selected");

		$("#schedule-next").show();
	});

	// When a date is selected for scheduling.
	$("#select-datepicker").change(function() {
	    var date = $(this).val();

	    if (date.length == 10 /*&& date != selected_date*/) {

            var tempDate = new Date(date);
            if (!enforcePickupMinDateOrAbort(tempDate)) {
                return; 
            }

			selected_date = date;

			// Remove the next button, if it happens to be visible at this point.
			$("#schedule-next").hide();

			var order_weight = 0;

			$(".order-item").each(function(key, value) {
				order_weight += $(value).data("weight");
			});

			// Round the weight to the nearest whole number.
			order_weight = Math.round(order_weight);

			// Format the date so we can pass it through a URL.
			var formatted_date = selected_date.replace(/\//g, "-");

			// Create CSV of orders.
			var orders = "";

			// Loop through the orders.
			$.each($("#order-search-view .order-item"), function(key, value) {
				var order_number = $(value).data("order-number");

				if (orders)
					orders += "," + order_number;
				else
					orders = order_number;
			});

			// Search for order.
			$.get("/vf/search-date/", { "_token" : "{{ csrf_token() }}", "order_type" : selected_order_type, "order_weight" : order_weight, "order_date" : formatted_date, "orders" : orders }, function(response) {
				var response = $.parseJSON(response);

				if (response.success) {
					$("#select-time-data").html("");
					$("#select-time-var").html(response.date);
					$("#select-time").show();

					//console.log(response.times.length, "is the length");
					$.each(response.times, function(key, value) {
						var time = value;

						if (selected_time == time) {
							var html = `
								<div data-time="${time}" class="select-time-button btn btn-lg btn-block btn-success selected">
									${time}
								</div>
							`;
							$("#schedule-next").show();
						} else {
							var html = `
									<div data-time="${time}" class="select-time-button btn btn-secondary btn-lg btn-block">
											${time}
									</div>
							`;
						}

						$("#select-time-data").append(html);
					});

					$("#time-string").html(response.message);
				} else {
					alert("An unknown error occurred.");
				}
			});

	    }
	});

	// Back Button
	$("body").on("click", "#back-button", function() {
		if ($("#information-view").is(":visible")) {
			$(".view").hide();
			$("#schedule-view").show();
            forceRepaint();
			$("#schedule-next").show();
			$(".remove-order").hide();

			if (!$("#vanee-logo").hasClass("smaller-logo"))
					$("#vanee-logo").addClass("smaller-logo");
		} else if ($("#schedule-view").is(":visible")) {
			$(".view").hide();
			$("#back-button").hide();
			$("#orders-next").show();
			$("#order-search-view").show();
			$(".remove-order").show();

			//$("#vanee-logo").removeClass("smaller-logo");
		}

		$(".table-row").collapse();
	});

	// Scheduling: Next
	$("body").on("click", "#schedule-next", function() {
		$(".view").hide();
		$("#schedule-next").hide();
		$("#information-view").show();
		//$("#back-button").show();
		$(".remove-order").hide();

		step = 3;
		UpdatePB();

		//if (!$("#vanee-logo").hasClass("smaller-logo"))
		//        $("#vanee-logo").addClass("smaller-logo");

		$(".table-row").collapse();
	});

	// Orders: Next
	$("body").on("click", "#orders-next", function() {
		// Create a friendly string for the order type.
		var friendly_order_type = (selected_order_type == "DELIVER") ? "Delivery" : "Pick Up";

		$(".view").hide();
		$("#orders-next").hide();
        refreshOrderTypeLabels();
		$("#schedule-view").show();
        forceRepaint();
		//$("#back-button").show();
		$(".remove-order").hide();

		step = 2;
		UpdatePB();

		//if (!$("#vanee-logo").hasClass("smaller-logo"))
		//        $("#vanee-logo").addClass("smaller-logo");

		// $(".table-row").collapse();
        last_order_count = -1;
        UpdateTotals();
        // try this to ensure nested rows are shown
        // $(".nested-data.collapse").collapse('show');

	});

	/*
	// Keep the "Next" button visible only when appropriate.
	$("body").on("blur", ".alert-dismissible", function() {
		var order_count = $("#order-search-view .order-item").length;

		// This event triggers just before the element is removed from the DOM.
		if ($(this).hasClass("order-item"))
			order_count --;

		// Hide the next button if applicable.
		if (!order_count) {
			$("#orders-next").hide();
			$("#load-selection").show();
			$(".orders-container").hide();
		}
	});
	*/

	$("body").on("blur", ".nested-remove-button", function() {
                var order_count = $("#order-search-view .order-item").length;

		console.log("BLUR");

                // This event triggers just before the element is removed from the DOM.
                if ($(this).hasClass("order-item"))
                        order_count --;

                // Hide the next button if applicable.
                if (!order_count) {
                        $("#orders-next").hide();
                        $("#load-selection").show();
			$(".orders-container").hide();

			$("#pbar-2").addClass("pbar-disabled");
			$("#pbar-3").addClass("pbar-disabled");
                }
	});

	// When a location is selected for validation.
	$("body").on("click", ".location-validation-button", function() {
		var city = $(this).data("city");
		var state = $(this).data("state");

		// Request to validate location.
		$.get("/vf/validate-location/", { "_token" : "{{ csrf_token() }}", "order_id" : selected_order_id, "order_type" : selected_order_type, "city" : city, "state" : state }, function(response) {
			var response = $.parseJSON(response);
			$(".view").hide();
			$("#order-search-view").show();

			if (response.success) {

	            var customer_po = response.customer_po;
				var depositor_po = response.depositor_po;
	            var order_number = response.order_number;
				var weight = Math.round(response.weight);
				var notes = response.notes;
				var city = response.city;
				var state = response.state;
				var pallet_count = response.pallet_count;
				var ship_date = response.ship_date;

				var depositor_po_html = (depositor_po == '') ? '' : '/ ' + depositor_po;

				weight = weight.toLocaleString('en');

                                // Initialize order notes.
                                //var html_notes = "<li class='list-group-item'>" + city + ", " + state + "</li>";
				var html_notes = "";

                                // Loop through the order notes.
                                $.each(notes, function(key, value) {
                                        html_notes += "<li class='list-group-item'>" + value + "</li>";
                                });

				// Concatenate the strings.
				var nested_html = `
					<div class='collapse expand-collapse-info expand-collapse-${order_number}' style='padding-top: 0.75rem;'>
					    <ul class='list-group'>
						${html_notes}
					    </ul>
					</div>
				`;

	                        var html = `
	                            <div data-pallet-count="${pallet_count}" data-ship-date="${ship_date}" data-po="${customer_po}" data-depositor="${depositor_po}" data-city="${city}" data-state="${state}" data-target=".expand-collapse-${order_number}" data-toggle="collapse" data-weight="${response.weight}" data-order-number="${order_number}" class="order-item alert alert-warning alert-dismissible fade show" role="alert" style="padding-right: 1.25rem;">
					${customer_po} ${depositor_po_html} / ${weight} LBS / ${pallet_count} pallets
	                                <button type="button" class="close remove-order" data-dismiss="alert" aria-label="Close" onClick="$('.order-item[data-order-number=${response.order_number}]').remove();">
	                                    <span aria-hidden="true">&times;</span>
	                                </button>

					${nested_html}
	                            </div>
				`;

				/*
				var table_html = `
					<tr class='order-row'>
						<td>${order_number}</td>
						<td>${depositor_po}</td>
						<td>${weight}</td>
						<td>${pallet_count}</td>
					</tr>
				`;

				$(".orders-container").html(GetTableHead() + table_html + GetTableFoot());
				*/

				/*
				// Initialize order notes.
				var html_notes = '';

				// Loop through the order notes.
				$.each(notes, function(key, value) {
					html_notes += "<li class='list-group-item'>" + value + "</li>";
				});

				// Concatenate the strings.
				html = `
					${html}
					<div class='collapse expand-collapse-${order_number}'>
					    <div class='card'>
						<div class='card-body'>
						    <h5 class='card-title' style='font-size: 1.5rem;'>${city}, ${state}</h5>
						    <ul class='list-group'>
							${html_notes}
						    </ul>
						</div>
					    </div>
					</div>
				`;
				*/

	            $(".orders").prepend(html);

				$(".expand-collapse-info").removeClass("show");
				$(".order-item[data-order-number=" + order_number + "]").click();

				$("#order-id").val("");
				$("#order-id").focus();

				// Hide the Pick Up / Deliver option.
				$("#load-selection").hide();

				$("#orders-next").show();

				/*
					Hotfix: 10/17/2022 by Joe Majewski:

					Orders added to the PICKUP will not be tested for whether or not the ship date and pick up date are compatible.
					To address this, I'm forcing the next button to disappear when an order is added to the PICKUP.
				*/
				$("#pbar-3").addClass("pbar-disabled");
				$("#schedule-next").hide();
				$("#select-time").hide();
				$("#select-datepicker").val("");

			} else {
				// Failure
				var html = `
						<div id="order-error" class="alert alert-danger alert-dismissible fade show" role="alert">
								Error: Invalid location.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
						</div>
					`;

				$("#orders-error").append(html);
			}
		});

	});

	// Auto-highlight the text when clicking into the order field.
	$("#order-id").click(function() {
	    $("#order-id").select();
	});

        // When the "Add" button is clicked...
        $("#add-order").click(function() {
            var order_id = $("#order-id").val();
	    var order_type = ($("#pick-up-button").hasClass("active")) ? "PICKUP" : "DELIVER";

	    $("#order-error").remove();

	    // Check that the order type hasn't changed.
	    if (selected_order_type.length && selected_order_type != order_type) {
		// Failure
		var html = `
			<div style="font-size: 1rem;" id="order-error" class="alert alert-danger alert-dismissible fade show" role="alert">
				Choose "Pick Up" or "Deliver"; not both.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		`;

		$("#orders-error").append(html);

		return;
	    }

	    // Check that the order is unique.
	    if ($("div[data-order-number=" + order_id + "]").length) {
		// Duplicate order entry found.
		var html = `
			<div id="order-error" class="alert alert-danger alert-dismissible fade show" role="alert">
				Order #${order_id} has already been added.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		`;
		$("#orders-error").append(html);

		return;
	    }


	    if (!$("#pick-up-button").hasClass("active") && !$("#deliver-button").hasClass("active")) {

		// No order type selected.
		var html = `
			<div id="order-error" class="alert alert-danger alert-dismissible fade show" role="alert">
				Error: Select an order type.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		`;

		$("#orders-error").append(html);

		return;
	    } else if (order_id.length == 0) {

                // Empty Order Number
                var html = `
                        <div id="order-error" class="alert alert-danger alert-dismissible fade show my-1" role="alert">
                                Error: Provide an Order #.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                `;

                $("#orders-error").append(html);

		return;
	    }



	    // Search for order.
            $.get("/vf/search-order/", { "_token" : "{{ csrf_token() }}", "order_id" : order_id, "order_type" : order_type, "existing_appointment" : "<?php echo isset($_GET['update']) ? $_GET['update'] : ""; ?>" }, function(response) {
                var response = $.parseJSON(response);

				if (response.success) {
					var order_id = response.order_id;
					var order_type = response.order_type;
					var locations = response.locations;

					selected_order_id = order_id;
					selected_order_type = order_type;
                    refreshOrderTypeLabels();

					// Create a friendly string for the order type.
					var friendly_order_type = (order_type == "DELIVER") ? "Delivery" : "Pick Up";

					// Prepare the location validation view.
					$(".view").hide();
					$("#select-location-data").html("");
					$("#select-location-order-type").html(friendly_order_type);

					/*
					if (friendly_order_type == "Pick Up")
						$("#select-location-order-string").html("Please confirm the delivery location:");
					else
						$("#select-location-order-string").html("Please confirm the delivery location:");
					*/

					$("#select-location").show();

					// Loop through the locations.
					$.each(locations, function (key, value) {
						var city = value.city;
						var state = value.state;

						var html = `
							<div data-city="${city}" data-state="${state}" class="location-validation-button btn btn-secondary btn-lg btn-block">
								${city}, ${state}
							</div>
						`;

						$("#select-location-data").append(html);
					});

				} else {
					var order_id = $("#order-id").val();

					if (response.message) {
						// Failure: Order already belongs to an appointment.
						var html = `
											<div id="order-error" class="alert alert-danger alert-dismissible fade show my-1" role="alert">
													Error: ${response.message}
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
											</div>
						`;
					} else {
						// Failure
						var html = `
							<div id="order-error" class="alert alert-danger alert-dismissible fade show my-1" role="alert">
								Error: Order #${order_id} not found.
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
							</div>
						`;

					}

					$("#orders-error").append(html);
				}
            });

        });

		// Call this function on a half-second interval. This could be improved by instead just calling it after specific actions take place. - JM
		window.setInterval(function() {
			UpdateTotals();
	}, 500);


    $("#pbar-1").click(function() {
		// Orders
		if ($(this).hasClass("pbar-disabled"))
			return;

		//if ($("#vanee-logo").hasClass("smaller-logo"))
		//$("#vanee-logo").removeClass("smaller-logo");

		$(".view").hide();
		$("#order-search-view").show();
		$("#orders-next").show();
		$("#schedule-next").hide();
		$(".remove-order").show();
        forceRepaint();  
    });

    $("#pbar-2").click(function() {
		// Schedule
		if ($(this).hasClass("pbar-disabled"))
			return;

		$(".view").hide();
		$("#schedule-view").show();
        forceRepaint();
		$("#orders-next").hide();
		$(".remove-order").hide();

		//if (!$("#vanee-logo").hasClass("smaller-logo"))
		//        $("#vanee-logo").addClass("smaller-logo");

		if ($(".select-time-button.btn-success").is(":visible"))
			$("#schedule-next").show();
    });

    $("#pbar-3").click(function() {
        // Contact
        if ($(this).hasClass("pbar-disabled"))
                return;

        $(".view").hide();
        $("#information-view").show();
	$("#orders-next").hide();
        $(".remove-order").hide();

        //if (!$("#vanee-logo").hasClass("smaller-logo"))
        //        $("#vanee-logo").addClass("smaller-logo");
    });

    $(".progress-bar").click(function() {
	if ($(this).hasClass("pbar-disabled"))
	    return;

        $(".progress-bar").removeClass('active');

        if ($("#order-search-view").is(":visible")) {
            $("#pbar-1").addClass("active");
        } else if ($("#schedule-view").is(":visible")) {
            $("#pbar-2").addClass("active");
        } else if ($("#information-view").is(":visible")) {
            $("#pbar-3").addClass("active");
        }
    });

    // Update the progress bar.
    function UpdatePB() {
        switch (step) {
            case 1:
		$("#pbar-1").removeClass("pbar-disabled");
                break;
            case 2:

		$("#pbar-1").removeClass("pbar-disabled");
		$("#pbar-2").removeClass("pbar-disabled");

                break;

            case 3:

		$("#pbar-1").removeClass("pbar-disabled");
		$("#pbar-2").removeClass("pbar-disabled");
		$("#pbar-3").removeClass("pbar-disabled");

                break;

            case 4:

		$("#pbar-1").removeClass("pbar-disabled");
		$("#pbar-2").removeClass("pbar-disabled");
		$("#pbar-3").removeClass("pbar-disabled");

                break;
        }

	$(".progress-bar").removeClass('active');

	if ($("#order-search-view").is(":visible")) {
	    $("#pbar-1").addClass("active");
	} else if ($("#schedule-view").is(":visible")) {
	    $("#pbar-2").addClass("active");
	} else if ($("#information-view").is(":visible")) {
	    $("#pbar-3").addClass("active");
	}

    }


    });

    function UpdateTotals() {
    // Find the visible container for rendering.
    var $target = $(".view:visible .orders-container");
    if (!$target.length) return; // nothing to render into on this view

    // gather the orders to render
    var orderIds = [];
    $("#order-search-view .order-item").each(function () {
        orderIds.push($(this).data("order-number"));
    });

    // Include the active view id so switching tabs always triggers a repaint.
    var activeViewId = $(".view:visible").attr("id") || "none";
    var renderSig = activeViewId + "|" + orderIds.join(",") + "|" + total_orders;
    if (renderSig === lastRenderSig) return;

    if (orderIds.length === 0) {
        $target.empty().hide();
        lastRenderSig = renderSig;
        return;
    }

	// Initialize variables to store totals.
	var total_pallets = 0;
	var total_weight = 0;
	var total_orders = 0;

	// Initialize table HTML.
	var html = GetTableHead();

	// Loop through the orders.
	$.each($("#order-search-view .order-item"), function(key, value) {
		var pallet_count = $(value).data("pallet-count");
		var weight = Math.round($(value).data("weight"), 0);
		var ship_date_raw = $(value).data("ship-date");
		var ship_date = new Date($(value).data("ship-date"));
		var order_number = $(value).data("order-number");
		var city = $(value).data("city");
		var state = $(value).data("state");
		var depositor_po = $(value).data("depositor");

		var customer_po = $(value).data("po");

		if (latest_ship_date == null) {
			latest_ship_date = ship_date;
			latest_ship_date_raw = ship_date_raw;
		} else if (latest_ship_date < ship_date) {
			latest_ship_date = ship_date;
			latest_ship_date_raw = ship_date_raw;
		}

		total_pallets += pallet_count;
		total_weight += parseInt(weight);
		total_orders++;

		// Formatting for output.
		var temp_po = (depositor_po) ? customer_po + "-" + depositor_po : customer_po;

		temp_po = order_number + "<br />" + customer_po + (depositor_po ? "<br/>" + depositor_po : "");

		var temp_date = formatDate(ship_date);
		weight = numberWithCommas(weight);

		// Next, generate the table row HTML.
		html += `
			<tr class="table-row" data-target=".nested-data-${order_number}" data-toggle="collapse" aria-expanded="true">
				<td>${temp_po}</td>
				<td>${weight}</td>
				<td>${pallet_count}</td>
				<td>${temp_date}</td>
				<td>${city}, ${state}</td>
				<!--td class="mobile-collapse">${state}</td-->
				<td class="mobile-collapse"><button class="nested-remove-button btn btn-danger" onClick="$('.orders .order-item[data-order-number=${order_number}]').remove();">Remove</button></td>
			</tr>
		`;

		var nested_data = $(".expand-collapse-" + order_number).html();


		html += `
			<tr class="table-row nested-data nested-data-${order_number} collapse show">
				<td colspan="6">
					${nested_data}
					<button class="nested-remove-button mobile-show btn btn-danger" style="margin-bottom: 0.35rem;" onClick="$('.orders .order-item[data-order-number=${order_number}]').remove();">Remove</button>
				</td>
			</tr>
		`;
	});

	total_weight = numberWithCommas(total_weight);


	html += `
		<tr class="table-row totals-row">
			<td></td>
			<td style="font-weight: bold;">${total_weight}</td>
			<td style="font-weight: bold;">${total_pallets}</td>
			<td colspan="3">Total: <span style="font-weight: bold;">${total_orders}</span></td>
		</tr>
	`;


    var $target = $(".view:visible .orders-container");
    $target.html(html);

    if (total_orders > 0) $target.show();
    lastRenderSig = renderSig;

	// For PICKUP, update the earliest date field.
	if (selected_order_type == "PICKUP") {
		var earliest = latest_ship_date.toLocaleDateString("en-US");

		/*
		var html = `
			<span class="total-label">Earliest Pick Up:</span> <span class="total-value">${earliest}</span>
		`;
		*/

		$(".earliest-date").html(earliest);
	}

    }

    function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatDate(date) {
	var d = new Date(date),
	    month = '' + (d.getMonth() + 1),
	    day = '' + d.getDate(),
	    year = d.getFullYear();

	if (month.length < 2)
	    month = '0' + month;
	if (day.length < 2)
	    day = '0' + day;

	return [month, day, year].join('/');
    }

    function forceRepaint() {
        lastRenderSig = null;
        UpdateTotals();
    }

</script>

<style>
    .earliest {
	font-size: 1.25rem;
    }

    .total-value {
	font-weight: 600;
	font-size: 1.50rem;
	color: #222;
	font-weight: bold;
    }

    .total-label {
	font-weight: 500;
	font-size: 1.25rem;
	color: #444;
    }

    body {
        font-size: 2rem;
    }

    /*
    .order-item {
	cursor: pointer;
	margin-bottom: 0.7rem;
    }*/

    #order-error {
	margin-top: 0.7rem;
	margin-bottom: 0.7rem;
    }

    .alert {
        font-weight: bold;
        font-size: 1.05rem;
        text-align: left;
    }

    #bottom-nav {
	position: fixed;
	bottom: 0;
	left: 0;
	right: 0;
    }

    .card {
	margin-bottom: 0.7rem;
    }

    .card-body {
	padding: 1rem;
    }

    .list-group {
	color: #444;
	font-weight: 500;
    }

    .list-group-item {
	text-align: left;
	font-size: 1.15rem;
        padding: .25rem .75rem;
    }

    #back-button {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	margin-top: 0.5rem !important;
	margin-left: 0.5rem !important;
	width: 120px;
	cursor: pointer;
    }

    .select-time-button, .location-validation-button {
	margin-bottom: 0.7rem !important;
    }

    #select-time-data {
	display: block;
    }

    .select-time-button {
	margin: 0 4px !important;
	display: inline-block;
	width: 9rem;
    }

    .h3, h3 {
	font-size: 1.65rem;
    }

    .smaller-logo {
	width: 140px !important;

	position: absolute !important;
	top: -3.5rem !important;
	left: 0.75rem !important;
    }

    .nested-remove-button { display: none; }
    #order-search-view .nested-remove-button { display: inherit; }

    .orders-table {
	width: 100%;
	font-size: 0.9rem;
    }

    .orders-table thead {
	font-size: 1rem;
	font-weight: bold;
    }

    .orders-table th, .orders-table td { padding: 1rem 0.15rem !important; }

    .container-fluid {
	text-align: center;
    }

    ul { margin: 0.5rem !important; }

    .confirmation-data {
	font-size: 1.35rem;
    }

    #vanee-logo { position: relative; top: 3rem; }

    /* iPhone Portrait */
    @media screen and (max-device-width: 480px) and (orientation:portrait) {
        #orders-next {
	    position: fixed !important;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    border-radius: 0;
        }

	#schedule-next {
	    position: fixed !important;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    border-radius: 0;
	}

	#create-order {
	    position: fixed !important;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    border-radius: 0;
	}
    }

    td.mobile-collapse { display: none; }
    th.mobile-collapse { display: none; }
    td.mobile-show { display: block; }

    @media only screen and (min-width: 450px) {
	td.mobile-collapse { display: table-cell; }
	th.mobile-collapse { display: table-cell; }
	td .mobile-show { display: none !important; }
    }

    /* iPhone Landscape */
    @media screen and (max-device-width: 480px) and (orientation:landscape) {

    }

    @media screen and (min-device-width: 600px) {
	.smaller-logo { max-width: 25% !important; }
    }

    .pbar-disabled {
	opacity: 0.5 !important;
    }

    .progress {
	cursor: pointer;
    }

    .progress-bar.active {
	/*border: 2px solid rgba(0, 0, 0, 0.2);*/
	font-weight: bold;
	opacity: 1 !important;
    }
    .progress-bar {
	/*border: 2px solid rgba(255, 255, 255, 0.65);*/
	opacity: 0.85;
    }

    #schedule-view .mobile-collapse, #success-view .mobile-collapse {
	display: none;
    }
</style>

@endsection
