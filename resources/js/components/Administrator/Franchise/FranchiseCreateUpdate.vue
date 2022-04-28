<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">

                    <form @submit.prevent="submit">

                        <div class="panel">
                            <div class="panel-content">
                                <h1 class="title is-5">NEW FRANCHISE</h1>
                                <hr>

                                <b-field grouped>
                                    <b-field label="Date Acquired" label-position="on-border" expanded
                                             :type="this.errors.date_acquired ? 'is-danger':''"
                                             :message="this.errors.date_acquired ? this.errors.date_acquired[0] : ''">
                                        <b-datepicker v-model="fields.date_acquired" placeholder="Date acquired" required></b-datepicker>
                                    </b-field>
                                    <b-field label="Franchise Reference" label-position="on-border" expanded
                                             :type="this.errors.franchise_reference ? 'is-danger':''"
                                             :message="this.errors.franchise_reference ? this.errors.franchise_reference[0] : ''">
                                        <b-input type="text" v-model="fields.franchise_reference" placeholder="Franchise Reference..." required/>
                                    </b-field>
                                </b-field>

                                <b-field label="Name of Operator" label-position="on-border"
                                         :type="this.errors.operator_name ? 'is-danger':''"
                                         :message="this.errors.operator_name ? this.errors.operator_name[0] : ''">
                                    <b-input type="text" v-model="fields.operator_name" placeholder="Name of Operator" required></b-input>
                                </b-field>

                                <b-field grouped>
                                    <b-field label="Province" label-position="on-border" expanded
                                        :type="this.errors.province ? 'is-danger':''"
                                        :message="this.errors.province ? this.errors.province[0] : ''">
                                        <b-select v-model="fields.province" @input="loadCity" expanded>
                                            <option v-for="(item, index) in provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                        </b-select>
                                    </b-field>
                                    <b-field label="City" label-position="on-border" expanded
                                            :type="this.errors.city ? 'is-danger':''"
                                            :message="this.errors.city ? this.errors.city[0] : ''">
                                        <b-select v-model="fields.city" @input="loadBarangay" expanded>
                                            <option v-for="(item, index) in cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                        </b-select>
                                    </b-field>
                                </b-field>

                                <b-field grouped>
                                    <b-field label="Barangay" label-position="on-border" expanded
                                                :type="this.errors.barangay ? 'is-danger':''"
                                                :message="this.errors.barangay ? this.errors.barangay[0] : ''">
                                        <b-select v-model="fields.barangay" expanded>
                                            <option v-for="(item, index) in barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                        </b-select>
                                    </b-field>
                                    <b-field label="Street" label-position="on-border" expanded>
                                        <b-input v-model="fields.street" expanded
                                                    placeholder="Street">
                                        </b-input>
                                    </b-field>
                                </b-field>

                                <b-field grouped>
                                    <b-field label="Vehicle Reference" label-position="on-border" expanded
                                            :type="this.errors.vehicle_reference ? 'is-danger':''"
                                            :message="this.errors.vehicle_reference ? this.errors.vehicle_reference[0] : ''">
                                        <b-input type="text" v-model="fields.vehicle_reference" placeholder="Vehicle Reference" expanded required></b-input>
                                    </b-field>
                                    <b-field label="Chassis Reference" label-position="on-border" expanded
                                        :type="this.errors.chassis_reference ? 'is-danger':''"
                                        :message="this.errors.chassis_reference ? this.errors.chassis_reference[0] : ''">
                                        <b-input v-model="fields.chassis_reference" expanded required
                                                    placeholder="Chassis Reference">
                                        </b-input>
                                    </b-field>
                                </b-field>


                                <b-field grouped>
                                    <b-field label="Make" label-position="on-border" expanded
                                            :type="this.errors.make ? 'is-danger':''"
                                            :message="this.errors.make ? this.errors.make[0] : ''">
                                        <b-input type="text" v-model="fields.make" placeholder="Make" expanded required></b-input>
                                    </b-field>
                                    <b-field label="Plate No." label-position="on-border" expanded
                                        :type="this.errors.plate_no ? 'is-danger':''"
                                        :message="this.errors.plate_no ? this.errors.plate_no[0] : ''">
                                        <b-input v-model="fields.plate_no" expanded required
                                                    placeholder="Plate No.">
                                        </b-input>
                                    </b-field>
                                </b-field>

                                <b-field grouped>
                                    <b-field label="Route Operation" label-position="on-border" expanded
                                            :type="this.errors.route_operation ? 'is-danger':''"
                                            :message="this.errors.route_operation ? this.errors.route_operation[0] : ''">
                                        <b-input type="text" v-model="fields.route_operation" placeholder="Route Operation" expanded required></b-input>
                                    </b-field>
                                    <b-field label="Cab No." label-position="on-border" expanded
                                        :type="this.errors.cab_no ? 'is-danger':''"
                                        :message="this.errors.cab_no ? this.errors.cab_no[0] : ''">
                                        <b-input v-model="fields.cab_no" expanded required
                                                    placeholder="Cab No.">
                                        </b-input>
                                    </b-field>
                                </b-field>

                                <div class="buttons">
                                    <button class="button is-primary">SUBMIT</button>
                                </div>
                            </div><!--panel content -->
                        </div> <!--panel-->
                    </form>
                </div>
            </div>
        </div>


    </div><!--root div-->
</template>

<script>
export default {

    props: ['dataId', 'propData'],
    data(){
        return{
            fields: {},
            errors: {},

            provinces: [],
            cities: [],
            barangays: [],

            id: 0,
        }

    },


    methods: {
        loadProvince: function(){
            axios.get('/load-provinces').then(res=>{
                this.provinces = res.data;
            })
        },

        loadCity: function(){
            axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                this.cities = res.data;
            })
        },

        loadBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                this.barangays = res.data;
            })
        },


        submit: function(){
            if(this.id>0){
                //update
                axios.put('/franchise/' + this.id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            message: 'Franchise save updated.',
                            type: 'is-success',
                            title: 'UPDATED!',
                            onConfirm : ()=>{
                                window.location = '/franchise';
                            }
                        })
                    }
                }).catch(err=>{
                    this.errors = err.response.data.errors;
                })
            }else{
                //insert
                axios.post('/franchise', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            message: 'Franchise save successfully.',
                            type: 'is-success',
                            title: 'SAVED!',
                            onConfirm : ()=>{
                                window.location = '/franchise';
                            }
                        })
                    }
                }).catch(err=>{
                    this.errors = err.response.data.errors;
                })
            }
        },

        getData: function(){
            axios.get('/get-franchise').then(res=>{
                this.fields = res.data;
            })
        },

        initData: function(){
            this.id = JSON.parse(this.dataId);
            if(this.id>0){
               
                let tempData = JSON.parse(this.propData);

                this.fields.date_acquired = new Date(tempData.date_acquired);
                this.fields.franchise_reference = tempData.franchise_reference;
                this.fields.operator_name = tempData.operator_name;
                this.fields.province = tempData.provCode;

                axios.get('/load-cities?prov='+tempData.provCode).then(res=>{
                    this.cities = res.data;
                    console.log(res.data[0]);
                    this.fields.city = tempData.citymunCode;

                     axios.get('/load-barangays?prov='+tempData.provCode + '&city_code=' + tempData.citymunCode).then(res=>{
                         this.barangays = res.data;
                         this.fields.barangay = tempData.brgyCode;
                     });
                });

                this.fields.street = tempData.street;
                this.fields.vehicle_reference = tempData.vehicle_reference;
                this.fields.chassis_reference = tempData.chassis_reference;
                this.fields.make = tempData.make;
                this.fields.plate_no = tempData.plate_no;
                this.fields.route_operation = tempData.route_operation;
                this.fields.cab_no = tempData.cab_no;
                this.fields.remarks = tempData.remarks;
            }
        }
    },

    mounted() {
        this.loadProvince();
        this.initData();
    }

}
</script>

<style>
    .panel-content{
        padding: 15px;
        border-radius: 5px;
        border: 1px solid rgb(209, 209, 209);
    }
</style>
