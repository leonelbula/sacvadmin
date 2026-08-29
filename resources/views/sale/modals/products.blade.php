  <div class="modal fade" id="productModal" tabindex="-1">

            <div class="modal-dialog modal-xl modal-dialog-scrollable">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header bg-success text-white">

                        <h5 class="modal-title">

                            <i class="bi bi-search me-2"></i>

                            Buscar Producto

                        </h5>

                        <button class="btn-close btn-close-white" data-bs-dismiss="modal">

                        </button>

                    </div>

                    <div class="modal-body">

                        <!-- Buscador -->

                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-body">

                              
                                    <div class="row">

                                        <div class="col-lg-7">

                                            <label class="form-label">

                                                Buscar

                                            </label>

                                            <input class="form-control" placeholder="Código o nombre" name="searchProduct" id="searchProduct">

                                        </div>

                                       
                                        <div class="col-lg-3 d-flex align-items-end">

                                            <button class="btn btn-success me-2" id="btnSearchProduct">

                                                <i class="bi bi-search"></i>

                                                Buscar

                                            </button>

                                           

                                        </div>

                                    </div>

                               

                            </div>

                        </div>

                        <!-- Tabla -->

                        <div class="table-responsive">

                            <table class="table table-hover align-middle " id="tableProducts">

                                <thead class="table-light">

                                    <tr>

                                        <th>Código</th>

                                        <th>Producto</th>

                                        <th>Stock</th>

                                        <th>Precio</th>

                                        <th>Estado</th>

                                        <th width="90">

                                            Acción

                                        </th>

                                    </tr>

                                </thead>

                                <tbody id="tbodyProducts">

                                    

                                </tbody>

                            </table>

                        </div>

                        <!-- Paginación -->

                        

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">

                            Cerrar

                        </button>

                    </div>

                </div>

            </div>

        </div>