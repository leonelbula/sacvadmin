<div class="card-body">



    <!-- Información Personal -->

    <h5 class="border-bottom pb-2 mb-4">

        <i class="bi bi-person-vcard me-2"></i>

        Información Personal

    </h5>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Nombre Completo

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-person"></i>

                </span>

                <input type="text" class="form-control" placeholder="Nombre completo" name="full_name"
                    value="{{ old('full_name', $customer->full_name ?? '') }}" required>

                @error('full_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        <div class="col-lg-3 mb-4">

            <label class="form-label fw-semibold">

                Tipo de Documento

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-credit-card"></i>

                </span>

                <select class="form-select identityDocuments " name="identification_document_id" required>
                    <option selected>
                        Seleccione
                    </option>
                    @foreach ($identityDocuments as $document)
                        <option value="{{ $document->id }}" @selected(old('identification_document_id', $customer->identification_document_id ?? '') == $document->id)>

                            {{ $document->name }}

                        </option>
                    @endforeach
                </select>
                @error('identification_document_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
        <div class="col-lg-3 mb-4">

            <label class="form-label fw-semibold">

                Documento

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-credit-card"></i>

                </span>

                <input type="text" class="form-control" placeholder="Número de identificación" name="identification"
                    value="{{ old('identification', $customer->identification ?? '') }}" required>

                @error('identification')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Teléfono

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-telephone"></i>

                </span>

                <input type="text" class="form-control" placeholder="Teléfono" name="phone"
                    value="{{ old('phone', $customer->phone ?? '') }}" required>
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Correo Electrónico

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-envelope"></i>

                </span>

                <input type="email" class="form-control" name="email" placeholder="correo@empresa.com"
                    value="{{ old('email', $customer->email ?? '') }}" required>

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

    <!-- Ubicación -->

    <h5 class="border-bottom pb-2 mb-4 mt-3">

        <i class="bi bi-geo-alt me-2"></i>

        Ubicación

    </h5>

    <div class="row">

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Departamento

            </label>

            <select class="form-select departament " name="departament_id" required>
                <option selected>
                    Seleccione una Departamento
                </option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('departament_id', $customer->departament_id ?? '') == $department->id)>

                        {{ $department->name }}

                    </option>
                @endforeach
            </select>
            @error('departament_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror


        </div>

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Ciudad

            </label>

            <select class="form-select departament " name="city_id" required>
                <option selected>
                    Seleccione una Ciudad
                </option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" @selected(old('city_id', $customer->city_id ?? '') == $city->id)>

                        {{ $city->name }}

                    </option>
                @endforeach
            </select>
            @error('city_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="col-12">

            <label class="form-label fw-semibold">

                Dirección

            </label>

            <textarea rows="2" class="form-control" placeholder="Dirección completa" name="address">{{ old('address', $customer->address ?? '') }}</textarea>

        </div>
        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <!-- Información Comercial -->

    <h5 class="border-bottom pb-2 mb-4 mt-4">

        <i class="bi bi-wallet2 me-2"></i>

        Información Comercial

    </h5>


    <div class="row">

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Tipo de Responsabilidad Fiscal

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-file-earmark-text"></i>
                </span>
                <select class="form-select customer_tribute " name="customer_tribute_id" required>
                    <option selected>
                        Seleccione una opción
                    </option>
                    @foreach ($customerTributes as $tribute)
                        <option value="{{ $tribute->id }}" @selected(old('customer_tribute_id', $customer->customer_tribute_id ?? '') == $tribute->id)>

                            {{ $tribute->name }}

                        </option>
                    @endforeach
                </select>
                @error('customer_tribute_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold d-block">

                Tipo de Cliente

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-people"></i>
                </span>
                <select class="form-select customer_tribute " name="organization_type_id" required>
                    <option selected>
                        Seleccione una opción
                    </option>
                    @foreach ($organizationTypes as $organizationType)
                        <option value="{{ $organizationType->id }}" @selected(old('organization_type_id', $customer->organization_type_id ?? '') == $organizationType->id)>

                            {{ $organizationType->name }}

                        </option>
                    @endforeach
                </select>
                @error('organization_type_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

    </div>
    <div class="row">

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Cupo de Crédito

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    $

                </span>

                <input type="number" class="form-control" placeholder="0" name="credit_amount"
                    value="{{ old('credit_amount', $customer->credit_amount ?? '0') }}">

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold d-block">

                Responsable de IVA

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-file-earmark-text"></i>
                </span>
                <select class="form-select responsibilities " name="responsibilities" required>
                    <option selected>
                        Seleccione una opción
                    </option>

                    <option value="si" @selected(old('responsibilities', $customer->responsibilities ?? 'no') == 'si')>

                        Responsable de IVA

                    </option>
                    <option value="no" @selected(old('responsibilities', $customer->responsibilities ?? 'no') == 'no')>

                        No Responsable de IVA
                    </option>

                </select>
                @error('responsibilities')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

    </div>

    <div class="row">



        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold d-block">

                Estado

            </label>

            <div class="form-check form-switch fs-5">
                <input type="hidden" name="state" value="0">
                <input class="form-check-input" type="checkbox" value="1" checked name="state">

                <label class="form-check-label">

                    Cliente Activo

                </label>

            </div>

        </div>

    </div>


</div>
