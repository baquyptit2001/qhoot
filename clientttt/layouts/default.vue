<template>
  <a-layout style="min-height: 100vh">
    <a-layout-sider v-model:collapsed="collapsed" collapsible>
      <div class="logo" style="text-align: center">
        <NuxtLink to="/" style="color: pink; font-family: Pacifico; font-size: 24px;text-align: center">
          Q<span v-if="!collapsed">HOOT</span>
        </NuxtLink>
      </div>
      <a-menu v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
        <a-menu-item key="1">
          <home-outlined/>
          <span>Home</span>
        </a-menu-item>
        <a-menu-item key="2">
          <desktop-outlined/>
          <span>Option 2</span>
        </a-menu-item>
        <a-sub-menu key="sub1">
          <template #title>
            <span>
              <user-outlined/>
              <span>User</span>
            </span>
          </template>
          <a-menu-item key="3">Tom</a-menu-item>
          <a-menu-item key="4">Bill</a-menu-item>
          <a-menu-item key="5">Alex</a-menu-item>
        </a-sub-menu>
        <a-sub-menu key="sub2">
          <template #title>
            <span>
              <team-outlined/>
              <span>Team</span>
            </span>
          </template>
          <a-menu-item key="6">Team 1</a-menu-item>
          <a-menu-item key="8">Team 2</a-menu-item>
        </a-sub-menu>
        <a-menu-item key="9">
          <file-outlined/>
          <span>File</span>
        </a-menu-item>
      </a-menu>
    </a-layout-sider>
    <a-layout>
      <a-layout-header style="background: #efefef; padding: 0 15px">
        <a-row>
          <marquee direction="left" scrolldelay="10">
            <div style="display:flex;">
              <div style="margin-right: 15px" v-for="weather in weathers">
                <img :src="weatherUrl(weather.icon)" alt="logo"
                     style="height: 50px; margin: 10px 0"/>
                <span>{{ weather.name + ' ' + weather.status + ' ' + weather.temperature + '℃' }}</span>
              </div>
            </div>
          </marquee>
        </a-row>
      </a-layout-header>
      <a-layout-content style="margin: 0 16px">
        <a-breadcrumb style="margin: 16px 0">
          <a-breadcrumb-item>User</a-breadcrumb-item>
          <a-breadcrumb-item>Bill</a-breadcrumb-item>
        </a-breadcrumb>
        <div :style="{ padding: '24px', background: '#fff', minHeight: '360px' }">
          <slot/>
        </div>
      </a-layout-content>
      <a-layout-footer style="text-align: center">
        Quy NB ©{{ new Date().getFullYear() }} Created by Quy NB
      </a-layout-footer>
    </a-layout>
  </a-layout>
</template>

<script lang="ts">
import {
  DesktopOutlined,
  FileOutlined,
  HomeOutlined,
  PieChartOutlined,
  TeamOutlined,
  UserOutlined
} from '@ant-design/icons-vue';
import {defineComponent, ref} from 'vue';
import weatherUrl from '../commons/commons.js';
import axios from 'axios';

export default defineComponent({
  components: {
    PieChartOutlined,
    DesktopOutlined,
    UserOutlined,
    TeamOutlined,
    FileOutlined,
    HomeOutlined
  },
  data() {
    return {
      collapsed: ref<boolean>(true),
      selectedKeys: ref<string[]>(['1']),
      hotNews: [
        {
          title: 'Quy NB',
        }
      ],
      weatherLocationKey: [
        353412, // Ha Noi
        353981, // Ho Chi Minh
        352954, // Da Nang
        356204, // Hue
        356184, // Thanh Hoa
        353511, // Hai Phong
        353501, // Hai Duong
        352098, // Bac Giang
        354293, // Lang Son
      ],
      weatherLocationName: [
        'Hà Nội',
        'Hồ Chí Minh',
        'Đà Nẵng',
        'Huế',
        'Thanh Hóa',
        'Hải Phòng',
        'Hải Dương',
        'Bắc Giang',
        'Lạng Sơn',
      ],
      weathers: [],
      apiWeatherKey: 'nXAyW0rGwufm0y14qYfx2SyAVk25mWdn'
    };
  },
  mounted() {
    this.getWeather();
  },
  methods: {
    weatherUrl,
    async getWeather() {
      for (let i = 0; i < this.weatherLocationKey.length; i++) {
        await axios.get(`http://dataservice.accuweather.com/forecasts/v1/hourly/1hour/${this.weatherLocationKey[i]}?apikey=${this.apiWeatherKey}&language=vi-vn`)
            .then((response: any) => {
              console.log(i)
              this.weathers.push({
                name: this.weatherLocationName[i],
                temperature: this.farenheitToCelsius(response.data[0].Temperature.Value),
                icon: response.data[0].WeatherIcon,
                status: response.data[0].IconPhrase,
              });
            })
      }
    },
    farenheitToCelsius(farenheit: number) {
      return Math.round((farenheit - 32) * 5 / 9);
    }
  }

});
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');

#components-layout-demo-side .logo {
  height: 32px;
  margin: 16px;
  background: rgba(255, 255, 255, 0.3);
}

.site-layout .site-layout-background {
  background: #fff;
}

[data-theme='dark'] .site-layout .site-layout-background {
  background: #141414;
}
</style>