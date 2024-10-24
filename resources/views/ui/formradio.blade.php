<x-app-layout>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card position-relative inner-page-bg bg-primary" style="height: 150px;">
                    <div class="inner-page-title">
                        <h3 class="text-white">Form Radio Page</h3>
                        <p class="text-white">lorem ipsum</p>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Default Radio Buttons</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                        <div class="form-check radio form-check-inline">
                            <input type="radio" name="bsradio" id="radio1" checked="">
                            <label for="radio1">Active</label>
                        </div>
                        <div class="form-check radio form-check-inline">
                            <input type="radio" name="bsradio" id="radio2">
                            <label for="radio2">Inactive</label>
                        </div>
                        <div class="form-check radio form-check-inline">
                            <input type="radio" name="bsradio1" id="radio3" disabled="" checked="">
                            <label for="radio3">Active - Disabled</label>
                        </div>
                        <div class="form-check radio form-check-inline">
                            <input type="radio" name="bsradio1" id="radio4" disabled="">
                            <label for="radio3">Inactive - Disabled</label>
                        </div>
                    </div>
                    </div>
                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Custom Colored Radio Buttons</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                        <div class="form-check custom-radio custom-radio-color form-check-inline">
                            <input type="radio" id="customRadio01" name="customRadio-11" class="form-check-input bg-primary">
                            <label class="form-check-label" for="customRadio01"> Primary </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color form-check-inline">
                            <input type="radio" id="customRadio02" name="customRadio-11" class="form-check-input bg-success">
                            <label class="form-check-label" for="customRadio02"> Success </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color form-check-inline">
                            <input type="radio" id="customRadio03" name="customRadio-11" class="form-check-input bg-danger">
                            <label class="form-check-label" for="customRadio03"> Danger </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color form-check-inline">
                            <input type="radio" id="customRadio04" name="customRadio-11" class="form-check-input bg-warning">
                            <label class="form-check-label" for="customRadio04"> Warning </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color form-check-inline">
                            <input type="radio" id="customRadio05" name="customRadio-11" class="form-check-input bg-dark">
                            <label class="form-check-label" for="customRadio05"> Dark </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color form-check-inline">
                            <input type="radio" id="customRadio06" name="customRadio-11" class="form-check-input bg-info">
                            <label class="form-check-label" for="customRadio06"> Info </label>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Custom Radio Buttons</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                        <div class="form-check custom-radio form-check-inline">
                            <input type="radio" id="customRadio6" name="customRadio-1" class="form-check-input">
                            <label class="form-check-label" for="customRadio6"> One </label>
                        </div>
                        <div class="form-check custom-radio form-check-inline">
                            <input type="radio" id="customRadio7" name="customRadio-1" class="form-check-input">
                            <label class="form-check-label" for="customRadio7"> Two </label>
                        </div>
                        <div class="form-check custom-radio form-check-inline">
                            <input type="radio" id="customRadio8" name="customRadio-1" class="form-check-input" checked="">
                            <label class="form-check-label" for="customRadio8"> Three </label>
                        </div>
                        <div class="form-check custom-radio form-check-inline">
                            <input type="radio" id="customRadio-8" name="customRadio-2" class="form-check-input" checked="">
                            <label class="form-check-label" for="customRadio-8"> Four Checked </label>
                        </div>
                        <div class="form-check custom-radio form-check-inline">
                            <input type="radio" id="customRadio9" name="customRadio-3" class="form-check-input" disabled="">
                            <label class="form-check-label" for="customRadio9"> Five disabled</label>
                        </div>
                        <div class="form-check custom-radio form-check-inline">
                            <input type="radio" id="customRadio10" name="customRadio-4" class="form-check-input" disabled="" checked="">
                            <label class="form-check-label" for="customRadio10"> Six Selected and  disabled</label>
                        </div>
                    </div>
                    </div>
                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Colored Radio Buttons</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                        <div class="form-check custom-radio custom-radio-color-checked form-check-inline">
                            <input type="radio" id="customRadio-1" name="customRadio-10" class="form-check-input">
                            <label class="form-check-label" for="customRadio-1"> Primary </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color-checked form-check-inline">
                            <input type="radio" id="customRadio-2" name="customRadio-10" class="form-check-input">
                            <label class="form-check-label" for="customRadio-2"> Success </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color-checked form-check-inline">
                            <input type="radio" id="customRadio-3" name="customRadio-10" class="form-check-input">
                            <label class="form-check-label" for="customRadio-3"> Danger </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color-checked form-check-inline">
                            <input type="radio" id="customRadio-4" name="customRadio-10" class="form-check-input">
                            <label class="form-check-label" for="customRadio-4"> Warning </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color-checked form-check-inline">
                            <input type="radio" id="customRadio-5" name="customRadio-10" class="form-check-input">
                            <label class="form-check-label" for="customRadio-5"> Dark </label>
                        </div>
                        <div class="form-check custom-radio custom-radio-color-checked form-check-inline">
                            <input type="radio" id="customRadio-6" name="customRadio-10" class="form-check-input">
                            <label class="form-check-label" for="customRadio-6"> Info </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>