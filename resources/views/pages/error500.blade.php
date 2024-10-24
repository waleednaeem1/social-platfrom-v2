<x-guest-layout>
    

      <div class="container p-0">
         <div class="row no-gutters height-self-center">
            <div class="col-sm-12 text-center align-self-center">
               <div class="iq-error position-relative mt-5">
                     <img src="{{asset('images/error/500.png')}}" class="img-fluid iq-error-img" alt="">
                     <h2 class="mb-0 text-center">Oops! This Page is Not Working.</h2>
                     <p class="text-center">The requested is Internal Server Error.</p>
                     <a class="btn btn-primary mt-3" href="{{route('home')}}"><span class="d-flex align-items-center">
                        <i class="material-symbols-outlined md-18 me-1">
                             home
                         </i>
                         Back to Home
                     </span></a>
                     
               </div>
            </div>
         </div>
   </div>
   
</x-guest-layout>