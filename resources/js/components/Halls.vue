<template>
    <div class="main-panel">
        <!-- Top Navbar -->
        <top-nav-bar
            v-bind:csrf="this.csrf"
            v-bind:title="trans('Halls')"
            create-new=true
            v-on:click-create-new="modalShow = true"
        ></top-nav-bar>
        <!-- End Navbar -->

    <div class="content">

    <!-- modal new and current item-->
        <modal-entity
            v-bind:show-me="modalShow"
            v-bind:item="modalHall"
            v-on:click-close="closeModal"
            v-on:click-save="updateHall"
            v-bind:title="modalTitle"
        ></modal-entity>

    <!-- main table -->
        <div class="card">
            <div class="card-body">
                <table-entity
                v-bind:items="halls"
                v-bind:fields="hallsFields"
                v-bind:filter-on="['name', 'address']"
                v-bind:sort-by="'name'"
                v-on:click-active="setActiveStatus"
                v-on:click-edit="goToHall"
                ></table-entity>
            </div>
        </div>

    </div>
        <footer-bar></footer-bar>

    </div>
</template>

<script>
    import Errors from "./utils/Errors";
    import RequestHelper from "./utils/RequestHelper";
    import TopNavBar from "./layout/TopNavBar";
    import FooterBar from "./layout/FooterBar";
    import InputText from "./elements/InputText";
    import TableEntity from "./elements/TableEntity";
    import ModalEntity from "./elements/ModalEntity";

    export default {
        components: {TableEntity, ModalEntity, TopNavBar, FooterBar, InputText},
        mixins: [Errors, RequestHelper, TopNavBar],

        data: function () {
            return {
                name: '',
                address: '',
                about:'',
                modalHall: {name:'', address:'', about:'', unique_id:''},
                halls: [],
                hallsFields: [
                    { key: 'name', label: this.trans('Name'), sortable: true},
                    { key: 'address', label: this.trans('Address'), sortable: false },
                    { key: 'active', label: this.trans('Active'), sortable: true, thClass:'text-center', tdClass: "text-center" },
                    { key: 'actions', label: this.trans('Actions'), sortable: false, thClass:'text-right', tdClass: "text-right" },
                ],
                modalShow: false,
                modalTitle: this.trans('Create new Classroom')
            }
        },

        mounted() {
            // get halls
            axios.get('/api/halls')
                .then(response => response.data)
                .then(data => {
                    this.halls = data;
                });
        },

        methods: {

            closeModal(){
                this.modalHall = {name:'', address:'', about:'', unique_id:''};
                this.modalShow = false;
            },

            goToHall(items){
                this.modalTitle = this.trans('Edit Classroom');
                this.modalHall = items;
                this.modalShow = true;
            },

            // ???
            deleteHall(uuid){

            },

            setActiveStatus(uuid, active){
                axios.post('/api/hall/' + uuid + '/update', {active: !active})
                    .then(response => {
                        this.flash(this.trans('Saved'), 'success', {
                            timeout: 3000
                        });

                    })
                    .catch(error => {
                        this.processErr(error);
                    });
            },

            // prepareData(uuid){
            //     let edithall = this.halls.find(o => o.unique_id === uuid);
            //     if( typeof edithall === 'object' && edithall !== null){
            //         return { active:edithall.active };
            //     }
            //
            //     return null;
            // },

            updateHall(){
                this.errors.clearAll();
                this.modalShow = false;
                let preparedData  = this.prepareSubmit();
                axios.post('/api/hall/create', preparedData)
                    .then(response => response.data)
                    .then(data => {
                        this.flash(this.trans('Saved'), 'success', {
                            timeout: 3000
                        });

                        if(data.result == 'created'){
                            preparedData.unique_id = data.uuid;
                            preparedData.active = true;
                            this.halls.push(preparedData);
                        }
                        this.modalHall = {name:'', address:'', about:'', unique_id:''};

                    })
                    .catch(error => {
                        this.processErr(error);
                        this.modalHall = {name:'', address:'', about:'', unique_id:''};
                    });

            },

            prepareSubmit(){
                return {
                    unique_id:this.modalHall.unique_id,
                    name: this.modalHall.name,
                    address: this.modalHall.address,
                    about: this.modalHall.about,
                }
            }
        }
    }
</script>
