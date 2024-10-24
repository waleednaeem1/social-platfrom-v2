<x-app-layout>
<div class="header-for-bg">
            <div class="background-header position-relative">
               <img src="images/page-img/profile-bg2.jpg" class="img-fluid w-100 rounded rounded" alt="header-bg">
               <div class="title-on-header">
                  <div class="data-block">
                     <h2>Weather</h2>
                  </div>
               </div>
            </div>
         </div>

    <div id="content-page" class="content-page">
      <div class="container">
         <div class="row">
            <div class="col-lg-3">
               <div class="card card-block card-stretch card-height">
                  <div class="card-body">
                     <form>
                        <div class="form-group">
                           <label class="form-label" for="country-and-timezone">Country and Timezone</label>
                           <select  class="form-select" id="country-and-timezone">
                              <option selected="" disabled="">Country and Timezone</option>
                              <option>United States (UTC-8)</option>
                              <option>Chicago (UTC-5)</option>
                              <option>New York (UTC-4)</option>
                              <option>Anchorage (UTC-8)</option>
                              <option>Honolulu (UTC-10)</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="extended-days">Extended Days</label>
                           <select  class="form-select" id="extended-days">
                              <option selected="" disabled="">Extended Days</option>
                              <option>Show Next Day</option>
                              <option>Show Next 7 Day</option>
                              <option>Show Next 10 Day</option>
                              <option>Show Next 20 Day</option>
                              <option>Show Next 30 Day</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label class="form-label" for="temperature-unit">Temperature Unit</label>
                           <select  class="form-select" id="temperature-unit">
                              <option selected="" disabled="">Temperature Unit</option>
                              <option>F° (Farenheit)</option>
                              <option>C° (Celsius)</option>
                           </select>
                        </div>
                        <div class="form-group mb-0">
                           <button type="submit" class="btn  btn-primary d-block w-100">Check wether</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="card card-block card-stretch card-height">
                  <div class="card-body p-0">
                     <div id="chart-map-column-04" class="custom-chart"></div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3">
               <div class="card card-block card-stretch card-height bg-primary rounded text-white">
                  <div class="card-body p-4">
                     <div class="text-center">
                        <div class="d-flex">
                           <div class="flex-shrink-0">
                              <i class="material-symbols-outlined md-36">filter_drama</i>
                           </div>
                           <div class="flex-grow-1 ms-3 text-start">
                              <h6 class="text-white">USA</h6>
                              <p class="mb-0">Lorem ipsum</p>
                           </div>
                        </div>
                        <div class="main-temp d-flex justify-content-center">
                           <h1 class="text-white display-1">53</h1>
                            <span>°</span>
                        </div>
                        <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0 weather-list">
                           <li>
                              <p class="mb-0">Yeasterday</p>
                               <i class="material-symbols-outlined text-white md-18">thunderstorm</i>
                              <h6 class="text-white">21 <span>&#8451;</span></h6>
                           </li>
                           <li>
                              <p class="mb-0">Today</p>
                              <i class="material-symbols-outlined md-18">filter_drama</i>
                              <h6 class="text-white">16 <span>&#8451;</span></h6>
                           </li>
                           <li>
                              <p class="mb-0">Tomorrow</p>
                              <i class="material-symbols-outlined text-white md-18">thunderstorm</i>
                              <h6 class="text-white">19 <span>&#8451;</span></h6>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-12">
               <div class="card">
                  <div class="card-body bg-info rounded text-white">
                     <ul class="iq-week-data d-flex justify-content-between list-inline m-0 p-0 flex-wrap">
                        <li class="text-center p-4">
                           <p class="mb-0">Sunday</p>
                           <div class="weather-icon mt-3 mb-3 font-size-20">
                              <i class="material-symbols-outlined md-18">thunderstorm</i>
                           </div>
                           <p class="mb-0">13 °  7 °</p>
                        </li>
                        <li class="text-center p-4">
                           <p class="mb-0">Monday</p>
                           <div class="weather-icon mt-3 mb-3 font-size-20">
                              <i class="material-symbols-outlined md-18">thunderstorm</i>
                           </div>
                           <p class="mb-0">11 ° 6 °</p>
                        </li>
                        <li class="text-center p-4">
                           <p class="mb-0">Tuesday</p>
                           <div class="weather-icon mt-3 mb-3 font-size-20">
                              <i class="material-symbols-outlined md-18">filter_drama</i>
                           </div>
                           <p class="mb-0">12 °  8 °</p>
                        </li>
                        <li class="text-center p-4">
                           <p class="mb-0">Wednesday</p>
                           <div class="weather-icon mt-3 mb-3 font-size-20">
                               <i class="material-symbols-outlined md-18">thunderstorm</i>
                           </div>
                           <p class="mb-0">12 °  7 °</p>
                        </li>
                        <li class="text-center p-4">
                           <p class="mb-0">Thursday</p>
                           <div class="weather-icon mt-3 mb-3 font-size-20">
                               <i class="material-symbols-outlined md-18">thunderstorm</i>
                           </div>
                           <p class="mb-0">11 °  6 °</p>
                        </li>
                        <li class="text-center p-4">
                           <p class="mb-0">Fryday</p>
                           <div class="weather-icon mt-3 mb-3 font-size-20">
                              <i class="material-symbols-outlined md-18">thunderstorm</i>
                           </div>
                           <p class="mb-0">11 °  8 °</p>
                        </li>
                        <li class="text-center p-4">
                           <p class="mb-0">Satuarday</p>
                           <div class="weather-icon mt-3 mb-3 font-size-20">
                              <i class="material-symbols-outlined md-18">light_mode</i>
                           </div>
                           <p class="mb-0">13 °  5 °</p>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
</x-app-layout>