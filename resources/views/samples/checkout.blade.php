@extends('layouts.samples')

@section('content')

<div class="container-fluid">
	<div class="row">
        <div class="col">

            @if ($data['current_address'])
                <h4 style="margin-bottom: 1rem;">Shipping Address</h4>

                
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

                        @if ($data['current_address']['crm_company_id'])
                            CRM Company ID:
                            <p>{{ $data['current_address']['crm_company_id'] }}</p>
                        @endif
                    </div>
                </div>
            @endif


            @if (session('cart'))
                <h4 style="margin-bottom: 1rem;">Shopping Cart</h4>

                <table class="table table-bordered table-striped table-hover datatable-standard datatable-inventory">
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
                        @forelse ($data['sample_inventory'] as $item)
                            <tr role="row" data-inventory-id="{{ $item->id }}" class="inventory-row">
                                <td>{{ $data['counter'] ++ }}</td>
                                <td class="show-slideshow" id="inventory-id-{{ $item->id }}" data-inventory-id="{{ $item->id }}"><a href="#" id="anchor-id-{{ $item->id }}" data-toggle="modal" data-target="#itemModal" onClick="LoadModal({{ $item->id }});" data-href="cart/{{ $item->id }}">{{ $item->description }}</a></td>
                                <td>{{ $item->product_sales_category }}</td>
                                <td>{{ $item->stock_number }}</td>
                                <!--<td>{{ $item->package_count . " X " . $item->container_net_weight . " " . $item->container_net_weight_uom }}</td>-->
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
                                <!--<td>
                                    <a href="#" class="btn btn-primary add-to-cart sample-units" data-inventory-id="{{ $item->id }}">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </a>
                                </td>-->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No inventory items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

            @if (session('display'))
                <h4 style="margin-bottom: 1rem; margin-top: 1rem;">Display Units</h4>

                <table class="table table-bordered table-striped table-hover datatable-standard datatable-inventory-display">
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
                        @forelse ($data['display_inventory'] as $item)
                            <tr role="row" data-inventory-id="{{ $item->id }}" class="inventory-row">
                                <td>{{ $data['counter'] ++ }}</td>
                                <td class="show-slideshow" id="inventory-id-{{ $item->id }}" data-inventory-id="{{ $item->id }}"><a href="#" id="anchor-id-{{ $item->id }}" data-toggle="modal" data-target="#itemModal" onClick="LoadModal({{ $item->id }});" data-href="cart/{{ $item->id }}">{{ $item->description }}</a></td>
                                <td>{{ $item->product_sales_category }}</td>
                                <td>{{ $item->stock_number }}</td>
                                <!--<td>{{ $item->package_count . " X " . $item->container_net_weight . " " . $item->container_net_weight_uom }}</td>-->
                                <td>{{ $item->packaging_container_description }}</td>
                                <td>{{ $item->brand }}</td>
                                <td class="cart-quantity-label" data-inventory-id="{{ $item->id }}">
                                    <div class="d-flex">
                                        <select name="" style="flex: 2;" class="cart-input display-units form-control form-control-select" value="{{ isset($data['display'][$item->id]) ? $data['display'][$item->id] : 0 }}" data-inventory-id="{{ $item->id }}">
                                            <option value="0" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 0 ? "selected" : "" }}>0</option>
                                            <option value="1" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 1 ? "selected" : "" }}>1</option>
                                            <option value="2" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 2 ? "selected" : "" }}>2</option>
                                            <option value="3" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 3 ? "selected" : "" }}>3</option>
                                            <option value="4" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 4 ? "selected" : "" }}>4</option>
                                            <option value="5" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 5 ? "selected" : "" }}>5</option>
                                            <option value="6" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 6 ? "selected" : "" }}>6</option>
                                            <option value="7" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 7 ? "selected" : "" }}>7</option>
                                            <option value="8" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 8 ? "selected" : "" }}>8</option>
                                            <option value="9" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] == 9 ? "selected" : "" }}>9</option>
                                            <option value="10" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 10 ? "selected" : "" }}>10</option>

                                            <option value="11" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 11 ? "selected" : "" }}>11</option>
                                            <option value="12" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 12 ? "selected" : "" }}>12</option>
                                            <option value="13" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 13 ? "selected" : "" }}>13</option>
                                            <option value="14" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 14 ? "selected" : "" }}>14</option>
                                            <option value="15" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 15 ? "selected" : "" }}>15</option>
                                            <option value="16" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 16 ? "selected" : "" }}>16</option>
                                            <option value="17" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 17 ? "selected" : "" }}>17</option>
                                            <option value="18" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 18 ? "selected" : "" }}>18</option>
                                            <option value="19" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 19 ? "selected" : "" }}>19</option>
                                            <option value="20" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 20 ? "selected" : "" }}>20</option>

                                            <option value="21" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 21 ? "selected" : "" }}>21</option>
                                            <option value="22" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 22 ? "selected" : "" }}>22</option>
                                            <option value="23" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 23 ? "selected" : "" }}>23</option>
                                            <option value="24" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 24 ? "selected" : "" }}>24</option>
                                            <option value="25" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 25 ? "selected" : "" }}>25</option>
                                            <option value="26" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 26 ? "selected" : "" }}>26</option>
                                            <option value="27" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 27 ? "selected" : "" }}>27</option>
                                            <option value="28" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 28 ? "selected" : "" }}>28</option>
                                            <option value="29" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 29 ? "selected" : "" }}>29</option>
                                            <option value="30" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 30 ? "selected" : "" }}>30</option>

                                            <option value="31" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 31 ? "selected" : "" }}>31</option>
                                            <option value="32" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 32 ? "selected" : "" }}>32</option>
                                            <option value="33" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 33 ? "selected" : "" }}>33</option>
                                            <option value="34" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 34 ? "selected" : "" }}>34</option>
                                            <option value="35" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 35 ? "selected" : "" }}>35</option>
                                            <option value="36" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 36 ? "selected" : "" }}>36</option>
                                            <option value="37" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 37 ? "selected" : "" }}>37</option>
                                            <option value="38" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 38 ? "selected" : "" }}>38</option>
                                            <option value="39" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 39 ? "selected" : "" }}>39</option>
                                            <option value="40" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 40 ? "selected" : "" }}>40</option>

                                            <option value="41" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 41 ? "selected" : "" }}>41</option>
                                            <option value="42" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 42 ? "selected" : "" }}>42</option>
                                            <option value="43" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 43 ? "selected" : "" }}>43</option>
                                            <option value="44" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 44 ? "selected" : "" }}>44</option>
                                            <option value="45" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 45 ? "selected" : "" }}>45</option>
                                            <option value="46" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 46 ? "selected" : "" }}>46</option>
                                            <option value="47" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 47 ? "selected" : "" }}>47</option>
                                            <option value="48" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 48 ? "selected" : "" }}>48</option>
                                            <option value="49" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 49 ? "selected" : "" }}>49</option>
                                            <option value="50" {{ isset($data['display'][$item->id]) && $data['display'][$item->id] >= 50 ? "selected" : "" }}>50</option>
                                        </select>

                                        <a href="#" class="btn btn-danger trash-can sample-units ml-1" data-inventory-id="{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                                <!--<td>
                                    <a href="#" class="btn btn-primary add-to-cart display-units" data-inventory-id="{{ $item->id }}">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </a>
                                </td>-->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No display units requested.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

            <input type="hidden" id="inputReason" name="reason" value="{{ isset($data['reason']) ? $data['reason'] : old('reason') }}" />
            <input type="hidden" id="inputBy" name="by" value="{{ isset($data['by']) ? $data['by'] : old('by') }}" />

            <!--
            <div class="form-group mt-3">
                <label for="inputReason">Reason for Request</label>
                <input type="text" class="form-control" id="inputReason" name="reason" value="{{ isset($data['reason']) ? $data['reason'] : old('reason') }}" placeholder="">
            </div>
            -->

            <div class="form-group mt-3">
                <label for="inputNotes">Order Notes</label>
                <textarea class="form-control" id="inputNotes" name="notes" placeholder="">{{ isset($data['notes']) ? $data['notes'] : old('notes') }}</textarea>
            </div>

            <!--
            <div class="form-group mt-3">
                <label for="inputBy">Date Needed By</label>
                <input type="text" class="form-control" id="inputBy" name="by" value="{{ isset($data['by']) ? $data['by'] : old('by') }}" placeholder="mm/dd/yyyy" />
            </div>
            -->
            <div id="response-block" style="display: none;">
                <div id="response-block-title" style="font-weight: bold;">This is the response:</div>
                <pre id="response-block-body"></pre>
            </div>
            

            @if ($data['order_id'])
                <a href="#" id="complete-checkout" class="my-2 btn btn-primary">Update Order</a>
            @else
                <a href="#" id="complete-checkout" class="my-2 btn btn-primary">Complete Checkout</a>
            @endif

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
        let showSamples = false;
        let showDisplay = false;

        Object.keys(cart).forEach((key) => {
            if (cart[key] > 0)
                showSamples = true;
        });

        Object.keys(display).forEach((key) => {
            if (display[key] > 0)
                showDisplay = true;
        });

        // Initialize DataTable.
        if (showSamples) {
            $(".datatable-inventory").DataTable({
                "bFilter": false,
                "bPaginate": false,
                "sDom": "lfrt",
                "columnDefs" : [
                    { "visible" : false, "targets" : [0] }
                ]
            });
        }

        // Initialize DataTable.
        if (showDisplay) {
            $(".datatable-inventory-display").DataTable({
                "bFilter": false,
                "bPaginate": false,
                "sDom": "lfrt",
                "columnDefs" : [
                    { "visible" : false, "targets" : [0] }
                ]
            });
        }

        // DatePicker
        $("#inputBy").datepicker();

        // When the button to confirm checkout is clicked...
        $("#complete-checkout").click(function() {
            let notes = $("#inputNotes").val();

            

            if ($(this).hasClass("disabled")) {
                console.log("Button is disabled.");
            } else {
                $(this).addClass("disabled");
                
                
                // Send out the request to the server.
                $.post("/checkout/process", { "_token" : "{{ csrf_token() }}", "notes" : notes }, function (response) {
                    // For debugging...
                    console.log(response);

                    $("#response-block-body").html(response);
                    $("#response-block").show();

                    // Check the response from the server.
                    if (response == 1) {
                        window.location = "/";
                    } else {
                        alert("An error has occurred. Please contact an administrator.");
                        $("#complete-checkout").removeClass("disabled");
                    }
                });
                

            }

            return false;
        });

        // Highlight text on input click.
        $(".cart-input").focus(function() {
            $(this).select();
        });
        
        /*
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
        */

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
    });
</script>

@endsection
