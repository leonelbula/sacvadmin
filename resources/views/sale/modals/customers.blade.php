   <div class="modal fade" id="customerModal" tabindex="-1">

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
                                       id="searchCustomer" name="searchCustomer">

                               </div>



                               <div class="col-lg-3 d-flex align-items-end">

                                   <button class="btn btn-primary me-2" id="btnSearchCustomer">

                                       <i class="bi bi-search"></i>

                                       Buscar

                                   </button>



                               </div>

                           </div>



                       </div>

                   </div>

                   <!-- Tabla -->

                   <div class="table-responsive">

                       <table class="table table-hover align-middle" id="tablaCustomer">

                           <thead class="table-light">

                               <tr>

                                   <th>Documento</th>

                                   <th>Cliente</th>

                                   <th>Teléfono</th>

                                   <th>Direccion</th>
                                   <th>Ciudad</th>

                                   <th width="100">

                                       Acción

                                   </th>

                               </tr>

                           </thead>

                           <tbody id="tbodyCustomers">



                           </tbody>

                       </table>

                   </div>

                   <!-- Paginación -->

                   <div class="d-flex justify-content-between align-items-center mt-3">

                       <small class="text-muted">

                           Mostrando 1 a 10 de 150 clientes

                       </small>

                       <nav>

                           <ul class="pagination pagination-sm mb-0">

                               <li class="page-item disabled">

                                   <a class="page-link">

                                       Anterior

                                   </a>

                               </li>

                               <li class="page-item active">

                                   <a class="page-link">

                                       1

                                   </a>

                               </li>

                               <li class="page-item">

                                   <a class="page-link">

                                       2

                                   </a>

                               </li>

                               <li class="page-item">

                                   <a class="page-link">

                                       3

                                   </a>

                               </li>

                               <li class="page-item">

                                   <a class="page-link">

                                       Siguiente

                                   </a>

                               </li>

                           </ul>

                       </nav>

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
