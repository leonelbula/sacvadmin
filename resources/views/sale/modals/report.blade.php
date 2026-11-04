  <div class="modal fade" id="reportMethodPaymentModal" tabindex="-1">

      <div class="modal-dialog modal-lg modal-dialog-scrollable">

          <div class="modal-content border-0 shadow">

              <div class="modal-header bg-success text-white">

                  <h5 class="modal-title">

                      <i class="bi bi-search me-2"></i>

                      Ventas por Medio de Pago
                  </h5>

                  <button class="btn-close btn-close-white" data-bs-dismiss="modal">

                  </button>

              </div>

              <div class="modal-body">

                  <!-- Buscador -->

                  <div class="card shadow-sm border-0 mb-4">

                      <div class="card-body">

                          <form method="GET" action="{{ route('reports.sales.payment-methods-details.pdf') }}" target="_blank">

                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                              <div class="row g-3 align-items-end">

                                  <div class="col-md-4">

                                      <label class="form-label fw-semibold">
                                          Fecha desde
                                      </label>

                                      <input type="date" name="fecha_desde" class="form-control"
                                          value="{{ $fechaDesde ?? '' }}">

                                  </div>


                                  <div class="col-md-4">

                                      <label class="form-label fw-semibold">
                                          Fecha hasta
                                      </label>

                                      <input type="date" name="fecha_hasta" class="form-control"
                                          value="{{ $fechaHasta ?? '' }}">

                                  </div>
                                  <div class="col-md-4">

                                      <div class="d-flex gap-2">

                                          <select name="payment_method_id" id="payment_method_id" class="form-control">
                                              <option value="">Seleccionar método de pago</option>
                                              @foreach ($payments as $payment)
                                                  <option value="{{ $payment->id }}">
                                                      {{ $payment->name }}
                                                  </option>
                                              @endforeach
                                          </select>

                                      </div>
                                  </div>

                                  <div class="col-md-4">

                                      <div class="d-flex gap-2">

                                          <button type="submit" class="btn btn-success">

                                              <i class="bi bi-search me-1"></i>

                                              Consultar

                                          </button>

                                      </div>

                                  </div>

                              </div>

                          </form>



                      </div>

                  </div>



              </div>

              <div class="modal-footer">

                  <button class="btn btn-secondary" data-bs-dismiss="modal">

                      Cerrar

                  </button>

              </div>

          </div>

      </div>

  </div>
