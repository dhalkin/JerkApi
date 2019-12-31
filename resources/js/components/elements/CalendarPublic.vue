<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <div class="card card-calendar">
                    <div class="card-body">
                        <div id="fullCalendar" ref="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import swal from 'sweetalert2'
    import {Calendar} from 'fullcalendar'
    import ruLocale from 'fullcalendar/dist/locales/ru'
    import enLocale from 'fullcalendar/dist/locales/en-gb'

    const today = new Date();
    const y = today.getFullYear();
    const m = today.getMonth();
    const d = today.getDate();

    export default {

        props: ['lang','events'],

        data() {
            return {
            }
        },
        watch:{
            events: function (val) {
                this.initCalendar();
            }
        },
        methods: {
            initCalendar() {
                const self = this;
                let $calendar = new Calendar(this.$refs.calendar, {
                    header: {
                        left: 'title',
                       // center: 'month,agendaWeek,agendaDay',
                        right: 'prev,next,today'
                    },
                    defaultView: 'agendaWeek',
                    defaultDate: today,
                    selectable: true,
                    selectHelper: true,
                    firstDay: 1,
                    locales: [ ruLocale, enLocale ],
                    locale: 'ru', // the initial locale. of not specified, uses the first one
                    minTime: '07:00:00',
                    maxTime: '23:00:00',
                    allDaySlot: false,
                    views: {
                        month: { // name of view
                            titleFormat: {
                                month: 'long',
                                year: 'numeric'
                            }
                            // other view-specific options here
                        },
                        week: {
                            titleFormat: {
                                month: 'long',
                                day: '2-digit',
                                year: 'numeric'
                            }
                        },
                        // day: {
                        //     titleFormat: {
                        //         day: '2-digit',
                        //         month: 'long',
                        //         year: 'numeric'
                        //     }
                        // }
                    },
                    select: async ({start, end}) => {
                        // on select we show the Sweet Alert modal with an input
                        let result = await swal({
                            title: 'Create an Event',
                            html: '<div class="form-group">' +
                                '<input class="form-control" placeholder="Event Title" id="input-field">' +
                                '</div>',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: true
                        });
                        if (result) {
                            let eventData
                            let eventTitle = document.getElementById('input-field').value;
                            if (eventTitle) {
                                eventData = {
                                    title: eventTitle,
                                    start: start,
                                    end: end,
                                    allDay: true
                                };
                                $calendar.addEvent(eventData);
                            }
                            $calendar.setOption('unselect')
                        }
                    },
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events

                    // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
                    events: self.events
                });
                $calendar.render();
                //console.log('cal')
            }
        },
        mounted() {

            // get events, then init calendar

            //this.initCalendar();
        }
    }
</script>
<style>
    #fullCalendar {
        min-height: 300px;
    }

    .el-loading-spinner .path {
        stroke: #66615B !important;
    }
</style>
