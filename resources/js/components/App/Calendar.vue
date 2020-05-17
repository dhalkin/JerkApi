<template>
    <div class="container-fluid">

        <!--modal for child elem -->
        <modal
            v-bind:show="showForm"
            v-on:close="showForm = false"
            headerClasses="p-2"
            bodyClasses="p-3"
        >
            <span class="h4" slot="header">{{trans('Event')}}</span>
            <event-form ref="form"
               :item=modalEntity
               :roles=modalEntity
               :groups=modalEntity
               :trainers=modalEntity
               v-on:save="saveEntity"
               v-on:delete="deleteEntity"
               v-on:close="showForm = false"
            >
            </event-form>
        </modal>

        <span class="card-title d-inline">
        <span class="h4">{{trans('Schedule')}}</span>
        <span class="text-primary ml-3"><p-button size="sm" type="primary" @click="openEditor('new')">
              <i slot="label" class="fa fa-edit"></i>{{trans('Create event')}}
            </p-button></span>
         </span>


        <div class="card">
            <div class="card-body">
            <!--title -->
            <div class="row">
                <div class="col-6 text-left new-header-title" v-text="newHeaderTitle"></div>
                <div class="col-6 text-right">
                    <b-form-select v-model="currentBranch" :options="branches"></b-form-select>
                </div>
            </div>
            <!-- buttons -->
            <div class="row justify-content-between">
                <div class="col-5 text-left">
                    <p-button type="info" size="sm" @click="calendarPrev">
                        <i class="nc-icon nc-minimal-left"></i>
                    </p-button>
                    <p-button type="info" size="sm" @click="calendarNext">
                        <i class="nc-icon nc-minimal-right"></i>
                    </p-button>
                </div>
                <div class="col-7 text-right">

                    <div class="btn-group">
                        <p-button
                                id="toggleWeek"
                                type="info"
                                size="sm"
                                outline
                                data-toggle="button"
                                aria-pressed="true"
                                @click="calendarChangeView('week')"
                        >{{this.trans('Week')}}
                        </p-button>
                        <p-button
                                id="toggleTwoDays"
                                type="info"
                                size="sm"
                                outline
                                data-toggle="button"
                                aria-pressed="true"
                                @click="calendarChangeView('twodays')"
                        >{{this.trans('Day')}}
                        </p-button>
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
                        :displayEventEnd="displayEventEnd"
                        :eventRender="eventRender"
                        :datesRender="datesRender"
                        :currentBranch="currentBranch"
                        @eventClick="eventClick"
                        :timeZone="companyTimezone"
                >
                </full-calendar>
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
    import {BFormSelect} from 'bootstrap-vue'
    import ErrorHelper from "../utils/ErrorHelper";

    import ruLocale from 'fullcalendar/dist/locales/ru'
    import enLocale from 'fullcalendar/dist/locales/en-gb'
    import CalendarTuning from '../utils/CalendarTuning'
    import Modal from "../../components/UIComponents/Modal"
    import EventForm from "./Forms/EventForm"

    import {formatDate} from '@fullcalendar/core'

    const rightNowDate = new Date();
    const nextDayDate = new Date(rightNowDate);
    const lastCallDate = new Date(rightNowDate);
    const abilityToRefuse = new Date(rightNowDate);

    nextDayDate.setDate(nextDayDate.getDate() + 1);

    export default {
        components: {FullCalendar, BFormSelect, Modal, EventForm},
        mixins: [ErrorHelper, CalendarTuning],
        data() {
            return {
                datePicker: '',
                pickerOptions1: {
                    shortcuts: [{
                        text: 'Today',
                        onClick (picker) {
                            picker.$emit('pick', new Date())
                        }
                    },
                    {
                        text: 'Yesterday',
                        onClick (picker) {
                            const date = new Date()
                            date.setTime(date.getTime() - 3600 * 1000 * 24)
                            picker.$emit('pick', date)
                        }
                    },
                    {
                        text: 'A week ago',
                        onClick (picker) {
                            const date = new Date()
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7)
                            picker.$emit('pick', date)
                        }
                    }]
                },
                showForm:false,
                modalEntity: {},
                newModalEntity:{ start:new Date(), finish:new Date(), group_id:'', hall_id:'', trainer_id:''},
                urls:{
                    'getEvents': `/api/company/${this.$root.companyUid}/events`,
                },
                calendarPlugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin
                ],
                themeSystem: 'bootstrap4',
                locales: ['ruLocale', 'enLocale'],
                minTime: "07:00:00",
                maxTime: "23:00:00",
                weekends: true,
                allDaySlot: false,
                firstDay: 1,
                textEscape: false,
                columnHeaderFormat: {weekday: 'long', day: 'numeric'},
                nowIndicator: true,
                newHeaderTitle: '',
                height: 'auto',
                handleWindowResize: true,
                header: false,
                displayEventEnd: true,
                currentBranch: 0,
                companyTimezone: this.$root.companyTimezone,
                branches:[
                    {value: 0, text: this.trans('All Branches')}
                ],
                events:[],
                lang: this.$root.lang,
                dataRange: {start: new Date(), stop: new Date()},
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
                        visibleRange(currentDate) {
                            return {
                                start: currentDate.clone(),
                                end: currentDate.clone(),
                            };
                        },
                        duration: {days: 1},
                        dateIncrement: {days: 1},
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
        watch: {
            dataRange: function (val, oldVal) {
                    this.getEvents()
            }
        },
        methods: {
            openEditor(flag){
                if (flag === 'new'){
                    this.showForm = true
                    this.newModalEntity.start.setHours('07')
                    this.newModalEntity.start.setMinutes('00')
                    this.modalEntity = this.newModalEntity
                }
            },
            saveEntity() {

            },
            deleteEntity() {

            },
            calendarNext() {
                this.$refs.fullCalendar.getApi().next();
            },
            calendarPrev() {
                this.$refs.fullCalendar.getApi().prev();
            },
            calendarChangeView(type) {
                if (type === 'twodays') {
                    document.getElementById('toggleTwoDays').classList.add("active");
                    document.getElementById('toggleWeek').classList.remove("active");
                    this.$refs.fullCalendar.getApi().changeView('agendaTwoDay');
                    this.$refs.fullCalendar.getApi().setOption('contentHeight', window.innerHeight - 100); // minus header
                } else {
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
                //console.log('render')
                this.dataRange = {start:info.view.currentStart, stop:info.view.currentEnd}
                // this.$emit('range-changed', {start: info.view.currentStart, stop: info.view.currentEnd});
                this.newHeaderTitle = info.view.title;
            },
            eventRender(info) {

                let title = `
                ${info.event._def.extendedProps.personalStatus ? `<span class="check text-success"><i class="nc-icon nc-check-2"></i></span>` : ''}
                <div class="row"><div class="col">
                <span class="group">${info.event.title}</span>
                </div></div>
                <div class="row">
                ${lastCallDate < info.event._instance.range.start ? `<div class="col text-right"><span class="people-stats">${this.trans('Places')} : ${info.event._def.extendedProps.peopleStats}</span></div>` : ''}
                </div>
                `

                let t = Math.abs(info.event._instance.range.end - info.event._instance.range.start)
                let diff = Math.floor((t/1000)/60)
                let time = `
                <div class="row">
                <div class="col text-left">${info.event._instance.range.start.getHours()}:${info.event._instance.range.start.getMinutes()}</div>
                <div class="col text-right" style="font-size:0.5em">${diff} min</div>
                </div>
                `

                if(lastCallDate > info.event._instance.range.start) {
                    info.el.style.backgroundColor = "";
                    info.el.style.border = "1px solid silver";
                    info.el.classList.add("expired-event");
                }
                info.el.childNodes[0].childNodes[0].innerHTML = time
                info.el.childNodes[0].childNodes[1].innerHTML = title
            },
            eventClick() {

            },
            getEvents() {
                axios.get(this.urls.getEvents, this.prepareEventsData())
                    .then(response => response.data)
                    .then(data => {
                        lastCallDate.setHours(lastCallDate.getHours() + data.company.lastCallHours);
                        abilityToRefuse.setHours(abilityToRefuse.getHours() -  data.company.refuseInHours);
                        this.events = data.events;
                    })
                    .catch(error => {
                        this.processErr(error);
                    });
            },
            prepareEventsData() {
                return {
                    params: {
                        start: this.dataRange.start,
                        stop: this.dataRange.stop,
                        currentBranch: this.currentBranch
                    }
                }
            }
        },
        mounted() {
            if (this.detectMob()){
                this.calendarChangeView('twodays')
            }else{
                this.calendarChangeView('week')
            }
        }
    }
</script>
