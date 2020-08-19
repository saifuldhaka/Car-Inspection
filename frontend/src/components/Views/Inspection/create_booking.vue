<template>
    <div class="container-fluid">
        <v-card class="p-3">
            <p class="display-1 text--primary">
               Inspection Booking Create
            </p>
            <div v-if="loading" class="text-center" style="padding: 50px 0;"><br /><br />
                <img src="../../../assets/loading.gif" style="width: 80px;" class="logo">
            </div>
            <v-form ref="form" @submit.prevent="submit" id="login-form">

                <v-card class="mx-auto" >
                    <v-card-text>
                        <h6 class="pl-3 pt-4">Booking Date and Time</h6>

                        <v-row>
                            <v-col cols="4">
                                <v-menu v-model="menu1" :close-on-content-click="true" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                                  <template v-slot:activator="{ on }">
                                      <v-text-field v-model="booking_date" label="Booking Date" readonly v-on="on" clearable :rules="[rules.required]"></v-text-field>
                                  </template>
                                  <v-date-picker v-model="booking_date"
                                    @input="menu1 = false"
                                    :min="minDay"
                                    :max="maxDay"
                                    v-on:change="resetTime"
                                    :allowed-dates="allowedDates"
                                    @update:picker-date="pickerUpdate($event)"
                                    >
                                  </v-date-picker>
                              </v-menu>
                            </v-col>
                            <v-col cols="4">
                              <v-menu
                                ref="menu"
                                v-model="menu2"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                :return-value.sync="time"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                              >
                                <template v-slot:activator="{ on, attrs }">
                                  <v-text-field
                                    v-model="booking_time"
                                    label="Booking time"
                                    readonly clearable
                                    readonly
                                    :rules="[rules.required]"
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-time-picker
                                  v-if="menu2"
                                  v-model="booking_time"
                                  @click:minute="$refs.menu.save(time)"
                                  :min="mintime"
                                  :max="maxTime"
                                  format="24hr"
                                  :allowed-minutes="allowedMinutes"
                                ></v-time-picker>
                              </v-menu>
                            </v-col>

                            <v-col cols="4">
                              <v-radio-group v-if="inspectionOtherDay" v-model="inspection_slot" column label="Inspection Slot" :rules="[rules.required]">
                                <v-radio label="Slot-A" value="Slot-A"></v-radio>
                                <v-radio label="Slot-B" value="Slot-B"></v-radio>
                              </v-radio-group>
                              <v-radio-group v-if="inspectionSaturdayDay" v-model="inspection_slot" column label="Inspection Slot" :rules="[rules.required]">
                                <v-radio label="Slot-A" value="Slot-A"></v-radio>
                                <v-radio label="Slot-B" value="Slot-B"></v-radio>
                                <v-radio label="Slot-C" value="Slot-C"></v-radio>
                                <v-radio label="Slot-D" value="Slot-D"></v-radio>
                              </v-radio-group>
                            </v-col>
                        </v-row>

                        <v-row >
                            <v-col cols="4">
                                <v-btn x-large color="warning" dark v-on:click="checkAvailable">check Availability</v-btn>
                            </v-col>
                            <v-col cols="8" v-if="limitExit">
                                <v-alert
                                  text
                                  prominent
                                  :type="limitExitType"
                                  icon="mdi-cloud-alert"
                                >
                                  {{limitExitMessage}}
                                </v-alert>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>


                <v-card class="mx-auto" style="margin-top: 15px;" >
                    <v-card-text>
                        <h6 class="pl-3 pt-4">Personal Details</h6>

                        <v-row>
                            <v-col cols="4">
                                <v-text-field label="First Name" v-model="first_name" type="text" :rules="[rules.required]">
                                </v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field label="Last Name" v-model="last_name" type="text" >
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <v-text-field label="E-mail" v-model="email" type="text" :rules="[rules.required, rules.email]">
                                </v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field label="Phone" v-model="phone" type="text" :rules="[rules.required]">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="8">
                                <v-textarea  autocomplete="Put your address" label="Address" v-model="address" :rules="[rules.required]" ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <v-card class="mx-auto" style="margin-top: 15px;" >
                    <v-card-text>
                        <h6 class="pl-3 pt-4">Car Details</h6>

                        <v-row>
                            <v-col cols="4">
                                <v-select v-model="type" :items="typeList" :rules="[rules.required]" label="Select Type">
                                </v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-select v-model="brand" :items="brandList" :rules="[rules.required]" label="Select Brand" v-on:change="showModel" >
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <v-select v-model="model" :items="filteredModelType" label="Select Model" class="" :rules="[rules.required]"></v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field label="Year Made" v-model="year_made" type="text" :rules="[rules.required]">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <v-select v-model="mileage" :items="mileageList" :rules="[rules.required]" label="Select Mileage">
                                </v-select>
                            </v-col>
                        </v-row>

                    </v-card-text>
                </v-card>

                <v-card-actions>
                    <v-btn x-large type="submit" color="primary" form="login-form" elevation="0"> Create Booking</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </div>
</template>

<style scoped>
    .v-application .mt-4{
            margin-top: 0 !important;
    }
</style>
<script>
    import validation from '@/assets/js/validation';
    import moment from 'moment'
    export default {
        name: 'login',
        mixins: [validation],
        data(){
            return{

                loading: false,
                inspectionOtherDay: false,
                inspectionSaturdayDay: false,
                limitExit: false,
                limitExitMessage: '',
                limitExitType: '',

                menu1: false,
                booking_date: '',
                dateFormatted: moment().format('YYYY-MM-DD'),

                menu2: false,
                booking_time: '',
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                address: '',
                type: '',
                typeList: [
                    {text: "Used", value: "Used"},
                    {text: "New", value: "New"},
                    {text: "Recon", value: "Recon"}
                ],
                brand: '',
                brandTemp: '',
                brandList: [
                    {text: "Proton", value: "Proton"},
                    {text: "Perodua", value: "Perodua"},
                    {text: "Honda", value: "Honda"},
                    {text: "Mercedes-Benz", value: "Mercedes-Benz"},
                    {text: "Nissan", value: "Nissan"}
                ],
                model: '',
                modelList: [
                    { text: "Arena", value: 'Arena' , type : 'Proton' },
                    { text: "Ertiga", value: 'Ertiga' , type : 'Proton' },
                    { text: "Exora", value: 'Exora' , type : 'Proton'},
                    { text: "Inspira", value: 'Inspira' , type : 'Proton'},
                    { text: "Persona", value: 'Persona' , type : 'Proton'},
                    { text: "Saga", value: 'Saga' , type : 'Proton'},
                    { text: "Alza", value: 'Alza' , type : 'Perodua'},
                    { text: "Axia", value: 'Axia' , type : 'Perodua'},
                    { text: "Myvi ", value: 'Myvi ' , type : 'Perodua'},
                    {  text: "Viva", value: 'Viva' , type : 'Perodua'},
                    { text: "Accord", value: 'Accord' , type : 'Honda'},
                    { text: "City ", value: 'City ' , type : 'Honda'},
                    {  text: "Civic", value: 'Civic' , type : 'Honda'},
                    { text: "Almera", value: 'Almera' , type : 'Nissan'},
                    { text: "Cefiro ", value: 'Cefiro ' , type : 'Nissan'},
                    {  text: "Dualis", value: 'Dualis' , type : 'Nissan'},
                    { text: "AMG GT", value: 'AMG GT' , type : 'Mercedes-Benz'}
                ],
                year_made: '',
                mileage: '',
                mileageList: [
                    { text: "10000 - 15000", value: '10000' },
                    { text: "15000 - 20000", value: '15000' },
                    { text: "20000 - 25000", value: '20000' }
                ],
                initialDay: moment().format('YYYY-MM-DD'),
                minDay: '',
                maxDay: '',
                availableDates: [],

                mintime: '9:00',
                maxTime: '18:00',
                inspection_slot: ''
            }
        },


        methods: {
            allowedMinutes: v => v % 30 === 0,
            allowedStep: m => m % 30 === 0,

            formatDate(date) {
                if (!date) return null
                const [year, month, day] = date.split('-')
                return `${month}/${day}/${year}`
            },
            parseDate(date) {
                if (!date) return null
                const [month, day, year] = date.split('/')
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            },

            showModel(evt){
                this.brandTemp = evt;
            },

            resetTime(){
                this.time = '';
                this.booking_time = '';
                this.inspection_slot = '';

                var d = new Date(this.booking_date);
                var weekday = new Array(7);
                weekday[0] = "Sunday";
                weekday[1] = "Monday";
                weekday[2] = "Tuesday";
                weekday[3] = "Wednesday";
                weekday[4] = "Thursday";
                weekday[5] = "Friday";
                weekday[6] = "Saturday";

                var dayName = weekday[d.getDay()];
                if(dayName === 'Saturday'){
                    this.inspectionOtherDay = false;
                    this.inspectionSaturdayDay = true;
                }else{
                    this.inspectionOtherDay = true;
                    this.inspectionSaturdayDay = false;

                }


                var currentDateTime = new Date();
                var extendedTime = moment(currentDateTime).add(1, 'hours').format('YYYY-MM-DD');

                var a = new Date(this.booking_date);
                var b = new Date(extendedTime);

                if(a.getTime() == b.getTime()) {
                    var extendedTime = moment(currentDateTime).add(1, 'hours').format('hh:mm');
                    this.mintime = extendedTime;
                }else{
                    this.mintime = '9:00';
                }



            },

            checkAvailable(){
                let selectedDateTime = this.booking_date+' '+this.booking_time;

                if( ( this.booking_date == '') || ( this.booking_time == '') || (this.inspection_slot == '') ){
                    this.limitExit = true;
                    this.limitExitMessage = 'Please select your booking date, time and inspection slot';
                    this.limitExitType = 'error';
                    return;
                }

                this.axios({
                    url: this.baseUrl + '/api/check-available?datetime=' + selectedDateTime+'&slot='+this.inspection_slot,
                    method: 'get',
                }).then((response) => {

                    var result = response.data;
                    if(result.limit == 1){
                        this.booking_time = '';
                        this.inspection_slot = '';
                        this.in = '';
                        this.limitExit = true;
                        this.limitExitMessage = result.message;
                        this.limitExitType = 'error';
                    }else{
                        this.limitExit = true;
                        this.limitExitMessage = result.message;
                        this.limitExitType = 'success';
                    }
                }).catch((response) => {

                });


            },

            setDate(){

                this.maxDay = moment(this.initialDay).add(21, 'days').format('YYYY-MM-DD');
                this.minDay = this.initialDay;

            },

            allowedDates(a) {
                return this.availableDates.includes(a);
            },

            pickerUpdate(val) {

                let totalDay = moment(val, "YYYY-MM").daysInMonth();
                let availableDates = [];
                let monthNow = moment().format('M');
                let monthSelected = moment(val).format('M');
                let day;

                if(monthNow == monthSelected)
                    day = moment().format('D');
                else
                    day = 1;

                for (let i = day; i <= totalDay ; i++) {
                    let date = moment().month(val.split('-')[1]-1).date(i).format("YYYY-MM-DD");
                    if (moment(date).day() !== 0)
                        availableDates.push(date);
                }
                this.availableDates = availableDates;
                this.allowedDates();
            },

            async  submit(evt) {
                evt.preventDefault();
                var valid = this.validate();
            },
            validate() {
                if (!this.$refs.form.validate()) {
                    return false;
                } else {
                    this.loading = true;
                    let currentObj = this;
                    var bodyFormData = new FormData();

                    bodyFormData.append('booking_date', this.booking_date);
                    bodyFormData.append('booking_time', this.booking_time);
                    bodyFormData.append('inspection_slot', this.inspection_slot);
                    bodyFormData.append('first_name', this.first_name);
                    bodyFormData.append('last_name', this.last_name);
                    bodyFormData.append('email', this.email);
                    bodyFormData.append('phone', this.phone);
                    bodyFormData.append('address', this.address);
                    bodyFormData.append('type', this.type);
                    bodyFormData.append('brand', this.brand);
                    bodyFormData.append('model', this.model);
                    bodyFormData.append('year_made', this.year_made);
                    bodyFormData.append('mileage', this.mileage);


                    this.axios.post(this.baseUrl + '/api/inspections',
                            bodyFormData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }
                        )
                        .then((response) => {

                            if (response.data.status == 1) {
                                this.loading = false;
                                this.limitExit = false;
                                this.$swal({
                                    title: "Success!",
                                    text: response.data.message,
                                    type: "success",
                                    timer: 2000,
                                });
                                this.$refs.form.reset();
                            } else {
                                this.loading = false;
                                this.$swal({
                                    title: "Failed!",
                                    text: response.data.message,
                                    type: "error",
                                    timer: 3000,
                                });
                            }
                        })
                        .catch(function(error) {
                            currentObj.output = error;
                        });

                    return true;
                }
            },

        },
        created() {
            this.baseUrl = this.$store.getters.getBaseUrl;
            this.setDate();
        },
        watch: {
            date(val) {
                this.dateFormatted = this.formatDate(this.date)
            },
        },
        computed: {
            computedDateFormatted() {
                return this.formatDate(this.date)
            },
            filteredModelType(){
                return this.modelList.filter(item => item.type === this.brandTemp);
            }
        },
    }

</script>
