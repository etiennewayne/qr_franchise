<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="camera">
                        <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit">
                            <div v-if="validationSuccess" class="validation-success">
                                Scanned successfully.
                            </div>

                            <div v-if="validationFailure" class="validation-failure">
                                Nothing found.
                            </div>

                            <div v-if="validationPending" class="validation-pending">
                                Processing...
                            </div>
                        </qrcode-stream>
                    </div>

                    <p class="decode-result">QR Code: <b>{{ result }}</b></p>

                    <div class="buttons mt-1 is-centered">
                        <b-button @click="turnCameraOn" label="TURN ON"></b-button>
                        <b-button @click="turnCameraOff" label="TURN OFF"></b-button>

                    </div>

                </div><!--col-->
            </div><!--close div -->

            <div class="columns is-centered">
                <div class="column is-6">
                    <table class="table is-fullwidth">
                        <thead>
                            <th>Properties</th>
                            <th>Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>FRANCHISE REF</td>
                                <td>{{ data.franchise_reference }}</td>
                            </tr>
                            <tr>
                                <td>DATE ACQUIRED</td>
                                <td>{{ data.date_acquired }}</td>
                            </tr>
                            <tr>
                                <td>OPERATOR</td>
                                <td>{{ data.operator_name }}</td>
                            </tr>
                            <tr>
                                <td>VEHICLE REF</td>
                                <td>{{ data.vehicle_reference }}</td>
                            </tr>
                            <tr>
                                <td>CHASSIS REF</td>
                                <td>{{ data.chassis_reference }}</td>
                            </tr>
                            <tr>
                                <td>MAKE</td>
                                <td>{{ data.make }}</td>
                            </tr>
                            <tr>
                                <td>PLATE NO.</td>
                                <td>{{ data.plate_no }}</td>
                            </tr>
                            <tr>
                                <td>ROUTE OPERATION</td>
                                <td>{{ data.route_operation }}</td>
                            </tr>
                            <tr>
                                <td>CAB NO.</td>
                                <td>{{ data.cab_no }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!--section -->

    </div><!--root div-->
</template>

<script>
export default {
    data(){
        return{

            isValid: undefined,
            camera: 'off',
            result: null,
            isProcessing: false,

            isModalValidModal: false,

            data: {},
        }
    },

    methods: {

        onInit (promise) {
            promise
                .catch(console.error)
                .then(this.resetValidationState)
        },

        resetValidationState () {
            this.isValid = undefined
        },

        async onDecode (content) {
            //console.log(content);
            this.result = content;
            this.turnCameraOff();

            // pretend it's taking really long
            this.isProcessing = true;
            //await this.timeout(3000);

            axios.post('/validate-qr/', {
                data : content
            }).then(res=>{
                this.user = res.data;
                this.isProcessing = false;

                if(res.data !== ''){
                    this.isValid = true;
                    this.data = res.data;
                    //this.loadAsyncData();
                    //this.submitTrack();
                }else{
                    this.isProcessing = false;
                    this.isValid = false;
                    this.data = {};
                }
            }).catch(err=>{
                this.isProcessing = false;
                this.data = {};
            })
            //this.isValid = content.startsWith('http') //this will return boolean value

            // some more delay, so users have time to read the message
            await this.timeout(2000);
            this.turnCameraOn()
        },

        turnCameraOn () {
            this.camera = 'auto';
        },

        turnCameraOff () {
            this.camera = 'off'
        },

        timeout (ms) {
            return new Promise(resolve => {
                window.setTimeout(resolve, ms)
            })
        },

    },

    computed: {
        validationPending() {
            return this.isProcessing;
        },

        validationSuccess() {

            return this.isValid === true
        },

        validationFailure() {
            return this.isValid === false
        },
    },


}
</script>

<style scoped>

.validation-success,
.validation-failure,
.validation-pending {
    position: absolute;
    width: 100%;
    height: 100%;

    background-color: rgba(255, 255, 255, .8);
    text-align: center;
    font-weight: bold;
    font-size: 1.4rem;
    padding: 10px;

    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
}
.validation-success {
    color: green;
}
.validation-failure {
    color: red;
}

.camera{
    margin: auto;
    width: 240px;
    height: 320px;
    border: 1px solid gray;
}

.decode-result{
    text-align: center;
}


</style>
