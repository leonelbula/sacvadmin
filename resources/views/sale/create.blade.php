@extends('layouts.app')

@section('title', 'Factura Electrónica')

@section('content')
    <form id="formSale">
        <div class="container-fluid py-4 mt-4">

            @csrf

            <div class="row">

                <div class="col-lg-8">
                    @include('sale.components.header')

                    @include('sale.components.customer')

                    @include('sale.components.products')
                    @include('sale.components.payment')

                </div>

                <div class="col-lg-4">

                    @include('sale.components.summary')

                </div>

            </div>


            @include('sale.components.footer')

        </div>
    </form>
    @include('sale.modals.customers')
    @include('sale.modals.products')

@endsection

@section('script')
    <script src="{{ asset('js/saleCustomer.js') }}"></script>
    <script src="{{ asset('js/saleProduct.js') }}"></script>
    <script src="{{ asset('js/proceFactura.js') }}"></script>

@endsection
