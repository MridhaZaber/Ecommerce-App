@extends('vendor.layouts.master')
@section('title')
{{ $settings->site_name }}||Image Gallary

@endsection



@section('content')
    <!--=============================
                    DASHBOARD START
                  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <a href="{{ route('vendor.products.index') }}" class="btn btn-warning mb-4"><i class="fas fa-long-arrow-left"></i>Back</a>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-images"></i> Products :{{ $product->name }}</h3>
                        <div class="create_button">
                            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                                Create Product</a>
                        </div>
                        <div class="wsus__dashboard_profile">

                            <form action="{{ route('vendor.products-image-gallary.store') }}" method="POST"
                                enctype="multipart/form-data">


                                @csrf
                                <div class="form-group wsus__input">
                                    <label for="">Image <code>Multiple Image Suppoerted</code></label>
                                    <input type="file" name="image[]" class="form-control" multiple>
                                    <input type="hidden" name="product" value="{{ $product->id }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-images"></i> Products Image Gallary</h3>

                        <div class="wsus__dashboard_profile">
                            {{ $dataTable->table() }}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                    DASHBOARD START
                  ==============================-->
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
