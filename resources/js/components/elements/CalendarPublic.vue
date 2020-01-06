import swal from "sweetalert2";
<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <div class="card card-calendar">
                    <div class="card-body">
                        <full-calendar
                            ref="fullCalendar"
                            defaultView="timeGridWeek"
                            :header="{
                                left: 'title',
                                right: 'prev,next,today'
                            }"
                            :themeSystem="themeSystem"
                            :plugins="calendarPlugins"
                            :weekends="weekends"
                            :events="events"
                            :allDaySlot="allDaySlot"
                            :firstDay="firstDay"
                            :locales="locales"
                            :locale="lang"
                            :minTime="minTime"
                            :maxTime="maxTime"
                            :textEscape="textEscape"
                            :columnHeaderFormat="columnHeaderFormat"
                            @eventRender="eventRender"
                            @eventClick="eventClick"
                        >
                        </full-calendar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    //import {swal} from 'vue-sweetalert2'
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'

    import ruLocale from 'fullcalendar/dist/locales/ru'
    import enLocale from 'fullcalendar/dist/locales/en-gb'

   // import EventTitle from "../UIComponents/Calendar/EventTitle";
    import { formatDate } from '@fullcalendar/core'

    const today = new Date();
    const y = today.getFullYear();
    const m = today.getMonth();
    const d = today.getDate();

    export default {

        props: ['lang', 'events', 'userName', 'companyUid'],
        components: {FullCalendar},
        data() {
            return {
                calendarPlugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin
                ],
                themeSystem: 'bootstrap4',
                locales: [ 'ruLocale', 'enLocale' ],
                minTime: "07:00:00",
                maxTime: "23:00:00",
                weekends: true,
                allDaySlot: false,
                firstDay: 1,
                textEscape: false,
                columnHeaderFormat: {weekday:'long', day: 'numeric'},
                views: { week: {
                    titleFormat: {
                        month: 'long',
                            day: '2-digit',
                            year: 'numeric'
                    }
                }}
            }
        },
        watch:{
            events: function (val) {

            }
        },
        methods: {
            eventRender(info) {

                let title = (info.event._def.extendedProps.personalStatus) ? '<span class="check text-success"><i class="nc-icon nc-check-2"></i></span>' : '';
                title += '<span class="group">' + info.event.title + '</span><br>';
                   // title += '<span class="trainer">' + info.event._def.extendedProps.trainer + '</span><br>';
                    title += '<span class="hall">' + info.event._def.extendedProps.hall + '</span><br>';
                    title += '<span class="people-stats">' + this.trans('Places left') + ' : ' + info.event._def.extendedProps.peopleStats + '</span>';

                info.el.childNodes[0].childNodes[1].innerHTML = title;

                // console.log(info.isStart);
                // console.log(info.isEnd);
                // console.log(info.isMirror);
            },
            eventClick(info) {
                let startDate = formatDate(info.event.start, {
                    month: 'long',
                    year: 'numeric',
                    day: 'numeric',
                    weekday: 'long',
                    hour: '2-digit',
                    minute: '2-digit',
                    locale: this.lang
                });
                let eventInfo = '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Beginning')+':</div><div class="col text-left">'+this.capitalize(startDate)+'</div></div>';
                //html += '<div class="row"><div class="col">'+this.trans('Тренер')+'</div><div class="col">'+info.event._def.extendedProps.trainer+'</div></div>';
                eventInfo += '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Group')+':</div><div class="col text-left">'+info.event.title+'</div></div>';
                eventInfo += '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Classroom')+':</div><div class="col text-left">'+info.event._def.extendedProps.hall+'</div></div>';
                eventInfo += '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Address')+':</div><div class="col text-left">'+info.event._def.extendedProps.hallAddress+'</div></div>';
                eventInfo += '<div class="row mb-2"><div class="col-5 text-right">'+this.trans('Places left')+':</div><div class="col text-left">'+info.event._def.extendedProps.peopleStats+'</div></div>';

                let invitation ='<div class="text-danger small mark p-2">'+ this.trans('You need register or log in to your account')+'</div>';
                let userChecked = info.event._def.extendedProps.personalStatus;

                this.$swal({
                    title: (userChecked) ? this.trans('You are applied on event') : this.trans('Join the Event'),
                    showCancelButton: true,
                    confirmButtonClass: (userChecked) ? 'btn btn-danger btn-fill' : 'btn btn-success btn-fill',
                    cancelButtonClass: 'btn btn-warning btn-fill',
                    confirmButtonText: (userChecked) ? this.trans('I want to cancel my visit') : this.trans('Yes, I want to join'),
                    cancelButtonText: (userChecked) ? this.trans('Close') : this.trans('Cancel'),
                    buttonsStyling: true,
                    reverseButtons: true,
                    html: eventInfo,
                    userName: this.userName,
                    eventId: info.event.id,
                    userChecked: userChecked,
                    onBeforeOpen: function (el) {

                        let div = document.createElement('div');
                        div.setAttribute("id", "alarma");
                        div.innerHTML = invitation.trim();

                        if(!this.userName){
                            el.children[2].children[1].disabled = true
                            el.children[2].appendChild(div)
                        }else{
                            el.children[2].children[1].disabled = false
                            let alarma = document.getElementById("alarma")
                            if(alarma){
                                el.children[2].removeChild(alarma)
                            }
                        }

                        if(info.isEnd){
                            this.disableButtons()
                        }

                    },
                    preConfirm: function (el) {

                    }
                }).then((result) => {
                    if (result.value) {

                        let data = {};
                        data['eventId'] = info.event.id;
                        data['checked'] = userChecked;

                        axios.post('/company/' + this.companyUid + '/event-attempt', data)
                            .then(response => response.data)
                            .then(data => {

                                this.$emit('need-refresh');

                                this.$swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: this.trans('Done'),
                                    text: (userChecked) ? this.trans('Will be happy to seeing you again') : this.trans('Waiting for you in the classroom'),
                                    showConfirmButton: false,
                                    timer: 2500
                                })

                            })
                            .catch(error => {
                                this.$emit('need-refresh');
                                this.$swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: this.trans('Oops'),
                                    text: this.trans('Something went wrong. Sorry.'),
                                    showConfirmButton: false,
                                    timer: 2500
                                })
                            });

                    }
                });
            }
        },
        mounted() {

            let leftButton = this.$refs.fullCalendar.$el.children[0].children[2].children[0].children[0];
            leftButton.classList.remove('fc-button-primary');
            leftButton.classList.add('fc-state-default');
            leftButton.classList.add('fc-corner-left');
            leftButton.children[0].classList.remove('fc-icon-chevron-left');
            leftButton.children[0].classList.add('fc-icon-left-single-arrow');
            let rightButton = this.$refs.fullCalendar.$el.children[0].children[2].children[0].children[1];
            rightButton.classList.remove('fc-button-primary');
            rightButton.classList.add('fc-state-default');
            rightButton.classList.add('fc-corner-right');
            rightButton.children[0].classList.remove('fc-icon-chevron-right');
            rightButton.children[0].classList.add('fc-icon-right-single-arrow');
            let todayButton = this.$refs.fullCalendar.$el.children[0].children[2].children[0].children[2];
            todayButton.classList.remove('fc-button-primary');
            todayButton.classList.add('fc-state-default');
            todayButton.classList.add('fc-corner-right');

        }
    }
</script>
<style>#fullCalendar {
        min-height: 300px;
    }

    .el-loading-spinner .path {
        stroke: #66615B !important;
    }
</style>
