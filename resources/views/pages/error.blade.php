<x-guest-layout>
      <style>
             @import url("https://fonts.googleapis.com/css?family=Barlow+Condensed:300,400,500,600,700,800,900|Barlow:300,400,500,600,700,800,900&display=swap");
      </style>
      <link rel="stylesheet" href="{{ asset('css/all.css?version=0.15')}}">
       <nav>
           <div class="menu">
            {{-- <img style="background-color:#695681; max-width: 157px;" src="https://www.vtfriends.com/images/icon/logo.png" alt="logo"> --}}
            <img style="background-color:#695681; height:100px;margin-top:20px" width="150px" src="{{ asset('images/icon/logo.png')}}" alt="logo">
               <div class="menu_icon">
                   <span class="icon"></span>
               </div>
           </div>
       </nav>
       <section class="wrapper">
           <div class="container404">
               <div id="scene" class="scene" data-hover-only="false">
                   <div class="circle" data-depth="1.2"></div>
                   <div class="one" data-depth="0.9">
                       <div class="content">
                           <span class="piece"></span>
                           <span class="piece"></span>
                           <span class="piece"></span>
                       </div>
                   </div>
                   <div class="two" data-depth="0.60">
                       <div class="content">
                           <span class="piece"></span>
                           <span class="piece"></span>
                           <span class="piece"></span>
                       </div>
                   </div>
                   <p class="p404" data-depth="0.50">404</p>
                   <p class="p404" data-depth="0.10">404</p>
               </div>
               <div class="text">
                   <article>
                        <p>OOPS, it looks like your page is not found..</p>
						<div>
							<a class="btn btn-primary mt-3" href="{{route('home')}}">
								<span class="d-flex align-items-center">
									<i class="material-symbols-outlined md-18 me-1">
										home
									</i>
								Back to Home
								</span>
							</a>   
						   <a class="btn btn-primary mt-3" href="/customer-support">
								<span class="d-flex align-items-center">
									<i class="material-symbols-outlined md-18 me-1">
										call
									</i>
									Contact Us
								</span>
							</a>   
						</div>
                   </article>
               </div>
   
           </div>
       </section>
  <script>
          // Parallax Code
      var scene = document.getElementById('scene');
      var parallax = new Parallax(scene);
  </script>
</x-guest-layout>