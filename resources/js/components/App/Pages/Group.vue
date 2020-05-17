<template>
    <div class="container-fluid">

        <!-- breadcrumbs-->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link name="Groups" to="/classes/groups">{{trans('Groups')}}</router-link>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{item.name}}</li>
            </ol>
        </nav>


<div class="col-sm-6">
    <group-form
            :item="item"
            :colors="colors"
            :trainers="trainers"
            v-on:save="saveItem"
            v-on:delete="deleteItem"
    ></group-form>
</div>



    </div>
</template>
<script>
    import GroupForm from './../Forms/GroupForm'
    import ErrorHelper from "../../utils/ErrorHelper"
    import swal from 'sweetalert2'

    export default {
        mixins: [ErrorHelper],
        components: {
            GroupForm
        },
        data() {
            return {
                urls:{
                    'getItem': `/api/company/${this.$root.companyUid}/group/${this.$route.params.uid}`,
                    'setItem': `/api/company/${this.$root.companyUid}/group`,
                },
                item:{},
                colors:[],
                trainers:[]
            }
        },
        mounted() {
            axios.get(this.urls.getItem)
                .then(response => {
                    this.item = response.data.group
                    this.colors = response.data.colors
                    this.trainers = response.data.trainers
                });
        },
        methods:{
            saveItem(){
                axios.post(this.urls.setItem, this.item)
                    .then(response => {
                        this.$notify({
                            //icon: 'nc-icon nc-bell-55',
                            horizontalAlign: 'right',
                            verticalAlign: 'top',
                            type: 'success',
                            message: this.trans('Done'),
                        })
                        this.$router.push({ name: 'Groups'})
                    })
                    .catch(error => {
                        this.processErr(error)
                    });

            },
            deleteItem(uid){
                swal({
                    title: this.item.name,
                    html: `<span class="h5">${this.trans('Delete Group')}?</span>`,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-danger btn-fill',
                    cancelButtonClass: 'btn btn-default btn-fill',
                    confirmButtonText: this.trans('Yes, delete it!'),
                    cancelButtonText: this.trans('Cancel'),
                    buttonsStyling: true,
                    reverseButtons: true,
                }).then(result => {
                    if (result) {
                        axios.delete(this.urls.setItem, { data: uid })
                            .then(response => {
                                this.$notify({
                                    //icon: 'nc-icon nc-bell-55',
                                    horizontalAlign: 'right',
                                    verticalAlign: 'top',
                                    type: 'success',
                                    message: this.trans('Done')
                                })
                                this.$router.push({ name: 'Groups'})
                            })
                            .catch(error => {
                                this.processErr(error)
                            });
                    }
                }).catch(swal.noop)
            }
        }
    }
</script>
