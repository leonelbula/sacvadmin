 <div class="row g-3">

     <div class="col-12 col-md-6">
         <label for="amount" class="form-label">
             Valor del abono
         </label>

         <div class="input-group">
             <span class="input-group-text">$</span>
             <input type="number" name="amount" id="amount" class="form-control" min="0"
                 max="{{ $saldo }}" value="{{ old('amount', $abono->amount ?? '') }}" required>
         </div>

         <button type="button" id="payFullBalance" class="btn btn-sm btn-outline-primary mt-2">
             Pagar saldo completo
         </button>
     </div>

     <div class="col-12 col-md-6">
         <label for="payment_date" class="form-label">
             Fecha de pago
         </label>

         <input type="date" name="payment_date" id="payment_date" class="form-control"
             value="{{ old('payment_date', now()->format('Y-m-d') , $abono->payment_date ?? '' ) }}" max="{{ now()->format('Y-m-d') }}" required>
     </div>

     <div class="col-12 col-md-6">
         <label for="payment_method" class="form-label">
             Método de pago
         </label>

         <select name="payment_method" id="payment_method" class="form-select" required>
             <option value="">Selecciona un método</option>

             <option value="Efectivo" @selected(old('payment_method') === 'Efectivo' || $abono->payment_method === 'Efectivo')>Efectivo</option>
             <option value="Transferencia" @selected(old('payment_method') === 'Transferencia' || $abono->payment_method === 'Transferencia')>Transferencia</option>
             <option value="Tarjeta débito" @selected(old('payment_method') === 'Tarjeta débito' || $abono->payment_method === 'Tarjeta débito')>Tarjeta débito</option>
             <option value="Tarjeta crédito" @selected(old('payment_method') === 'Tarjeta crédito' || $abono->payment_method === 'Tarjeta crédito')>Tarjeta crédito
             </option>
             <option value="Otro" @selected(old('payment_method') === 'Otro' || $abono->payment_method === 'Otro')>Otro</option>
         </select>
     </div>

     <div class="col-12 col-md-6">
         <label for="reference" class="form-label">
             Referencia del pago
         </label>

         <input type="text" name="reference" id="reference" class="form-control" maxlength="100"
             value="{{ old('reference', $abono->reference ?? '') }}" placeholder="Número de comprobante">
     </div>

     <div class="col-12">
         <label for="observation" class="form-label">
             Observaciones
         </label>

         <textarea name="observation" id="observation" class="form-control" rows="3" maxlength="1000"
             placeholder="Información adicional del pago">{{ old('observation', $abono->observation ?? '') }}</textarea>
     </div>

 </div>
