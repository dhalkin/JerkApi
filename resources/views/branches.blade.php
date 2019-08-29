@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card bg-light mb-3">
                <div class="card-header">
                    <span class="float-left">Branches</span>
                </div>

                <div class="card-body">

                    <img src="/pictures/200x200.jpg" class="img-fluid rounded float-left mr-4" v-bind:class="isMobileViewImg" alt="200x200">

                    <div class="form-group">
                        <fieldset disabled="">

                            <label class="col-form-label" for="name" v-bind:class="isMobileViewFormLabel">Name</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="name" type="text" placeholder="Some text" disabled="">

                            <label class="control-label" for="address">Address</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="address" type="text" placeholder="Some address" disabled="">

                            <label for="notes">Notes</label>
                            <textarea class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="notes" rows="3">Thare are some notes about that studio, might be kind of additional information</textarea>
                        </fieldset>
                    </div>

                    <div class="float-left">

                        <span class="badge badge-primary">Branches: 3</span>
                        <span class="badge badge-warning">Trainers: 6</span>
                        <span class="badge badge-light">Trainee: 17</span>

                    </div>

                    <div class="float-right">

                        <button type="button" class="btn btn-primary">Statistics</button>
                        <button type="button" class="btn btn-danger">Edit Info</button>

                    </div>

                    <br style="clear: both"/>

                    <div class="form-group">
                        <label >Einde voorverkoop periode</label>
                        <input type="date" name="bday" min="1000-01-01"
                               max="3000-12-31" class="form-control">
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
