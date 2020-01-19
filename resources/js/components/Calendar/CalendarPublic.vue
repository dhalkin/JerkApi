<template>
    <div class="row">
        <div class="col">
            <!--title -->
            <div class="row">
                <div class="col text-center new-header-title" v-text="newHeaderTitle"></div>
            </div>
            <!-- buttons -->
            <div class="row justify-content-between">
                <div class="col-4 text-left">
                    <p-button type="primary" size="sm" @click="calendarPrev">
                        <i class="nc-icon nc-minimal-left"></i>
                    </p-button>
                    <p-button type="primary" size="sm" @click="calendarNext">
                        <i class="nc-icon nc-minimal-right"></i>
                    </p-button>
                </div>
                <div class="col-8 text-right">
                    <div class="btn-group">
                        <p-button
                                id="toggleWeek"
                                type="primary"
                                size="sm"
                                data-toggle="button"
                                aria-pressed="true"
                                @click="calendarChangeView('week')"
                        >{{this.trans('Week')}}</p-button>
                        <p-button
                                id="toggleTwoDays"
                                type="primary"
                                size="sm"
                                data-toggle="button"
                                aria-pressed="true"
                                @click="calendarChangeView('twodays')"
                        >{{this.trans('2 Days')}}</p-button>
                    </div>
                </div>
            </div>

            <div class="card-calendar">
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
                    :timeZone="companyTimezone"
                    :displayEventEnd="displayEventEnd"
                    @eventRender="eventRender"
                    @eventClick="eventClick"
                    @viewSkeletonRender="viewSkeletonRender"
                    @datesRender="datesRender"
                >
                </full-calendar>
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

    import { formatDate } from '@fullcalendar/core'
    import CalendarTuning from '../utils/CalendarTuning';

    const rightNowDate = new Date();
    const lastCallDate = new Date(rightNowDate);
    const nextDayDate = new Date();
    lastCallDate.setHours(lastCallDate.getHours() + 3);
    nextDayDate.setDate(nextDayDate.getDate() + 1);

    export default {
        mixins: [CalendarTuning],
        props: ['lang', 'events', 'userName', 'companyUid', 'companyTimezone'],
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
                newHeaderTitle: '',
                height: 'auto',
                handleWindowResize: true,
                header: false,
                displayEventEnd: false,
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
                        visibleRange(currentDate){
                            return {
                                start: currentDate.clone(),
                                end: currentDate.clone().add(1, 'days'),
                            };
                        },
                        duration: { days: 2 },
                        dateIncrement: { days: 2 },
                        titleFormat: {
                            month: 'long',
                            day: '2-digit',
                            year: 'numeric'
                        },
                        buttonText: this.trans('Today + 1'),
                    }
                }
            }
        },
        methods: {
            windowResize(view){
                this.$refs.fullCalendar.getApi().setOption('contentHeight', window.innerHeight-100);
            },
            calendarNext(){
                this.$refs.fullCalendar.getApi().next();
            },
            calendarPrev(){
                this.$refs.fullCalendar.getApi().prev();
            },
            calendarChangeView(type){
                if(type === 'twodays'){
                    document.getElementById('toggleTwoDays').classList.add("active");
                    document.getElementById('toggleWeek').classList.remove("active");
                    this.$refs.fullCalendar.getApi().changeView('agendaTwoDay');
                    this.$refs.fullCalendar.getApi().setOption('contentHeight', window.innerHeight-100); // minus header
                }else{
                    document.getElementById('toggleWeek').classList.add("active");
                    document.getElementById('toggleTwoDays').classList.remove("active");
                    this.$refs.fullCalendar.getApi().changeView('timeGridWeek');
                }
                this.calendarAjustHeight();

            },
            calendarAjustHeight(){
                if (window.innerWidth <= 800) {
                    this.$refs.fullCalendar.getApi().setOption('columnHeaderFormat',
                        {
                            weekday:'short',
                            day: 'numeric'
                        }
                    );
                }else{
                    this.$refs.fullCalendar.getApi().setOption('columnHeaderFormat',
                        {
                            weekday:'long',
                            day: 'numeric'
                        }
                    );
                }
            },
            // call for ini
            datesRender(info){
                this.$emit('range-changed', {start: info.view.currentStart, stop: info.view.currentEnd});
                this.newHeaderTitle = info.view.title;
            },
            viewSkeletonRender(info){

            },
            eventRender(info) {
                let title = (info.event._def.extendedProps.personalStatus) ? '<span class="check text-success"><i class="nc-icon nc-check-2"></i></span>' : '';
                    title += '<span class="group">' + info.event.title + '</span><br>';
                   // title += '<span class="hall">' + info.event._def.extendedProps.hall + '</span><br>';
                    title += '<span class="hall">' + info.event._def.extendedProps.hallAddress + '</span><br>';

                if(lastCallDate > info.event._instance.range.start){
                    info.el.style.backgroundColor = "";
                    info.el.style.border = "1px solid silver";
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
                    cancelButtonText: (!userChecked && lastCallDate <= info.event._instance.range.start) ? this.trans('Cancel') : this.trans('Close'),
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
            }
        },
        mounted() {
            if (this.detectMob()){
                this.calendarChangeView('twodays');
            }else{
                this.calendarChangeView('week');
            }
        }
    }
</script>
