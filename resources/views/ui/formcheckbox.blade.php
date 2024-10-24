<x-app-layout>
    

    <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                        <div class="inner-page-title">
                           <h3 class="text-white">Form Checkbox Page</h3>
                           <p class="text-white">lorem ipsum</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Basic Checkbox</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                           <div class="form-check form-check-inline me-2">
                              <input type="checkbox" class="form-check-input" id="checkbox1" >
                              <label for="checkbox1">Primary / Inactive</label>
                           </div>
                           <div class="form-check form-check-inline me-2">
                              <input type="checkbox" class="form-check-input" value="" id="checkbox2" checked="">
                              <label for="checkbox2">Primary / Active</label>
                           </div>
                           <div class="form-check form-check-inline me-2">
                              <input type="checkbox" class="form-check-input" value="" id="checkbox3" disabled="">
                              <label for="checkbox3">Disable / Inactive</label>
                           </div>
                           <div class="form-check form-check-inline me-2">
                              <input type="checkbox" class="form-check-input" value="" id="checkbox4" checked="" disabled="">
                              <label for="checkbox4">Active / Disable</label>
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Custom Color</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                           <div class="form-check form-check-inline form-checkbox form-checkbox-color me-2">
                              <input type="checkbox" class="form-check-input bg-primary" id="customCheck-11" >
                              <label class="form-check-label" for="customCheck-11">Primary</label>
                           </div>
                           <div class="form-check form-check-inline form-checkbox form-checkbox-color me-2">
                              <input type="checkbox" class="form-check-input bg-success" id="customCheck-22">
                              <label class="form-check-label" for="customCheck-22">Success</label>
                           </div>
                           <div class="form-check form-check-inline form-checkbox form-checkbox-color me-2">
                              <input type="checkbox" class="form-check-input bg-danger" id="customCheck-33">
                              <label class="form-check-label" for="customCheck-33">Danger</label>
                           </div>
                           <div class="form-check form-check-inline form-checkbox form-checkbox-color me-2">
                              <input type="checkbox" class="form-check-input bg-warning" id="customCheck-44">
                              <label class="form-check-label" for="customCheck-44">Warning</label>
                           </div>
                           <div class="form-check form-check-inline form-checkbox form-checkbox-color me-2">
                              <input type="checkbox" class="form-check-input bg-dark" id="customCheck-55">
                              <label class="form-check-label" for="customCheck-55">Dark</label>
                           </div>
                           <div class="form-check form-check-inline form-checkbox form-checkbox-color me-2">
                              <input type="checkbox" class="form-check-input bg-info" id="customCheck-66">
                              <label class="form-check-label" for="customCheck-66"> Info</label>
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Boolean Checkbox</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                           <div class="form-check form-check-inline me-2">
                              <input type="checkbox" class="form-check-input" id="customCheck-t" checked="">
                              <label class="form-check-label" for="customCheck-t">True</label>
                           </div>
                           <div class="form-check form-check-inline me-2">
                              <input type="checkbox" class="form-check-input" id="customCheck-f">
                              <label class="form-check-label" for="customCheck-f">False</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Custom Checkbox</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input" id="customCheck5">
                              <label class="form-check-label" for="customCheck5">Primary / Inactive</label>
                           </div>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input" id="customCheck6" Checked="">
                              <label class="form-check-label" for="customCheck6">Primary - active</label>
                           </div>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input" id="customCheck7"  disabled="">
                              <label class="form-check-label" for="customCheck7">Primary - inactive - disabled</label>
                           </div>
                           <div class="form-check custom-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input" id="customCheck8"  checked="" disabled="">
                              <label class="form-check-label" for="customCheck8">Primary - active - disabled</label>
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-header d-flex justify-content-between">
                           <div class="header-title">
                              <h4 class="card-title">Color</h4>
                           </div>
                        </div>
                        <div class="card-body">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input bg-primary" id="customCheck-1" checked="">
                              <label class="form-check-label" for="customCheck-1"> Primary</label>
                           </div>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input bg-success" id="customCheck-2" checked="">
                              <label class="form-check-label" for="customCheck-2">Success</label>
                           </div>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input bg-danger" id="customCheck-3" checked="">
                              <label class="form-check-label" for="customCheck-3">Danger</label>
                           </div>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input bg-warning" id="customCheck-4" checked="">
                              <label class="form-check-label" for="customCheck-4">Warning</label>
                           </div>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input bg-dark" id="customCheck-5" checked="">
                              <label class="form-check-label" for="customCheck-5">Dark</label>
                           </div>
                           <div class="form-check form-checkbox form-check-inline">
                              <input type="checkbox" class="form-check-input bg-info" id="customCheck-6" checked="">
                              <label class="form-check-label" for="customCheck-6">Info</label>
                           </div>
                        </div>
                     </div>
                     
                  </div>
               </div>
    </div>   

</x-app-layout>