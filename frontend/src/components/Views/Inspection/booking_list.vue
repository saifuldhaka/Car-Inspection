<template>  
    <div class="container-fluid">

        <!--  v- modal box -->
        <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="600px">
                <v-card>
                    <v-card-title>
                        <span class="headline">Inspection Booking Details</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12"  md="12"  >
                                    Booking Date : {{bookingDate}}
                                </v-col>
                                <v-col cols="12"  md="12"  >
                                    Inspection Slot: {{inspectionSlot}}
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-title>
                        <span class="headline">Personel Details</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12"  md="12"  >
                                    Name: {{name}} 
                                </v-col>
                                <v-col cols="12"  md="12"  >
                                    Address : {{address}}
                                    
                                </v-col>
                                <v-col cols="6"  md="6"  >
                                    Email: {{email}}
                                </v-col>
                                <v-col cols="6"  md="6"  >
                                    Phone: {{phone}}
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-title>
                        <span class="headline">Car Details</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="6"  md="6"  >
                                    Brand: {{brand}} 
                                </v-col>
                                <v-col cols="6"  md="6"  >
                                    Model : {{model}}
                                    
                                </v-col>
                                <v-col cols="6"  md="6"  >
                                    Type: {{type}}
                                </v-col>
                                <v-col cols="6"  md="6"  >
                                    Year Made: {{yearMade}}
                                </v-col>
                                <v-col cols="6"  md="6"  >
                                    Mileage: {{mileage}} 
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                    </v-card-actions>
                    
                </v-card>
            </v-dialog>
        </v-row>
        <!-- end modal box -->

        <v-card class="p-3" >
            <p class="display-1 text--primary">
               Inspection Booking List
            </p>

        
            <div v-if="failed_ckeck" class="text-center"  style="padding: 50px;">
                <v-alert type="warning">
                  <strong>Ops!</strong> No result found.
                </v-alert>                
                <br /><br /><br />
                <img src="../../../assets/warning.png" style="width: 100px;" class="logo"> 
            </div>

            <!-- recon report -->
            <v-card-text>
                <v-row>
                    <div class="v-data-table font-weight-regular theme--light">
                        <div class="v-data-table__wrapper table-responsive">
                            <table class="table table-striped table-bordered elevation-3 font-80">
                                <thead class="v-data-table-header">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Year Made</th>
                                        <th>Mileage</th>
                                        <th>Booking Date</th>
                                        <th>Inspection Slot</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="data in datalist">
                                        <td >{{data.name}}</td>
                                        <td >{{data.email}}</td>
                                        <td >{{data.phone}}</td>
                                        <td >{{data.address}}</td>
                                        <td >{{data.type}}</td> 
                                        <td >{{data.brand}}</td>
                                        <td >{{data.model}}</td>
                                        <td>{{data.year_made}}</td>
                                        <td >{{data.mileage}}</td>
                                        <td >{{data.booking_date}}</td>
                                        <td >{{data.inspection_slot}}</td>
                                        
                                        <td >
                                            <button x-small @click="showDetails(data)" class="mx-1 my-2 bg-primary rounded-circle">
                                                <i class="mdi mdi-eye text-white p-1"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </v-row>
                <div class="text-center">
                    <v-pagination
                      v-model="page"
                      :length="last_page"
                      :total-visible="7"
                      circle
                      @input="pagination"
                    ></v-pagination>
                </div>
                <div class="text-right">
                    Page {{this.current_page}} of {{this.last_page}}, showing {{this.per_page}} records out of {{this.total_record}} total, starting on record {{this.from_record}}, ending on {{this.to_record}}
                </div>


                
            </v-card-text>
            
            
        </v-card> 

    </div>
</template>
<style>
.hideheader {
    display: none;
}

</style>
<script>
  import validation from'@/assets/js/validation';

  export default {

    name: 'Inspection Boolink List',
    mixins: [validation],
    data(){
        return{
            current_page: '',
            per_page: '',
            total_record: '',
            from_record: '',
            to_record: '',
            failed_ckeck: false,
            status: '',
            error : false,

            datalist : [],
            // pagination
            page: 1,            
            last_page: 1,

            // modal
            dialog: false,
            name: '',
            address: '',
            email: '',
            phone: '',
            brand: '',
            model: '',
            type: '',
            yearMade: '',
            mileage: '',
            bookingDate: '',
            inspectionSlot:'',
            interval: '',

        }  
    },


    methods:  {

        getData(page) {

            this.page = page;
            var url = this.baseUrl + '/api/inspections?page='+page;
            this.axios({
                url: url,
                method: 'get',
            }).then((response) => {
                let result = response.data; 
                if (result.data.length > 0) {
                    this.failed_ckeck = false;
                }else{
                    this.failed_ckeck = true;
                }

                let dataResponse = [];
                                    
                for (let i = 0; i < result.data.length; i ++ ) {    
                    
                    dataResponse.push({
                        id: result.data[i].id, 
                        name : result.data[i].first_name + ' ' + result.data[i].last_name,
                        email : result.data[i].email,
                        phone : result.data[i].phone,
                        address : result.data[i].address,
                        type : result.data[i].type,
                        brand : result.data[i].brand,
                        model : result.data[i].model,
                        year_made : result.data[i].year_made,
                        mileage : result.data[i].mileage,
                        booking_date : result.data[i].booking_date,
                        inspection_slot : result.data[i].inspection_slot                        

                    })
                }
                this.datalist = dataResponse;
                this.current_page = result.current_page;
                this.last_page = result.last_page;
                this.per_page = result.data.length;
                this.total_record = result.total;
                this.from_record = (result.from === null) ? 0 : result.from;
                this.to_record = (result.to === null) ? 0 : result.to; 
            }).catch((response) => {

            });
            return true;
        },

        pagination(page) {
            this.getData(page);
        },
       
        showDetails(item) {
            this.name = item.name;
            this.address = item.address;
            this.email = item.email;
            this.phone = item.phone;
            this.brand = item.brand;
            this.model = item.model;
            this.type = item.type;
            this.yearMade = item.year_made;
            this.mileage = item.mileage;
            this.bookingDate = item.booking_date;
            this.inspectionSlot = item.inspection_slot;
            this.dialog = true;
        },

        formatDate(date) {
            var newDate = new Date(dateVal);

            var sMonth = padValue(newDate.getMonth() + 1);
            var sDay = padValue(newDate.getDate());
            var sYear = newDate.getFullYear();
            var sHour = newDate.getHours();
            var sMinute = padValue(newDate.getMinutes());
            var sAMPM = "AM";

            var iHourCheck = parseInt(sHour);

            if (iHourCheck > 12) {
                sAMPM = "PM";
                sHour = iHourCheck - 12;
            }
            else if (iHourCheck === 0) {
                sHour = "12";
            }

            sHour = padValue(sHour);

            return sYear+" - "+sMonth + "-" + sDay  + " " + sHour + ":" + sMinute + " " + sAMPM;
        }

    },
    created() {
        this.baseUrl = this.$store.getters.getBaseUrl;
        this.getData(1);
        this.interval = setInterval(() => this.getData(1), 10000);
      
    },
    watch : {
    },
    computed: {
    }
  }
</script>
