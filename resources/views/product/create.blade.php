@extends('layouts.app')

@section('title', 'Productos')

@section('content')


    <div class="container py-4 mt-4">

        <div class="card shadow-lg border-0 rounded-4">

            <div class="card-header bg-primary text-white rounded-top-4">
                <h4 class="mb-0">
                    <i class="bi bi-box-seam me-2"></i>
                    Nuevo Producto
                </h4>
            </div>
            <form action="{{ route('product.store') }}" method="POST">
                <div class="card-body p-4">
                    @csrf


                    @include('product._form')



                </div>

                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle"></i>
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary px-4">

                            <i class="bi bi-check-circle"></i>

                            Guardar Producto

                        </button>

                    </div>

                </div>
            </form>
        </div>

    </div>



@endsection
@section('script')
    <script src="{{ asset('js/products.js') }}"></script>
@endsection
