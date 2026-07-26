<div class="row g-4">

    <!-- Código -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">
            Código
        </label>

        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-upc-scan"></i>
            </span>

            <input type="text" class="form-control" placeholder="Código del producto" value="{{ old('code',$product->code ?? '') }}"
                @if ($automatic_product != 0) disabled @endif>
        </div>
    </div>

    <!-- Nombre -->
    <div class="col-md-8">
        <label class="form-label fw-semibold">
            Nombre
        </label>

        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-box"></i>
            </span>

            <input type="text" class="form-control" name="name" id="nameProduct"
                value="{{ old('name', $product->name ?? '') }}" placeholder="Nombre del producto">
        </div>
    </div>

    <!-- Costo -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">
            Costo
        </label>

        <div class="input-group">
            <span class="input-group-text">$</span>

            <input type="number" class="form-control costo" name="cost" id="cost"
                value="{{ old('cost', $product->cost ?? '') }}" placeholder="0">
        </div>
    </div>

    <!-- Precio -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">
            Precio
        </label>

        <div class="input-group">
            <span class="input-group-text">$</span>

            <input type="number" class="form-control Precioventa" name="price"
                value="{{ old('price', $product->price ?? '') }}" id="price" placeholder="0">
        </div>
    </div>

    <!-- Utilidad -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">
            Utilidad (%)
        </label>

        <div class="input-group">
            <input type="number" name="utility" id="utility" value="{{ old('utility', $product->utility ?? '') }}"
                class="form-control Utilidad" >

            <span class="input-group-text">
                %
            </span>
        </div>
    </div>

    <!-- Categoría -->
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            Categoría
        </label>

        <select class="form-select seleccionarCategoria " name="category_id" required>
            <option selected>
                Seleccione una categoría
            </option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>

                    {{ $category->name }}

                </option>
            @endforeach
        </select>
    </div>

    <!-- Stock mínimo -->
    <div class="col-md-3">
        <label class="form-label fw-semibold">
            Stock Mínimo
        </label>

        <input type="number" class="form-control" name="stock_min" id="stock_min" required
            value="{{ old('minimum_amount', $product->stock_min ?? '1') }}">
    </div>

    <!-- Stock -->
    <div class="col-md-3">
        <label class="form-label fw-semibold">
            Stock Actual
        </label>

        <input type="number" class="form-control" name="stock" id="stock"
            value="{{ old('amount', $product->stock ?? '0') }}"
            {{ Auth::user()->type == 'ingreso' ? 'readonly' : '' }}>
    </div>

    <!-- Estado -->
    <div class="col-md-12">

        <div class="form-check form-switch fs-5">

            <input class="form-check-input" type="checkbox" checked name="state" required>

            <label class="form-check-label fw-semibold">
                Producto Activo
            </label>

        </div>

    </div>
    

</div>
