<?php
namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
use Validator;

use Illuminate\Support\Facades\Http;

class SampleController extends Controller
{
	public $api = 'http://internal.vaneefoods.com/SampleAPI.php';

	public function inventory(Request $request) {
		/*
		// Ensure that the user is logged in.
		if (!session('authenticated')) {
			return redirect()->route('sample-login');
		}
		*/
		// How to set a session value.
		//session(['authenticated' => true]);

		// Build the request array.
		$data = array();
		$data['Function'] = "availableItems";

		$obj = $this->makeRequest($data);

		$inventory = array();

		foreach ($obj->availableItemsResults as $item) {
			$inventory[$item->id] = $item;
		}

		//print_r($inventory);

		$template = array();
		$template['inventory'] = $inventory;

		return view('samples.inventory', ['data' => $template]);
	}

	public function login(Request $request) {
		// Check if the user is attempting to login.
		if (isset($request->username)) {
			$creds = array();
			$creds['username'] = $request->username;
			$creds['password'] = $request->password;

			// Build the request array.
			$data = array();
			$data['Function'] = "login";
			$data['auth'] = json_encode($creds);

	                // Create the URL for the request.
	                $query = $this->api . "?" . http_build_query($data);

			// Query for the order.
			$obj = json_decode(file_get_contents($query));

			print_r($obj);
			exit;
		}

		$template = array();
		$template['test'] = "login page";

		return view('samples.login', ['data' => $template]);
	}

	public function makeRequest($data) {
		// Create the URL for the request.
		$query = $this->api . "?" . http_build_query($data);

		// Fetch and return the response.
		return json_decode(file_get_contents($query));
	}
}
