{{-- ORDER1 --}}
@if(!empty($order_history) && (count($order_history) > 0))
                    @foreach ($order_history as $key => $item)
                      <div class="row singleorder">
                        <div class="col-md-12 singleorderid">
                          <h5><strong>Orders ID: {{ $item['order_id'] }}</strong></h5>
                          <p>Order Date: {{ $item['order_date'] }}</p>
                        </div>
                        <div class="row">
                          <div class="col-md-2 singleorderimg">
                            <a href="#"><img src="{{asset('product/banner/'.$item['banner'].'')}}" alt=""></a>
                          </div>
                          <div class="col-md-10 singleordercontent">
                            <a href="#">Syska X110 11000 mAh Li-Ion Power Bank - White&amp;Grey</a><br>
                            <b class="sub-tag">Product Type : Metal</b>
                            <b class="sub-tag spl">Color : White</b> 
                            <p class="quantity">Quantity: 2</p>
                            <div class="cart-price" style="text-align: left;">                           
                              <span class="cancel-price">
                                ₹ 2000
                              </span>
                              <span>
                                ₹1000
                              </span>
                            </div>
                          </div>                        
                        </div>
                        <div class="row">
                          <div class="col-md-2 singleorderimg">
                            <a href="#"><img src="{{asset('product/banner/'.$item['banner'].'')}}" alt=""></a>
                          </div>
                          <div class="col-md-10 singleordercontent">
                            <a href="#">Samsung Galaxy J2-j200g Tempered Glass Screen Guard by Saadgi Collections</a><br>
                            <b class="sub-tag">Product Type : Metal</b>
                            <b class="sub-tag spl">Color : White</b> 
                            <p class="quantity">Quantity: 2</p>
                            <div class="cart-price" style="text-align: left;">                           
                              <span class="cancel-price">
                                ₹ 2000
                              </span>
                              <span>
                                ₹1000
                              </span>
                            </div>
                          </div>
                          <div class="col-md-12 totalordercontent"> 
                            <h5>Total Order Amount: Rs 1900</h5>   
                            <h5>Total Discount: Rs 100</h5>                           
                            <h5 class="status">Order Status: <span style="color: #07bdbd;">TRANSIT</span></h5>
                            <div class="action">
                              <button type="button" class="button">Cancel</button>
                            </div>
                          </div>                         
                        </div>
                      </div>

    @endforeach
@endif