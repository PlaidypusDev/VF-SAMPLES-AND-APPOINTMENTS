<?php
namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
use Validator;

class SampleController extends Controller
{
	public $api = 'http://internal.vaneefoods.com/SampleAPI.php';

	public function cartAdd(Request $request) {
		// Localize request data.
		$inventory_id = $request->inventory_id;
		$quantity = $request->quantity;

		// Check if we are incrementing display units.
		if (isset($request->displayUnits)) {
			$display_units = $request->displayUnits;
		} else {
			$display_units = 0;
		}

		// Fetch the current cart contents.
		$cart = session('cart') ? session('cart') : array();
		$display = session('display') ? session('display') : array();

		// Update cart/display quantity.
		if ($display_units) {
			if (!isset($display[$inventory_id])) {
				$display[$inventory_id] = $quantity;
			} else {
				$display[$inventory_id] += $quantity;
			}
		} else {
			if (!isset($cart[$inventory_id])) {
				$cart[$inventory_id] = $quantity;
			} else {
				$cart[$inventory_id] += $quantity;
			}
		}

		// Write to the session.
		session(['cart' => $cart]);
		session(['display' => $display]);

		if ($display_units)
			return response($display[$inventory_id]);
		else
			return response($cart[$inventory_id]);
	}

	public function cartModify(Request $request) {
		// Localize request data.
		$inventory_id = $request->inventory_id;
		$quantity = $request->quantity;

		// Check if we are modifying display units.
		if (isset($request->displayUnits)) {
			$display_units = $request->displayUnits;
		} else {
			$display_units = 0;
		}

		// Fetch the current cart contents.
		$cart = session('cart') ? session('cart') : array();
		$display = session('display') ? session('display') : array();

		// Update cart/display quantity.
		if ($display_units)
			$display[$inventory_id] = $quantity;
		else
			$cart[$inventory_id] = $quantity;

		// Write to the session.
		session(['cart' => $cart]);
		session(['display' => $display]);

		if ($display_units)
			return response($display[$inventory_id]);
		else
			return response($cart[$inventory_id]);
	}

	public function viewInventory(Request $request, $inventory_id) {
		echo $inventory_id;
		exit;
	}

	public function cartSearch(Request $request) {
		$search = $request->search;

		session(['search' => $search]);

		return $search;
	}

	public function editOrder(Request $request) {
		// Ensure that the user is logged in.
		if (!session('authenticated')) {

			if ($request->method() == "GET") {
				session(['intended' => '/orders/edit/' . $request->id]);
			}

			return redirect()->route('sample-login');
		}

		// Initialize template.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();
		
		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		// Get the User's ID.
		$user_id = session('user_id');

		// Get stock number.
		$stock = array();

		// Make a version of this array indexed by stock number.
		foreach ($template['all_inventory'] as $key => $val) {
			$stock[$val->stock_number] = $val;
		}

		// Check the order that was requested to be modified.
		$order_id = $request->id;

		$data = array();
		$data['Function'] = "orderDetail";
		$data['orderID'] = $order_id;
		$data['userID'] = $user_id;
		//$data['userID'] = "ALL"; // @todo

		// Make the request for order data.
		$obj = $this->makeRequest($data);

		// Check for a valid response.
		if (isset($obj->orderDetailResults) && $obj->orderDetailResults[0]->id == $order_id) {
			// Localize object for ease of access.
			$order = $obj->orderDetailResults[0];

			
			// Don't proceed if the user does not have permission.
			/*
			if ($order->created_user != $user_id) {
				$response = array();
				$response['status'] = 0;
				$response['message'] = "You do not have permission to edit this order.";
				
				return json_encode($response);
			}
			*/

			// Don't proceed if the order is no longer pending.
			if ($order->status != 1) {
				$response = array();
				$response['status'] = 0;
				$response['message'] = "This order can no longer be modified.";
				
				return json_encode($response);
			}

			// Begin populating array details.
			$temp = array();
			$temp['address_1'] = $order->ship_to_address_1;
			$temp['address_2'] = $order->ship_to_address_2;
			$temp['city'] = $order->ship_to_city;
			$temp['state'] = $order->ship_to_state;
			$temp['zip'] = $order->ship_to_zipcode;
			//$temp['type'] = $order->ship_to_loc_type; // Old method to obtain address type.
			$temp['type'] = (strtoupper($order->ship_to_loc_type) == "RESIDENCE" || strtoupper($order->ship_to_loc_type) == "RESIDENTIAL") ? "residential" : "business";

			$temp['reason'] = $order->reason;
			$temp['company_name'] = $order->ship_to_company;
			$temp['attn'] = $order->ship_to_attention;
			$temp['crm_company_id'] = isset($order->crm_company_id) ? $order->crm_company_id : "";

			$temp['email'] = $order->ship_to_email;
			$temp['phone'] = isset($order->phone_number) ? $order->phone_number : "";
			$temp['by'] = ($order->need_by == "0000-00-00") ? "" : date("m/d/Y", strtotime($order->need_by));
			$temp['notes'] = $order->shipment_notes;

			// Initialize arrays to store shopping cart information.
			$temp['cart'] = array();
			$temp['display'] = array();

			$cart = array();
			$display = array();

			// Loop through the order items to populate the shopping cart data.
			if (isset($order->details)) {
				foreach ($order->details as $item) {
					if (isset($stock[$item->stock_number])) {
						if (isset($item->type) && $item-> type == 60) {
							$temp['display'][$stock[$item->stock_number]->id] = $item->quantity;
						} else {
							$temp['cart'][$stock[$item->stock_number]->id] = $item->quantity;
						}
					}
				}
			}

			// Write out the session data.
			session(['order_id' => $order_id]);
			session(['address_1' => $temp['address_1']]);
			session(['address_2' => $temp['address_2']]);
			session(['city' => $temp['city']]);
			session(['state' => $temp['state']]);
			session(['zip' => $temp['zip']]);
			session(['type' => $temp['type']]);

			session(['reason' => $temp['reason']]);
			session(['company_name' => $temp['company_name']]);
			session(['attn' => $temp['attn']]);

			session(['email' => $temp['email']]);
			session(['phone' => $temp['phone']]);
			session(['by' => $temp['by']]);
			session(['notes' => $temp['notes']]);
			session(['status' => 'Existing']);
			session(['crm_company_id' => $temp['crm_company_id']]);

			// Finally, the shopping cart data.
			session(['cart' => $temp['cart']]);
			session(['display' => $temp['display']]);

			if ($request->method() == "GET") {
				return redirect()->route("sample-cart");
			} else {
				// Send out a success status.
				$response = array();
				$response['status'] = 1;
				$response['message'] = "Success";
				
				return json_encode($response);
			}

		} else {

			if ($request->method() == "GET") {
				return redirect()->route("sample-orders");
			} else {
				// Send out a failure status.
				$response = array();
				$response['status'] = 0;
				$response['message'] = "An error occurred trying to locate this order.";
				
				return json_encode($response);
			}

		}
			

		/*
		stdClass Object([orderDetailResults] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 55097
                    [created_date] => 2022-09-07 12:40:32
                    [created_user] => 322
                    [acknowledged_user] => 
                    [reason] => This is my reason.
                    [need_by] => 2022-09-30
                    [status] => 1
                    [ship_method_id] => 1
                    [total_shipping_cost] => 0.00
                    [shipment_id_number] => 
                    [shipping_time] => 0000-00-00 00:00:00
                    [ups_account] => 
                    [ups_zipcode] => 
                    [ups_cost_account] => 1
                    [priority] => 0
                    [insured_value] => 0.00
                    [control_log_receipt] => 
                    [phone_number] => 
                    [ship_to_company] => Plaidypus, Inc.
                    [ship_to_attention] => Joe Majewski
                    [ship_to_address_1] => 328 BARNABY DR
                    [ship_to_address_2] => 
                    [ship_to_city] => OSWEGO
                    [ship_to_state] => IL
                    [ship_to_zipcode] => 60543
                    [ship_to_loc_type] => RESIDENTIAL
                    [ship_to_email] => majewski.joseph@gmail.com
                    [validated] => 1
                    [shipment_notes] => 
                    [status_description] => BLAKE
                    [ups_account_description] => VANEE
                    [ship_method_description] => Ground
                    [ups_shipping_info] => Talk to Vanee Samples samples@vaneefoods.com
                    [details] => Array
                        (
                            [0] => stdClass Object
                                (
                                    [id] => 55097
                                    [type] => 10
                                    [quantity] => 1
                                    [stock_number] => 8960-08FD-1WCK
                                    [picked] => 
                                    [description] => ALFREDO SAUCE MIX
                                    [packaging_type] => 15.945" 405mm POUCH
                                    [packaging_container_type] => POUCH
                                    [net_weight] => 7.000000
                                    [gtin14] => 10806795585084
                                )
                        )
                )
        )
		*/
	}

	public function viewOrder(Request $request, $order_id) {
		// Ensure that the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}

		// Initialize template.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();
		
		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		// Get the User's ID.
		$user_id = session('user_id');
		//$user_id = "ALL"; // @todo: Remove in production.

		/* THIS IS CODE THAT GETS ALL ORDERS

		// Get the User's ID.
		$user_id = session('user_id');
		$user_id = "ALL"; // @todo: Remove in production.

		// Build the request array.
		$data = array();
		$data['Function'] = "orderHeader";
		$data['userID'] = $user_id;
		$data['recordLimit'] = 250;

		// Make the request for order data.
		$obj = $this->makeRequest($data);

		print_r($obj);exit;

		// Initialize array of orders.
		$orders = array();

		// Different categories an order can belong to.
		$pending = array();
		$packing = array();
		$shipping = array();

		// Check that results were found.
		if (isset($obj->orderHeaderResults)) {
			// Loop through the results.
			foreach ($obj->orderHeaderResults as $order) {
				$orders[$order->id] = $order;

				// Check the status to determine whether the order is pending, being packed, or already shipped.
				if ($order->status == 3) {
					$pending[$order->id] = $order;
				} else if ($order->status == 2) {
					$packing[$order->id] = $order;
				} else if ($order->status == 1) {
					$shipping[$order->id] = $order;
				}
			}
		}
		*/

		// Initialize data to send to the template.
		$template['order_id'] = $order_id;
		$template['inventory'] = $inventory;
		$template['error'] = false;

		$template['quantity'] = 0;
		$template['details'] = array(); // May not be used.

		$template['sample_quantity'] = 0;
		$template['sample_details'] = array();

		$template['display_quantity'] = 0;
		$template['display_details'] = array();

		// Get stock number.
		$stock = array();

		// Make a version of this array indexed by stock number.
		foreach ($template['inventory'] as $key => $val) {
			$stock[$val->stock_number] = $val;
		}

		// Add to the template.
		$template['stock'] = $stock;

		$data = array();
		$data['Function'] = "orderDetail";
		$data['orderID'] = $order_id;
		$data['userID'] = session('user_id');
		//$data['userID'] = "ALL"; @todo

		// Make the request for order data.
		$obj = $this->makeRequest($data);

		// Check for a valid response.
		if (isset($obj->orderDetailResults) && $obj->orderDetailResults[0]->id == $order_id) {
			$template['order'] = $obj->orderDetailResults[0];

			// Check if order details are present.
			if (isset($obj->orderDetailResults[0]->details)) {
				// Loop through the samples within this order.
				foreach ($obj->orderDetailResults[0]->details as $key => $sample) {

					// A type of `10` refers to a sample. A type of `60` refers to a display unit.
					if ($sample->type == 10) {
						$template['sample_details'][$sample->stock_number] = $sample;
						$template['sample_quantity'] += $sample->quantity;
					} else {
						$template['display_details'][$sample->stock_number] = $sample;
						$template['display_quantity'] += $sample->quantity;
					}

					// We may not use the details array as it contians everything. The `sample` and `display` arrays contain the separated information.
					$template['details'][] = $sample;
					$template['quantity'] += $sample->quantity;
				}
			}

		} else {
			$template['error'] = true;
		}

		$template['counter'] = 0;

		return view('samples.order-details', ['data' => $template]);
	}

	/* 
	 * Note:
	 *
	 * The following function is no longer used as we changed the inventory page to instead represent 
	 * everything in a tabular format. Being preserved, as at the time of writing this, there has
	 * not yet been a repo created for this project.
	 * 
	 * See: cart()
	 */

	/*
	public function inventory(Request $request) {
		// Ensure the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}

		// Initialize template.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();
		
		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		//$template['inventory'] = $inventory; // Disable to only show items in your cart.
		$template['counter'] = 0;

		return view('samples.inventory', ['data' => $template]);
	}
	*/

	// Checkout: Process Order
	public function checkoutProcess(Request $request) {
		// Ensure the user is logged in.
		if (!session('authenticated')) {
			// Prevent further execution...
			exit;
		}

		// Get shopping cart data.
		$samples = session('cart');
		$display = session('display');

		// Begin Deprecated Code @todo
		// Remove once Blake switches to using the `samples` and `display` arrays.

		// Initialize array to store order items.
		$order_items = array();

		if ($samples) {
			// Create array of samples.
			foreach ($samples as $key => $val) {
				$order_items[$key]['sample_qty'] = $val;
			}
		}

		if ($display) {
			// Add display units to this array as well.
			foreach ($display as $key => $val) {
				$order_items[$key]['display_qty'] = $val;
			}
		}
		// End Deprecated Code

		// Build the request object.
		$temp = array();
		$temp['user_id'] = session('user_id');
		$temp['shipping_name'] = session('company_name');
		$temp['shipping_attn'] = session('attn');
		$temp['shipping_address_1'] = session('address_1');
		$temp['shipping_address_2'] = session('address_2');
		$temp['city'] = session('city');
		$temp['state'] = session('state');
		$temp['zip'] = session('zip');
		$temp['type'] = session('type');
		$temp['email'] = session('email');
		$temp['phone'] = session('phone');
		$temp['validated'] = (session('status') == "manual") ? 0 : 1;
		$temp['reason_for_request'] = session('reason');
		$temp['need_by'] = session('by');
		$temp['notes'] = $request->notes;
		$temp['shipment_notes'] = $request->notes;
		$temp['crm_company_id'] = session('crm_company_id');

		// Add the samples.
		$temp['samples'] = $order_items; // Deprecated @todo
		$temp['sample_quantities'] = $samples;
		$temp['display_quantities'] = $display;
		$temp['orderID'] = session('order_id');

		// Before performing the request, strip the formatting from the phone number.
		$temp['phone'] = preg_replace("/[^0-9]/", "", $temp['phone']);

		if ($temp['orderID']) {
			// Perform the cURL request to submit the order.
			$data = $this->curl($this->api . "?Function=updateOrder&orderID=" . $temp['orderID'], ['Data' => json_encode($temp)]);
		
			$response = json_decode($data[0]);

			// Check for a successful response code.
			if (isset($response->updateOrderResults) && isset($response->updateOrderResults->success) && $response->updateOrderResults->success == 1) {
				session(['successful_order' => true]);
				session(['order_id' => null]);
				session(['address_1' => false]);
				session(['address_2' => false]);
				session(['city' => false]);
				session(['state' => false]);
				session(['zip' => false]);
				session(['reason' => false]);
				session(['notes' => false]);
				session(['by' => false]);
				session(['status' => false]);
				session(['crm_company_id' => false]);
		
				session(['company_name' => false]);
				session(['attn' => false]);
				session(['email' => false]);
				session(['phone' => false]);
		
				session(['cart' => false]);
				session(['display' => false]);
				session(['notes' => null]);
				
				return response(1);
			} else {
				return response(0);
			}

			exit;
		} else {
			// Perform the cURL request to submit the order.
			$data = $this->curl($this->api . "?Function=createOrder", ['Data' => json_encode($temp)]);

			//print_r($data);exit;
			
			$response = json_decode($data[0]);

			// Check for a successful response code.
			if (isset($response->createOrderResults) && isset($response->createOrderResults->success) && $response->createOrderResults->success == 1) {
				session(['successful_order' => true]);
				session(['order_id' => null]);
				session(['address_1' => false]);
				session(['address_2' => false]);
				session(['city' => false]);
				session(['state' => false]);
				session(['zip' => false]);
				session(['reason' => false]);
				session(['notes' => false]);
				session(['by' => false]);
				session(['status' => false]);
				session(['crm_company_id' => false]);
		
				session(['company_name' => false]);
				session(['attn' => false]);
				session(['email' => false]);
				session(['phone' => false]);
		
				session(['cart' => false]);
				session(['display' => false]);
				session(['notes' => null]);
				return response(1);
			} else {
				return response(0);
			}

			exit;
		}

	}
	
	function curl($url, $fields = array(), $auth = false) {
		$j = 0;
		$i = 0;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HEADER, 1);

		curl_setopt($curl, CURLOPT_TIMEOUT, 5);

		if ($auth) {
			curl_setopt($curl, CURLOPT_USERPWD, "$auth");
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		}

		if ($fields){
			$fields_string = http_build_query($fields);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
		}

		$response = curl_exec($curl);
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header_string = substr($response, 0, $header_size);
		$body = substr($response, $header_size);

		$header_rows = explode(PHP_EOL, $header_string);
		$header_rows = array_filter($header_rows, 'trim');

		foreach((array)$header_rows as $hr){
			$colonpos = strpos($hr, ':');
			$key = $colonpos !== false ? substr($hr, 0, $colonpos) : (int)$i++;

			if (strpos("TEST" . $hr, "Set-Cookie")) {
				$key = "Set-Cookie-$j";
				$j++;
			}

			$headers[$key] = $colonpos !== false ? trim(substr($hr, $colonpos+1)) : $hr;
		}

		foreach ((array)$headers as $key => $val) {
			$vals = explode(';', $val);
			if(count($vals) >= 2) {
				unset($headers[$key]);
				foreach($vals as $vk => $vv) {
					$equalpos = strpos($vv, '=');
					$vkey = $equalpos !== false ? trim(substr($vv, 0, $equalpos)) : (int)$j++;
					$headers[$key][$vkey] = $equalpos !== false ? trim(substr($vv, $equalpos+1)) : $vv;
				}
			}
		}

		curl_close($curl);
		return array($body, $headers);
	}

	/*
	// Checkout: Process Order (Original)
	public function checkoutProcessOriginal(Request $request) {
		print_r($_REQUEST);
		exit;

		// Initialize template.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();

		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		print_r($template);
		echo "\n\n\n\n\n\nInventory:\n\n";
		print_r($inventory);

		
		// Initialize template.
		//$template = array();

		// Get Samples
		//$inventory = $this->getSamples();
		
		// Generate sidebar data.
		//$this->GetSidebarData($template, $inventory);

		// Build the request array.
		$data = array();
		$data['Function'] = "createOrder";
		$data['orderDataObject'] = "test";

		// Build the request object.
		$temp = array();
		$temp['user_id'] = session('user_id');

		$temp['reason_for_request'] = $request->reason;
		$temp['notes'] = $request->notes;
		$temp['need_by'] = $request->by;

		$temp['shipping_name'] = session('company_name');
		$temp['shipping_attn'] = session('attn');

		$temp['shipping_address_1'] = session('address_1');
		$temp['shipping_address_2'] = session('address_2');
		
		$temp['city'] = session('city');
		$temp['state'] = session('state');
		$temp['zip'] = session('zip');

		$temp['type'] = session('type');
		$temp['email'] = session('email');
		$temp['phone'] = session('phone');
		$temp['validated'] = (session('status') == "manual") ? 0 : 1;

		$data = $temp;

		//print_r($data);

		// Create the URL for the request.
		$query = $this->api . "?" . http_build_query($data);

		$response = Http::post($this->api . "?Function=createOrder", ['Data' => json_encode($data)]);

		echo $response;
		//print_r($response);


		// Fetch and return the response.
		//return json_decode(file_get_contents($query));

		// Make the request for order data.
		//$obj = $this->makeRequest($data);
		//print_r($obj);
	}
	*/

	// Checkout: Review Order
	public function checkout(Request $request) {
		// Ensure the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}

		// Initialize template.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();
		
		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		/*
		// Fetch the current cart contents.
		$cart = session('cart') ? session('cart') : array();
		$display = session('display') ? session('display') : array();

		$temp = array();
		$disp = array();
		$relevant_inventory = array();

		foreach ($inventory as $key => $inv) {
			if (isset($cart[$inv->id]) && $cart[$inv->id] > 0) {
				$temp[$key] = $inv;
			}

			if (isset($display[$inv->id]) && $display[$inv->id] > 0) {
				$disp[$key] = $inv;
			}

			if ((isset($display[$inv->id]) && $display[$inv->id] > 0) || (isset($cart[$inv->id]) && $cart[$inv->id] > 0)) {
				$relevant_inventory[$key] = $inv;
			}
		}

		// Populate display inventory.
		$inventory = $temp;
		$display_inventory = $disp;
		$drawer_inventory = $relevant_inventory;

		$template['drawer_inventory'] = $drawer_inventory;
		*/

		// Assign current address.
		if (session('address_1')) {
			$temp = array();
			$temp['address_1'] = session('address_1');
			$temp['address_2'] = session('address_2');
			$temp['city'] = session('city');
			$temp['state'] = session('state');
			$temp['zip'] = session('zip');
			$temp['type'] = session('type');
			$temp['reason'] = session('reason');
			$temp['company_name'] = session('company_name');
			$temp['attn'] = session('attn');
			$temp['email'] = session('email');
			$temp['phone'] = session('phone');
			$temp['by'] = session('by');
			$temp['crm_company_id'] = session('crm_company_id');

			$template['current_address'] = $temp;
		} else {
			$template['current_address'] = false;

			// Force the user to the address page.
			return redirect()->route('sample-address');
		}

		// Send data to template.
		$template['counter'] = 0;
		$template['reason'] = session('reason');
		$template['notes'] = session('notes');

		// Create or Update?
		$template['order_id'] = session('order_id');

		return view('samples.checkout', ['data' => $template]);
	}

	public function cart(Request $request) {
		// Ensure that the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}

		// Initialize variable to store template data.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();

		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		$template['counter'] = 0;
		$template['search'] = session('search');

		return view('samples.inventory-table', ['data' => $template]);
	}

	// View Details for a Given Sample (Modal Version)
	public function sampleDetailsModal(Request $request, $inventory_id) {
		// Ensure that the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}

		// Fetch the current cart contents.
		$cart = session('cart') ? session('cart') : array();
		$display = session('display') ? session('display') : array();

		// Initialize template data.
		$template = array();
		$template['error'] = false;
		$template['inventory_id'] = $inventory_id;
		$template['cart'] = $cart;
		$template['display'] = $display;

		// Get Samples
		$inventory = $this->getSamples();

		// Make sure that the inventory item was found.
		if (isset($inventory[$inventory_id])) {
			$template['sample'] = $inventory[$inventory_id];

			$slideshow = array();

			// Populate Slideshow
			if (isset($inventory[$inventory_id]->product_image_url_1) && strlen($inventory[$inventory_id]->product_image_url_1) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_1;
			if (isset($inventory[$inventory_id]->product_image_url_2) && strlen($inventory[$inventory_id]->product_image_url_2) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_2;
			if (isset($inventory[$inventory_id]->product_image_url_3) && strlen($inventory[$inventory_id]->product_image_url_3) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_3;
			if (isset($inventory[$inventory_id]->product_image_url_4) && strlen($inventory[$inventory_id]->product_image_url_4) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_4;
			if (isset($inventory[$inventory_id]->product_image_url_5) && strlen($inventory[$inventory_id]->product_image_url_5) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_5;
			if (isset($inventory[$inventory_id]->product_image_url_6) && strlen($inventory[$inventory_id]->product_image_url_6) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_6;
			
			$template['slideshow'] = $slideshow;
		} else {
			$template['error'] = true;
		}
		
		return view('samples.sample-details-modal', ['data' => $template]);
	}

	/* 
	 * Note:
	 *
	 * The following function is no longer used as we changed the sample details view to instead
	 * always display itself within a modal. Being preserved, as at the time of writing this, there has
	 * not yet been a repo created for this project.
	 * 
	 * See: sampleDetailsModal()
	 */

	/*
	// View Details for a Given Sample
	public function sampleDetails(Request $request, $inventory_id) {
		// Ensure that the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}

		// Initialize variable to store template data.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();

		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		$template['counter'] = 0;

		// Fetch the current cart contents.
		$cart = session('cart') ? session('cart') : array();
		$display = session('display') ? session('display') : array();

		// Initialize template data.
		$template['error'] = false;
		$template['inventory_id'] = $inventory_id;

		// Make sure that the inventory item was found.
		if (isset($inventory[$inventory_id])) {
			$template['sample'] = $inventory[$inventory_id];

			$slideshow = array();

			// Populate Slideshow
			if (isset($inventory[$inventory_id]->product_image_url_1) && strlen($inventory[$inventory_id]->product_image_url_1) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_1;
			if (isset($inventory[$inventory_id]->product_image_url_2) && strlen($inventory[$inventory_id]->product_image_url_2) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_2;
			if (isset($inventory[$inventory_id]->product_image_url_3) && strlen($inventory[$inventory_id]->product_image_url_3) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_3;
			if (isset($inventory[$inventory_id]->product_image_url_4) && strlen($inventory[$inventory_id]->product_image_url_4) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_4;
			if (isset($inventory[$inventory_id]->product_image_url_5) && strlen($inventory[$inventory_id]->product_image_url_5) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_5;
			if (isset($inventory[$inventory_id]->product_image_url_6) && strlen($inventory[$inventory_id]->product_image_url_6) > 0)
				$slideshow[] = $inventory[$inventory_id]->product_image_url_6;
			
			$template['slideshow'] = $slideshow;
		} else {
			$template['error'] = true;
		}
		
		return view('samples.sample-details', ['data' => $template]);
	}
	*/

	// Reset the user's session.
	public function resetSession(Request $request) {
		session(['successful_order' => false]);
		session(['cart' => false]);
		session(['display' => false]);

		$order_id = session('order_id');

		// When performing an update, reset the entire session back to the intial state.
		if ($order_id > 0) {
			session(['order_id' => null]);
			session(['address_1' => false]);
			session(['address_2' => false]);
			session(['city' => false]);
			session(['state' => false]);
			session(['zip' => false]);
			session(['reason' => false]);
			session(['notes' => false]);
			session(['by' => false]);
			session(['status' => false]);
	
			session(['company_name' => false]);
			session(['attn' => false]);
			session(['email' => false]);
			session(['phone' => false]);

			session(['notes' => null]);

			return redirect()->route("sample-orders");
		} else {
			return redirect()->route("sample-cart");
		}
	}

	// Selecting a pre-existing address.
	public function addressSelectExisting(Request $request, $order_id) {
		// Parameters to fetch order data.
		$data = array();
		$data['Function'] = "orderDetail";
		$data['orderID'] = $order_id;
		$data['userID'] = session('user_id');
		//$data['userID'] = "ALL"; // @todo: Remove for production.

		// Make the request for order data.
		$obj = $this->makeRequest($data);

		if (isset($obj->orderDetailResults[0])) {
			$data = $obj->orderDetailResults[0];

			// Localize request data.
			$address_1 = $data->ship_to_address_1;
			$address_2 = $data->ship_to_address_2;
			$city = $data->ship_to_city;
			$state = $data->ship_to_state;
			$zip = $data->ship_to_zipcode;
			$type = (strtoupper($data->ship_to_loc_type) == "RESIDENCE" || strtoupper($data->ship_to_loc_type) == "RESIDENTIAL") ? "Residential" : "Business";
			$company_name = $data->ship_to_company;
			$attn = $data->ship_to_attention;
			$email = $data->ship_to_email;
			$phone = $data->phone_number;
			$status = "Existing";
			$by = $request->by;
			$reason = $request->reason;

			// Write to the session.
			session(['address_1' => $address_1]);
			session(['address_2' => $address_2]);
			session(['city' => $city]);
			session(['state' => $state]);
			session(['zip' => $zip]);
			session(['type' => $type]);
			session(['company_name' => $company_name]);
			session(['attn' => $attn]);
			session(['email' => $email]);
			session(['phone' => $phone]);
			session(['status' => $status]);
			session(['by' => $by]);
			session(['reason' => $reason]);
		} else {
			return response(0);
		}

		return response(1);
	}

	// Writes new address data to the session.
	public function addressUpdate(Request $request) {
		// Localize request data.
		$address_1 = $request->address_1;
		$address_2 = ($request->address_2 == null) ? "" : $request->address_2;
		$city = $request->city;
		$state = $request->state;
		$zip = $request->zip;
		$type = $request->type;
		$reason = $request->reason;
		$company_name = $request->company_name;
		$attn = $request->attn;
		$email = $request->email;
		$phone = $request->phone;
		$by = $request->by;
		$status = $request->status;
		$crm_company_id = $request->crm_company_id;

		// Write to the session.
		session(['address_1' => $address_1]);
		session(['address_2' => $address_2]);
		session(['city' => $city]);
		session(['state' => $state]);
		session(['zip' => $zip]);
		session(['type' => $type]);
		session(['reason' => $reason]);
		session(['company_name' => $company_name]);
		session(['attn' => $attn]);
		session(['email' => $email]);
		session(['phone' => $phone]);
		session(['by' => $by]);
		session(['status' => $status]);
		session(['crm_company_id' => $crm_company_id]);

		return response(1);
	}

	public function address(Request $request) {
		// Ensure that the user is logged in.
		if (!session('authenticated')) {
			session(['intended' => '/address']);
			return redirect()->route('sample-login');
		}

		// Track the page state.
		$template = array();
		$template['posted'] = false;
		$template['error'] = false;
		$template['warning'] = false;

		// Get Samples
		$inventory = $this->getSamples();
		
		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		/*
		 * Next, fetch a list of previously submitted orders from this
		 * account. We can use this data to make it easier for the
		 * user to select an address they have already used.
		 */

		// Get the User's ID.
		$user_id = session('user_id');
		//$user_id = "ALL"; // @todo: Remove in production.

		// Build the request array.
		$data = array();
		$data['Function'] = "orderHeader";
		$data['userID'] = $user_id;
		$data['recordLimit'] = 250;

		// Make the request for order data.
		$obj = $this->makeRequest($data);

		// Initialize array of orders.
		$orders = array();
		$duplicates = array();

		// Check that results were found.
		if (isset($obj->orderHeaderResults)) {
			// Loop through the results.
			foreach ($obj->orderHeaderResults as $order) {
				$unique_string = $order->ship_to_company . ","
					. $order->ship_to_attention . ","
					. $order->ship_to_address_1 . ","
					. $order->ship_to_address_2 . ","
					. $order->ship_to_city . ","
					. $order->ship_to_state . ","
					. $order->ship_to_zipcode;
				
				// Make sure the address is unique.
				if (!isset($duplicates[$unique_string])) {
					$orders[$order->id] = $order;
				}
				
				// Ensure the record appears within the duplicates array.
				$duplicates[$unique_string] = $order;
			}
		}

		$template['orders'] = $orders;

		/*
		 * Next, we must check if a new address has been submitted.
		 * We will first validate the form. If successful, we proceed
		 * to building out an array containing all of the validated
		 * data and provide it to the template.
		 * 
		 * Then we will send that address to the API for further geo-
		 * validation. Using the response, we generate options for the
		 * user to choose from.
		 * 
		 * For example, if a user submits the form with Michigan Street
		 * as the address, they might see two options come back: (1) one
		 * containing an address that best matches their perceived intention,
		 * (MICHIGAN AVE), and (2) an option that allows them to proceed
		 * with exactly what they entered.
		 */

		// Initialize array to store valid options.
		$options = array();

		// Check if an address submission has been made.
		if ($request->method() == "POST") {
			// Basic form validation rules.
			$validatedData = $request->validate([
				'address_1' => 'required',
				'city' => 'required',
				'state' => 'required',
				'zip' => 'required|numeric',
				'type' => 'required',
				'reason' => 'required',
				'company_name' => 'required',
				'attn' => 'required',
				'email' => 'required|email',
				'phone' => 'required',
				'by' => 'nullable|date',
				'crm_company_id' => 'nullable'
			]);

			// Localize request data.
			$address_1 = $request->address_1;
			$address_2 = $request->address_2;
			$city = $request->city;
			$state = $request->state;
			$zip = $request->zip;
			$type = $request->type;
			$reason = $request->reason;
			$company_name = $request->company_name;
			$attn = $request->attn;
			$email = $request->email;
			$phone = $request->phone;
			$by = $request->by;
			$crm_company_id = $request->crm_company_id;

			// Add to the template.
			$template['address_1'] = $address_1;
			$template['address_2'] = $address_2;
			$template['city'] = $city;
			$template['state'] = $state;
			$template['zip'] = $zip;
			$template['type'] = $type;
			$template['reason'] = $reason;
			$template['company_name'] = $company_name;
			$template['attn'] = $attn;
			$template['email'] = $email;
			$template['phone'] = $phone;
			$template['by'] = $by;
			$template['crm_company_id'] = $crm_company_id;

			// Build the request array.
			$data = array();
			$data['Function'] = "validateAddress";
			$data['address1'] = $address_1;
			$data['address2'] = $address_2;
			$data['city'] = $city;
			$data['state'] = $state;
			$data['zip'] = $zip;
			$data['type'] = $type;

			// Make the request for order data.
			$obj = $this->makeRequest($data);

			// Default to failure until successful.
			$error = false;

			// Check for a valid response.
			if (isset($obj->validateAddressResults)) {
				// Address was posted successfully.
				$template['posted'] = true;

				// Check the status code of the response.
				if ($obj->validateAddressResults[0]->status == "error") {
					$error = true;
					$template['error'] = true;
				} else if ($obj->validateAddressResults[0]->status == "warning") {
					$error = true;
					$template['warning'] = true;
				}

				// Add the option for the user to strictly force the address they provided.
				$temp = array();
				$temp['address_1'] = $address_1;
				$temp['address_2'] = $address_2;
				$temp['city'] = $city;
				$temp['state'] = $state;
				$temp['zip'] = $zip;
				$temp['type'] = $type;
				$temp['reason'] = $reason;
				$temp['company_name'] = $company_name;
				$temp['attn'] = $attn;
				$temp['email'] = $email;
				$temp['phone'] = $phone;
				$temp['status'] = "manual";
				$temp['by'] = $by;
				$temp['crm_company_id'] = $crm_company_id;

				$options[] = $temp;

				// If the address was matched, find the matches and add them to the list of options.
				if (!$error) {
					foreach ($obj->validateAddressResults as $result) {
						// Add this option to the result set.
						$temp = array();
						$temp['address_1'] = $result->address1;
						$temp['address_2'] = $result->address2;
						$temp['city'] = $result->city;
						$temp['state'] = $state;
						$temp['zip'] = $result->zip;
						$temp['type'] = ($result->type == "") ? $type : $result->type;
						$temp['reason'] = $reason;
						$temp['company_name'] = $company_name;
						$temp['attn'] = $attn;
						$temp['email'] = $email;
						$temp['phone'] = $phone;
						$temp['status'] = "auto";
						$temp['by'] = $by;
						$temp['crm_company_id'] = $crm_company_id;
						
						$options[] = $temp;
					}
				}
			} else {
				$template['error_msg'] = "Invalid data submitted.";
				$template['error'] = true;
			}
		} else { // IF POST DATA WAS NOT FOUND

			if (session('status')) {
				// Assign to the template.
				$template['address_1'] = session('address_1');
				$template['address_2'] = session('address_2');
				$template['city'] = session('city');
				$template['state'] = session('state');
				$template['zip'] = session('zip');
				$template['type'] = session('type');
				$template['company_name'] = session('company_name');
				$template['attn'] = session('attn');
				$template['email'] = session('email');
				$template['phone'] = session('phone');
				$template['status'] = session('status');
				$template['by'] = session('by');
				$template['reason'] = session('reason');
				$template['crm_company_id'] = session('crm_company_id');

			} else if (session('addressParams')) { // Check for preset address data.

				$template['address_1'] = session('defaultAddress1');
				$template['address_2'] = session('defaultAddress2');
				$template['city'] = session('defaultCity');
				$template['state'] = session('defaultState');
				$template['zip'] = session('defaultZip');
				$template['type'] = session('defaultType');
				$template['company_name'] = session('defaultCompany');
				$template['attn'] = session('defaultAttn');
				$template['email'] = session('defaultEmail');
				$template['phone'] = session('defaultPhone');
				$template['status'] = session('defaultStatus');
				$template['by'] = session('defaultBy');
				$template['reason'] = session('defaultReason');
				$template['crm_company_id'] = session('crmCompanyId');

				session(['addressParams' => false]);
				session(['defaultCompany' => false]);
				session(['defaultAttn' => false]);
				session(['defaultEmail' => false]);
				session(['defaultPhone' => false]);
				session(['defaultAddress1' => false]);
				session(['defaultAddress2' => false]);
				session(['defaultCity' => false]);
				session(['defaultState' => false]);
				session(['defaultZip' => false]);
				session(['defaultType' => false]);
				session(['defaultReason' => false]);
				session(['defaultBy' => false]);
				session(['crmCompanyId' => false]);

			}
		}

		// Pass all address options to the template.
		$template['options'] = $options;

		/*
		 * Lastly, we need to look at the session data to determine
		 * what the currently selected address is. We can use the
		 * session data to build out an array of relevant fields
		 * and provide it to the template.
		 */

		// Assign current address.
		if (session('address_1')) {
			$temp = array();
			$temp['address_1'] = session('address_1');
			$temp['address_2'] = session('address_2');
			$temp['city'] = session('city');
			$temp['state'] = session('state');
			$temp['zip'] = session('zip');
			$temp['type'] = session('type');
			$temp['reason'] = session('reason');
			$temp['company_name'] = session('company_name');
			$temp['attn'] = session('attn');
			$temp['email'] = session('email');
			$temp['phone'] = session('phone');
			$temp['by'] = session('by');
			$temp['crm_company_id'] = session('crm_company_id');
			
			$template['current_address'] = $temp;
		} else {
			$template['current_address'] = false;
		}

		return view('samples.address', ['data' => $template]);
	}

	// Initialize Address Using `$_GET` Params
	public function addressParams(Request $request) {
		// Localize query data.
		$company = $request->company;
		$attn = $request->attn;
		$email = $request->email;
		$phone = $request->phone;
		$address_1 = $request->address_1;
		$address_2 = $request->address_2;
		$city = $request->city;
		$state = $request->state;
		$zip = $request->zip;
		$type = $request->type;
		$reason = $request->reason;
		$by = $request->by;
		$crm_company_id = $request->crm_company_id;

		session(['addressParams' => true]);
		session(['defaultCompany' => $company]);
		session(['defaultAttn' => $attn]);
		session(['defaultEmail' => $email]);
		session(['defaultPhone' => $phone]);
		session(['defaultAddress1' => $address_1]);
		session(['defaultAddress2' => $address_2]);
		session(['defaultCity' => $city]);
		session(['defaultState' => $state]);
		session(['defaultZip' => $zip]);
		session(['defaultType' => $type]);
		session(['defaultReason' => $reason]);
		session(['defaultBy' => $by]);
		session(['crmCompanyId' => $crm_company_id]);

		return redirect()->route("sample-address");
	}

	// Get data needed for the sidebar.
	public function GetSidebarData(& $template, $inventory = false) {
		// Make sure inventory items are populated.
		if (!$inventory)
			$inventory = $this->getSamples();
		
		// Fetch the current cart contents.
		$cart = session('cart') ? session('cart') : array();
		$display = session('display') ? session('display') : array();

		// Initialize arrays that will store a subset of the inventory containing either display units or sample units.
		$samp = array();
		$disp = array();

		// Initialize array that will store a subset of the inventory containing shopping cart items.
		$shopping_cart = array();

		// Used in the upcoming loop to sum up all quantities.
		$order_qty = 0;

		// Loop through the inventory items.
		foreach ($inventory as $key => $inv) {
			// If this item has been added as a sample, add to the array.
			if (isset($cart[$inv->id]) && $cart[$inv->id] > 0) {
				$samp[$key] = $inv;
				$order_qty += $cart[$inv->id];
			}

			// If this item has been added as a display unit, add to the array.
			if (isset($display[$inv->id]) && $display[$inv->id] > 0) {
				$disp[$key] = $inv;
				$order_qty += $display[$inv->id];
			}

			// If this item has been added as either a sample or a display unit, add to the array.
			if ((isset($display[$inv->id]) && $display[$inv->id] > 0) || (isset($cart[$inv->id]) && $cart[$inv->id] > 0)) {
				$shopping_cart[$key] = $inv;
			}
		}

		// All inventory items.
		$template['all_inventory'] = $inventory;

		// Only the items that should appear in the sidebar.
		$template['shopping_cart'] = $shopping_cart;

		// Only the items that have sample or display unit quantities.
		$template['inventory'] = $samp; // Deprecated... @todo
		$template['sample_inventory'] = $samp;
		$template['display_inventory'] = $disp;

		// Quantities in the shopping cart for samples and display units.
		$template['cart'] = $cart;
		$template['display'] = $display;
		$template['order_qty'] = $order_qty;

		// Assign current address.
		if (session('address_1')) {
			$temp = array();
			$temp['address_1'] = session('address_1');
			$temp['address_2'] = session('address_2');
			$temp['city'] = session('city');
			$temp['state'] = session('state');
			$temp['zip'] = session('zip');
			$temp['type'] = session('type');
			$temp['reason'] = session('reason');
			$temp['company_name'] = session('company_name');
			$temp['attn'] = session('attn');
			$temp['email'] = session('email');
			$temp['phone'] = session('phone');
			$temp['by'] = session('by');

			$template['current_address'] = $temp;
		} else {
			$template['current_address'] = false;
		}

		// Reason for sample request.
		if (session('reason')) {
			$template['reason'] = session('reason');
		} else {
			$template['reason'] = false;
		}

		// Receive by date.
		if (session('by')) {
			$template['by'] = session('by');
		} else {
			$template['by'] = false;
		}

	}

	// My Orders
	public function orders(Request $request) {
		// Ensure that the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}
		
		// Initialize template.
		$template = array();

		// Get Samples
		$inventory = $this->getSamples();
		
		// Generate sidebar data.
		$this->GetSidebarData($template, $inventory);

		// Get the User's ID.
		$user_id = session('user_id');
		//$user_id = "ALL"; // @todo: Remove in production.

		// Check if we are returning to this page from a successful checkout.
		if (session('successful_order')) {
			$template['successful_order'] = 1;
			session(['successful_order' => false]);
		} else {
			$template['successful_order'] = 0;
		}

		// Build the request array.
		$data = array();
		$data['Function'] = "orderHeader";
		$data['userID'] = $user_id;
		$data['recordLimit'] = 250;

		// Make the request for order data.
		$obj = $this->makeRequest($data);

		// Initialize array of orders.
		$orders = array();

		// Different categories an order can belong to.
		$pending = array();
		$packing = array();
		$shipping = array();

		// Check that results were found.
		if (isset($obj->orderHeaderResults)) {
			// Loop through the results.
			foreach ($obj->orderHeaderResults as $order) {
				$orders[$order->id] = $order;

				// Check the status to determine whether the order is pending, being packed, or already shipped.
				if ($order->status == 1) {
					$pending[$order->id] = $order;
				} else if ($order->status == 2) {
					$packing[$order->id] = $order;
				} else if ($order->status == 3) {
					$shipping[$order->id] = $order;
				}
			}
		}

		// Data to be sent to the template.
		$template['orders'] = $orders;
		$template['pending'] = $pending;
		$template['packing'] = $packing;
		$template['shipping'] = $shipping;
		$template['counter'] = 0;

		return view('samples.orders', ['data' => $template]);
	}

	// Sign Out (Logout)
	public function logout(Request $request) {
		// Remove session values.
		session(['authenticated' => false]);
		session(['intended' => false]);
		session(['user_id' => 0]);
		session(['successful_order' => false]);
		session(['order_id' => null]);
		session(['address_1' => false]);
		session(['address_2' => false]);
		session(['city' => false]);
		session(['state' => false]);
		session(['zip' => false]);
		session(['reason' => false]);
		session(['notes' => false]);
		session(['by' => false]);
		session(['status' => false]);
		session(['search' => false]);

		session(['company_name' => false]);
		session(['attn' => false]);
		session(['email' => false]);
		session(['phone' => false]);

		session(['cart' => false]);
		session(['display' => false]);
		session(['notes' => null]);

		// Re-direct back to the main view.
		return redirect()->route('sample-login');
	}

	// Sign In (OAuth)
	public function oauth(Request $request) {
        $appid = config('services.microsoft_online.client_id');
        $tenantId = config('services.microsoft_online.tenant_id');
        $secret   = config('services.microsoft_online.client_secret');

		// OAuth URL
		$login_url = "https://login.microsoftonline.com/" . $tenantId . "/oauth2/v2.0/authorize";

		// Laravel's method to obtain Session ID.
		$session_id = session()->getId();
		session(['state' => $session_id]); // $_SESSION['state'] = session_id();

		// Check if a login attempt is being made.
		if ($request->action == 'login'){
				$params = array (       
					'client_id' => $appid,
					'redirect_uri' => 'https://samples.vanee.com/login/oauth',
					'response_type' => 'token',
					'response_mode' => 'form_post',
					'scope' => 'https://graph.microsoft.com/User.Read',
					'state' => $session_id
				);
				
				header ('Location: '. $login_url . '?' . http_build_query($params));
				exit;
		}

		// Check if an access token was found, indicating that a login attempt was made.
		if ($request->access_token) { // if (array_key_exists('access_token', $_POST))
			session(['t' => $request->access_token]); // $_SESSION['t'] = $_POST['access_token'];

			// Begin cURL
			$ch = curl_init();

			// Configure cURL Request
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $request->access_token, 'Content-type: application/json'));
			curl_setopt($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me/");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// Perform the cURL Request / Decode the Response
			$rez = json_decode(curl_exec($ch), 1);

			curl_close($ch);

			if (array_key_exists('error', $rez)){
				header ('Location: https://samples.vanee.com');
				exit;
			} else  {
				$name = $rez['userPrincipalName'];

				// Store the request data.
				$data = array();
				$data['Function'] = "loginOAuth";
				$data['username'] = $name;
		
				// Make the login request.
				$obj = $this->makeRequest($data);

				// API Validation
                // alex commetnted out next line to fix nested ternary deprecation in php 7.4
				// $template['error'] = (isset($obj->result) && $obj->result == "error") ? true : (isset($obj->loginOAuthResults) && $obj->loginOAuthResults[0]->result == "error") ? true : false;

                // alex added below
                $hasResultError = isset($obj->result) && $obj->result === 'error';

                $hasOAuthError =
                    isset($obj->loginOAuthResults) &&
                    is_array($obj->loginOAuthResults) &&
                    isset($obj->loginOAuthResults[0]) &&
                    is_object($obj->loginOAuthResults[0]) &&
                    isset($obj->loginOAuthResults[0]->result) &&
                    $obj->loginOAuthResults[0]->result === 'error';

                $template['error'] = $hasResultError || $hasOAuthError;
                // alex added above

				// Check if there is not an error message.
				if (!$template['error']) {
					// Get and store the logged in User's ID.
					$user_id = $obj->loginOAuthResults[0]->userID;

					session(['authenticated' => true]);
					session(['user_id' => $user_id]);
					session(['order_id' => null]);
					session(['notes' => null]);

					return redirect()->route('sample-orders');
				} else {
					header ('Location: https://samples.vanee.com');
					exit;
				}
			}

			header ('Location: https://www.vaneefoods.com/login/');
		}
	}

	// Sign In (Login)
	public function login(Request $request) {
		// This array will store the data to be sent to the template.
		$template = array();
		$template['error'] = false;

		// Check if the user is attempting to login.
		if ($request->method() == "POST") {
			// Basic form validation rules.
			$validatedData = $request->validate([
				'username' => 'required',
				'password' => 'required'
			]);

			// Store the request data.
			$data = array();
			$data['Function'] = "login";
			$data['username'] = $request->username;
			$data['password'] = $request->password;
	
			// Make the login request.
			$obj = $this->makeRequest($data);

			// API Validation
            // alex commented out next two lines to fix nested ternary deprecation for php7.4
			// $template['error'] = (isset($obj->result) && $obj->result == "error") ? true : (isset($obj->loginResults) && $obj->loginResults[0]->result == "error") ? true : false;
			// $template['error_message'] = (isset($obj->result) && $obj->result == "error") ? $obj->errorMessage : (isset($obj->loginResults) && $obj->loginResults[0]->result == "error") ? "Invalid login credentials." : "";

            // alex added below 
            $hasResultError = isset($obj->result) && $obj->result === 'error';

            $hasLoginError =
                isset($obj->loginResults) &&
                is_array($obj->loginResults) &&
                isset($obj->loginResults[0]) &&
                is_object($obj->loginResults[0]) &&
                isset($obj->loginResults[0]->result) &&
                $obj->loginResults[0]->result === 'error';

            $template['error'] = $hasResultError || $hasLoginError;

            if ($hasResultError && isset($obj->errorMessage) && is_string($obj->errorMessage)) {
                $template['error_message'] = $obj->errorMessage;
            } elseif ($hasLoginError) {
                $template['error_message'] = 'Invalid login credentials.';
            } else {
                $template['error_message'] = '';
            }
            // alex added above 


			// Check if there is not an error message.
			if (!$template['error']) {
				// Get and store the logged in User's ID.
				$user_id = $obj->loginResults[0]->userID;

				session(['authenticated' => true]);
				session(['user_id' => $user_id]);
				session(['order_id' => null]);
				session(['notes' => null]);

				$intended = session('intended');

				if ($intended) {
					return redirect($intended);
				} else {
					return redirect()->route('sample-orders');
				}
			} else {
				// Pass the data back to the template so the user doesn't need to re-type the information.
				$template['username'] = $request->username;
			}
		}

		return view('samples.login', ['data' => $template]);
	}

	// Populate Inventory Items
	public function getSamples() {
		// Build the request array.
		$data = array();
		$data['Function'] = "availableItems";

		$obj = $this->makeRequest($data);

		$inventory = array();

		// Populate inventory items.
		foreach ($obj->availableItemsResults as $item) {
			$inventory[$item->id] = $item;
		}

		return $inventory;
	}

	// Make a `$_GET` Request
	public function makeRequest($data) {
		// Create the URL for the request.
		$query = $this->api . "?" . http_build_query($data);

		// Fetch and return the response.
		return json_decode(file_get_contents($query));
	}
}
