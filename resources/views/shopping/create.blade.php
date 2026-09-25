@extends('layouts.app')

@section('content')
    <form id="formShopping">
        <div class="container-fluid py-4 mt-4">

            @csrf

            <div class="row">

                <div class="col-lg-8">
                    @include('shopping.components.header')

                    @include('shopping.components.supplier')

                    @include('shopping.components.products')

                    @include('shopping.components.payment')

                </div>

                <div class="col-lg-4">

                    @include('shopping.components.summary')

                </div>

            </div>


            @include('shopping.components.footer')

        </div>
    </form>
    @include('shopping.modals.suppliers')
    @include('shopping.modals.products')
@endsection

@section('script')
    <script src="{{ asset('js/supplierShopping.js') }}"></script>
    <script src="{{ asset('js/shopping.js') }}"></script>
    <script src="{{asset('js/proceShopping.js')}}"></script>
@endsection
