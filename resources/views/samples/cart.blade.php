@extends('layouts.samples')

@section('content')

Shopping cart...

@foreach ($data['cart'] as $key => $item)
    {{ $data['inventory'][$key]->description }} has quantity {{ $item }} <br />
@endforeach

@endsection

@section('scripts')

@endsection
