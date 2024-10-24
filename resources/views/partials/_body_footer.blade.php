<footer class="iq-footer bg-white">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-6">
            <ul class="list-inline mb-0">
               <li class="list-inline-item"><a href="{{route('footer.privacypolicy')}}">Privacy Policy</a>&nbsp;</li>
               <li class="list-inline-item"><a href="{{route('footer.termsofservice')}}">Terms of Use</a>&nbsp;</li>
               <li class="list-inline-item"><a href="{{route('footer.aboutus')}}">About Us</a></li>
               {{-- <li class="list-inline-item"><a href="{{route('comingsoon')}}">Customer Support</a></li> --}}
               <li class="list-inline-item"><a href="{{route('footer.customersupport')}}">Customer Support</a></li>
            </ul>
         </div>
         <div class="col-lg-6 d-flex justify-content-end">
            Copyright {{ date('Y') }}&nbsp;<a href="https://www.vetandtech.com/" target="_blank"> Vet and Tech Inc </a>. All Rights Reserved.
         </div>
      </div>
   </div>
</footer>