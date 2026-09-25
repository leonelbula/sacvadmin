<div class="row g-4">

    {{-- Información principal --}}
    <div class="col-12 col-xl-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex align-items-center">

                    <div
                        class="bg-primary bg-opacity-10
                                        text-primary rounded-3 p-2 me-3">

                        <i class="bi bi-person-vcard fs-5"></i>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Información del proveedor
                        </h5>

                        <small class="text-muted">
                            Datos principales de identificación
                        </small>

                    </div>

                </div>

            </div>


            <div class="card-body p-4">

                <div class="row g-4">

                    {{-- Nombre --}}
                    <div class="col-12">

                        <label for="full_name" class="form-label fw-semibold">

                            Nombre completo / Razón social
                            <span class="text-danger">*</span>

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-person"></i>
                            </span>

                            <input type="text" name="full_name" id="full_name"
                                class="form-control @error('full_name') is-invalid @enderror"
                                value="{{ old('full_name' , $supplier->full_name ?? '') }}" placeholder="Ej. Distribuciones ABC S.A.S." required>

                        </div>

                        @error('full_name')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Identificación --}}
                    <div class="col-12 col-md-6">

                        <label for="identification" class="form-label fw-semibold">

                            Identificación
                            <span class="text-danger">*</span>

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-card-text"></i>
                            </span>

                            <input type="text" name="identification" id="identification"
                                class="form-control @error('identification') is-invalid @enderror"
                                value="{{ old('identification',$supplier->identification ?? '') }}" placeholder="NIT / C.C." required>

                        </div>

                        @error('identification_card')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Teléfono --}}
                    <div class="col-12 col-md-6">

                        <label for="phone" class="form-label fw-semibold">

                            Teléfono

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-telephone"></i>
                            </span>

                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$supplier->phone ?? '') }}"
                                placeholder="Ej. 300 123 4567">

                        </div>

                        @error('phone')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Correo --}}
                    <div class="col-12">

                        <label for="email" class="form-label fw-semibold">

                            Correo electrónico

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$supplier->email ?? '') }}"
                                placeholder="proveedor@empresa.com">

                        </div>

                        @error('email')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Dirección --}}
                    <div class="col-12">

                        <label for="address" class="form-label fw-semibold">

                            Dirección

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-geo-alt"></i>
                            </span>

                            <input type="text" name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror" value="{{ old('address',$supplier->address ?? '') }}"
                                placeholder="Ej. Carrera 10 # 20-30">

                        </div>

                        @error('address')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- Descripción --}}
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex align-items-center">

                    <div
                        class="bg-secondary bg-opacity-10
                                        text-secondary rounded-3 p-2 me-3">

                        <i class="bi bi-card-text fs-5"></i>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Información adicional
                        </h5>

                        <small class="text-muted">
                            Agrega observaciones del proveedor
                        </small>

                    </div>

                </div>

            </div>

            <div class="card-body p-4">

                <label for="description" class="form-label fw-semibold">

                    Descripción / Observaciones

                </label>

                <textarea name="description" id="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Escribe información adicional del proveedor...">{{ old('description',$supplier->description ?? '') }}</textarea>

                @error('description')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>


    {{-- Columna lateral --}}
    <div class="col-12 col-xl-4">

        {{-- Ubicación --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex align-items-center">

                    <div
                        class="bg-info bg-opacity-10
                                        text-info rounded-3 p-2 me-3">

                        <i class="bi bi-geo-alt fs-5"></i>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Ubicación
                        </h5>

                        <small class="text-muted">
                            Lugar donde se encuentra
                        </small>

                    </div>

                </div>

            </div>


            <div class="card-body p-4">

                {{-- Departamento --}}
                <div class="mb-3">

                    <label for="department" class="form-label fw-semibold">

                        Departamento

                    </label>

                    <input type="text" name="department" id="department"
                        class="form-control @error('department') is-invalid @enderror"
                        value="{{ old('department',$supplier->department ?? '') }}" placeholder="Ej. Córdoba">

                    @error('department')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Ciudad --}}
                <div>

                    <label for="city" class="form-label fw-semibold">

                        Ciudad

                    </label>

                    <input type="text" name="city" id="city"
                        class="form-control @error('city') is-invalid @enderror" value="{{ old('city',$supplier->city ?? '') }}"
                        placeholder="Ej. Sahagún">

                    @error('city')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Crédito --}}
        <div class="card border-0 shadow-sm mt-4">

            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex align-items-center">

                    <div
                        class="bg-warning bg-opacity-10
                                        text-warning rounded-3 p-2 me-3">

                        <i class="bi bi-credit-card fs-5"></i>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Crédito
                        </h5>

                        <small class="text-muted">
                            Información financiera
                        </small>

                    </div>

                </div>

            </div>


            <div class="card-body p-4">

                <label for="credit_amount" class="form-label fw-semibold">

                    Cupo de crédito

                </label>

                <div class="input-group">

                    <span class="input-group-text bg-light">
                        $
                    </span>

                    <input type="number" name="credit_amount" id="credit_amount"
                        class="form-control @error('credit_amount') is-invalid @enderror"
                        value="{{ old('credit_amount', $supplier->credit_amount ?? 0) }}" min="0" step="1" placeholder="0">

                </div>

                <div class="form-text">
                    Ingresa 0 si el proveedor no maneja crédito.
                </div>

                @error('credit_amount')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>


        {{-- Resumen --}}
        <div class="card border-0 shadow-sm mt-4 bg-primary text-white">

            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-3">

                    <i class="bi bi-info-circle fs-4 me-2"></i>

                    <h6 class="fw-bold mb-0">
                        Registro de proveedor
                    </h6>

                </div>

                <p class="small mb-0 opacity-75">
                    Verifica que la identificación y los datos
                    de contacto sean correctos antes de guardar.
                </p>

            </div>

        </div>

    </div>

</div>


{{-- Botones --}}
<div class="card border-0 shadow-sm mt-4">

    <div class="card-body p-4">

        <div class="d-flex flex-column flex-sm-row
                            justify-content-end gap-2">

            <a href="{{ route('supplier.index') }}" class="btn btn-light border px-4">

                <i class="bi bi-x-lg me-1"></i>
                Cancelar

            </a>

            <button type="submit" class="btn btn-primary px-4">

                <i class="bi bi-check-lg me-1"></i>
                Guardar proveedor

            </button>

        </div>

    </div>

</div>
