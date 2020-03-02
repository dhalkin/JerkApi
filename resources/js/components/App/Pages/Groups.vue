<template>
  <div class="container-fluid">
    <h4 class="card-title" v-text="trans('Groups')"></h4>

    <div class="card">
      <div class="card-body">
        <!--data block -->
        <div v-if="this.items.length > 0">
          <div class="row">
            <div class="col">
              <!--filter -->
              <div class="input-group" style="flex-wrap: nowrap;">
                <input type="search" class="form-control form-control-sm"
                       placeholder="Type to Search"
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
        ></b-table>
        </div>
        <div class="h5 p-5" v-else>
          Seems you still don't have any group, use "Create" button.
          <p>
            <p-button type="primary" outline round @click="openEditor()">
              <i slot="label" class="fa fa-edit"></i>{{trans('Create')}}
            </p-button>
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

  export default {
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
          { key: 'name', label: this.trans('Name'), sortable: true},
          { key: 'direction', label: this.trans('Direction'), sortable: true},
          { key: 'color', label: this.trans('Color'), sortable: false},
          { key: 'max_person', label: this.trans('Max Person'), sortable: false},
          { key: 'duration', label: this.trans('Duration'), sortable: true},
        ],
        filterOn:['name'],
        sortBy:'name',
        totalRows: 1,
        currentPage: 1,
        perPage: 5,
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
      openEditor() {

      }
    },
    mounted() {
      axios.get(this.urls.getItems) // , {withCredentials: true}
              .then(response => {
                this.items = response.data
              });
    }
  }
</script>
<style>
</style>
