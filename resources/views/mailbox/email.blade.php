<x-app-layout>
<div class="container relative">
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                <div class="">
                    <div class="iq-email-list">
                        <button class="btn btn-primary btn-lg btn-block mb-3 p-2 w-100 d-flex align-items-center" data-bs-target="#compose-email-popup" data-bs-toggle="modal"><i class="material-symbols-outlined me-2 writ-icon">
                        send
                        </i>New Message</button>
                        <div class="modal fade " id="compose-email-popup" tabindex="-1" aria-labelledby="compose-email-popupLabel" aria-hidden="true">
                           <div class="modal-dialog" style="max-width: 100%;">
                              <div class="modal-content">
                                 <div class="modal-header border-0 pb-0">
                                    <h5 class="text-primary float-left d-flex align-items-center  "><i class="material-symbols-outlined md-18 me-1">
                                       mode_edit
                                       </i> Compose Message
                                    </h5>
                                    <button type="submit" class="float-right close-popup" data-bs-dismiss="modal"><span class="material-symbols-outlined">
                                    clear
                                    </span></button>
                                 </div>
                                 <div class="modal-body">
                                    <form class="email-form">
                                       <div class="form-group row">
                                          <label for="inputEmail3" class="col-sm-2 col-form-label">To:</label>
                                          <div class="col-sm-10">
                                              <select  id="inputEmail3" class="select2jsMultiSelect form-control" multiple="multiple">
                                                <option value="Petey Cruiser">Petey Cruiser</option>
                                                <option value="Bob Frapples">Bob Frapples</option>
                                                <option value="Barb Ackue">Barb Ackue</option>
                                                <option value="Greta Life">Greta Life</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group row">
                                          <label for="cc" class="col-sm-2 col-form-label">Cc:</label>
                                          <div class="col-sm-10">
                                             <select  id="cc" class="select2jsMultiSelect form-control" multiple="multiple">
                                                <option value="Brock Lee">Brock Lee</option>
                                                <option value="Rick O'Shea">Rick O'Shea</option>
                                                <option value="Cliff Hanger">Cliff Hanger</option>
                                                <option value="Barb Dwyer">Barb Dwyer</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group row">
                                          <label for="subject" class="col-sm-2 col-form-label">Subject:</label>
                                          <div class="col-sm-10">
                                             <input type="text"  id="subject" class="form-control">
                                          </div>
                                       </div>
                                       <div class="form-group row">
                                          <label for="subject" class="col-sm-2 col-form-label">Your Message:</label>
                                          <div class="col-md-10">
                                             <textarea class="textarea form-control" rows="5">Next, use our Get Started docs to setup Tiny!</textarea>
                                          </div>
                                       </div>
                                       <div class="form-group d-flex justify-content-between align-items-center compose-bottom pt-3 m-0">
                                          <div class="d-flex flex-grow-1 align-items-center">
                                             <div class="send-btn">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                             </div>
                                             <div class="send-panel">
                                                <label class="ms-2 mb-0 bg-soft-primary rounded" for="file"> <input type="file" id="file" style="display: none"> <a href="#" class="material-symbols-outlined writ-icon text-primary">
                                                attachment
                                                </a> </label>
                                                <label class="ms-2 mb-0 bg-soft-primary rounded"> <a href="#" class="material-symbols-outlined text-primary">
                                                place
                                                </a>  </label>
                                                <label class="ms-2 mb-0 bg-soft-primary rounded"> <a href="#" class="material-symbols-outlined text-primary"> 
                                                add_to_drive
                                                </a>  </label>
                                                <label class="ms-2 mb-0 bg-soft-primary rounded"> <a href="#" class="material-symbols-outlined text-primary"> 
                                                photo_camera
                                                </a>  </label>
                                                <label class="ms-2 mb-0 bg-soft-primary rounded"> <a href="#" class="material-symbols-outlined text-primary"> 
                                                sentiment_satisfied
                                                </a>  </label>
                                             </div>
                                          </div>
                                          <div class="d-flex align-items-center">
                                             <div class="send-panel float-right">
                                                <label class="ms-2 mb-0 bg-soft-primary rounded" ><a href="#" class="material-symbols-outlined text-primary">
                                                settings
                                                </a></label>
                                                <label class="ms-2 mb-0 bg-soft-primary rounded"><a href="#" class="material-symbols-outlined">  
                                                delete
                                                </a>  </label>
                                             </div>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="iq-email-ui nav flex-column nav-pills">
                           <a class="nav-link active" role="button" data-bs-toggle="pill" href="#mail-inbox">
                              <div class="d-flex align-items-center justify-content-between"><span class="d-flex align-items-center"><i class="material-symbols-outlined md-18">
                                 mail
                                 </i>Inbox</span><span class="badge bg-primary ms-2">4</span>
                              </div>
                           </a>
                           <a class="nav-link d-flex align-items-center" role="button" data-bs-toggle="pill" href="#mail-starred"><i class="material-symbols-outlined md-18">
                           star_border
                           </i>Starred</a>
                           <a class="nav-link d-flex align-items-center" role="button" data-bs-toggle="pill" href="#mail-snoozed"><i class="material-symbols-outlined md-18">
                           watch_later
                           </i>Snoozed</a>
                           <a class="nav-link d-flex align-items-center" role="button" data-bs-toggle="pill" href="#mail-draft"><i class="material-symbols-outlined md-18">
                           article
                           </i>Draft</a>
                           <a class="nav-link d-flex align-items-center" role="button" data-bs-toggle="pill" href="#mail-sent"><i class="material-symbols-outlined md-18">
                           forward_to_inbox
                           </i>Sent Mail</a>
                           <a class="nav-link d-flex align-items-center" role="button" data-bs-toggle="pill" href="#mail-trash"><i class="material-symbols-outlined md-18">
                           delete_outline
                           </i>Trash</a>
                           <a class="nav-link d-flex align-items-center" role="button" data-bs-toggle="pill" href="#mail-important"><i class="material-symbols-outlined md-18">
                           turned_in_not
                           </i>Important</a>
                           <a class="nav-link d-flex align-items-center" role="button" data-bs-toggle="pill" href="#mail-spam"><i class="material-symbols-outlined md-18">
                           report_gmailerrorred
                           </i>Spam</a>
                        </div>
                        <h6 class="mt-4 mb-3">Labels</h6>
                        <ul class="iq-email-ui iq-email-label list-inline p-0 m-0">
                           <li><a href="#" class="d-flex align-items-center"><i class="material-symbols-outlined md-18 text-primary">
                              trip_origin
                              </i>Personal</a>
                           </li>
                           <li><a href="#" class="d-flex align-items-center"><i class="material-symbols-outlined md-18 text-warning">
                              trip_origin
                              </i>Company</a>
                           </li>
                           <li><a href="#" class="d-flex align-items-center"><i class="material-symbols-outlined md-18 text-success">
                              trip_origin
                              </i>Important</a>
                           </li>
                           <li><a href="#" class="d-flex align-items-center"><i class="material-symbols-outlined md-18 text-info">
                              trip_origin
                              </i>Private</a>
                           </li>
                           <li><a href="#" class="d-flex align-items-center"><i class="material-symbols-outlined md-18 text-warning">
                              trip_origin
                              </i>Private</a>
                           </li>
                           <li><a href="#" class="d-flex align-items-center"><i class="material-symbols-outlined md-18">add_circle_outline</i>Add New Labels</a></li>
                        </ul>
                        <div class="iq-progress-bar-linear d-inline-block w-100">
                           <h6 class="mt-4 mb-3">Storage</h6>
                           <div class="iq-progress-bar">
                              <span class="bg-danger" data-percent="90"></span>
                           </div>
                           <span class="mt-1 d-inline-block w-100">7.02 GB (46%) of 15 GB used</span>
                        </div>
                     </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 mail-box-detail">
            <div class="card">
                <div class="card-body p-0">
                <div class="">
                    <div class="iq-email-to-list p-3">
                        <div class="iq-email-to-list-detail d-flex justify-content-between">
                            <ul class="list-inline d-flex align-items-center justify-content-between m-0 p-0">
                               <li class="me-1">
                                  <div id="navbarDropdown" data-bs-toggle="dropdown">
                                     <div class="d-flex align-items-center form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label d-flex align-items-center" for="customCheck1"><i class="material-symbols-outlined">
                                        expand_more
                                        </i></label>
                                     </div>
                                  </div>
                                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                     <a class="dropdown-item" href="#">Action</a>
                                     <a class="dropdown-item" href="#">Another action</a>
                                     <div class="dropdown-divider"></div>
                                     <a class="dropdown-item" href="#">Something else here</a>
                                  </div>
                               </li>
                               <li class="me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Reload"><a href="#" class="d-flex align-items-center justify-content-center"><i class="material-symbols-outlined md-16">
                                  refresh
                                  </i></a>
                               </li>
                               <li class="me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive"><a href="#" class="d-flex align-items-center justify-content-center"><i class="material-symbols-outlined md-16">
                                  drafts
                                  </i></a>
                               </li>
                               <li class="me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><a href="#" class="d-flex align-items-center justify-content-center"><i class="material-symbols-outlined md-16">
                                  delete
                                  </i></a>
                               </li>
                               <li class="me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Inbox"><a href="#" class="d-flex align-items-center justify-content-center"><i class="material-symbols-outlined md-16">
                                  mark_email_unread
                                  </i></a>
                               </li>
                               <li data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom"><a href="#" class="d-flex align-items-center justify-content-center"><i class="material-symbols-outlined md-16">
                                  zoom_out_map
                                  </i></a>
                               </li>
                            </ul>
                            <div class="iq-email-search d-flex">
                               <form class="me-2 position-relative searchbox">
                                  <div class="form-group mb-0">
                                     <input type="email" class="form-control search-input" id="exampleInputEmail1" placeholder="Search">
                                     <a class="search-link" href="#"><i class="material-symbols-outlined">
                                     search
                                     </i></a>
                                  </div>
                               </form>
                               <ul class="list-inline d-flex align-items-center justify-content-between m-0 p-0">
                                  <li class="me-2">
                                     <a class="font-size-14" href="#" id="navbarDropdown1" data-bs-toggle="dropdown">
                                     1 - 50 of 505
                                     </a>
                                     <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                        <a class="dropdown-item" href="#">20 per page</a>
                                        <a class="dropdown-item" href="#">50 per page</a>
                                        <a class="dropdown-item" href="#">100 per page</a>
                                     </div>
                                  </li>
                                  <li class="me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Previous"><a href="#" class="material-symbols-outlined">
                                     keyboard_arrow_left
                                     </a>
                                  </li>
                                  <li class="me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Next"><a href="#" class="material-symbols-outlined">
                                     keyboard_arrow_right</a>
                                  </li>
                                  <li class="me-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Setting"><a href="#"  class="material-symbols-outlined">settings</a></li>
                               </ul>
                            </div>
                         </div>
                    </div>
                    <div class="iq-email-listbox">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="mail-inbox" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li class="iq-unread">
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk">
                                                <label class="form-check-label" for="mailk"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle text-warning"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@MackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@MackenzieBnio - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">08:00 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div> 
                                            
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                        
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk1">
                                                <label class="form-check-label" for="mailk1"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Deray Billings (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Megan Allen (@meganallen) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">08:15 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk2">
                                                <label class="form-check-label" for="mailk2"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Dixa Horton (@dixahorton) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk3">
                                                <label class="form-check-label" for="mailk3"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk4">
                                                <label class="form-check-label" for="mailk4"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre (@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li class="iq-unread">
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk017">
                                                <label class="form-check-label" for="mailk017"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle text-warning"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk6">
                                                <label class="form-check-label" for="mailk6"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk7">
                                                <label class="form-check-label" for="mailk7"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Deray Billings (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li class="iq-unread">
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk8">
                                                <label class="form-check-label" for="mailk8"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle text-warning"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre (@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk9">
                                                <label class="form-check-label" for="mailk9"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk011">
                                                <label class="form-check-label" for="mailk011"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk11">
                                                <label class="form-check-label" for="mailk11"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk12">
                                                <label class="form-check-label" for="mailk12"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk13">
                                                <label class="form-check-label" for="mailk13"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Deray Billings (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg(@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk14">
                                                <label class="form-check-label" for="mailk14"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk15">
                                                <label class="form-check-label" for="mailk15"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre(@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>                                    
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk16">
                                                <label class="form-check-label" for="mailk16"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>                                    
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk17">
                                                <label class="form-check-label" for="mailk17"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                            </ul>
                            </div>
                            <div class="tab-pane fade" id="mail-starred" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk02">
                                                <label class="form-check-label" for="mailk02"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Dixa Horton (@dixahorton) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk03">
                                                <label class="form-check-label" for="mailk03"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk04">
                                                <label class="form-check-label" for="mailk04"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre (@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                     
                                </li>
                                <li class="iq-unread">
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk5">
                                                <label class="form-check-label" for="mailk5"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle text-warning"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk018">
                                                <label class="form-check-label" for="mailk018"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                            </ul>
                            </div>
                            <div class="tab-pane fade" id="mail-snoozed" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk004">
                                                <label class="form-check-label" for="mailk004"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre (@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li class="iq-unread">
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk012">
                                                <label class="form-check-label" for="mailk012"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle text-warning"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk024">
                                                <label class="form-check-label" for="mailk024"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                            </ul>
                            </div>
                            <div class="tab-pane fade" id="mail-draft" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk09">
                                                <label class="form-check-label" for="mailk09"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk013">
                                                <label class="form-check-label" for="mailk013"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk014">
                                                <label class="form-check-label" for="mailk014"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk019">
                                                <label class="form-check-label" for="mailk019"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk025">
                                                <label class="form-check-label" for="mailk025"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Deray Billings (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg(@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                            </ul>
                            </div>
                            <div class="tab-pane fade" id="mail-sent" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk015">
                                                <label class="form-check-label" for="mailk015"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk020">
                                                <label class="form-check-label" for="mailk020"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk026">
                                                <label class="form-check-label" for="mailk026"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Deray Billings (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg(@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk027">
                                                <label class="form-check-label" for="mailk027"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk032">
                                                <label class="form-check-label" for="mailk032"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre(@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk037">
                                                <label class="form-check-label" for="mailk037"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                            </ul>
                            </div>
                            <div class="tab-pane fade" id="mail-trash" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk028">
                                                <label class="form-check-label" for="mailk028"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk033">
                                                <label class="form-check-label" for="mailk033"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre(@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk038">
                                                <label class="form-check-label" for="mailk038"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                            </ul>
                            </div>
                            <div class="tab-pane fade" id="mail-important" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk029">
                                                <label class="form-check-label" for="mailk029"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk034">
                                                <label class="form-check-label" for="mailk034"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Deray Billings (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li class="iq-unread">
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk035">
                                                <label class="form-check-label" for="mailk035"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle text-warning"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre (@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk009">
                                                <label class="form-check-label" for="mailk009"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk010">
                                                <label class="form-check-label" for="mailk010"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk016">
                                                <label class="form-check-label" for="mailk016"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                            </ul>
                            </div>
                            <div class="tab-pane fade" id="mail-spam" role="tabpanel">
                            <ul class="iq-email-sender-list">
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk021">
                                                <label class="form-check-label" for="mailk021"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Jopour Xiong (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Mackenzie Bnio (@mackenzieBnio) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk023">
                                                <label class="form-check-label" for="mailk023"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Deray Billings (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg(@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk030">
                                                <label class="form-check-label" for="mailk030"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Lauren Drury (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk031">
                                                <label class="form-check-label" for="mailk031"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Fabian Ros (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Let Hunre(@lethunre) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk036">
                                                <label class="form-check-label" for="mailk036"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Dixa Horton (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Eb Begg (@ebbegg) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-self-center iq-unread-inner">
                                        <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="mailk040">
                                                <label class="form-check-label" for="mailk040"></label>
                                            </div>
                                        </div>
                                        <span class="ri-star-line iq-star-toggle"></span>
                                        <a href="#" class="iq-email-title">Megan Allen (Me)</a>
                                        </div>
                                        <div class="iq-email-content">
                                        <a href="#" class="iq-email-subject">Jecno Mac (@jecnomac) has sent
                                        you a direct message on Twitter! &nbsp;–&nbsp;
                                        <span>@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span>
                                        </a>
                                        <div class="iq-email-date">11:49 am</div>
                                        </div>
                                        <ul class="iq-social-media list-inline">
                                            <li><a href="#" class="material-symbols-outlined">delete_forever</a></li>
                                            <li><a href="#" class="material-symbols-outlined">mail_outline</a></li>
                                            <li><a href="#" class="material-symbols-outlined">article</a></li>
                                            <li><a href="#" class="material-symbols-outlined">watch_later</a></li>
                                         </ul>
                                    </div>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div id="compose-email-popup" class="compose-popup modal modal-sticky-bottom-right modal-sticky-lg">
            <div class="card iq-border-radius-20 mb-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12 mb-3">
                            <h5 class="text-primary float-left"><i class="ri-pencil-fill"></i> Compose Message</h5>
                            <button type="submit" class="close-popup" data-dismiss="modal"><i class="ri-close-fill"></i></button>
                        </div>
                    </div>
                    <form class="email-form">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">To:</label>
                            <div class="col-sm-10">
                                <select  id="inputEmail3" class="select2jsMultiSelect form-control" multiple="multiple">
                                    <option value="Petey Cruiser">Petey Cruiser</option>
                                    <option value="Bob Frapples">Bob Frapples</option>
                                    <option value="Barb Ackue">Barb Ackue</option>
                                    <option value="Greta Life">Greta Life</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cc" class="col-sm-2 col-form-label">Cc:</label>
                            <div class="col-sm-10">
                                <select  id="cc" class="select2jsMultiSelect form-control" multiple="multiple">
                                    <option value="Brock Lee">Brock Lee</option>
                                    <option value="Rick O'Shea">Rick O'Shea</option>
                                    <option value="Cliff Hanger">Cliff Hanger</option>
                                    <option value="Barb Dwyer">Barb Dwyer</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subject" class="col-sm-2 col-form-label">Subject:</label>
                            <div class="col-sm-10">
                                <input type="text"  id="subject" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subject" class="col-sm-2 col-form-label">Your Message:</label>
                            <div class="col-md-10">
                                <textarea class="textarea form-control" rows="5">Next, use our Get Started docs to setup Tiny!</textarea>
                            </div>
                        </div>
                        <div class="form-group row align-items-center compose-bottom pt-3 m-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <div class="send-btn">
                                <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                                <div class="send-panel">
                                <label class="ms-2 mb-0 soft-bg-primary rounded" for="file"> <input type="file" id="file" style="display: none"> <a><i class="ri-attachment-line"></i> </a> </label>
                                <label class="ms-2 mb-0 soft-bg-primary rounded"> <a href="javascript:void();"> <i class="ri-map-pin-user-line text-primary"></i></a>  </label>
                                <label class="ms-2 mb-0 soft-bg-primary rounded"> <a href="javascript:void();"> <i class="ri-drive-line text-primary"></i></a>  </label>
                                <label class="ms-2 mb-0 soft-bg-primary rounded"> <a href="javascript:void();"> <i class="ri-camera-line text-primary"></i></a>  </label>
                                <label class="ms-2 mb-0 soft-bg-primary rounded"> <a href="javascript:void();"> <i class="ri-user-smile-line text-primary"></i></a>  </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="send-panel">
                                    <label class="ms-2 mb-0 soft-bg-primary rounded" ><a href="javascript:void();"><i class="ri-settings-2-line text-primary"></i></a></label>
                                    <label class="ms-2 mb-0 soft-bg-primary rounded"><a href="javascript:void();"><i class="ri-delete-bin-line text-primary"></i></a>  </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>