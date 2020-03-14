<template>
  <div class="container-fluid">

   <span class="card-title d-inline">
     <span class="h4">{{trans('Groups')}}</span>
   <span class="text-primary ml-3"><p-button size="sm" type="primary" @click="openEditor('new')">
              <i slot="label" class="fa fa-edit"></i>{{trans('Create')}}
            </p-button></span>
   </span>

    <div class="card">
      <div class="card-body">
        <!--data block -->
        <div v-if="this.items.length > 0">
          <div class="row">
            <div class="col">
              <!--filter -->
              <div class="input-group" style="flex-wrap: nowrap;">
                <input type="search" class="form-control form-control-sm"
                       v-bind:placeholder="trans('Type to Search')"
                       aria-describedby="button-addon2"
                       v-model="filter"
                       id="filterInput"
                       style="min-width:130px">
                <div class="input-group-append">
                  <button class="btn btn-outline-default btn-sm mt-0"
                          type="button"
                          id="button-addon2"
                          :disabled="!filter"
                          @click="filter = ''"
                          style="height: 31px"
                          v-text="trans('Clear')"
                  ></button>
                </div>
              </div>
            </div>
            <div class="col">
              <!-- rows -->
              <b-form-select
                      v-model="perPage"
                      id="perPageSelect"
                      size="sm"
                      :options="pageOptions"
                      style="width:60px;"
              ></b-form-select>
            </div>
            <div class="col">
              <b-pagination
                      v-model="currentPage"
                      :total-rows="totalRows"
                      :per-page="perPage"
                      align="fill"
                      size="sm"
                      class="my-0"
              ></b-pagination>
            </div>
          </div>

        <b-table striped hover
           responsive="sm"
           :items="items"
           :fields="fields"
           :current-page="currentPage"
           :per-page="perPage"
           :filter="filter"
           :filterIncludedFields="filterOn"
           :sort-by.sync="sortBy"
           :sort-desc.sync="sortDesc"
           :sort-direction="sortDirection"
           @filtered="onFiltered"
           sort-icon-left
        >
          <template v-slot:head(name)="scope">
            <div class="text-nowrap">Name</div>
          </template>

          <template v-slot:cell(actions)="row">
            <p-button size="sm" @click="openEditor(row.item)" class="mr-1">
              <i class="fa fa-edit"></i> {{trans('Edit')}}
            </p-button>
          </template>

          <template v-slot:table-caption>{{trans('Total records')}}: {{totalRows}}</template>
        </b-table>
        </div>
        <div class="p-5" v-else>
          <p>
            {{trans('Seems you still do not have any group')}}
          </p>
        </div>

      </div>
    </div>
  </div>
</template>
<script>

  import {Button, Card} from '../../../components/UIComponents'
  import {BTable} from "bootstrap-vue"
  import {BFormSelect} from "bootstrap-vue"
  import {BPagination} from "bootstrap-vue"
  import PButton from "../../UIComponents/Button"
  import ErrorHelper from "../../utils/ErrorHelper"

  export default {
    mixins: [ErrorHelper],
    components: {
      [Button.name]: Button,
      Card,
      BTable,
      BFormSelect,
      BPagination,
      PButton
    },
    data() {
      return {
        urls:{
          'getItems': `/api/company/${this.$root.companyUid}/groups`,
        },
        items:[],
        fields:[
          { key: 'name', label: this.trans('Name'), sortable: true, stickyColumn: true},
          { key: 'max_person', label: this.trans('Max Person'), sortable: false, class:'text-center'},
          { key: 'duration_min', label: this.trans('Duration')+',min', sortable: true, class:'text-center'},
          { key: 'actions', label: this.trans('Actions'), class:'text-right' }
        ],
        stickyHeader: true,
        noCollapse: false,
        filterOn:['name'],
        sortBy:'name',
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        pageOptions: [5, 10, 15],
        sortDesc: false,
        sortDirection: 'asc',
        filter: null
      }
    },
    watch:{
      items: function (val) {
        // Set the initial number of items
        this.totalRows = val.length
      }
    },

    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
                .filter(f => f.sortable)
                .map(f => {
                  return { text: f.label, value: f.key }
                })
      }
    },
    methods: {
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },
      openEditor(val) {
        if(val === 'new'){
          this.$router.push({ name: 'GroupEditor', params: { uid: 'new'}})
        }else{
          this.$router.push({ name: 'GroupEditor', params: { uid: val.uid}})
        }
      },
    },
    mounted() {
      axios.get(this.urls.getItems)
              .then(response => {
                this.items = response.data
              }).catch(error => {
                this.processErr(error)
              });
    }
  }
</script>
