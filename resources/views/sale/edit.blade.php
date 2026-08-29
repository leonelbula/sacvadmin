@extends('layouts.app')

@section('title', 'Factura Electrónica')

@section('content')
    <form id="formSale" method="POST" action="{{route('sale.update', $sale)}}">
        <div class="container-fluid py-4 mt-4">
            

            @csrf
            @method('put')

            <div class="row">

                <div class="col-lg-8">
                    @include('sale.components.header')

                    @include('sale.components.customer')

                    @include('sale.components.productsEdit')
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

    <script>
        window.saleData = @json($sale);
    </script>
@endsection

@section('script')    
    <script src="{{ asset('js/saleEdit.js') }}"></script>

@endsection
