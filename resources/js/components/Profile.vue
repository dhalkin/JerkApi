<template>
    <div class="container">

        <!-- to show card as card on deck -->
        <div class="card-deck">

            <div class="card bg-light">
                <div class="card-header text-left">Profile : <span class="badge badge-danger">Owner</span></div>

                <div class="card-body">
                    <table>
                        <tr>
                            <td>
                                <img src="/pictures/100x100.jpg" class="rounded-circle mr-4">
                            </td>
                            <td>
                                <form>
                                    <p class="card-text">Choose file for avatar, you can select .jpg, .png file.</p>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>

                    <div class="form-group">
                        <fieldset>

                            <label class="col-form-label" for="first-name" v-bind:class="isMobileViewFormLabel">First name *</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="first-name" type="text">

                            <label class="control-label" for="second-name" v-bind:class="isMobileViewFormLabel">Second name</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="second-name" type="text">

                            <label class="control-label" for="email" v-bind:class="isMobileViewFormLabel">Email *</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="email" type="email">

                        </fieldset>
                    </div>

                    <div class="float-right">
                        <button type="button" class="btn btn-danger">Save</button>
                    </div>

                </div>
            </div>

            <!-- next card Settings-->
            <div class="card bg-light">
                <div class="card-header text-left h5">Company Settings</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <td>
                                <img src="/pictures/100x100.jpg" class="rounded-circle mr-4">
                            </td>
                            <td>
                                <form>
                                    <p class="card-text">Choose file for company LOGO, you can select .jpg, .png file.</p>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>

                    <div class="form-group">
                        <fieldset>

                            <label class="col-form-label" for="company-name" v-bind:class="isMobileViewFormLabel">Company name *</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="first-name" type="text">

                            <label class="control-label" for="location" v-bind:class="isMobileViewFormLabel">Location</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="location" type="text">

                            <label class="control-label" for="email" v-bind:class="isMobileViewFormLabel">Email *</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="email" type="email">

                            <label class="control-label" for="phone" v-bind:class="isMobileViewFormLabel">Phone *</label>
                            <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="phone" type="text">

                            <div class="form-group">
                                <label for="timezone">Timezone *</label>
                                <select class="form-control" id="timezone">
                                    <option>1 -asfdasdfasfda</option>
                                    <option>2 -yuiyuiyuiyui</option>
                                    <option>3 -asdasdasdasda</option>
                                    <option>4 -bnm,nm,bm,nm,nm,</option>
                                    <option>5 -gfhtyuiio[pop[oi[</option>
                                </select>
                            </div>

                        </fieldset>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {

        mounted() {
            console.log('Profile mounted.')
        },


    }
</script>
