<div class="card-body">



    <!-- Información Personal -->

    <h5 class="border-bottom pb-2 mb-4">

        <i class="bi bi-person-vcard me-2"></i>

        Información Personal

    </h5>

    <div class="row">

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Nombre Completo

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-person"></i>

                </span>

                <input type="text" class="form-control" placeholder="Nombre completo" name="full_name" value="{{old('full_name', $customer->full_name ?? '')}}" required>

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Documento

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-credit-card"></i>

                </span>

                <input type="text" class="form-control" placeholder="Número de identificación" name="identification" value="{{old('identification', $customer->identification ?? '')}}" required>

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

                <input type="text" class="form-control" placeholder="Teléfono" name="phone" value="{{old('phone', $customer->phone ?? '')}}" required>

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

                <input type="email" class="form-control" name="email" placeholder="correo@empresa.com" value="{{old('email', $customer->email ?? '')}}" required>

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

            <input type="text" name="department" id="department" class="form-control" value="{{old('department', $customer->department ?? '')}}" required>

        </div>

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Ciudad

            </label>

            <input type="text" name="city" id="city" class="form-control" value="{{old('city', $customer->city ?? '')}}" required>

        </div>

        <div class="col-12">

            <label class="form-label fw-semibold">

                Dirección

            </label>

            <textarea rows="2" class="form-control" placeholder="Dirección completa" name="address">{{old('address', $customer->address ?? '')}}</textarea>

        </div>

    </div>

    <!-- Información Comercial -->

    <h5 class="border-bottom pb-2 mb-4 mt-4">

        <i class="bi bi-wallet2 me-2"></i>

        Información Comercial

    </h5>

    <div class="row">

        <div class="col-lg-6 mb-4">

            <label class="form-label fw-semibold">

                Cupo de Crédito

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    $

                </span>

                <input type="number" class="form-control" placeholder="0" name="credit_amount" value="{{old('credit_amount', $customer->credit_amount ?? '0')}}">

            </div>

        </div>

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
