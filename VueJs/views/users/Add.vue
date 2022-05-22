<template>

  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <div id="kt_content_container" class="container-fluid">
        <div class="row filter-demo-div">
          <div class="col-md-12 d-flex flex-stack">
            <div  class="page-title d-flex align-items-center flex-wrap lh-1">
              <h1 class="d-flex align-items-center text-dark fw-bolder m-0 fs-3">{{ $t('Add User')}}</h1>
              <span class="h-20px border-gray-200 border-start mx-4"></span>
              <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <li class="breadcrumb-item fw-bold">
                  <router-link :to='{name:"UserManagement"}' class="fw-bold text-hover-primary">{{ $t('User Management') }}</router-link>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark">{{ $t('Add User') }}</li>
              </ul>
            </div>
            <div class="d-flex align-items-center py-1">           
              <div>
                <router-link :to='{name:"UserManagement"}' class="btn btn-sm btn-secondary">
                  {{ $t('Back') }}
                </router-link>
              </div>
              
            </div>
          </div>
        </div>
        <div class="row h-100">
            <div class="card p-0">
            <div class="card-body pt-3">
              <form @submit.prevent="addUser" class="form w-100" method="post">
                <div class="mt-7">
                  <div class="fw-bold fs-5 mb-7">{{ $t('Please fill your user details.') }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold my-2 required">{{ $t('First name') }}</label>
                        <input type="text" class="form-control form-control-solid cursor-pointer" v-model="form.fname" required autocomplete="off"/>
                        <span class="text-danger my-1" v-if="errors.fname">{{ $t(errors.fname[0]) }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold my-2 required">{{ $t('Last name') }}</label>
                        <input type="text" class="form-control form-control-solid cursor-pointer" v-model="form.lname" required autocomplete="off"/>
                        <span class="text-danger my-1" v-if="errors.lname">{{ $t(errors.lname[0]) }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold my-2 required">{{ $t('Email') }}</label>
                        <input type="email" class="form-control form-control-solid cursor-pointer" v-model="form.email" required autocomplete="off"/>
                        <span class="text-danger my-1" v-if="errors.email">{{ $t(errors.email[0]) }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold my-2">{{ $t('Profile Picture') }}</label>
                        <input type="file" class="form-control form-control-solid cursor-pointer" v-on:change="uploadProfilePicture"  accept=".jpeg,.jpg,.png"/>
                        <span class="text-danger my-1" v-if="errors.avatar">{{ $t(errors.avatar[0]) }}</span>
                    </div>
                </div>
                <div class="row mb-4">
                  <div class="col-md-6 mb-2">
                    <label class="fw-bold my-2 required">{{ $t('Password') }}</label>
                    <input type="password" class="form-control form-control-solid cursor-pointer" v-model="form.password" required autocomplete="new-password"/>
                    <span class="text-danger my-1" v-if="errors.password">{{ $t(errors.password[0]) }}</span>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="fw-bold my-2 required">{{ $t('Password Confirmation') }}</label>
                    <input type="password" class="form-control form-control-solid cursor-pointer" v-model="form.password_confirmation" required autocomplete="new-password"/>
                    <span class="text-danger my-1" v-if="errors.password_confirmation">{{ $t(errors.password_confirmation[0]) }}</span>
                  </div>
                </div> 
                <div class="row mb-4">
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold my-2">{{ $t('Status') }}</label>
                        <div class="form-check form-check-custom form-check-solid form-switch mb-2">
                        <input class="form-check-input cursor-pointer" type="checkbox" name="layout-builder[layout][aside][display]" value="true" v-model="form.status" checked="checked">
                        <span class="text-danger my-1" v-if="errors.status">{{ $t(errors.status[0]) }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="fw-bold my-2">{{ $t('Send Mail') }}</label>
                        <div class="form-check form-check-custom form-check-solid form-switch mb-2">
                            <input class="form-check-input cursor-pointer" type="checkbox" name="layout-builder[layout][aside][display]" value="true" v-model="form.sendMail" checked="checked">
                            <span class="text-danger my-1" v-if="errors.sendMail">{{ $t(errors.sendMail[0]) }}</span>
                        </div>
                    </div>                   
                </div>
                <div class="row mb-4">
                  <div class="col-md-12 mb-2 text-end">
                    <router-link :to='{name:"UserManagement"}' class="btn btn-sm btn-secondary me-2">
                      {{ $t('Cancel') }}
                    </router-link>
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-sm btn-primary" :disabled="loader">
                      <span class="indicator-label">{{ $t('Submit') }}</span>
                      <span v-show="loader"><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                  </div>
                </div>                
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="loading" v-if="loader">
      <div class="loader"></div>
    </div>
  </div>  
</template>
<script>
  import User from "../../apis/User";

  export default {
    name: 'add-user',
    data(){
      return {
        form:{
          email: null,
          fname: null,
          lname: null,
          client_role: null,
          client: {
              'label': '',
              'value': ''
          },
          avatar: null,
          password: null,
          password_confirmation: null,
          sendMail: null,
          status: true
        },
        avatar_file: null,
        loader: false,
        errors: {},
      }
    },
    mounted() {
      if(localStorage.user_role == 'Client') {
        this.$router.push({ name: "Dashboard" })
      }
    },
    methods:{
      async addUser(){
        this.loader = true
        if(this.avatar_file != null){
            let fileData = new FormData()
            fileData.append('avatar', this.avatar_file)
            fileData.append('email', this.form.email)
            User.uploadProfilePicture(fileData).then(res => {
                this.form.avatar = res.data.path;             
                this.CreateUser();
            }).catch(error=> {
                this.loader = false
                if (error.response.status === 400) {
                  this.$toast.error(this.$t(error.response.data.errors))
                }
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors
                }
            })
        }else{
            this.CreateUser();
        }
       
      },
      async CreateUser(){
         User.create(this.form).then(res => {
            this.$toast.success(this.$t(res.data.message))
            this.$router.push({name:"UserManagement"})
            this.loader = false
          }).catch(error=> {
            if (error.response.status === 400) {
              this.$toast.error(this.$t(error.response.data.errors))
            }
            if (error.response.status === 422) {
              this.errors = error.response.data.errors
            }
            this.loader = false
          })
      },
      async uploadProfilePicture(event){
            this.avatar_file = event.target.files[0]
      }
    }
  };
</script>