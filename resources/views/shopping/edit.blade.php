@extends('layouts.app')

@section('title', 'Editar compra')

@section('content')
    <form id="formShoppingUpdate" method="POST" action="{{ route('shopping.update', $shopping->id) }}">
        <div class="container-fluid py-4 mt-4">


            @csrf
            @method('put')

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


            @include('sale.components.footer')

        </div>
    </form>
    @include('sale.modals.customers')
    @include('sale.modals.products')

    <script>
        window.shoppingData = @json($shopping);
    </script>
@endsection

@section('script')
    <script src="{{ asset('js/shoppingEdit.js') }}"></script>

@endsection
