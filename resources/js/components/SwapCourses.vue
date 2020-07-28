<template>
    <div>
        <div class="col-12" >
        <label id="title" for="format">Courses</label>
        <div class="row">
            <div class="col-5" style="padding-left:0px">
            <div class="form-group col-10">
                <label id="subtitle" for="name">Name</label>
                <input id="name" type="text" class="form-control"  v-model="name" placeholder="LEI" >
            </div>

            <div class="form-group col-10">
                <label id="subtitle" for="code">Code</label>
                <input id="code" type="text" class="form-control" v-model="code" placeholder="HP1998" >
            </div>

            <div class="form-group col-10">
                <label id="subtitle" for="year">Year</label>
                <input id="year" type="text" class="form-control" v-model="year" placeholder="4" >
            </div>

            <div class="form-group col-10">
                <label id="subtitle" for="semester">Semester</label>
                <input id="semester" type="text" class="form-control" v-model="semester" placeholder="2" >
            </div>
        
            <div class="form-group col-4">
                <button type="button" class="btn btn-primary btn-sm" v-on:click="addCourse()">Add</button>
            </div>
            <div class="col-10">
              <div class="alert alert-danger" role="alert" v-if="errors.length">
                  <span>Attention:</span>
                  <li v-for="error in errors" :key="error">{{ error }}</li>
              </div>
            </div>
            </div>
        

            <div class="col-6 table-responsive-xl table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Year</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Remove</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="c in courses" :key="c.code">
                    <td> {{c.name}} </td>
                    <td> {{c.code}} </td>
                    <td> {{c.year}} </td>
                    <td> {{c.semester}} </td>
                    <td class="centered"><button class="btn btn-danger" v-on:click="deleteCourse(c.code)">Remove</button></td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>

        <div class="form-group col-5">
        <div class="input-group mb-3">
            <form>
          <div class="form-group">
            <label for="exampleFormControlFile1">Import csv file with courses</label>
            <p>(name, code, year, semester)</p>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" @change="readFile">
          </div>
        </form>
        </div>
        </div>
        
        <div class="col-12">
          <a class="btn btn-danger btn-lg" style="float: left;" :href="'/'">Cancel</a>
          <button v-if="oldSubdomain=='' " type="submit" class="btn btn-primary btn-lg" style="float: right;" v-on:click="sendCourses" :disabled="allFilled==0">Create Swap</button>
          <button v-if="oldSubdomain!==''" type="submit" class="btn btn-primary btn-lg" style="float: right;" v-on:click="sendCourses" :disabled="allFilled==0">Reset Swap</button>
          <div class="d-flex justify-content-center" v-if="ready==1">
              <div class="spinner-border" role="status" ></div>
          </div>
          

        </div>
    </div>
</template>

<script>
  export default {
    
    props:['selName', 'selCode', 'selYear', 'selSemester','subdomain','Courses','oldSubdomain','allFilled'],
    watch: {
      availability(current) {
        if (current) {
          console.log(current)
        } 
      }
    },
    methods: {
        async sendCourses(){
          this.ready=1;
          if(this.allFilled == 1){
            let axios = require('axios');
            axios.post('/addCourses/',[
              this.subdomain,this.oldSubdomain,this.courses,])
            .then(response => {
            })
            .catch(e => {
              this.errors.push(e);
            });
          }
        },
        validation: function(e){
          this.errors = [];

          if (!this.name) {
            this.errors.push("Name required!");
          }
          if (!this.code) {
            this.errors.push('Code required.');
          }
          if (!this.year) {
            this.errors.push('Year required.');
          }
          else{
              if(this.year <1 || this.year >6){
                this.errors.push('Invalid year.'); 
              }
          }
          if (!this.semester) {
            this.errors.push('Semester required.');
          }
          else{
              if(this.semester <1 || this.semester >2){
                this.errors.push('Invalid semester.'); 
              }
          }

          if (!this.errors.length) {
            return true;
          }
          return false;
      },

      addCourse: function(message) {
        if(!this.validation(message)){
          return false;
        }

        if(this.existingCourse(this.code)!=-1){
          this.errors.push('That code already exists.');
          return false;
        }
        var course = {
          name:this.name,
          code: this.code,
          year: this.year,
          semester: this.semester
        };
        this.courses.push(course);
        this.name="";
        this.code="";
        this.year="";
        this.semester="";
        return true;
      },

      deleteCourse: function(code){
        var index = this.existingCourse(code);
        this.courses.splice(index, 1);
      },

      existingCourse: function(code){
        for(var i=0; i<this.courses.length;i++){
          if(this.courses[i].code == code){
            return i;
          };
        };
        return -1;
      },

      addCsvCourses: function(){
        var arrayLength = this.availability.length;
        for (var i = 0; i < arrayLength; i++) {
          var course=this.availability[i];
          if(course.name!==""){
            if(this.existingCourse(course.code)==-1){
              if(course.year>=1 && course.year<=6 && (course.semester==1 || course.semester==2)){
                this.courses.push(course);
              }
            }
          }
        } 
      },
      readFile() {
            /* return first object in FileList */
            var file = event.target.files[0];
            this.availability=this.$papa.parse(file, {
                header: true,
                complete: (results) => {
                  this.availability = results.data;
                }
            });
        }
    },
    watch: {
        availability: function(){
            this.addCsvCourses();
        },
        readyfunction(){}
    },
    mounted: function() {

        if (this.Courses == undefined){
          this.courses=[];
        } 
        else{
          this.courses=this.Courses;
          this.oldsubdomain=this.oldSubdomain;
        }
    },
    data() {
      return{
        errors: [],
        courses: this.Courses,
        name : this.selName,
        code : this.selCode,
        year : this.selYear,
        semester: this.selSemester,
        subdomain: this.subdomain,
        availability: null,
        oldsubdomain:'',
        ready:0,
      }
    }
  }
</script>
