<template>
  <div class="app-wrapper">
    <div class="sidebar-menu">
      <el-menu
          :default-active="clientLayoutStore.menuActive"
          class="el-menu-vertical-demo"
          :collapse="clientLayoutStore.isCollapse"
          @open="handleOpen"
          @close="handleClose"
      >
        <div>
          <Logo :show-text="!clientLayoutStore.isCollapse"/>
        </div>
        <el-divider/>
        <el-menu-item index="1">
          <el-icon>
            <HomeFilled/>
          </el-icon>
          <template #title>Home</template>
        </el-menu-item>
        <el-menu-item index="2">
          <el-icon>
            <UserFilled/>
          </el-icon>
          <template #title>Profile</template>
        </el-menu-item>
      </el-menu>
    </div>
    <div style="width: 100%;padding: 0 15px">
      <div class="header">
        <div class="icon-menu" style="margin-right: 15px; display:flex;align-items: center">
          <el-icon @click="collapse" :class="{active: !clientLayoutStore.isCollapse}">
            <Fold/>
          </el-icon>
        </div>
        <marquee style="margin-right: auto; font-size: 20px" behavior="scroll" direction="left" scrollamount="10">
          <div>
            <div v-for="weather in weathers" style="margin-right: 10px; display: inline-block">
              <img style="margin-bottom: -15px"
                   :src="`https://developer.accuweather.com/sites/default/files/${pad(weather.weather.WeatherIcon, 2)}-s.png`"/>
              <span style="height: 100px;line-height: 100px">{{
                  weather.name
                }}({{ farenheitToCelsius(weather.weather.Temperature.Value) }}℃)</span>
            </div>
          </div>
        </marquee>
        <el-dropdown style="margin-left: auto">
          <el-avatar :icon="UserFilled"/>
          <template #dropdown>
            <el-dropdown-menu v-if="userStore.getUser == null">
              <NuxtLink :to="{name: 'auth-login'}">
                <el-dropdown-item>Sign in</el-dropdown-item>
              </NuxtLink>
              <el-dropdown-item>Sign up</el-dropdown-item>
            </el-dropdown-menu>
            <el-dropdown-menu v-else>
              <el-dropdown-item>Profile</el-dropdown-item>
              <NuxtLink :to="{name: 'topics'}">
                <el-dropdown-item>Bộ đề</el-dropdown-item>
              </NuxtLink>
              <el-dropdown-item disabled>{{ userStore.user.name }}</el-dropdown-item>
              <el-dropdown-item divided @click="logout">Đăng xuất</el-dropdown-item>
            </el-dropdown-menu>
          </template>
        </el-dropdown>
      </div>
      <div style="margin: 15px 0;">
        <el-tag style="cursor:pointer;margin-right: 5px;" v-for="tag in clientLayoutStore.tags"
                @click="redirect(tag.path)"
                :effect="tag.active ? 'dark' : 'light'" :key="tag.path" :round="true" :closable="true"
                @close="closeTag(tag)">{{ tag.name }}
        </el-tag>
      </div>
      <el-divider style="margin-top: 0"></el-divider>
      <div class="content">
        <slot/>
      </div>
    </div>
  </div>
</template>


<script setup>
import {Fold, HomeFilled, UserFilled} from '@element-plus/icons-vue'
import Logo from "~/components/common/logo.vue";
import {useClientLayoutStore} from "~/stores/clientStore/clientLayoutStore";
import Cookies from "js-cookie";
import axios from "axios";
import {useAuthUserStore} from "~/stores/authUserStore";
import {useRouter} from 'vue-router';

const router = useRouter()

const handleOpen = (key, keyPath) => {
  console.log(key, keyPath)
}
const handleClose = (key, keyPath) => {
  console.log(key, keyPath)
}

const clientLayoutStore = useClientLayoutStore()
const userStore = useAuthUserStore()
const token = Cookies.get('access_token')
const loading = ref(false)

if (token && userStore.getUser == null) {
  userStore.fetchUser()
}

const collapse = () => {
  clientLayoutStore.setIsCollapse()
}

const closeTag = (tag) => {
  clientLayoutStore.removeTag(tag)
  if (tag.active) {
    router.back()
  }
}

const logout = () => {
  axios.get(API_URL + 'auth/logout', generateHeader()).then(res => {
    Cookies.remove('access_token')
    userStore.setUser(null)
    router.push({name: 'auth-login'})
  }).catch(err => {
    console.log(err)
  })
}


</script>

<script>
import {ref} from 'vue'
import generateHeader from "~/composables/common";


export default {
  name: "default",
  async mounted() {
    await this.getWeather()
    console.log(this.weathers)
  },
  computed: {},
  methods: {
    redirect(path) {
      let destination = {name: path.name}
      if (path.params != null) {
        destination.params = path.params
      }
      this.$router.push(destination)
    },
    farenheitToCelsius(temp) {
      return Math.round((temp - 32) * 5 / 9)
    },
    pad(num, size) {
      num = num.toString();
      while (num.length < size) num = "0" + num;
      return num;
    },
    async getWeather() {
      for (const item of this.locationCode) {
        await axios.get(this.weatherUrl + item.code + '?apikey=' + WEATHER_API_KEY + '&language=vi-vn&details=false').then(res => {
          this.weathers.push({
            name: item.name,
            weather: res.data[0]
          })
        })
      }
    }
  },
  data() {
    return {
      weatherUrl: 'http://dataservice.accuweather.com/forecasts/v1/hourly/1hour/',
      weathers: [],
      locationCode: [
        {
          name: 'Hà Nội',
          code: '353412'
        },
        {
          name: 'Hồ Chí Minh',
          code: '353981'
        },
        {
          name: 'Hải Dương',
          code: '353501'
        },
        {
          name: 'Hải Phòng',
          code: '353511'
        },
        {
          name: 'Sa Pa',
          code: '416623'
        },
        {
          name: 'Đà Lạt',
          code: '354287'
        },
        {
          name: 'Đà Nẵng',
          code: '352954'
        }
      ]
    }
  }
}
</script>

<style scoped>
.app-wrapper {
  position: relative;
  height: 100%;
  width: 100%;
  display: flex;
}

.sidebar-menu {
  width: auto;
  height: 100%;
  float: left;
}

.el-menu-vertical-demo {
  height: 100%;
}

.header {
  height: 50px;
  border-bottom: 1px solid #e4e4e4;
  display: flex;
  align-items: center;
  font-size: 30px;
}

.header .el-icon {
  transform: rotate(180deg);
  transition: 0.5s;
}

.header .el-icon:hover {
  cursor: pointer;
}

.header .el-icon.active {
  transform: rotate(0deg);
  transition: 0.5s;
}

a {
  text-decoration: none;
}
</style>