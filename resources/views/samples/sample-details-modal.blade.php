@extends('layouts.samples-modal')

@section('content')

<div class="container">
	<div class="row">
        <div class="col">
            @if ($data['error'])
                <div class="alert alert-danger"><strong>Error</strong>: This inventory item could not be found.</div>
            @else

                @if (count($data['slideshow']) > 0)
                    <div id="sampleSlideshow" class="carousel slide" data-ride="carousel" style="margin-top: 1rem; margin-bottom: 1rem;">
                        <ol class="carousel-indicators">
                            @foreach ($data['slideshow'] as $key => $url)
                                @if ($key == 0)
                                    <li data-target="#sampleSlideshow" data-slide-to="{{ $key }}" class="active"></li>
                                @else
                                    <li data-target="#sampleSlideshow" data-slide-to="{{ $key }}"></li>
                                @endif
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($data['slideshow'] as $key => $url)
                                @if ($key == 0)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ $url }}" alt="Image #{{ $key + 1 }}">
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ $url }}" alt="Image #{{ $key + 1 }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#sampleSlideshow" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#sampleSlideshow" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt>Stock Number</dt>
                            <dd>{{ $data['sample']->stock_number }}</dd>

                            <dt>GTIN14</dt>
                            <dd>{{ $data['sample']->gtin14 }}</dd>

                            <dt>Brand</dt>
                            <dd>{{ $data['sample']->brand }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <dt>Category</dt>
                            <dd>{{ $data['sample']->product_sales_category }}</dd>

                            <dt>Package</dt>
                            <dd>
                                {{ $data['sample']->package_count }} x {{ $data['sample']->packaging_container_description }}
                                <!--{{ $data['sample']->container_net_weight }} {{ $data['sample']->container_net_weight_uom }} {{ $data['sample']->packaging_container_type }}-->
                            </dd>
                        </dl>
                    </div>
                </div>

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

    #sampleSlideshow {
        background-color: #6c757d;
    }

    #sampleSlideshow img {
        max-height: 400px !important;
        width: fit-content !important;
        background-size: auto !important;
        text-align: center;
        margin: auto;
        padding-bottom: 1.85rem;
        padding-top: 0.35rem;
    }

    .carousel-indicators li {
        border-bottom: 0 !important;
    }
</style>

<script>
    $(document).ready(function() {
        // Highlight text on input click.
        $(".cart-input").focus(function() {
            $(this).select();
        });
    });
</script>

@endsection
