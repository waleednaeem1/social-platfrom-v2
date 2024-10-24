<!-- Setting offcanvas start here -->
<div class="offcanvas offcanvas-end live-customizer" tabindex="-1" id="live-customizer" data-bs-backdrop="false" data-bs-scroll="true" aria-labelledby="live-customizer-label">
    <div class="offcanvas-header pb-0">
        <div class="d-flex align-items-center">
            <h4 class="offcanvas-title" id="live-customizer-label">Setting Pannel</h4>
        </div>
        <div class="close-icon" data-bs-dismiss="offcanvas">
            <svg xmlns="http://www.w3.org/2000/svg"  width="24px" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    <div class="offcanvas-body data-scrollbar">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="text-center mb-4">
                        <h5 class="d-inline-block">Style Setting</h5>
                    </div>
                    <div>
                        <!-- Theme start here -->
                        <div class="mb-4">
                            <h5 class="mb-3">Theme</h5>
                            <div class=" mb-3" data-setting="radio">
                                <div class="form-check mb-0 w-100" >
                                    <input class="form-check-input custum-redio-btn" type="radio" value="light" name="theme_scheme" id="color-mode-light" checked>
                                    <label class="form-check-label h6 d-flex align-items-center justify-content-between" for="color-mode-light">
                                       <span>Light Theme</span> 
                                        <div class="text-primary ">
                                            <svg width="60" height="27" viewBox="0 0 60 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.375" y="0.375" width="59.25" height="26.25" rx="4.125" fill="white"/>
                                                <circle cx="9.75" cy="9.75" r="3.75" fill="#80868B"/>
                                                <rect x="16.5" y="8.25" width="37.5" height="3" rx="1.5" fill="#DADCE0"/>
                                                <rect x="6" y="18" width="48" height="3" rx="1.5" fill="currentColor"/>
                                                <rect x="0.375" y="0.375" width="59.25" height="26.25" rx="4.125" stroke="#DADCE0" stroke-width="0.75"/>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            </div>
                             <div class=" mb-3" data-setting="radio">
                                <div class="form-check mb-0 w-100 ">
                                    <input class="form-check-input custum-redio-btn" type="radio" value="dark"  name="theme_scheme" id="color-mode-dark">
                                    <label class="form-check-label h6 d-flex align-items-center justify-content-between"  for="color-mode-dark">
                                       <span>Dark Theme</span>
                                       <div class="text-primary ">
                                           <svg width="60" height="27" viewBox="0 0 60 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.375" y="0.375" width="59.25" height="26.25" rx="4.125" fill="#1E2745"/>
                                                <circle cx="9.75" cy="9.75" r="3.75" fill="#80868B"/>
                                                <rect x="16.5" y="8.25" width="37.5" height="3" rx="1.5" fill="#DADCE0"/>
                                                <rect x="6" y="18" width="48" height="3" rx="1.5" fill="currentColor"/>
                                                <rect x="0.375" y="0.375" width="59.25" height="26.25" rx="4.125" stroke="currentColor" stroke-width="0.75"/>
                                            </svg>
                                       </div>                                    
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between" data-setting="radio">
                                <div class="form-check mb-0 w-100">
                                    <input class="form-check-input custum-redio-btn" type="radio" value="auto"  name="theme_scheme" id="color-mode-auto">
                                    <label class="form-check-label h6 d-flex align-items-center justify-content-between"  for="color-mode-auto">
                                       <span>Device Default</span> 
                                       <div class="text-primary ">
                                            <svg class="rounded" width="60" height="27" viewBox="0 0 60 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="0.375" y="0.375" width="59.25" height="26.25" rx="4.125" fill="#1E2745"/>
                                                <circle cx="9.75" cy="9.75" r="3.75" fill="#80868B"/>
                                                <rect x="16.5" y="8.25" width="37.5" height="3" rx="1.5" fill="#DADCE0"/>
                                                <rect x="6" y="18" width="48" height="3" rx="1.5" fill="currentColor"/>
                                                <g clip-path="url(#clip0_507_92)">
                                                <rect width="30" height="27" fill="white"/>
                                                <circle cx="9.75" cy="9.75" r="3.75" fill="#80868B"/>
                                                <rect x="16.5" y="8.25" width="37.5" height="3" rx="1.5" fill="#DADCE0"/>
                                                <rect x="6" y="18" width="48" height="3" rx="1.5" fill="currentColor"/>
                                                </g>
                                                <rect x="0.375" y="0.375" width="59.25" height="26.25" rx="4.125" stroke="#DADCE0" stroke-width="0.75"/>
                                                <defs>
                                                <clipPath id="clip0_507_92">
                                                <rect width="30" height="27" fill="white"/>
                                                </clipPath>
                                                </defs>
                                            </svg>
                                       </div>
                                    </label>
                                </div>
                                
                            </div>
                        </div>
                        <!-- Color customizer end here -->
                        @if(!activeRoute('withoutleftsidebar'))
                        <hr class="hr-horizontal">
                        <!-- Menu Style start here -->
                        <div>
                            <h5 class="mt-4 mb-3">Menu Style</h5>
                            <div class="d-grid gap-3 grid-cols-3 mb-4">
                                <div data-setting="checkbox" class="text-center">
                                    <input type="checkbox" value="sidebar-mini" class="btn-check" name="sidebar_type" id="sidebar-mini">
                                    <label class="btn btn-border btn-setting-panel d-block overflow-hidden" for="sidebar-mini">
                                        Mini
                                    </label>
                                </div>
                                <div data-setting="checkbox" class="text-center">
                                    <input type="checkbox" value="sidebar-hover" data-extra="{target: '.sidebar', ClassListAdd: 'sidebar-mini'}"
                                        class="btn-check" name="sidebar_type" id="sidebar-hover">
                                    <label class="btn btn-border btn-setting-panel d-block overflow-hidden" for="sidebar-hover">
                                        Hover
                                    </label>
                                </div>
                                <div data-setting="checkbox" class="text-center">
                                    <input type="checkbox" value="sidebar-soft" class="btn-check" name="sidebar_type" id="sidebar-soft">
                                    <label class="btn btn-border btn-setting-panel d-block overflow-hidden" for="sidebar-soft">
                                        Soft
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Style end here -->

                        <hr class="hr-horizontal">

                        <!-- Active Menu Style start here -->

                        <div class="mb-4">
                            <h5 class="mt-4 mb-3">Active Menu Style</h5>
                            <div class="d-grid gap-3 grid-cols-2">
                                <div data-setting="radio" class="text-center">
                                    <input type="radio" value="navs-rounded" class="btn-check" name="sidebar_menu_style" id="navs-rounded">
                                    <label class="btn btn-border btn-setting-panel d-block overflow-hidden" for="navs-rounded">
                                        Rounded One
                                    </label>
                                </div>
                                <div data-setting="radio" class="text-center">
                                    <input type="radio" value="navs-rounded-all" class="btn-check" name="sidebar_menu_style" id="navs-rounded-all">
                                    <label class="btn btn-border btn-setting-panel d-block overflow-hidden" for="navs-rounded-all">
                                        Rounded All
                                    </label>
                                </div>
                                <div data-setting="radio" class="text-center">
                                    <input type="radio" value="navs-pill" class="btn-check" name="sidebar_menu_style" id="navs-pill">
                                    <label class="btn btn-border btn-setting-panel d-block overflow-hidden" for="navs-pill">
                                        Pill One Side
                                    </label>
                                </div>
                                <div data-setting="radio" class="text-center">
                                    <input type="radio" value="navs-pill-all" class="btn-check" name="sidebar_menu_style" id="navs-pill-all">
                                    <label class="btn btn-border btn-setting-panel d-block overflow-hidden" for="navs-pill-all">
                                        Pill All
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                         <hr class="hr-horizontal">
                        <!-- Color customizer start here -->
                        <div>
                            <div class="d-flex align-items-center justify-content-between my-3">
                                <h5>Color Customizer</h5>
                                <div class="d-flex align-items-center">
                                    <div data-setting="radio">
                                        <input type="radio" value="theme-color-default" class="btn-check" name="theme_color" id="theme-color-default" data-colors='{"primary": "#3a57e8", "info": "#08B1BA"}'>
                                        <label class="btn bg-transparent" for="theme-color-default" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Color" data-bs-original-title="Reset color">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M21.4799 12.2424C21.7557 12.2326 21.9886 12.4482 21.9852 12.7241C21.9595 14.8075 21.2975 16.8392 20.0799 18.5506C18.7652 20.3986 16.8748 21.7718 14.6964 22.4612C12.518 23.1505 10.1711 23.1183 8.01299 22.3694C5.85488 21.6205 4.00382 20.196 2.74167 18.3126C1.47952 16.4293 0.875433 14.1905 1.02139 11.937C1.16734 9.68346 2.05534 7.53876 3.55018 5.82945C5.04501 4.12014 7.06478 2.93987 9.30193 2.46835C11.5391 1.99683 13.8711 2.2599 15.9428 3.2175L16.7558 1.91838C16.9822 1.55679 17.5282 1.62643 17.6565 2.03324L18.8635 5.85986C18.945 6.11851 18.8055 6.39505 18.549 6.48314L14.6564 7.82007C14.2314 7.96603 13.8445 7.52091 14.0483 7.12042L14.6828 5.87345C13.1977 5.18699 11.526 4.9984 9.92231 5.33642C8.31859 5.67443 6.8707 6.52052 5.79911 7.74586C4.72753 8.97119 4.09095 10.5086 3.98633 12.1241C3.8817 13.7395 4.31474 15.3445 5.21953 16.6945C6.12431 18.0446 7.45126 19.0658 8.99832 19.6027C10.5454 20.1395 12.2278 20.1626 13.7894 19.6684C15.351 19.1743 16.7062 18.1899 17.6486 16.8652C18.4937 15.6773 18.9654 14.2742 19.0113 12.8307C19.0201 12.5545 19.2341 12.3223 19.5103 12.3125L21.4799 12.2424Z" fill="#31BAF1"/>
                                                    <path d="M20.0941 18.5594C21.3117 16.848 21.9736 14.8163 21.9993 12.7329C22.0027 12.4569 21.7699 12.2413 21.4941 12.2512L19.5244 12.3213C19.2482 12.3311 19.0342 12.5633 19.0254 12.8395C18.9796 14.283 18.5078 15.6861 17.6628 16.8739C16.7203 18.1986 15.3651 19.183 13.8035 19.6772C12.2419 20.1714 10.5595 20.1483 9.01246 19.6114C7.4654 19.0746 6.13845 18.0534 5.23367 16.7033C4.66562 15.8557 4.28352 14.9076 4.10367 13.9196C4.00935 18.0934 6.49194 21.37 10.008 22.6416C10.697 22.8908 11.4336 22.9852 12.1652 22.9465C13.075 22.8983 13.8508 22.742 14.7105 22.4699C16.8889 21.7805 18.7794 20.4073 20.0941 18.5594Z" fill="#0169CA"/>
                                                </svg>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-cols-5 mb-4 d-grid gap-3">
                                <div data-setting="radio">
                                    <input type="radio" value="theme-color-blue" class="btn-check" name="theme_color"
                                        id="theme-color-1" data-colors='{"primary": "#4285F4", "info": "#EA4335"}'>
                                    <label class="btn btn-border d-block bg-transparent p-2" for="theme-color-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Gmail" data-bs-original-title="Gmail">
                                        <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                            <circle cx="12" cy="12" r="10" fill="#4285F4" />
                                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#EA4335" />
                                        </svg>
                                    </label>
                                </div>
                                <div data-setting="radio">
                                    <input type="radio" value="theme-color-red" class="btn-check" name="theme_color" id="theme-color-2" data-colors='{"primary": "#FF4500", "info": "#1A73E8"}'>
                                    <label class="btn btn-border  d-block bg-transparent p-2" for="theme-color-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Reddit" data-bs-original-title="Reddit">
                                        <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                            <circle cx="12" cy="12" r="10" fill="#FF4500" />
                                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#1A73E8" />
                                        </svg>
                                    </label>
                                </div>
                                <div data-setting="radio">
                                    <input type="radio" value="theme-color-purple" class="btn-check" name="theme_color" id="theme-color-3" data-colors='{"primary": "#5C16C5", "info": "#EE4266"}'>
                                    <label class="btn btn-border d-block bg-transparent p-2" for="theme-color-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitch" data-bs-original-title="Twitch">
                                        <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                            <circle cx="12" cy="12" r="10" fill="#5C16C5" />
                                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#EE4266" />
                                        </svg>
                                    </label>
                                </div>
                                <div data-setting="radio">
                                    <input type="radio" value="theme-color-cyan" class="btn-check" name="theme_color" id="theme-color-4" data-colors='{"primary": "#0A66C2", "info": "#333333"}'>
                                    <label class="btn btn-border d-block bg-transparent p-2" for="theme-color-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Linkdin" data-bs-original-title="Linkdin">
                                        <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                            <circle cx="12" cy="12" r="10" fill="#0A66C2" />
                                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#333333" />
                                        </svg>
                                    </label>
                                </div>
                                <div data-setting="radio">
                                    <input type="radio" value="theme-color-green" class="btn-check" name="theme_color" id="theme-color-5" data-colors='{"primary": "#0B9D43", "info": "#000000"}'>
                                    <label class="btn btn-border d-block bg-transparent p-2" for="theme-color-5" data-bs-toggle="tooltip" data-bs-placement="top" title="Spotify" data-bs-original-title="Spotify">
                                        <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                            <circle cx="12" cy="12" r="10" fill="#0B9D43" />
                                            <path d="M2,12 a1,1 1 1,0 20,0" fill="#000000" />
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                          <!-- Theme end here -->
                        <hr class="hr-horizontal">
                        <div>
                            <h5 class="mb-3 mt-4">Direction</h5>
                            <div class=" mb-3" data-setting="radio">
                                <div class="form-check mb-0 w-100">
                                    <input class="form-check-input custum-redio-btn" type="radio" value="ltr" name="theme_scheme_direction" data-prop="dir" id="theme-scheme-direction-ltr" checked>
                                    <label class="form-check-label h6 d-flex align-items-center justify-content-between"  for="theme-scheme-direction-ltr">
                                       <span>LTR</span>
                                        <svg width="60" height="27" viewBox="0 0 60 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="11.5" cy="13.5002" r="6.5" fill="#50B5FF"/>
                                            <rect x="21" y="7.70026" width="34" height="5" rx="2" fill="#80868B"/>
                                            <rect opacity="0.5" x="21" y="16.1003" width="25.6281" height="3.2" rx="1.6" fill="#80868B"/>
                                            <rect x="0.375" y="0.375244" width="59.25" height="26.25" rx="4.125" stroke="#DADCE0" stroke-width="0.75"/>
                                        </svg>
                                    </label>
                                </div>
                               
                            </div>
                             <div class="mb-3" data-setting="radio">
                                <div class="form-check mb-0 w-100">
                                    <input class="form-check-input custum-redio-btn" type="radio" value="rtl" class="btn-check" name="theme_scheme_direction" data-prop="dir" id="theme-scheme-direction-rtl">
                                    <label class="form-check-label h6 d-flex align-items-center justify-content-between "  for="theme-scheme-direction-rtl">
                                        <span>RTL</span>
                                        <svg width="60" height="27" viewBox="0 0 60 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle r="6.5" transform="matrix(-1 0 0 1 48.5 13.5002)" fill="#50B5FF"/>
                                            <rect width="34" height="5" rx="2" transform="matrix(-1 0 0 1 39 7.70026)" fill="#80868B"/>
                                            <rect opacity="0.5" width="25.6281" height="3.2" rx="1.6" transform="matrix(-1 0 0 1 39 16.1003)" fill="#80868B"/>
                                            <rect x="-0.375" y="0.375" width="59.25" height="26.25" rx="4.125" transform="matrix(-1 0 0 1 59.25 0.000244141)" stroke="#50B5FF" stroke-width="0.75"/>
                                        </svg>
                                    </label>
                                </div>
                                
                            </div>
                        </div>
                        <!-- Theme end here -->
                        <!-- Active Menu Style end here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Settings sidebar end here -->

{{-- <a class="btn btn-fixed-end btn-danger btn-icon btn-setting" id="settingbutton"
    data-bs-toggle="offcanvas" data-bs-target="#live-customizer" role="button" aria-controls="live-customizer">
    <span class="icon material-symbols-outlined animated-rotate text-white">
        settings
    </span>
</a> --}}