<x-app-layout>
    

         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                     <div class="inner-page-title">
                        <h3 class="text-white">Budges Page</h3>
                        <p class="text-white">lorem ipsum</p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-lg-6">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Badge</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Badges scale to match the size of the immediate parent element by using relative font sizing and <code>em</code> units.</p>
                        <h1 class="mb-3">Example heading <span class="badge  bg-primary">New</span></h1>
                        <h2 class="mb-3">Example heading <span class="badge bg-secondary">New</span></h2>
                        <h3 class="mb-3">Example heading <button type="button" class="btn btn-success">
                           Notifications <span class="badge bg-light text-dark ml-2">4</span>
                           </button>
                        </h3>
                        <h4 class="mb-3">Example heading <span class="badge bg-danger">New</span></h4>
                        <h5 class="mb-3">Example heading <span class="badge bg-warning">New</span></h5>
                        <h6 class="mb-0">Example heading <span class="badge bg-info">New</span></h6>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Button Badges</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Badges can be used as part of buttons to provide a counter.</p>
                        <button type="button" class="btn mb-1 btn-primary">
                        Notifications <span class="badge bg-light text-dark ml-2">4</span>
                        </button>
                        <button type="button" class="btn mb-1 btn-success">
                        Notifications <span class="badge bg-light text-dark ml-2">4</span>
                        </button>
                        <button type="button" class="btn mb-1 btn-danger">
                        Notifications <span class="badge bg-light text-dark ml-2">4</span>
                        </button>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Button Light background Badges</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Badges can be used as part of buttons to provide a counter.</p>
                        <button type="button" class="btn mb-1 btn-outline-primary">
                        Notifications <span class="badge bg-primary ml-2">4</span>
                        </button>
                        <button type="button" class="btn mb-1 btn-outline-success">
                        Notifications <span class="badge bg-success ml-2">4</span>
                        </button>
                        <button type="button" class="btn mb-1 btn-outline-danger">
                        Notifications <span class="badge bg-danger ml-2">4</span>
                        </button>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Button Border Badges</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p>Badges can be used as part of buttons to provide a counter.</p>
                        <button type="button" class="btn mb-1 bg-soft-primary">
                        Notifications <span class="badge bg-primary ml-2">4</span>
                        </button>
                        <button type="button" class="btn mb-1 bg-soft-success">
                        Notifications <span class="badge bg-success ml-2">4</span>
                        </button>
                        <button type="button" class="btn mb-1 bg-soft-danger">
                        Notifications <span class="badge bg-danger ml-2">4</span>
                        </button>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-lg-6">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Contextual variations</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p class="mb-0">Add any of the below mentioned modifier classes to change the appearance of a badge.</p>
                        <span class="badge bg-primary mt-2">Primary</span>
                        <span class="badge bg-secondary mt-2">Secondary</span>
                        <span class="badge bg-success mt-2">Success</span>
                        <span class="badge bg-danger mt-2">Danger</span>
                        <span class="badge bg-warning mt-2">Warning</span>
                        <span class="badge bg-info mt-2">Info</span>
                        <span class="badge bg-light mt-2">Light</span>
                        <span class="badge bg-dark mt-2">Dark</span>
                        <h5 class="card-title mt-4">Pill badges</h5>
                        <p class="mb-0">Use the <code>.badge-pill</code> modifier class to make badges more rounded (with a larger <code>border-radius</code> and additional horizontal <code>padding</code>). Useful if you miss the badges from v3.</p>
                        <span class="badge badge-pill bg-primary mt-2">Primary</span>
                        <span class="badge badge-pill bg-secondary mt-2">Secondary</span>
                        <span class="badge badge-pill bg-success mt-2">Success</span>
                        <span class="badge badge-pill bg-danger mt-2">Danger</span>
                        <span class="badge badge-pill bg-warning mt-2">Warning</span>
                        <span class="badge badge-pill bg-info mt-2">Info</span>
                        <span class="badge badge-pill bg-light mt-2">Light</span>
                        <span class="badge badge-pill bg-dark mt-2">Dark</span>
                        <h5 class="card-title mt-4">Links</h5>
                        <p class="mb-0">Using the contextual <code>.badge-*</code> classes on an <code>&lt;a&gt;</code> element quickly provide <em>actionable</em> badges with hover and focus states.</p>
                        <a href="#" class="badge bg-primary mt-2">Primary</a>
                        <a href="#" class="badge bg-secondary mt-2">Secondary</a>
                        <a href="#" class="badge bg-success mt-2">Success</a>
                        <a href="#" class="badge bg-danger mt-2">Danger</a>
                        <a href="#" class="badge bg-warning mt-2">Warning</a>
                        <a href="#" class="badge bg-info mt-2">Info</a>
                        <a href="#" class="badge bg-light mt-2">Light</a>
                        <a href="#" class="badge bg-dark mt-2">Dark</a>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Contextual variations Border</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <p class="mb-0">Add any of the below mentioned modifier classes to change the appearance of a badge.</p>
                        <span class="badge border border-primary text-primary mt-2">Primary</span>
                        <span class="badge border border-secondary text-secondary mt-2">Secondary</span>
                        <span class="badge border border-success text-success mt-2">Success</span>
                        <span class="badge border border-danger text-danger mt-2">Danger</span>
                        <span class="badge border border-warning text-warning mt-2">Warning</span>
                        <span class="badge border border-info text-info mt-2">Info</span>
                        <span class="badge border border-light text-light mt-2">Light</span>
                        <span class="badge border border-dark text-dark mt-2">Dark</span>
                        <h5 class="card-title mt-4">Pill badges</h5>
                        <p class="mb-0">Use the <code>.badge-pill</code> modifier class to make badges more rounded (with a larger <code>border-radius</code> and additional horizontal <code>padding</code>). Useful if you miss the badges from v3.</p>
                        <span class="badge badge-pill border border-primary text-primary mt-2">Primary</span>
                        <span class="badge badge-pill border border-secondary text-secondary mt-2">Secondary</span>
                        <span class="badge badge-pill border border-success text-success mt-2">Success</span>
                        <span class="badge badge-pill border border-danger text-danger mt-2">Danger</span>
                        <span class="badge badge-pill border border-warning text-warning mt-2 ">Warning</span>
                        <span class="badge badge-pill border border-info text-info mt-2">Info</span>
                        <span class="badge badge-pill border border-light text-light mt-2">Light</span>
                        <span class="badge badge-pill border border-dark text-dark mt-2">Dark</span>
                        <h5 class="card-title mt-4">Links</h5>
                        <p class="mb-0">Using the contextual <code>.badge-*</code> classes on an <code>&lt;a&gt;</code> element quickly provide <em>actionable</em> badges with hover and focus states.</p>
                        <a href="#" class="badge border border-primary text-primary mt-2">Primary</a>
                        <a href="#" class="badge border border-secondary text-secondary mt-2">Secondary</a>
                        <a href="#" class="badge border border-success text-success mt-2">Success</a>
                        <a href="#" class="badge border border-danger text-danger mt-2">Danger</a>
                        <a href="#" class="badge border border-warning text-warning mt-2">Warning</a>
                        <a href="#" class="badge border border-info text-info mt-2">Info</a>
                        <a href="#" class="badge border border-light text-light mt-2">Light</a>
                        <a href="#" class="badge border border-dark text-dark mt-2">Dark</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      
         
</x-app-layout>
