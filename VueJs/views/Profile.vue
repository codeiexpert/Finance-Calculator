<template>
 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
     <div class="row filter-demo-div">
      <div class="col-md-12">
        <div class="d-flex flex-stack">
          <div class="d-inline-block">
            <h1 class="d-inline-block align-items-center text-dark fw-bolder m-0 fs-3">{{ $t('My Profile')}}</h1>
          </div>
          <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary" id="kt_aside_mobile_toggle">
              <span class="svg-icon svg-icon-2x mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24" />
                    <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                    <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
                  </g>
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row h-100">
      <div class="card p-0">
        <div class="card-body pt-3">
          <form @submit.prevent="updateUser" class="form w-100 mt-5" method="post">
            <div class="row mb-4">
              <div class="col-md-6 mb-2">
                <label class="fw-bold my-2">{{ $t('Username') }}</label>
                <span class="form-control initiative-field form-control-solid">{{ user.username }}</span>
              </div>
              <div class="col-md-6 mb-2">
                <label class="fw-bold my-2 required">{{ $t('Email') }}</label>
                <span class="form-control initiative-field form-control-solid">{{ user.email }}</span>
              </div>            
              <div class="col-md-6 mb-2">
                  <label class="fw-bold my-2 required">{{ $t('First name') }}</label>
                  <input type="text" class="form-control form-control-solid cursor-pointer" placeholder="Enter First Name" v-model="form.fname" required autocomplete="off"/>
                  <span class="text-danger my-1" v-if="errors.fname">{{ $t(errors.fname[0]) }}</span>
              </div>
              <div class="col-md-6 mb-2">
                  <label class="fw-bold my-2 required">{{ $t('Last name') }}</label>
                  <input type="text" class="form-control form-control-solid cursor-pointer" placeholder="Enter Last Name" v-model="form.lname" required autocomplete="off"/>
                  <span class="text-danger my-1" v-if="errors.lname">{{ $t(errors.lname[0]) }}</span>
              </div>   
              <div class="mb-2  d-flex gap-3">
                  <div>
                      <label class="fw-bold my-2">{{ $t('Profile Picture') }}</label>
                      <input type="file" class="form-control form-control-solid cursor-pointer" v-on:change="uploadProfilePicture"  accept=".jpeg,.jpg,.png"/>
                      <span class="text-danger my-1" v-if="errors.avatar">{{ $t(errors.avatar[0]) }}</span>     
                  </div>
                    <div class="mt-10">
                      <img class="user_profile_pic rounded-circle" width="35" height="35" alt="profile picture" :src="user_profile_picture ? user_profile_picture : '/uploads/blank.png'">
                  </div>
              </div>
            </div>
            <div class="row mt-10">
              <div class="col-md-12 mb-2">
                <label class="d-flex align-items-center mb-2">
                  <span class="fs-5 fw-bolder">{{ $t('Login credentials') }}</span>
                </label>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6 mb-2">
                <label class="fw-bold my-2">{{ $t('Password') }}</label>
                <input type="password" class="form-control initiative-field form-control-solid" v-model="form.password"  autocomplete="false" />
                <small class="text-muted w-100">Leave empty if don't want to change password</small>
                <span class="text-danger my-1" v-if="errors.password">{{ $t(errors.password[0]) }}</span>
              </div>
              <div class="col-md-6 mb-2">
                <label class="fw-bold my-2">{{ $t('Password Confirmation') }}</label>
                <input type="password" class="form-control initiative-field form-control-solid" v-model="form.password_confirmation"/>
                <span class="text-danger my-1" v-if="errors.password_confirmation">{{ $t(errors.password_confirmation[0]) }}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-sm btn-primary" :disabled="loader">
                  {{ $t('Update') }} 
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
  import User from "../apis/User"

  export default {
    name: 'my-profile',
    data() {
      return {
        loader: false,
        errors: {},
        user: [],
        form: {
          fname: '',
          lname: '',
          avatar: null,
          password: '',
          password_confirmation: ''
        },
        avatar_file: null,
        user_profile_picture: null
      }
    },
    mounted() {
      this.getProfile()
    },
    methods:{
      async getProfile() {
        
        this.loader = true
        User.auth().then(res => {
          this.user = res.data.user
          this.form = res.data.user
          this.user_profile_picture = res.data.user.profile_picture
          // if(res.data.user.user_details != null){
          //   this.form.fname = res.data.user.user_details.fname
          //   this.form.lname = res.data.user.user_details.lname
          //   
          // }
          this.loader = false
        })
        .catch(error=> {
          this.user = []
          this.loader = false
        });
      },
      async updateUser() {
        this.loader = true
        if(this.avatar_file != null){
            let fileData = new FormData()
            fileData.append('avatar', this.avatar_file)
            User.uploadProfilePicture(fileData).then(res => {
                this.form.avatar = res.data.path;
                this.UpdateData();
                this.user_profile_picture = res.data.path;   
                this.userProfile = res.data.path;              
                document.getElementById('user-avatar').setAttribute('src', res.data.path)
                localStorage.setItem("user_profile", res.data.path)    
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
            this.UpdateData();
        }
       
      },
      async UpdateData(){
        User.updateUser(this.form).then(res => {
          this.errors = {}
          this.$toast.success(this.$t(res.data.message))
          this.loader = false
        })
        .catch(error=> {
          if(error.response.status === 401) {
            this.$toast.error(this.$t(res.data.errors))
          }
          if(error.response.status === 422) {
            this.errors = error.response.data.errors
          }
          this.loader = false
        });
      },
      async uploadProfilePicture(event){
        this.avatar_file = event.target.files[0]
      }
    }
  };
</script>