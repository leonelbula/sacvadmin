 <div class="modal fade" id="modalSupplier" tabindex="-1">

       <div class="modal-dialog modal-xl modal-dialog-scrollable">

           <div class="modal-content border-0 shadow">

               <div class="modal-header bg-primary text-white">

                   <h5 class="modal-title">

                       <i class="bi bi-search me-2"></i>

                       Buscar Cliente

                   </h5>

                   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">

                   </button>

               </div>

               <div class="modal-body">

                   <!-- Buscador -->

                   <div class="card border-0 shadow-sm mb-4">

                       <div class="card-body">


                           <div class="row">

                               <div class="col-lg-7">

                                   <label class="form-label">

                                       Buscar

                                   </label>

                                   <input type="text" class="form-control" placeholder="Nombre o documento"
                                       id="searchSupplier" name="searchSupplier">

                               </div>



                               <div class="col-lg-3 d-flex align-items-end">

                                   <button class="btn btn-primary me-2" id="btnSearchSupplier">

                                       <i class="bi bi-search"></i>

                                       Buscar

                                   </button>



                               </div>

                           </div>



                       </div>

                   </div>

                   <!-- Tabla -->

                   <div class="table-responsive">

                       <table class="table table-hover align-middle" id="tablaSupplier">

                           <thead class="table-light">

                               <tr>

                                   <th>Documento</th>

                                   <th>Proveedort</th>

                                   <th>Teléfono</th>

                                   <th>Direccion</th>
                                   <th>Ciudad</th>

                                   <th width="100">

                                       Acción

                                   </th>

                               </tr>

                           </thead>

                           <tbody id="tbodySupplier">



                           </tbody>

                       </table>

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
