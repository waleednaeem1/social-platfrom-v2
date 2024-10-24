<x-app-layout>
    <div class="header-for-bg">
         <div class="background-header position-relative">
            {{-- <img src="{{asset('images/page-img/profile-bg7.jpg')}}" class="img-fluid w-100" alt="header-bg"> --}}
            <img src="{{asset('images/user/courseCover.png')}}" class="img-fluid w-100" style="height: 368px;" alt="header-bg">
            <div class="title-on-header">
               <div class="data-block">
                  <h2>Courses Checkout</h2>
               </div>
            </div>
         </div>
    </div>
    <div class="content-page" id="content-page">
      <div class="container">
         <div class="row" id="courseCartHeading">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header d-flex justify-content-between iq-border-bottom mb-0">
                     <div class="header-title">
                        <h4 class="card-title">Course Cart</h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal fade" id="couponModal" tabindex="-1" role="dialog" aria-labelledby="couponModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="couponModalLabel">Enter Coupon Code</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="couponInput">Coupon Code:</label>
                      <input type="text" class="form-control" id="couponInput" placeholder="Enter coupon code">
                    </div>
                  </form>
                  <div id="couponError" class="text-danger"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="applyCouponBtn" onclick="applyCoupon()">Apply Coupon</button>
                </div>
              </div>
            </div>
         </div>
         @if(isset($courses) && count($courses) > 0)
         <div class="row">
            <div id="cart" class="cart-card-block show p-0 col-12">
               <div class="row" id="courseCartCouponHeading" class="courseCartCouponHeading" style="margin-bottom: 2rem; margin-left: 3rem;">
                  <div class="col-lg-8">
                  <h4 class="card-title coupon_model" style="color: #8C68CD;">
                     If you have any coupon, please click here
                     <span>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#couponModal">Add Coupon</button>
                     </span>
                  </h4>
                  </div>
               </div>
               <div class="row align-item-center">
                  <div class="col-lg-8">
                     @php $totalCartPrice = 0; @endphp
                     @foreach($courses as $course)
                        {{-- <div class="card course_card" id="cartItemId- @if(isset($course->cart_item_id)){{$course->cart_item_id}}@endif "> --}}
                        <div class="card" id="cartItemId-{{$course->cart_item_id}}">
                           <div class="card-body">
                              <div class="checkout-product">
                                 <div class="row align-items-center">
                                    <div class="col-sm-2">
                                       <span class="checkout-product-img">
                                       {{-- <a href="{{route('courseDetail',  ['cat_slug' => $course->courseCategoryId,'course_slug' => $course->slug])}}"> --}}
                                          <img class="img-fluid rounded" src="https://web.dvmcentral.com/up_data/courses/thumbnails/{{$course->thumbnail}}" alt="">
                                       {{-- </a> --}}
                                       </span>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="checkout-product-details">
                                          <h5>{{$course->title}}</h5>
                                          <p class="text-success">Available</p>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="row">
                                          <div class="col-sm-10 col-10">
                                             <div class="row align-items-center ">
                                                {{-- <div class="col-sm-7 col-md-6 col-8">
                                                   <div class="quantity buttons_added">
                                                         <input type="button" value="-" class="minus h5">
                                                         <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode=""><input type="button" value="+" class="plus h5">
                                                   </div>
                                                </div> --}}
                                                {{-- <div class="col-sm-5 col-md-6 col-4"> --}}
                                                <div>
                                                   <span class="product-price" style="padding-left:10rem;font-size:18px">${{$course->price_original}}</span>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-sm-2 col-2">
                                             <a href="#" class="text-dark"><a href="#" onclick="removeFromCart({{$course->cart_item_id}})" class="text-dark material-symbols-outlined">delete</a></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @php $totalCartPrice += $course->price_original; @endphp
                     @endforeach
                  </div>
                  <div class="col-lg-3">
                     <div class="card updateCartList">
                        <div class="card-body">
                           <p><b>Order Details</b></p>
                           <div class="d-flex justify-content-between mb-2">
                              <span id="courseCount">cart({{count($courses)}})</span>
                              <span>${{$totalCartPrice}}</span>
                           </div>
                           <div class="d-flex justify-content-between mb-2">
                              <span>Coupon Discount</span>
                              <span class="text-success" id="totalCouponDiscount"></span>
                           </div>
                           <hr>
                           <div class="d-flex justify-content-between mb-4">
                              <span class="text-dark"><strong>Total</strong></span>
                              <span class="text-dark" id="totalCartPrice" data-total-price="{{$totalCartPrice}}"><strong>${{$totalCartPrice}}</strong></span>
                           </div>
                           <a id="checkout-order" href="#" class="btn btn-primary d-block mt-3 next">Place order</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div id="address" class="cart-card-block p-0 col-12">
               <div class="row align-item-center">
                  <div class="col-lg-8">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Add New Address</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <form onsubmit="required()">
                              <div class="row mt-3">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label">Full Name: *</label>
                                       <input type="text" class="form-control" name="first_name" required="">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label">Mobile Number: *</label>
                                       <input type="text" class="form-control" name="mno" required="">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label">Flat, House No: *</label>
                                       <input type="text" class="form-control" name="houseno" required="">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label">Landmark e.g. near apollo hospital:: *</label>
                                       <input type="text" class="form-control" name="landmark" required="">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label">Town/City: *</label>
                                       <input type="text" class="form-control" name="city" required="">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label">Pincode: *</label>
                                       <input type="text" class="form-control" name="pincode" required="">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label">State: *</label>
                                       <input type="text" class="form-control" name="state" required="">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="form-label" for="addtype">Address Type</label>
                                       <select class="form-control" id="addtype">
                                          <option>Home</option>
                                          <option>Office</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <button id="savenddeliver" type="submit" class="btn btn-primary">Save And Deliver Here</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="mb-2">Nik John</h4>
                           <div class="shipping-address">
                              <p class="mb-0">9447 Glen Eagles Drive</p>
                              <p>Lewis Center, OH 43035</p>
                              <p>UTC-5: Eastern Standard Time (EST)</p>
                              <p>202-555-0140</p>
                           </div>
                           <hr>
                           <a id="deliver-address" href="#" class="btn btn-primary d-block mt-1 next">Deliver To this Address</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div id="payment" class="cart-card-block p-0 col-12">
               <div class="row align-item-center">
                  <div class="col-lg-8">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Payment</h4>
                           </div>
                        </div>
                        <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                        <div class="card-body">
                           <form class="mt-3" id="payment-form" method="POST" action="{{route('purchaseCourse')}}">
                              @csrf
                              <input type="hidden" class="form-control" id="couponDiscountPercent" name="couponDiscountPercent" value="">
                              <input type="hidden" class="form-control" id="totalCartPriceToPay" name="totalCartPriceToPay" value="">
                              <div class="form-group">
                                 <label for="cardNumber">Card Number</label>
                                 <input type="text" class="form-control" id="cardNumber" minlength="17" maxlength="22" name="cardNumber" required placeholder="Enter card number">
                              </div>
                              <div class="form-group">
                                 <label for="cardHolder">Card Holder</label>
                                 <input type="text" class="form-control" id="cardHolder" required name="cardHolder" placeholder="Enter card holder's name">
                              </div>
                              <div class="form-group">
                                 <label for="expiryDate">Expiry Date</label>
                                 <input type="text" class="form-control" id="expiryDate" required name="expiryDate" placeholder="MM/YY">
                              </div>
                              <div class="form-group">
                                 <label for="cvc">CVC</label>
                                 <input type="text" class="form-control" minlength="3" maxlength="3" required id="cvc" name="cvc" placeholder="Enter CVV">
                              </div>
                              <button type="submit" class="btn btn-primary btn-block">Pay Now</button>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="mb-2">Price Details</h4>
                           <div class="d-flex justify-content-between">
                              <span>Total purchased courses ({{count($courses)}})</span>
                              {{-- <span><strong>${{$totalCartPrice}}</strong></span> --}}
                           </div>
                           {{-- <div class="d-flex justify-content-between">
                              <span>Delivery Charges</span>
                              <span class="text-success">Free</span>
                           </div> --}}
                           <hr>
                           <div class="d-flex justify-content-between">
                              <span>Amount Payable</span>
                              <span class="text-dark" id="finalCartPrice" data-total-price="{{$totalCartPrice}}"><strong>${{$totalCartPrice}}</strong></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div id="success" class="cart-card-block p-0 col-12">
               {{-- <div class="col-lg-12">
                     <img src="{{asset('images/page-img/img-success.png')}}" class="img-fluid" alt="fit-image">
                     <h1>You have purchased course successfully</h1>
               </div> --}}
               <div style="margin-top:2rem;margin-left: 4rem;" class="col-lg-12">
                  <h4 style="margin-bottom: 2rem;color: #8C68CD;">You have purchased course successfully. Click on button below to see all you courses.</h4>
                  <a href="{{route('myCourses')}}" class="btn btn-primary d-block mt-3" style="width: 30px;width: 125px;height: 50px; padding-top: 0.75rem;">View Courses</a>
              </div>
            </div>
         </div>
      </div>
      @else
         <div style="margin-top:2rem">
            <h4 style="margin-bottom: 2rem;color: #8C68CD">Cart is empty</h4>
            <a href="{{route('courses.categories')}}" class="btn btn-primary d-block mt-3" style="width: 151px;height: 50px; padding-top: 0.75rem;">Purchase Courses</a>
         </div>
      @endif
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
         var cardNumberInput = document.getElementById('cardNumber');
         cardNumberInput.addEventListener('input', function(event) {
            var input = event.target.value.replace(/\s/g, '');
            var cardNumber = input.replace(/(\d{4})(?=\d)/g, '$1 ');
            event.target.value = cardNumber;
         });
      });
      $(document).ready(function() {
         Inputmask("99/99").mask("#expiryDate");
      });
  </script>
</x-app-layout>