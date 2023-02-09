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
        <el-breadcrumb separator="/">
          <el-breadcrumb-item v-for="bread in clientLayoutStore.breadcrumb" :to="bread.path">{{
              bread.name
            }}
          </el-breadcrumb-item>
        </el-breadcrumb>
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
              <el-dropdown-item disabled>{{ userStore.user.name }}</el-dropdown-item>
              <el-dropdown-item divided @click="logout">Đăng xuất</el-dropdown-item>
            </el-dropdown-menu>
          </template>
        </el-dropdown>
      </div>
      <div style="margin: 15px 0;">
        <el-tag style="cursor:pointer;" v-for="tag in clientLayoutStore.tags" @click="redirect(tag.path)"
                :effect="tag.active ? 'dark' : 'light'" :key="tag.path" :round="true" :closable="true"
                @close="clientLayoutStore.removeTag(tag)">{{ tag.name }}
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

const logout = () => {
  axios.get(API_URL + 'auth/logout', generateHeader()).then(res => {
    Cookies.remove('access_token')
    userStore.setUser(null)
    this.$router.push({name: 'auth-login'})
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
  mounted() {
  },
  methods: {
    redirect(path) {
      this.$router.push(path)
    }
  },
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