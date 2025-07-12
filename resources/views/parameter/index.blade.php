@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')

<a href="{{route('home')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRegistrarDatos" data-dismiss="modal">
    Agregar Datos
 </button>
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarParametros" data-dismiss="modal">
    Editar  Configuracion
 </button>
<div class="row">
    <div class="col-md-6">
       <div class="box-body">

          <div class="panel panel-default">
             <div class="panel-heading">Informacion del Empresa</div>
             <ul class="list-group">			  
               

                   <li class="list-group-item"><b>NIT:</b><h4> </h4></li>
                   <li class="list-group-item"><b>NOMBRE: </b><h4> </h4></li>
                   <li class="list-group-item"><b>Direccion: </b> <h4></h4></li>
                   <li class="list-group-item"><b>Ciudad: </b> <h4></h4></li>
                   <li class="list-group-item"><b>Departamento: </b> <h4> </h4></li>							
                   <li class="list-group-item"><b>Telefono:</b><h4> </h4></li>
                   <li class="list-group-item"><b>Celular:</b><h4> </h4></li>
                   <li class="list-group-item"><b>Email:</b><h4> </h4></li>
                   <li class="list-group-item"><b>Regimen:</b><h4> </h4></li>
                   <li class="list-group-item"><b>Eslogan:</b><h4></h4></li>							
                
             </ul>
          </div>
       </div>
    </div>
    <div class="col-md-6">
       <div class="box-body">
         @if ($parameters)
             
         <div class="panel panel-default">
            <div class="panel-heading">Informacion del Configuracion</div>
            <ul class="list-group">	           
               <li class="list-group-item"><b>Numero de Inicio Facturacion:</b><h4> {{ $parameters->sale_code }}</h4></li>
               <li class="list-group-item"><b>Numero de Inicio Facturacion:</b><h4>{{ $parameters->prefix_sale }} </h4></li>
               
               <li class="list-group-item">
                  <b>General Codigo Producto Automatico:</b>
                  <h4> 
                     @if ($parameters->automatic_product == 1)
                     {{ 'Generar Automaticamente' }}
                     @else
                     {{ 'No generar'}}
                     @endif  
                  </h4>
               </li>
            </li>
            <li class="list-group-item"><b>Codigo Producto:</b><h4> {{ $parameters->product_code }}</h4></li>
            
            
         </ul>
      </div>
   </div>
</div>
@endif
</div>

<div id="modalRegistrarDatos" class="modal fade" role="dialog">

    <div class="modal-dialog">
 
       <div class="modal-content">
 
          <form role="form" action="" method="POST" >
 
             <!--=====================================
             CABEZA DEL MODAL
             ======================================-->
 
             <div class="modal-header" style="background:#3c8dbc; color:white">
 
                <button type="button" class="close" data-dismiss="modal">&times;</button>
 
                <h4 class="modal-title">Agregar Datos Empresa</h4>
 
             </div>
 
             <!--=====================================
             CUERPO DEL MODAL
             ======================================-->
 
             <div class="modal-body">
 
                <div class="box-body">
 
 
                   <div class="form-group">
                      <label>Nombre:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                         </div>
                         <input type="text" class="form-control" name="nombre" required>
                      </div>
                      <!-- /.input group -->
                   </div>            
 
                   <div class="form-group">
                      <label>Nit - CC:</label>
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-tag"></i>
                         </div>
                         <input type="text" class="form-control"name="nit" required>
                      </div>
                      <!-- /.input group -->
                   </div>             
 
                   <div class="form-group">
                      <label>Direccion:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                         </div>
                         <input type="text" class="form-control" name="direccion" required>
                      </div>
                      <!-- /.input group -->
                   </div>
                   <div class="form-group">
                      <label>Departamento:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                         </div>
                         <input type="text" class="form-control" name="departamento" required>
                      </div>
                      <!-- /.input group -->
                   </div>
                   <div class="form-group">
                      <label>Ciudad:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                         </div>
                         <input type="text" class="form-control" name="ciudad" required>
                      </div>
                      <!-- /.input group -->
                   </div>             
                   <div class="form-group">
                      <label>Telefono:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                         </div>
                         <input type="text" class="form-control" name="telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                      </div>
                      <!-- /.input group -->
                   </div>
                   <div class="form-group">
                      <label>Celular:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                         </div>
                         <input type="text" class="form-control" name="celular" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                      </div>
                      <!-- /.input group -->
                   </div>
 
                   <div class="form-group">
                      <label>Email:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-envelope-o"></i>
                         </div>
                         <input type="text" class="form-control" name="email" >
                      </div>
                      <!-- /.input group -->
                   </div>   
                   <div class="form-group">
                      <label>Regimen:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-envelope-o"></i>
                         </div>
                         <input type="text" class="form-control" name="regimen" >
                      </div>
                      <!-- /.input group -->
                   </div> 
                   <div class="form-group">
                      <label>Eslogan:</label>
 
                      <div class="input-group">
                         <div class="input-group-addon">
                            <i class="fa fa-envelope-o"></i>
                         </div>
                         <input type="text" class="form-control" name="eslogan" >
                      </div>
                      <!-- /.input group -->
                   </div> 
 
                </div>
 
             </div>
 
             <!--=====================================
             PIE DEL MODAL
             ======================================-->
 
             <div class="modal-footer">
 
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
 
                <button type="submit" class="btn btn-primary">Guardar</button>
 
             </div>
 
          </form>     
 
       </div>
 
    </div>
 
 </div>


 <div id="modalEditarParametros" class="modal fade" role="dialog">

    <div class="modal-dialog">
 
       <div class="modal-content">
 
          <form role="form" action="{{ route('parametros.store') }}" method="POST" >			
               @csrf
                <div class="modal-header" style="background:#3c8dbc; color:white">
 
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
 
                   <h4 class="modal-title">Editar Configuracion</h4>
 
                </div>
 
                <div class="modal-body">
 
                   <div class="box-body">
 
 
                      <div class="form-group">
                         <label>Numero Facturacion:</label>
 
                         <div class="input-group">
                            <div class="input-group-addon">
                               <i class="fa fa-user"></i>
                            </div>
                            <input type="number" class="form-control" name="sale_code" value="" required>
                         </div>
                         <!-- /.input group -->
                      </div>     
                      <div class="form-group">
                        <label>Prefijo Facturacion:</label>

                        <div class="input-group">
                           <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                           </div>
                           <input type="text" class="form-control" name="prefix_sale" value="" required>
                        </div>
                        <!-- /.input group -->
                     </div>                      
                      <div class="form-group">
                         <label>General Codigo Automatico:</label>
 
                         <div class="input-group">
                            <div class="input-group-addon">
                               <i class="fa fa-tag"></i>
                            </div>
                            <div class="checkbox">
                               <label>
                                  <input type="checkbox" name="automatic_product">
                                  Si
                               </label>
                            </div>
 
                         </div>
                         <!-- /.input group -->
                      </div>   
                      <div class="form-group">
                         <label>Codigo Producto:</label>
 
                         <div class="input-group">
                            <div class="input-group-addon">
                               <i class="fa fa-tag"></i>
                            </div>
                            <input type="text" class="form-control" name="product_code" value="" >
                         </div>
                         <!-- /.input group -->
                      </div> 
 
 
                   </div>
 
                </div>
             <!--=====================================
             PIE DEL MODAL
             ======================================-->
 
             <div class="modal-footer">
 
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
 
                <button type="submit" class="btn btn-primary">Editar</button>
 
             </div>
 
          </form>     
 
       </div>
 
    </div>
 
 </div>

 @endsection
