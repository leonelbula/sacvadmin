@extends('layouts.app')

@section('title', 'Factura Electrónica')

@section('content')

    <div class="container-fluid py-4 mt-4">

        @include('sale.components.header')

        @include('sale.components.customer')

        @include('sale.components.products')

        <div class="row">

            <div class="col-lg-8">

                @include('sale.components.payment')

            </div>

            <div class="col-lg-4">

                @include('sale.components.summary')

            </div>

        </div>

        @include('sale.components.footer')

    </div>

    @include('sale.modals.customers')
    @include('sale.modals.products')

@endsection

@section('script')
    <script src="{{ asset('js/saleCustomer.js') }}"></script>
    <script src="{{ asset('js/saleProduct.js') }}"></script>

@endsection
