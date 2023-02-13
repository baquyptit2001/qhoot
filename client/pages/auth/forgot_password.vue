<template>
        <div class="login100-form validate-form flex-sb flex-w" style="padding: 15px">
          <span class="login100-form-title p-b-32" style="margin-bottom: 15px;text-align:center;">
            Sign in
          </span>
          <span class="txt1 p-b-11" style="margin-top: 15px;">
            Email
          </span>
          <div class="wrap-input100 validate-input m-b-36" data-validate="Email is required"
               style="margin-bottom: 15px;">
            <input class="input100" type="email" name="email" v-model="user.email">
            <span class="focus-input100"></span>
          </div>
          <span class="txt1 p-b-11" style="margin-top: 15px;">
            Password
          </span>
          <div class="wrap-input100 validate-input m-b-12" data-validate="Password is required"
               style="margin-bottom: 15px;">
            <span class="btn-show-pass">
              <i class="fa fa-eye"></i>
            </span>
            <input class="input100" type="password" name="pass" v-model="user.password">
            <span class="focus-input100"></span>
          </div>
          <div class="" style="display:flex; justify-content: space-between;">
            <div>
              Didn't have an account?
              <NuxtLink :to="{name: 'auth-register'}" class="txt3">
                Sign up
              </NuxtLink>
            </div>
            <div>
              <a href="#" class="txt3">
                Forgot Password?
              </a>
            </div>
          </div>
          <div class="container-login100-form-btn" style="margin-top: 15px;">
            <button class="login100-form-btn"  @click="login">
              Login
            </button>
          </div>
        </div>
</template>

<script setup>
definePageMeta({
  meta: [
    {
      content: 'Login page'
    }
  ],
  layout: 'auth',
  middleware: ['auth']
})

useSeoMeta({
  title: 'Login',
  description: 'Login page'
})
</script>

<script>
import {ElNotification} from "element-plus";
import Cookies from 'js-cookie'
import axios from "axios";
import {useAuthUserStore} from "~/stores/authUserStore";

export default {
  name: "login",
  data() {
    return {
      user: {
        email: '',
        password: ''
      },
      userStore: useAuthUserStore()
    }
  },
  methods: {
    login() {
      let validate = validateRequired(this.user)
      if (validate) {
        ElNotification({
          title: 'Error',
          message: validate,
          type: 'error'
        })
        return
      }
      axios.post(API_URL + 'auth/login', this.user)
          .then(res => {
            ElNotification({
              title: 'Success',
              message: 'Login success',
              type: 'success'
            })
            this.userStore.setUser(res.data.user)
            Cookies.set('access_token', res.data.access_token)
            this.$router.push({name: 'index'})
          })
          .catch(err => {
            console.log(err)
            ElNotification({
              title: 'Error',
              message: err.response.data.message,
              type: 'error'
            })
          })
    }
  }
}
</script>

<style scoped>

</style>