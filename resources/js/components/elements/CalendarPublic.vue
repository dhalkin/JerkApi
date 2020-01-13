<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <div class="card card-calendar">
                    <div class="card-body">
                        <full-calendar
                            ref="fullCalendar"
                            defaultView="timeGridWeek"
                            :header="header"
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
                            :nowIndicator="nowIndicator"
                            :views="views"
                            :customButtons="customButtons"
                            @eventRender="eventRender"
                            @eventClick="eventClick"
                            @viewSkeletonRender="viewSkeletonRender"
                            @datesRender="datesRender"
                        >
                        </full-calendar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'

    import ruLocale from 'fullcalendar/dist/locales/ru'
    import enLocale from 'fullcalendar/dist/locales/en-gb'

   // import EventTitle from "../UIComponents/Calendar/EventTitle";
    import { formatDate } from '@fullcalendar/core'
    import CalendarTuning from '../utils/CalendarTuning';

    const rightNowDate = new Date();
    const lastCallDate = new Date(rightNowDate);
    const nextDayDate = new Date();
    lastCallDate.setHours(lastCallDate.getHours() + 3);
    nextDayDate.setDate(nextDayDate.getDate() + 1);

    const y = rightNowDate.getFullYear();
    const m = rightNowDate.getMonth();
    const d = rightNowDate.getDate();

    export default {
        mixins: [CalendarTuning],
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
                nowIndicator: true,
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek, myCustomButton'
                },
                views: {
                    timeGridWeek: {
                        type: 'timeGrid',
                        titleFormat: {
                            month: 'long',
                                day: '2-digit',
                                year: 'numeric'
                            },
                        buttonText: this.trans('Week'),
                    },
                    agendaTwoDay: {
                        type: 'timeGrid',
                        //duration: { days: 2 },
                        titleFormat: {
                            month: 'short',
                            day: '2-digit',
                            year: 'numeric'
                        },
                        buttonText: this.trans('Today | Tomorrow'),
                    }
                },
                customButtons: {
                    myCustomButton: {
                        text: this.trans('Today - Tomorrow'),
                            click: () => { this.customClick()}
                    }
                }
            }
        },
        watch:{
            events: function (val) {

            }
        },
        methods: {
            customClick(){
                this.$refs.fullCalendar.getApi().changeView('agendaTwoDay', {
                    'start':rightNowDate,
                    'end':nextDayDate
                });
            },
            // call for ini
            datesRender(info){
                this.$emit('range-changed', {start: info.view.currentStart, stop: info.view.currentEnd})
                //this.$emit('need-refresh')
                //console.log('render')
            },
            viewSkeletonRender(info){
               // this.$emit('range-changed', {start: info.view.currentStart, stop: info.view.currentEnd})
               // console.log('skeleton')
            },
            eventRender(info) {

                let title = (info.event._def.extendedProps.personalStatus) ? '<span class="check text-success"><i class="nc-icon nc-check-2"></i></span>' : '';
                    title += '<span class="group">' + info.event.title + '</span><br>';
                    title += '<span class="hall">' + info.event._def.extendedProps.hall + '</span><br>';

                if(lastCallDate > info.event._instance.range.start){
                    info.el.style.backgroundColor = "";
                    //info.el.style.border = "1px solid gray";
                    info.el.classList.add("expired-event");
                }else{
                    title += '<span class="people-stats">' + this.trans('Places left') + ' : ' + info.event._def.extendedProps.peopleStats + '</span>';
                }
                info.el.childNodes[0].childNodes[1].innerHTML = title;
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
                eventInfo += '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Group')+':</div><div class="col text-left">'+info.event.title+'</div></div>';
                if(info.event._def.extendedProps.trainer){
                    eventInfo += '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Trainer')+':</div><div class="col text-left">'+info.event._def.extendedProps.trainer+'</div></div>';
                }
                eventInfo += '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Classroom')+':</div><div class="col text-left">'+info.event._def.extendedProps.hall+'</div></div>';
                eventInfo += '<div class="row mb-2"><div class="col-4 text-right">'+this.trans('Address')+':</div><div class="col text-left">'+info.event._def.extendedProps.hallAddress+'</div></div>';
                eventInfo += '<div class="row mb-2"><div class="col-5 text-right">'+this.trans('Places left')+':</div><div class="col text-left">'+info.event._def.extendedProps.peopleStats+'</div></div>';

                let invitation ='<div class="text-danger small mark p-2 w-100">'+ this.trans('You need register or log in to your account')+'</div>';
                let userChecked = info.event._def.extendedProps.personalStatus;

                let title = (userChecked) ? this.trans('You are applied on event') : this.trans('Join the Event');
                if (lastCallDate > info.event._instance.range.start)  title = this.trans('Registration completed');

                this.$swal({
                    title: title,
                    showCancelButton: true,
                    confirmButtonClass: (userChecked) ? 'btn btn-danger btn-fill' : 'btn btn-success btn-fill',
                    cancelButtonClass: 'btn btn-warning btn-fill',
                    confirmButtonText: (userChecked) ? this.trans('I want to cancel my visit') : this.trans('Yes, I want to join'),
                    cancelButtonText: (userChecked) ? this.trans('Close') : this.trans('Cancel'),
                    buttonsStyling: true,
                    reverseButtons: true,
                    showConfirmButton: (lastCallDate <= info.event._instance.range.start) && this.userName,
                    html: eventInfo,
                    userName: this.userName,
                    eventId: info.event.id,
                    userChecked: userChecked,
                    expired: (lastCallDate > info.event._instance.range.start),
                    footer: (!this.userName && lastCallDate < info.event._instance.range.start) ? invitation : '',
                    onBeforeOpen: function (el) {

                        if(this.expired){
                            el.style.background = "rgba(163, 163, 163, 0.85) linear-gradient(90deg, rgba(255, 255, 255, .8) 50%, rgba(255, 255, 255, .9) 50%)  center center / 6em";
                            //el.classList.add("expired-event");
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
            },
            detectMob(){
                if (window.innerWidth <= 800 && window.innerHeight <= 600) {
                    return true;
                } else {
                    return false;
                }
            },
        },
        mounted() {
            this.buttonsTune();
            if(this.detectMob()){
                this.$refs.fullCalendar.getApi().setOption('columnHeaderFormat',
                    {
                        weekday:'short',
                        day: 'numeric'
                    }
                );
            }
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
