<template>
  <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-size1: 100% 50%; background-image: url(/assets/media/bg/outdoor.png)">
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
      <router-link class="flex-column-auto my-5 pb-lg-0 pb-10 display-3 text-white" to="/">
        Finance Calculator
      </router-link>
      <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
        <form @submit.prevent="login" class="form w-100" method="post">
          <div class="text-center mb-10">
            <h1 class="text-dark mb-3">{{ $t('Sign In') }}</h1>
          </div>
          <div class="fv-row mb-10">
            <label class="form-label fs-6 fw-bolder text-dark">{{ $t('Email')}}</label>
            <input class="form-control form-control-lg form-control-solid" type="text" v-model="form.email" name="email" autocomplete="off" required/>
            <span class="d-block text-danger my-1" v-if="errors.email">{{ $t(errors.email[0]) }}</span>
          </div>
          <div class="fv-row mb-10">
            <div class="d-flex flex-stack mb-2">
              <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ $t('Password') }}</label>
               <router-link :to='{name:"ForgotPassword"}' class="link-primary fs-6 fw-bolder">{{ $t('Forgot Password') }}?</router-link>
            </div>
            <input class="form-control form-control-lg form-control-solid" type="password" v-model="form.password" name="password" autocomplete="off" required/>
            <span class="d-block text-danger my-1" v-if="errors.password">{{ $t(errors.password[0]) }}</span>
          </div>
          <div class="text-center">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5" :disabled="loader">
              <span class="indicator-label">{{ $t('Sign In')}}</span>
              <span v-show="loader"><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
          </div>
        </form>
      </div>
      <div class="d-flex align-items-center fw-bold fs-6 mt-5">
        <div class="opacity-70 font-weight-bold text-white">© {{ new Date().getFullYear() }} Finance Calcualtor</div>
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
        email: "",
        password: ""
      },
      errors: [],
      loader: false
    };
  },
  methods: {
    login() {
      this.loader = true
      User.login(this.form).then((res) => {
        this.$root.$emit("login", true)
        localStorage.setItem("auth", "true")
        localStorage.setItem("access_token", res.data.access_token)
        localStorage.setItem("user_name", res.data.user.username)
        localStorage.setItem("user_email", res.data.user.email)
        localStorage.setItem("user_role", res.data.user.role)
        localStorage.setItem("user_profile", res.data.user.profile_picture)
        location.reload();
        // }
        this.loader = false
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
};
</script>