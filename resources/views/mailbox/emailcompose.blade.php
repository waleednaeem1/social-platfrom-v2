<x-app-layout>

     <div class="container">
        <div class="row row-eq-height">
            <div class="col-md-12">
                <div class="row">
                <div class="col-md-12">
                    <div class="card iq-border-radius-20">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12 mb-3">
                                <h5 class="text-primary card-title"><i class="ri-pencil-fill"></i> Compose Message</h5>
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
                                      <label class="ms-2 mb-0 bg-soft-primary rounded"><a href="#" class="material-symbols-outlined text-primary">
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
            </div>
        </div>
    </div>

</x-app-layout>