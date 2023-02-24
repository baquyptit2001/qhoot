<template>
  <NuxtLink :to="{name: 'topics-create'}" style="text-decoration: none">
    <el-button type="primary" round>Add Topic</el-button>
  </NuxtLink>
</template>

<script>
import {useClientLayoutStore} from "~/stores/clientStore/clientLayoutStore";

export default {
  name: "index",
  data() {
    return {
      clientLayoutStore: useClientLayoutStore()
    }
  },
  mounted() {
    this.clientLayoutStore.addTag({
      name: 'Topics',
      path: {
        name: 'topics',
        params: null
      }
    })
  }
}
</script>

<style scoped>

</style>