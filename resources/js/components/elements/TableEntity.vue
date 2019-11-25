<template>
    <transition>
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
                            <button class="btn btn-outline-secondary btn-sm mt-0"
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

            <b-table
                striped hover
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
                sort-icon-left>
                <!-- A custom formatted column -->
                <template v-slot:cell(active)="data">
                    <div class="custom-control custom-switch">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            :id="data.item.unique_id"
                            v-model="data.item.active"
                            @click="$emit('click-active', data.item.unique_id, data.item.active)"
                        >
                        <label class="custom-control-label" :for="data.item.unique_id"></label>
                    </div>
                </template>
                <!--actions -->
                <template v-slot:cell(actions)="data">
                    <button type="button" class="btn btn-success btn-icon btn-sm"
                            @click="$emit('click-edit', data.item)"
                    ><i class="fa fa-edit"></i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm">
                        <i class="fa fa-times"></i>
                    </button>
                </template>
            </b-table>
        </div>
        <p class="h5 p-4" v-else>
            Seems you still don't have a classroom, use "Create new" button.
        </p>
    </transition>
</template>

<script>
    export default {

        props:['items', 'fields', 'filterOn', 'sortBy'],

        data: function(){
            return {
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
        }

    }
</script>
