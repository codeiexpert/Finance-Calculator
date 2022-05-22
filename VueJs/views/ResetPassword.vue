<template>
  <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-size1: 100% 50%; background-image: url(/assets/media/bg/outdoor.png)">
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
      <router-link class="flex-column-auto my-5 pb-lg-0 pb-10 display-3 text-white" to="/">
        <img alt="demo Consulting" src="/assets/media/logo/logo.png" />
      </router-link>
      <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form autocomplete="off" @submit.prevent="resetPassword" method="post">
          <div class="text-center mb-10">
            <h1 class="text-dark mb-3">{{ $t('Setup New Password') }}?</h1>
            <div class="text-gray-400 fw-bold fs-4">{{ $t('Already have reset your password') }}? 
              <router-link :to='{name:"Login"}' class="text-link">{{ $t('Sign In') }}</router-link>
            </div>
          </div>
          <div class="fv-row mb-10">
            <label class="form-label fs-6 fw-bolder text-dark">{{ $t('Password')}}</label>
            <input class="form-control form-control-lg form-control-solid" type="password" v-model="form.password" autocomplete="off" required/>
            <span class="d-block text-danger my-1" v-if="errors.password">{{ $t(errors.password[0]) }}</span>
          </div>
          <div class="fv-row mb-10">
            <label class="form-label fs-6 fw-bolder text-dark">{{ $t('Password Confirmation')}}</label>
            <input class="form-control form-control-lg form-control-solid" type="password" v-model="form.password_confirmation" autocomplete="off" required/>
            <span class="d-block text-danger my-1" v-if="errors.password_confirmation">{{ $t(errors.password_confirmation[0]) }}</span>
          </div>
          <div class="text-center">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5" :disabled="loader">
              <span class="indicator-label">{{ $t('Submit')}}</span>
              <span v-show="loader"><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../apis/User";

export default {
    data() {
      return {
        form: {
          password: '',
          password_confirmation: '',
        },
        errors: {},
        loader: false
      }
    },
    methods: {
        resetPassword() {
          this.loader = true
          this.form.token = this.$route.params.token
          this.form.uid = this.$route.params.id
          User.resetPassword(this.form).then((res) => {
            this.$toast.success(this.$t(res.data.message))
            this.loader = false
            this.$router.push({ name: "Login" })
          }).catch(error => {
            this.loader = false
            if (error.response.status === 422) {
              this.errors = error.response.data.errors
            }
            if (error.response.status === 401) {
              this.$toast.error(this.$t(error.response.data.errors))
            }
          });
        }
    }
}
</script>