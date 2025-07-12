@extends('layouts.app')
@section('title'){{ $title }} @endsection
@section('content')
<?php  date_default_timezone_set('America/Bogota'); ?>
<a href="{{route('venta.index')}}">
    <button type="button" class="btn btn-primary">Volver</button>
</a>

<section class="invoice">
     
    <!-- title row -->
    <div class="row">
       <div class="col-xs-12">
          <div class="box-body">
             <div class="box-header with-border cabeceraVenta">

                <button class="btn btn-primary agregarCliente" data-toggle="modal" id="agregarCliente" data-target="#modalAgregarCliente">

                   Seleccionar cliente

                </button>
             
                <button class="btn btn-danger quitarCliente">
                   <i class="fa fa-close"></i> 
                   Borrar
                </button>


             </div>
          </div>

       </div>
       <!-- /.col -->
    </div>
    <!-- info row -->
<form role="form" method="post" action="{{ route('venta.store') }}" class="formularioVenta">
@csrf
    <div class="row invoice-info">
       <div class="cabeceraVenta">	
      
          <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
             <label>Cliente(*):</label>
             <input type="hidden" class="IdCliente" name="idcliente" id="IdCliente" value="{{$customer['id']}}">
             <input type="text" class="form-control" name="nombre" id="nombre" value="{{$customer->full_name}}"  disabled>
          </div>
          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
             <label>Fecha(*):</label>
             <input type="date" class="form-control" name="fecha" id="fecha" value="{{$sale->date_sale}}">
          </div>
          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
             <label>C.C.:</label>
             <input type="text" class="form-control" name="nit" id="nit" value="{{$customer->identification_card}}"  disabled>
          </div>
          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
             <label>Direccion:</label>
             <input type="text" class="form-control"  id="direccion" value="{{$customer->address}}" disabled>
          </div>
          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
             <label>Ciudad:</label>
             <input type="text" class="form-control" id="ciudad" value="{{$customer->city}}" disabled>
          </div>
          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
             <label>Telefono:</label>
             <input type="text" class="form-control" id="telefono" value="{{$customer->phone}}" disabled>
          </div>
       
 
     
       </div>

       <div class="col-sm-12 invoice-col">	

          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">


          </div>                          

       </div>

    </div>
    <!-- /.row -->
    <div class="box-body">
       <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProductos">

             Agregar productos

          </button>


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
                @php
                    $listProducts = json_decode($sale->content,true);
                  
                @endphp

                @foreach ($listProducts as $product)
                   
                    <tr> 
                        <td> {{$product['codigo']}} </td>
                        <td class="costop"> {{$product['descripcion']}} <input  class="costo" type="hidden" name="costo"  value=" {{$product['costo']}}"/></td>
                        <td class="ingresoCantidad"><input type="number" class="nuevaCantidadProducto" name="nuevaCantidadProducto" stock="$stock" value="{{$product['cantidad']}}" /></td>
                        <td class="precio"><input type="number" class="precioProducto" name="precioProducto" value="{{$product['precio']}}"/></td>
                        <td class="descuentop"><input type="number" class="descuento" id="descuentoProdu" name="descuento" value="0"/></td>
                        <td class="nuevototalp"><input type="text" class="nuevototal"  name="nuevototal"  value="{{$product['subtotal']}}" readonly></td>
                        <td><button class="btn btn-danger quitarProducto" idProducto="{{$product['id']}}"><i class="fa fa-times"></i></button></td>
                        <input  class="nombreProduc" type="hidden" name="nombreProduc" value=" {{$product['descripcion']}}"/>
                        <input  class="idProductoVenta" type="hidden" name="idProductoVenta" value="'.$row3['id'].'"/>
                        <input  class="codigo" type="hidden" name="codigo" value=" {{$product['codigo']}}"/>
                    </tr>
                  @endforeach
             </tbody>
          </table>
          <input type="hidden" id="listaProductos" name="listaProductos">
          <input type="hidden" id="clienteVentaN" name="clienteVentaN" value="">
       </div>
       <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
       <!-- accepted payments column -->
       <div class="col-xs-8">
          <p class="lead"></p>


          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"></p>
          <div class="col-xs-6">
             <div class="form-group">
                <label for="estado">Tipo de ventas</label>						
                <select class="chosen-select form-control seleccionarTipoventa" name="tipoventa" id="form-field-select-3" required="">
                   <option value="">Seleciones el Tipo</option>                 
                   
               
                   <option value="0">Contado</option>
                   <option value="1">Credito</option>
                   <option value="2">Nequi/otros</option>
                   <option value="3">Plan separe</option>
         
                </select>
             </div>
             <div class="form-group">
                <label for="estado">Plazo en Dias</label>					
                <select class="chosen-select form-control plazoVenta" name="plazos" id="form-field-select-3">
                   <option value="">Seleciones el Tipo</option>
                     @foreach ($terms as $term)
                     <option value="{{$term->value}}">{{$term->description}}</option>
                     @endforeach
                </select>
             </div>
          </div>



       </div>
       <!-- /.col -->
       <div class="col-xs-4">


          <div class="table-responsive">
             <table class="table">

                <tr class="l-total">
                   <th class="total-t">TOTAL:</th>
                   <td class="total-v">
                      <input type="hidden" name="totalVenta" id="totalVenta" value="{{$sale->total}}">
                      <input type="text" class="form-control input-lg nuevoTotalVenta" id="nuevoTotalVenta" name="nuevoTotalVenta" value="{{$sale->total}}" readonly/>
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
       <div class="col-xs-12">								
          </button>
          <button type="submit" class="btn btn-primary pull-right" style="margin-right: 5px;">
             <i class="fa fa-download"></i> Guardar venta
          </button>
       </div>
    </div>
 </form>

</section>
<div class="clearfix"></div>


<div id="modalAgregarProductos" class="modal fade  modalProduto" role="dialog">

    <div class="modal-dialog">
 
       <div class="modal-content">
 
          <div class="modal-header" style="background:#3c8dbc; color:white">
 
             <button type="button" class="close" data-dismiss="modal">&times;</button>
 
             <h4 class="modal-title">Agregar Prouctos</h4>
 
          </div>
 
          <div class="modal-body">
 
             <div class="box-body">
 
 
                <div class="col-xs-12 table-responsive modalProduct">
                   <table class="table table-bordered table-striped dt-responsive  tableproductoventa">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>codigo</th>
                            <th>Descripcion</th>                           
                            <th>precio</th>
                            <th>stop</th>
                            <th>accion</th>
                         </tr>
                      </thead>
                   </table>
                </div>
 
 
             </div>
 
          </div>
          <div class="modal-footer">
 
             <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
 
  
          </div>
 
       </div>
 
    </div>
 
 </div>


 <div id="modalAgregarCliente" class="modal fade" role="dialog">

   <div class="modal-dialog">

      <div class="modal-content">

         <form>           
            <div class="modal-header" style="background:#3c8dbc; color:white">

               <button type="button" class="close" data-dismiss="modal">&times;</button>

               <h4 class="modal-title">Agregar cliente</h4>

            </div>

            <div class="modal-body">

               <div class="box-body">

                  <div class="form-group">

                     <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered table-striped dt-responsive  tablaclienteventa">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>id</th>
                                 <th>nombre</th>
                                 <th>nit</th>
                                 <th>accion</th>        

                              </tr>
                           </thead>            
                        </table>
                     </div>

                  </div>       

               </div>

            </div>

            <div class="modal-footer">

               <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

               <button type="submit" class="btn btn-primary"></button>

            </div>

         </form>


      </div>

   </div>

</div>

 <input type="hidden" id="productall" value="{{ route('ajaxproducto.all') }}">
 <input type="hidden" id="productget" value="{{ route('ajaxproducto.get') }}">
 <input type="hidden" id="customerall" value="{{ route('ajaxcustomer.all') }}">
 <input type="hidden" id="customerget" value="{{ route('ajaxcustomer.get') }}">


 


@endsection
@section('script')
<script src="{{ asset('js/newsale.js')}}"></script>
<script src="{{ asset('js/customer.js')}}"></script>
@endsection