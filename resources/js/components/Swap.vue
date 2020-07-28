<template class="row">
    
    <div>
        <div class="form-group col-12" >
            <div class="alert alert-danger" role="alert" v-if="errors.length">
                <span v-for="error in errors" :key="error">Attention: {{ error }}</span>
            </div>
            <input name="oldsubdomain" type="hidden" v-model="oldsubdomain">
            <label id="title" for="subdomain">Subdomain</label>
            <input id="subdomain" type="text" class="form-control" name="subdomain" placeholder="SwapMiei" v-model="subdomain" maxlength="255" required>
        </div>

        <div class="form-group col-12">
            <label id="title" for="email">Institutional E-mail</label>
            <input id="email" type="text" name="email" class="form-control" placeholder="alunos.uminho.pt" v-model="email" maxlength="255" >
        </div>

        <div class="form-group col-12">
            <label id="title" for="format">E-mail Format</label>
            <input id="format" type="text" name="format" class="form-control" placeholder="a****" v-model="format" minlength="2" required>
        </div>

        <div class="row col-12">
            <div class="form-group col-6">
                <label id="title" for="emailAdmin">Admin Account</label>
                <input id="emailAdmin" class="form-control"  type="email" name="emailAdmin" v-model="emailAdmin" minlength="4" maxlength="255" required>
            </div>

            <div class="form-group col-6">
                <label id="title" for="password">Password</label>
                <input id="password" class="form-control" type="password" name="password" minlength="8" v-model="password" required>
            </div>
        </div>

        <swap-courses :subdomain="subdomain" :Courses="Courses" :oldSubdomain="oldsubdomain" :allFilled="allfilled"></swap-courses>
    </div>
</template>



<script>
  import SwapCourses from "./SwapCourses.vue"; 
  export default {
    components: {
      SwapCourses
    },
    props:['Info','subDomain', 'Courses'],
    mounted: function() {
        
        if(this.info!==undefined){
            this.subdomain = this.info[0].subdomain;
            this.email = this.info[0].institutional_mail;
            this.format = this.info[0].email_format;
            this.emailAdmin = this.info[0].email_admin;
            this.errors=[];
            this.oldsubdomain=this.info[0].subdomain;
        }
        else{
            this.subdomain='';
        }

    },
    methods: {
        async validate(val){
            this.errors=[];
            if(this.oldsubdomain=='' || this.info[0].subdomain !== this.subdomain){
                if(val !== ""){
                let axios = require('axios');
                axios.get('/validateSubdomain/'+val)
                .then(response => {
                    console.log("RESPONSE");
                    console.log(response.data);
                    if(response.data==0){
                    this.errors.push('This subdomain already exists.');
                    }
                })
                .catch(e => {
                    this.errors.push(e);
                });
            }
            }
            
        }
    },
    watch:{
        async subdomain(val){
            this.validate(val);
        },
        errors(){

        },
        allFilled(){
            
        }
    },
    computed:{
        allFilled(){
            if(this.subdomain!==''  && this.email!=='' && this.format!=='' && this.emailAdmin!=='' && this.password!==''){
                this.allfilled=1; 
            }
            else{
                this.allfilled=0;
            }
        }
    },
    data() {
      return{
        errors: [],
        subdomain: this.subdomain,
        email:'',
        format:'',
        emailAdmin:'',
        info:this.Info,
        oldsubdomain:'',
        password:'',
        allfilled:0,
      }
    }
  }
</script>
