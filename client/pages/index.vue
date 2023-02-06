<template>
  <el-carousel trigger="click" :interval="4000" type="card" height="300px" class="crousel_image">
    <el-carousel-item>
      <img src="../assets/images/client/home/1.jpg">
    </el-carousel-item>
    <el-carousel-item>
      <img src="../assets/images/client/home/1.jpg">
    </el-carousel-item>
    <el-carousel-item>
      <img src="../assets/images/client/home/1.jpg">
    </el-carousel-item>
    <el-carousel-item>
      <img src="../assets/images/client/home/1.jpg">
    </el-carousel-item>

  </el-carousel>
</template>

<script>
import {defineComponent} from 'vue'
import {useClientLayoutStore} from "~/stores/clientStore/clientLayoutStore";

export default defineComponent({
  name: 'Index',
  setup() {
    return {}
  },
  data() {
    return {
      clientLayoutStore: useClientLayoutStore()
    }
  },
  mounted() {
    this.clientLayoutStore.addTag({
      name: 'Home',
      path: '/'
    })
    this.clientLayoutStore.updateBreadcrumb([
      {
        name: 'Home',
        path: '/'
      }
    ])
  }
})
</script>

<style>
.carousel_image {

}
</style>
