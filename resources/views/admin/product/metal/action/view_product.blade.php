@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Product Details</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <section class="content invoice">
              <div class="row invoice-info">
                @if (!empty($product_record))                    
                <div class="col-sm-6 invoice-col">
                  <table class="table table-striped">
                    <caption>Product Deails</caption>
                    <tr>
                      <th style="width:150px;">Sub-Category : </th>
                      <td>{{$product_record->sub_cate_name}}</td>
                    </tr> 
                    <tr>
                      <th style="width:150px;">Name : </th>
                      <td>{{$product_record->product_name}}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Customer Price : </th>
                      <td>{{$product_record->customer_price}}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Whole Seller Price : </th>
                      <td>{{$product_record->distributor_price}}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Discount : </th>
                      <td>{{$product_record->discount}}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Stock : </th>
                      <td>{{$product_record->stock}}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Shipping Amount : </th>
                      <td>{{$product_record->shipping_amount}}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Weight in (KG) : </th>
                      <td>{{$product_record->weight}}</td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Status : </th>
                      <td>
                            @if($product_record->status == 1)
                                <a class="btn btn-success">Active</a>
                            @else
                                <a class="btn btn-success">In-Active</a>
                            @endif
                      </td>
                    </tr>
                    <tr>
                      <th style="width:150px;">Description : </th>
                      <td>{!!$product_record->desc!!}</td>
                    </tr>
                  </table>
                </div>
                @endif

                <div class="col-sm-6 invoice-col">
                    <table class="table table-striped">
                      <caption>Product Image</caption>                     
                        <tr>
                          <td colspan="2">
                            <img src="{{ route('admin.metal_banner_image', ['product_id' => encrypt($product_record->id)]) }}" style="max-width:400px;" >
                          </td>
                        </tr>                   
                    </table>
                </div>
              </div>
              <!-- /.row -->
              <hr>
           


              <div class="row">
                <button class="btn btn-warning" onclick="javascript:window.close()">Close</button>
              </div>
              <!-- /.row -->
            </section>
          </div>
        </div>
      </div>
    </div>

</div>


 @endsection
