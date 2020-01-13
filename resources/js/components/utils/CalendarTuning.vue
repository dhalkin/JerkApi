<script>
    export default {
        methods: {
            buttonsTune(){

                let leftButton = this.$refs.fullCalendar.$el.getElementsByClassName('fc-prev-button')[0];
                leftButton.classList.remove('fc-button-primary');
                leftButton.classList.add('fc-state-default');
                leftButton.classList.add('fc-corner-left');
                leftButton.children[0].classList.remove('fc-icon-chevron-left');
                leftButton.children[0].classList.add('fc-icon-left-single-arrow');
                let rightButton = this.$refs.fullCalendar.$el.getElementsByClassName('fc-next-button')[0];
                rightButton.classList.remove('fc-button-primary');
                rightButton.classList.add('fc-state-default');
                rightButton.classList.add('fc-corner-right');
                rightButton.children[0].classList.remove('fc-icon-chevron-right');
                rightButton.children[0].classList.add('fc-icon-right-single-arrow');

                let todayButton = this.$refs.fullCalendar.$el.getElementsByClassName('fc-timeGridWeek-button')[0];
                todayButton.classList.remove('fc-button-primary');
                todayButton.classList.add('fc-state-default');
                todayButton.classList.add('fc-corner-right');
                let twoButton = this.$refs.fullCalendar.$el.getElementsByClassName('fc-myCustomButton-button')[0];
                twoButton.classList.remove('fc-button-primary');
                twoButton.classList.add('fc-state-default');
                twoButton.classList.add('fc-corner-right');
            }
        }
    }
</script>
