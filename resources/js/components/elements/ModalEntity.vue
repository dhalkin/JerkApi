<template>
    <b-modal
        :title="title"
        :header-bg-variant="headerBgVariant"
        :header-text-variant="headerTextVariant"
        :body-bg-variant="bodyBgVariant"
        :body-text-variant="bodyTextVariant"
        :footer-bg-variant="footerBgVariant"
        :footer-text-variant="footerTextVariant"
        hide-header-close
        v-model="isModalOpen"
    >
        <form method="POST" action="#" @submit.prevent="$emit('click-save')"
              @keydown="errors.clear($event.target.name)" id="modalForm">
            <input type="hidden" name="uid" v-model="item.uid">
            <div class="form-row">
                <div class="col">
                    <input-text
                        v-bind:label="trans('Hall name') + ' *'"
                        v-model.trim="item.name"
                        v-bind:errors="errors"
                        name="name"
                        required="required"
                        >
                    </input-text>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <input-text
                        v-bind:label="trans('Address') + ' *'"
                        v-model.trim="item.address"
                        v-bind:errors="errors"
                        name="address"
                        required="required"
                        set-referense="focusThis">
                    </input-text>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="comment" v-text="trans('About')"></label>
                        <textarea class="form-control" rows="3"
                                  id="about" name="about"
                                  v-model.trim="item.about"
                        ></textarea>
                    </div>
                </div>
            </div>

            <button type="submit"
                    class=""
                    style="display: none"
                    id="buttonSave">
            </button>
        </form>
        <template v-slot:modal-footer>
            <div class="w-100">
                <b-button
                    variant="secondary"
                    class="float-left ml-2 w-25"
                    @click="$emit('click-close')"
                    v-text="trans('Close')"
                >
                </b-button>
                <b-button
                    variant="primary"
                    class="float-right mr-2 w-25"
                    @click="submitForm"
                    v-text="trans('Save it!')"
                >
                </b-button>
            </div>
        </template>

    </b-modal>
</template>

<script>
    import Errors from "./../utils/Errors";
    import InputText from "./InputText";

    export default {
        props: ['item', 'title', 'showMe'],
        mixins: [Errors],
        components: {InputText},

        data: function () {
            return {
                headerBgVariant: 'gray',
                headerTextVariant: 'dark',
                bodyBgVariant: 'light',
                bodyTextVariant: 'dark',
                footerBgVariant: 'gray',
                footerTextVariant: 'dark'
            }
        },

        computed: {
            isModalOpen: {
                get: function () {
                    return this.showMe
                },
                set: function (v) {
                    this.$emit('click-close');
                }
            }
        },

        methods: {
            submitForm() {
                $('#buttonSave').click();
            }
        }
    }
</script>
