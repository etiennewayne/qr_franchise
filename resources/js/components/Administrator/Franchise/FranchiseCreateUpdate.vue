<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="panel">
                        <div class="panel-content">
                            <h1 class="title is-5">NEW FRANCHISE</h1>
                            <hr>

                            <b-field grouped>
                                <b-field label="Date Acquired" label-position="on-border" expanded>
                                    <b-datepicker placeholder="Date acquired"></b-datepicker>
                                </b-field>
                                <b-field label="Franchise Reference" label-position="on-border" expanded>
                                    <b-input type="text" placeholder="Franchise Reference..." required/>
                                </b-field>
                            </b-field>

                            <b-field label="Name of Operator" label-position="on-border">
                                <b-input type="text" placeholder="Name of Operator"></b-input>
                            </b-field>

                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div><!--root div-->
</template>

<script>
export default {

}
</script>

<style>
    .panel-content{
        padding: 15px;
    }
</style>