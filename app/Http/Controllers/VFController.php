<?php
namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
use Validator;

use Illuminate\Support\Facades\Http;

class VFController extends Controller
{
    public $api = 'http://internal.vaneefoods.com/AppointmentAPI.php';

    public function schedule(Request $request) {
        // Build the data array to pass to the template.
        $template = array();

	// Check if an update is occurring.
	if (isset($request->update)) {
		$confirmation_code = $request->update;
		$token = $request->token;

		// Build the request array.
		$data = array();
		$data['function'] = "viewAppointment";
		$data['id'] = $confirmation_code;
		$data['token'] = $token;

		$template['id'] = $confirmation_code;

		// Create the URL for the request.
		$query = $this->api . "?" . http_build_query($data);

		// Query for the order.
		$obj = json_decode(file_get_contents($query));

		// Initialize array to store the response that we will send back.
		$response = array();

		// Check if a match was found.
		if (isset($obj->viewAppointmentResults[0]) && $obj->viewAppointmentResults[0]) {

			$res = $obj->viewAppointmentResults[0];


			// Build an array with the data we need.
			$response = array();

			$response['id'] = $res->id;
			$response['order_type'] = $res->type;
			$response['carrier'] = $res->carrier;
			$response['email'] = $res->email;
			$response['phone'] = $res->phone;
			$response['appointment_datetime'] = $res->appointment_datetime;
			$response['orders'] = array();

			foreach ($res->orders as $order_id) {

				$order_response = array();
				$order_response['order_type'] = $res->type;
				$order_response['order_id'] = $order_id;

				$data = array();
                                $data['function'] = "viewOrder";
                                $data['appointmentType'] = $res->type;
                                $data['orderNumber'] = $order_id->vanee_number;

				/*
				$data = array();
				$data['function'] = "searchForOrder";
				$data['appointmentType'] = $response['order_type'];
				$data['search'] = $order_id->vanee_number;

				// Create the URL for the request.
				$query = $this->api . "?" . http_build_query($data);

				// Query for the order.
				$obj = json_decode(file_get_contents($query));*/

		                // Check if a match was found.
		                //if (isset($obj->searchForOrderResults[0]) && $obj->searchForOrderResults[0]) {
		                        // Build an array with the data we need.
		                        //$order_response['order_type'] = $res->type;
		                        //$order_response['order_id'] = $order_id;
		                        //$order_response['customer_po'] = $obj->searchForOrderResults[0]->customer_po;
		                        //$order_response['order_number'] = $obj->searchForOrderResults[0]->order_number;

		                        /* We need to get the weight of the order, but that is not
		                           found in the same request as the validation information. */
					/*
		                        $data = array();
		                        $data['function'] = "viewOrder";
		                        $data['appointmentType'] = $res->type;
		                        $data['orderNumber'] = $order_id->vanee_number;
					*/

		                        // Create the URL for the request.
		                        $query = $this->api . "?" . http_build_query($data);

		                        // Query for the order.
		                        $obj = json_decode(file_get_contents($query));

		                        // Add the weight to the response object.
		                        $order_response['weight'] = $obj->viewOrderResults[0]->totalWeight;

		                        // Get the order notes.
		                        $notes = $obj->viewOrderResults[0]->notes;

		                        $order_response['notes'] = array();

		                        // Loop through the notes.
		                        foreach ($notes as $note) {
		                            $order_response['notes'][] = $note;
		                        }

		                        // Add the weight to the response object.
		                        $order_response['city'] = $obj->viewOrderResults[0]->city;
		                        $order_response['state'] = $obj->viewOrderResults[0]->state;
					$order_response['pallet_count'] = $obj->viewOrderResults[0]->palletCount;
					$order_response['ship_date'] = date("m/d/Y", strtotime($obj->viewOrderResults[0]->ship_date));
					$order_response['depositor_po'] = $obj->viewOrderResults[0]->depositor_po_number;

					$order_response['customer_po'] = $obj->viewOrderResults[0]->customer_po;
					$order_response['order_number'] = $obj->viewOrderResults[0]->order_number;

					if ($order_response['depositor_po'] == " ")
					    $order_response['depositor_po'] = "";

		                        $template['orders'][] = $order_response;
				/*
		                } else {
		                        echo "Error #55: Order not located.";
		                        exit;
		                }*/



				$response['orders'][] = $order_response;
			}

			$response['information'] = $res->information;
		}

		// Add the date to the template array.
		$template = $response;
		$template['date'] = date("m/d/Y", strtotime($response['appointment_datetime']));
		$template['time'] = date("g:i A", strtotime($response['appointment_datetime']));
		$template['order_type'] = $res->type;
		$template['view'] = "update";
		$json = json_encode($template);

		$json = preg_replace("_\\\_", "\\\\\\", $json);
		$json = preg_replace("/\"/", "\\\"", $json);

		$template['json'] = $json;
	}

	// Check if we need to pre-build the layout based on provided order data.
	if (isset($request->orders)) {
	    $order_type = $request->order_type;

        $existingHits = [];  // collect all orders that already have appointments

	    // Initialize array of orders.
	    $template['orders'] = array();

	    $order_list = $request->orders;

	    $order_list = explode(",", $request->orders);

	    // Loop through the orders that were passed into the URL.
	    foreach ($order_list as $key => $order_id) {
		// Build the request array.
		$data = array();
		$data['function'] = "searchForOrder";
		$data['appointmentType'] = $order_type;
		$data['search'] = $order_id;

		// Create the URL for the request.
		$query = $this->api . "?" . http_build_query($data);

		// Query for the order.
		$obj = json_decode(file_get_contents($query));

		// Initialize array to store the response that we will send back.
		$response = array();

		// Check if a match was found.
		if (isset($obj->searchForOrderResults[0]) && $obj->searchForOrderResults[0]) {

            $existing = $obj->searchForOrderResults[0]->existing_appointments ?? [];
            if (!is_array($existing)) {
                $existing = $existing ? [$existing] : [];
            }
        
            if (count($existing) > 0) {
                $existingHits[] = [
                    'order'        => (string)$order_id,
                    'appointments' => $existing,
                ];
                continue;
            }

			// Build an array with the data we need.
                        $response['order_type'] = $order_type;
                        $response['order_id'] = $order_id;
                        $response['customer_po'] = $obj->searchForOrderResults[0]->customer_po;
                        $response['order_number'] = $obj->searchForOrderResults[0]->order_number;

                        /* We need to get the weight of the order, but that is not
                           found in the same request as the validation information. */

                        $data = array();
                        $data['function'] = "viewOrder";
                        $data['appointmentType'] = $order_type;
                        $data['orderNumber'] = $order_id;

                        // Create the URL for the request.
                        $query = $this->api . "?" . http_build_query($data);

                        // Query for the order.
                        $obj = json_decode(file_get_contents($query));

                        // Add the weight to the response object.
                        $response['weight'] = $obj->viewOrderResults[0]->totalWeight;


                        // Get the order notes.
                        $notes = $obj->viewOrderResults[0]->notes;

                        $response['notes'] = array();

                        // Loop through the notes.
                        foreach ($notes as $note) {
                           $response['notes'][] = $note;
                        }

                        // Add the weight to the response object.
                        $response['city'] = $obj->viewOrderResults[0]->city;
                        $response['state'] = $obj->viewOrderResults[0]->state;
			$response['pallet_count'] = $obj->viewOrderResults[0]->palletCount;
			$response['ship_date'] = date("m/d/Y", strtotime($obj->viewOrderResults[0]->ship_date));
			$response['depositor_po'] = $obj->viewOrderResults[0]->depositor_po_number;

                        if ($response['depositor_po'] == " ")
                            $response['depositor_po'] = "";

			$template['orders'][] = $response;
		} else {
			echo "Error #55: Order not located.";
			exit;
		}
	    }

        if (!empty($existingHits)) {
            // Build a concise message, e.g., list the orders that are blocked
            $orderList = implode(', ', array_map(fn($x) => $x['order'], $existingHits));
        
            $template['existing_block'] = [
                'code'    => 'EXISTING_APPOINTMENT',
                'message' => "An appointment already exists for order(s): {$orderList}. Redirecting home 5 seconds",
                'redirect'=> url('/'),
                'details' => $existingHits, // just sending so FE can inspect
            ];
        
            return view('vf.schedule', ['data' => $template]);
        }

	    // Add the date to the template array.
	    $template['date'] = date("m/d/Y", strtotime($request->date));
	    $template['order_type'] = $request->order_type;

	    $template['carrier'] = isset($request->carrier) ? $request->carrier : '';
	    $template['phone'] = isset($request->phone) ? $request->phone : '';
	    $template['email'] = isset($request->email) ? $request->email : '';



	    $template['view'] = "premade";
	    $json = json_encode($template);
	    //$template['json'] = $json;

	    $json = preg_replace("_\\\_", "\\\\\\", $json);
	    $json = preg_replace("/\"/", "\\\"", $json);

	    $template['json'] = $json;

	}

        return view('vf.schedule', ['data' => $template]);
    }

    public function createOrder(Request $request) {
	$id = $request->id;
	$token = isset($request->token) ? $request->token : "";

	if ($id > 0)
		$method = "update";
	else
		$method = "create";

	// Localize user input.
	$order_type = $request->order_type;
	$order_date = $request->date;
	$order_time = $request->time;
	$orders = $request->orders;

	$order_email = $request->email;
	$order_phone = $request->phone;
	$order_carrier = $request->carrier;

	// Strip out formatting characters in the phone field.
	$order_phone = preg_replace("/[^0-9]/", "", $order_phone);
	$order_phone = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $order_phone);


	// Format the selected date.
	$order_date = str_replace("-", "/", $order_date);
	$formatted_order_date = date("m/d/Y", strtotime($order_date));
	$order_date = date("Y-m-d", strtotime($order_date));

	// Format the time.
	$time_in_24_hour_format  = date("H:i:s", strtotime($order_time));

	// Concatenate the datetime.
	$order_datetime = $order_date . " " . $time_in_24_hour_format;

	// Build the request array.
	$data = array();

	if ($method == "create") {
		$data['function'] = "createAppointment";
	} else {
		$data['function'] = "updateAppointment";
		$data['id'] = $id;
		$data['token'] = $token;
	}


	$data['appointmentType'] = $order_type;
	$data['orders'] = $orders;
	$data['appointmentDateTime'] = $order_datetime;
	$data['emailAddress'] = $order_email;
	$data['phone'] = $order_phone;
	$data['carrier'] = $order_carrier;

	// Create the URL for the request.
	$query = $this->api . "?" . http_build_query($data);

	// Query for the order.
	$obj = json_decode(file_get_contents($query));

	// Initialize array to store the response that we will send back.
	$response = array();

	if ($method == "update") {
	  if ($obj->updateAppointmentResults) {
	    $res = $obj->updateAppointmentResults;

            // Fetch the status and identifier.
            $status = $res->status;
            $id = $res->id;

            $response['success'] = 1;
            $response['status'] = $status;
            $response['id'] = $id;
            $response['day'] = $formatted_order_date;
	    $response['vanee_location'] = $res->vanee_location->address . "<br />" . $res->vanee_location->city_state_zip;
	  } else {
	    $response['success'] = 0;
	  }
	} else {
	  if ($obj->createAppointmentResults) {
	      $res = $obj->createAppointmentResults;

	      // Fetch the status and identifier.
	      $status = $res->status;
	      $id = $res->id;
	      $token = $res->token;

	      $response['success'] = 1;
	      $response['status'] = $status;
	      $response['id'] = $id;
	      $response['token'] = $token;
	      $response['day'] = $formatted_order_date;
	      $response['vanee_location'] = $res->vanee_location->address . "<br />" . $res->vanee_location->city_state_zip;

	  } else {
	      $response['success'] = 0;
	  }
	}

	echo json_encode($response);
	exit;
    }

    public function deleteAppointment(Request $request) {
        $id    = $request->query('id');
        $token = $request->query('token');

        if (!$id || !$token) {
            return response()->json(['success' => 0, 'message' => 'Missing id/token'], 400);
        }

        $params = [
            'function' => 'deleteAppointment',
            'id'       => $id,
            'token'    => $token,
        ];

        try {
            $resp = Http::timeout(10)->get($this->api, $params);
            $code = $resp->status(); 

            return response()->json([
                'success'     => ($code >= 200 && $code < 300) ? 1 : 0,
                'http_status' => $code,
                // pass through body later if needed 'upstream' => $resp->json(),
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success'     => 0,
                'http_status' => 0,
                'message'     => 'Network error contacting upstream',
            ], 200);
        }
    }


    public function searchDate(Request $request) {
	// Localize user input.
	$order_type = $request->order_type;
	$order_date = $request->order_date;
	$order_weight = $request->order_weight;
	$orders_csv = $request->orders;

	$orders = explode(",", $orders_csv);

	// Format the selected date.
	$order_date = str_replace("-", "/", $order_date);
	$formatted_order_date = date("m/d/Y", strtotime($order_date));
	$order_date = date("Y-m-d", strtotime($order_date));

	// Build the request array.
	$data = array();
	$data['function'] = "searchAppointment";
	$data['appointmentType'] = $order_type;
	$data['totalWeight'] = $order_weight;
	$data['requestedDate'] = $order_date;
	$data['orders'] = $orders;

        // Create the URL for the request.
        $query = $this->api . "?" . http_build_query($data);

        // Query for the order.
        $obj = json_decode(file_get_contents($query));

        // Initialize array to store the response that we will send back.
        $response = array();

        // Check if a match was found.
        if ($obj->searchAppointmentResults) {
		$response['success'] = 1;
		$response['date'] = $formatted_order_date;

		// Create an array to store the available times.
		$times = array();


		if ($obj->searchAppointmentResults->slots[0] != "") {

		  // Loop through the available time slots.
		  foreach ($obj->searchAppointmentResults->slots as $key => $time) {
			$time_in_12_hour_format  = date("g:i A", strtotime($time));
			$times[] = $time_in_12_hour_format;
		  }

		} else {

		  //$response['success'] = 0;
		  $response['empty'] = 1;

		}

		$response['message'] = $obj->searchAppointmentResults->message;
		$response['times'] = $times;
	} else {
		$response['success'] = 0;
	}

	echo json_encode($response);
	exit;
    }

    public function validateLocation(Request $request) {
        // Localize user input.
		$order_id = $request->order_id;
		$order_type = $request->order_type;
		$city = $request->city;
		$state = $request->state;

		// Build the request array.
		$data = array();
		$data['function'] = "searchForOrder";
        $data['appointmentType'] = $order_type;
        $data['search'] = $order_id;

        // Create the URL for the request.
        $query = $this->api . "?" . http_build_query($data);

        // Query for the order.
        $obj = json_decode(file_get_contents($query));
        // Initialize array to store the response that we will send back.
        $response = array();

        // Check if a match was found.
        if ($obj->searchForOrderResults[0]) {

		$existing_appointments = $obj->searchForOrderResults[0]->existing_appointments;

		if ($obj->searchForOrderResults[0]->state == $state && $obj->searchForOrderResults[0]->city == $city) {
			$response['success'] = 1;
	                $response['order_type'] = $order_type;
			$response['order_id'] = $order_id;

			$response['customer_po'] = $obj->searchForOrderResults[0]->customer_po;
	                $response['order_number'] = $obj->searchForOrderResults[0]->order_number;

			/* We need to get the weight of the order, but that is not
			   found in the same request as the validation information. */

			$data = array();
			$data['function'] = "viewOrder";
			$data['appointmentType'] = $order_type;
			//$data['orderNumber'] = $order_id;
			$data['orderNumber'] = $response['order_number'];

			//echo $this->api . "?" . http_build_query($data);exit;

		        // Create the URL for the request.
		        $query = $this->api . "?" . http_build_query($data);

		        // Query for the order.
		        $obj = json_decode(file_get_contents($query));

			// Get the order notes.
			// Loop through the notes.
			$response['notes'] = array();
			if( isset($obj->viewOrderResults[0]->notes) ) {
				$notes = $obj->viewOrderResults[0]->notes;
				foreach ($notes as $note) {
				    $response['notes'][] = $note;
				}
			}

			// Add the weight to the response object.
			$response['weight'] = $obj->viewOrderResults[0]->totalWeight;
			$response['city'] = $obj->viewOrderResults[0]->city;
			$response['state'] = $obj->viewOrderResults[0]->state;
			$response['pallet_count'] = $obj->viewOrderResults[0]->palletCount;
			$response['ship_date'] = date("m/d/Y", strtotime($obj->viewOrderResults[0]->ship_date));
			$response['depositor_po'] = $obj->viewOrderResults[0]->depositor_po_number;

			if ($response['depositor_po'] == " ")
			    $response['depositor_po'] = "";

                } else {
                        $response['success'] = 0;
                }
        } else {
                $response['success'] = 0;
        }

        echo json_encode($response);
        exit;
    }

    public function searchOrder(Request $request) {
	// Localize user input.
        $order_id = $request->order_id;
	$order_type = $request->order_type;
	$existing_appointment = $request->existing_appointment;

	// Build the request array.
	$data = array();
	$data['function'] = "searchForOrder";
	$data['appointmentType'] = $order_type;
	$data['search'] = $order_id;

	// Create the URL for the request.
	$query = $this->api . "?" . http_build_query($data);

        // Query for the order.
        $obj = json_decode(file_get_contents($query));

	// Initialize array to store the response that we will send back.
	$response = array();

	// Check if a match was found.
	if (isset($obj->searchForOrderResults[0])) {


		$existing_appointments = $obj->searchForOrderResults[0]->existing_appointments;

		// Check if this appointment already exists.
		if ($existing_appointments) {
			foreach ($existing_appointments as $val) {
				if ($val != $existing_appointment) {
					$response['success'] = 0;
					$response['message'] = "Order #" . $order_id . " is already scheduled.";

					echo json_encode($response);
					exit;
				}
			}
		}



		$response['success'] = 1;

		// Fetch the validation results.
		$validation = $obj->searchForOrderResults[0]->validation;

		// Create array to store locations.
		$locations = array();

		// Add the correct answer to the array.
		$locations[] = array("city" => $obj->searchForOrderResults[0]->city, "state" => $obj->searchForOrderResults[0]->state);

		// Loop through the validation results.
		foreach ($validation  as $val) {
			// Create a temporary array to store location.
			$temp = array();
			$temp['city'] = $val->city;
			$temp['state'] = $val->state;

			if (!($temp['state'] == "" && $temp['city'] == " ")) {
				// Add this entry to the locations array.
				$locations[] = $temp;
			}
		}

		// Randomize the order of elements.
		shuffle($locations);

		$response['locations'] = $locations;
		$response['order_type'] = $order_type;
		$response['order_id'] = $order_id;

		//$response['customer_po'] = $obj->searchForOrderResults[0]->customer_po;
		//$response['order_number'] = $obj->searchForOrderResults[0]->order_number;
	} else {
		$response['success'] = 0;
	}

	echo json_encode($response);
        exit;
    }

    public function sampleOrder(Request $request) {
        header("Content-Type: application/json");

        // Generate JSON.
        $data = array("order_number" => "193983", "customer_po" => "SO-48483", "depositor_po_number" => "SO-48483", "vanee_location" => "2759 S 25TH AVE, BROADVIEW, IL");

        echo json_encode($data);

        exit;
    }

}
