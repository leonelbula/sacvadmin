@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('subtitle')Nueva Venta @endsection
@section('content')
<?php date_default_timezone_set('America/Bogota'); ?>

<div class="card-body">
   <!-- title row -->
   <div class="row">
      <div class="col-xs-12">
         <div class="box-body">
            <div class="box-header with-border cabeceraVenta">
               <a href="{{route('venta.index')}}">
                  <button type="button" class="btn btn-primary">Volver</button>
               </a>

               <button class="btn btn-primary" data-toggle="modal" data-target="#customerModal">Agregar Cliente</button>
               <button class="btn btn-danger" id="btnBlack">
                  <i class="fa fa-close"></i>
                  Borrar
               </button>


            </div>
         </div>
      </div>
      <!-- /.col -->
   </div>


   <br>

   <!-- info row -->
   <form role="form" method="post" action="{{ route('venta.store') }}" class="formularioVenta">
      @csrf
      <div class="row ">
         <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
               <input type="hidden" name="customer_id" id="customer_id" value="">
               <input type="text" class="form-control" name="full_name" id="full_name" value="" disabled placeholder="Nombre cliente">
            </div>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
               <input type="text" class="form-control"  id="identification_card" value="" disabled placeholder="Nit - CC">
            </div>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
               <input type="date" class="form-control" name="fecha" id="fecha" value="<?= date('Y-m-d') ?>">
            </div>
         </div>

      </div>
      <div class="row">
         <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <input type="text" class="form-control" id="address" value="" disabled placeholder="Direccion">
         </div>
         <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <input type="text" class="form-control" id="city" value="" disabled placeholder="Ciudad">
         </div>         
         <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <select class="chosen-select form-control seleccionarTipoventa" name="type_sale" id="" required="">
               <option value="">Tipo Venta</option>
               <option value="0">Contado</option>
               <option value="1">Credito</option>
               <option value="2">Nequi/otros</option>
               <option value="3">Plan separe</option>

            </select>
         </div>
         <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <select class="chosen-select form-control plazoVenta" name="plazos" id="plazo-sale">
               <option value="">Plazo de venta</option>
               @foreach ($terms as $term)
               <option value="{{$term->value}}">{{$term->description}}</option>
               @endforeach
            </select>
         </div>

      </div>

      <div class="col-sm-12 ">

         <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
         <button class="btn btn-primary" data-toggle="modal" data-target="#productsModal">Agregar productos</button>

         </div>

      </div>


      <!-- Table row -->
      <div class="row">
         <div class="col-xs-12 ">
            <table class="table table-striped table-responsive">
               <thead>
                  <tr>
                     <th>codigo</th>
                     <th>Producto detalle</th>
                     <th>cantidad</th>							
                     <th>precio</th>							
                     <th>% Descuento</th>                        
                     <th>Subtotal</th>
                     <th>Accion</th>
                  </tr>
               </thead>

               <tbody class="nuevoProducto">
                       <!--<tr>
                               <td>1</td>
                               <td>Call of Duty</td>
                               <td><input type="number" name="cantidad" value="1" /></td>
                               <td><input type="number" name="precio" value=""/></td>
                               <td><input type="number" name="descuento" value="0"/></td>
                               <td>$64.50</td>
                               <td><a href="eliminar&id="><button class="btn btn-danger btnEliminarProducto"><i class="fa fa-times"></i></button></a></td>
                       </tr>-->

               </tbody>
            </table>
            <input type="hidden" id="listaProductos" name="listaProductos">
            <input type="hidden" id="clienteVentaN" name="clienteVentaN" value="">
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        
         <div class="col-md-8">          
        
         </div>
         <!-- /.col -->
         <div class="col-md-4">


            <div class="table-responsive">
               <table class="table">

                  <tr class="l-total">
                     <th class="total-t">TOTAL:</th>
                     <td class="total-v">
                        <input type="hidden" name="totalVenta" id="totalVenta">
                        <input type="text" class="form-control input-lg nuevoTotalVenta" id="nuevoTotalVenta" name="nuevoTotalVenta" value="0" readonly/>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
         <div class="col-md-12">
            </button>
            <button type="submit" class="btn btn-primary pull-right" style="margin-right: 5px;">
               <i class="fa fa-download"></i> Guardar venta
            </button>
         </div>
      </div>
   </form>

</div>
<div class="clearfix"></div>


<input type="hidden" id="productall" value="{{ route('ajaxproducto.all') }}">
<input type="hidden" id="productget" value="{{ route('ajaxproducto.get') }}">
<input type="hidden" id="customerall" value="{{ route('ajaxcustomer.all') }}">
<input type="hidden" id="customerget" value="{{ route('ajaxcustomer.get') }}">

@endsection

<div class="modal fade" tabindex="-1" role="dialog" id="customerModal">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Lista de Clientes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table class="table table-bordered table-striped dt-responsive" id="tableCustomer">
               <thead>
                  <tr>
                     <th>#</th>                     
                     <th>Nombre</th>
                     <th>Nit</th>
                     <th>Accion</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($customers as $customer)
                  <tr>
                     <th>{{ $customer->id }}</th>                     
                     <th>{{ $customer->full_name }}</th>
                     <th>{{ $customer->identification_card }}</th>
                     <th> <button class="btn btn-primary " id="customer_id" data-customerId='{{$customer->id}}' >Selecionar</button></th>
                  </tr>
                  @endforeach
                 
               </tbody>
            </table>
         </div>
         <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="productsModal">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Lista de Productos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table class="table table-bordered table-striped dt-responsive" id="tb_product_sale">
               <thead>
                  <tr>                     
                     <th>codigo</th>
                     <th>Descripcion</th>
                     <th>precio</th>
                     <th>stop</th>
                     <th>accion</th>
                  </tr>
               </thead>
               <tbody>
                 
               </tbody>
            </table>
         </div>
         <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>






@section('script')
<script src="{{ asset('js/newsale.js')}}"></script>
<script src="{{ asset('js/customer.js')}}"></script>
<script src="{{ asset('js/productssale.js')}}"></script>
@endsection