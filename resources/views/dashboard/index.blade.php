@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="page-header">

        <div>

            <h2 class="page-title">

                Dashboard

            </h2>

            <p class="text-muted">

                Bienvenido nuevamente 👋 {{ Auth::user()->name }}

            </p>

        </div>



    </div>



    <div class="row mt-4">
        <div class="col-lg-12">
            @include('dashboard.partials.cards')
        </div>


    </div>

    <div class="row mt-4">


        @can('sale.view')
            <div class="col-lg-8">
                @include('dashboard.partials.last-sales')
            </div>
        @endcan




        <div class="col-lg-4">

            @include('dashboard.partials.stock')

        </div>

    </div>



@endsection
