@extends('layouts.app')

@section('title', $title)

@section('content')



    <div class="container-fluid py-4   mt-4">

        <div class="card shadow border-0 rounded-4">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    <i class="bi bi-tags-fill me-2"></i>
                    Gestión de Categorías
                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <!--=====================
                                                                                FORMULARIO
                                                                            ======================-->

                    <div class="col-lg-4 mb-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <h5 class="mb-4">
                                    Nueva Categoría
                                </h5>

                                <form method="POST"
                                    action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }} ">
                                    @csrf

                                    @isset($category)
                                        @method('PUT')
                                    @endisset



                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">
                                            Nombre
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                <i class="bi bi-tag"></i>
                                            </span>

                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $category->name ?? '') ? $category->name : '' }}"
                                                placeholder="Nombre de la categoría">

                                        </div>

                                    </div>

                                    <div class="mb-4">

                                        <label class="form-label fw-semibold d-block">
                                            Estado
                                        </label>

                                        <div class="form-check form-switch">
                                            <input type="hidden" name="state" value="0">

                                            <input class="form-check-input" type="checkbox" value="1" name="state"
                                                {{ old('state', $category->state ?? false) ? 'checked' : '' }}>

                                            <label class="form-check-label">
                                                Activa
                                            </label>

                                        </div>

                                    </div>

                                    <div class="d-grid gap-2">

                                        <button class="btn btn-primary">

                                            <i class="bi bi-check-circle"></i>

                                            Guardar

                                        </button>

                                        <button type="reset" class="btn btn-outline-secondary">

                                            Cancelar

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    <!--=====================
                                                                                TABLA
                                                                            ======================-->

                    <div class="col-lg-8">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">
                                <div class="row">
                                    <div col-lg-8>

                                    </div>
                                    <div class="col-lg-4">

                                    </div>
                                </div>

                                <form class="row g-3 align-items-end mb-4" action="{{ route('category.index') }}"
                                    method="GET">
                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Buscar categoría
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                <i class="bi bi-search"></i>
                                            </span>

                                            <input type="text" class="form-control" name="search"
                                                placeholder="Nombre de la categoría">

                                        </div>

                                    </div>

                                    <div class="col-auto">

                                        <button type="submit" class="btn btn-primary">

                                            <i class="bi bi-search"></i>

                                            Buscar

                                        </button>

                                    </div>

                                    <div class="col-auto">
                                        <a href="{{route('category.index')}}" class="btn btn-outline-secondary">

                                            <i class="bi bi-arrow-clockwise"></i>

                                            Mostrar Todos

                                        </a>



                                    </div>

                                </form>

                                <div class="table-responsive">

                                    <table class="table table-hover align-middle">

                                        <thead class="table-light">

                                            <tr>

                                                <th>#</th>

                                                <th>Nombre</th>

                                                <th>Estado</th>

                                                <th width="120">Acciones</th>

                                            </tr>

                                        </thead>

                                        <tbody>
                                            @foreach ($categories as $category)
                                                <tr>

                                                    <td>{{ $category->id }}</td>

                                                    <td>{{ $category->name }}</td>

                                                    <td>
                                                        @if ($category->state)
                                                            <span class="btn btn-sm bg-success">
                                                                Activa
                                                            </span>
                                                        @else
                                                            <span class="btn btn-sm bg-secondary">
                                                                Inactiva
                                                            </span>
                                                        @endif



                                                    </td>

                                                    <td>
                                                        <a href="{{ route('category.index', $category) }}">

                                                            <button class="btn btn-sm btn-warning">

                                                                <i class="bi bi-pencil"></i>

                                                            </button>
                                                        </a>
                                                        <form action="{{ route('category.destroy', $category) }}"
                                                            method="post" style="display: inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger">

                                                                <i class="bi bi-trash"></i>

                                                            </button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            @endforeach


                                        </tbody>

                                    </table>

                                </div>

                                <nav class="mt-3">

                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $categories->links() }}
                                    </div>
                                </nav>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>





@endsection
