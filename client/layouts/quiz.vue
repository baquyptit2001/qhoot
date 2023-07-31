<template>
    <div class="common-layout" :style="'background-color: ' + LIGHT_PINK + ';height: 100%'">
        <el-container>
            <el-header :style="'background-color: ' + MID_PINK + ';'">
                <div style="height: 100%;display: flex;align-items: center;justify-content: center;">
                    <Logo :showText="true" />
                </div>
            </el-header>
            <el-main>
                <slot/>
            </el-main>
        </el-container>
    </div>
</template>

<script setup>
import {useAuthUserStore} from "~/stores/authUserStore";
import Cookies from "js-cookie";

const userStore = useAuthUserStore()

const token = Cookies.get('access_token')

if (token && userStore.getUser == null) {
  userStore.fetchUser()
}


</script>

<script>
    import Logo from '~/components/common/logo.vue'
    export default {
        components: {
            Logo
        }
    }
</script>


<style>

</style>