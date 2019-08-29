@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <span class="float-left">Dashboard</span>
                    <span class="float-right"><button type="button" class="btn btn-primary">Settings</button></span>
                </div>

                <div class="card-body">
                    <fieldset>
                        <legend>Custom forms</legend>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" checked="">
                                <label class="custom-control-label" for="customRadio1">Toggle this custom radio</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio2">Or toggle this other custom radio</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input" disabled="">
                                <label class="custom-control-label" for="customRadio3">Disabled custom radio</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                                <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2" disabled="">
                                <label class="custom-control-label" for="customCheck2">Disabled custom checkbox</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="">
                                <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" disabled="" id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2">Disabled switch element</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected="">Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
