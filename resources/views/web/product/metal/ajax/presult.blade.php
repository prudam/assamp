<div class="category-products">
                <ul class="products-grid row brass-metal">
                @if(!empty($products) && (count($products) > 0))
                    @foreach ($products as $key => $item)
                      <li class="item col-lg-4 col-md-4 col-sm-4 col-xs-6" >
                        <div class="item-inner">
                          <div class="item-img">
                            <div class="item-img-info"> <a class="product-image" title="{{ $item->product_name }}" href="{{ route('web.bell_brass_metal_product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"> <img alt="{{ $item->product_name }}" src="{{ route('admin.metal_product_banner', ['product_id' => encrypt($item->id)]) }}"> </a>
                            </div>
                          </div>
                          <div class="item-info">
                            <div class="info-inner">
                              <div class="item-title"> <a title="{{ $item->product_name }}" href="{{ route('web.bell_brass_metal_product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"> {{ $item->product_name }} </a> </div>
                              <div class="item-content">
                                <div class="rating"> 
                                    {{-- @if(!empty($item->star_sum) && (count($item->star_sum) > 0))
                                        @for($i = 0; $i < $item->star_sum; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor

                                        @for($j = $i; $j < 5; $j++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    @else
                                        @for($j = 0; $j < 5; $j++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    @endif --}}
                                 </div>
                                <div class="item-price">
                                  <div class="price-box">
                                    <span class="regular-price">
                                      <span class="price">
                                        @auth('users')
                                            @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                                @if(!empty($item->discount))
                                                    ₹{{ $item->distributor_price }}
                                                @endif
                                                @php
                                                $price = $item->distributor_price;
                                                @endphp
                                            @else
                                                @if(!empty($item->discount))
                                                    ₹{{ $item->customer_price }}
                                                @endif
                                                @php
                                                $price = $item->customer_price;
                                                @endphp
                                            @endif
                                        @else
                                            @if(!empty($item->discount))
                                                ₹{{ $item->customer_price }}
                                            @endif
                                            @php
                                            $price = $item->customer_price;
                                            @endphp
                                        @endif
                                      </span>
                                       @php
                                        if (!empty($item->discount)) {
                                            $discount = (($price * $item->discount) / 100);
                                            $selling_price = $price - $discount;
                                        } else
                                            $selling_price = $price;
                                        @endphp

                                        {{ $selling_price }}
                                    </span>
                                  </div>
                                </div>
                                <div class="action">
								<a class="link-wishlist" href="{{ route('web.add_wish_list', ['product_id' => $item->id]) }}"><i class="icon-heart icons"></i><span class="hidden">Wishlist</span></a>
								@if ($item->stock > 0)
                                <form action="{{ route('web.add_cart') }}" method="POST" autocomplete="off">
                                  @csrf
                                  <input type="hidden" name="product_id" value="{{ $item->id }}" />
                                  <input type="hidden" name="quantity" value="1"/>
                                  <input type="hidden" name="product_type" value="3"/>
                                  <input type="hidden" name="product_price" value="{{ $selling_price }}"/>
                                  <button class="button btn-cart" title="{{ $item->product_name }}" type="submit"><span>Add to Cart</span> </button> 
								</form>
								@else
								<button class="button btn-cart"  type="button"><span>Out of Stock</span> </a> 
								@endif
                              </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                    @endforeach
                @endif
                </ul>
              </div>
              <div class="toolbar">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <ul class="pagination">
                      {!! $products->render() !!}
                    </ul>
                  </div>
                </div>
              </div>