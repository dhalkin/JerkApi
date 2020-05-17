<template>
    <div class="dropdown">
        <a class="btn-sm btn-outline-danger dropdown-toggle"
           href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false" @click="clickLang">
            {{currentLang.name}}
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a v-for="item in this.items" class="dropdown-item" v-text="item.name" :href="item.url"></a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: [
                    { name: 'En', url: '/lang/en' },
                    { name: 'Ru', url: '/lang/ru' }
                ],
                currentLang: {}
            }
        },

        created() {
            // get current lang
            let htmlLang = $('html').get(0).getAttribute('lang');
            // ?? user locale
            let browserLanguage = window.navigator.userLanguage || window.navigator.language;

            this.items.forEach(function(item, index, arr){
                if(item.name.toUpperCase() === htmlLang.toUpperCase()){
                    this.currentLang = arr[index];
                    arr.splice(index,1);
                }

            }, this);
        },

        methods:{
            clickLang(el){
                el.preventDefault();
                var element = $(el.target).next('div');

                element.css('position','absolute');
                element.css('margin-top','10px');
                element.css('padding','0');
                element.css('min-width','0');

                return true;
            }
        }
    }
</script>
