<template>
  <h1 style="text-align:center;">
    Create Topic
  </h1>
  <el-form :model="form" label-width="120px">
    <el-form-item label="Name">
      <el-input v-model="form.name"/>
    </el-form-item>
    <el-form-item label="Category">
      <el-select v-model="form.category_id" placeholder="Please select topic's category">
        <el-option v-for="category in categories" :label="category.name" :value="category.id"/>
      </el-select>
    </el-form-item>
    <el-form-item label="Description">
      <el-input v-model="form.description" type="textarea"/>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="onSubmit">Create</el-button>
      <el-button @click="back">Cancel</el-button>
    </el-form-item>
  </el-form>
</template>


<script setup>

const onSubmit = () => {
  console.log('submit!')
}

</script>

<script>
import {useClientLayoutStore} from "~/stores/clientStore/clientLayoutStore";
import axios from 'axios';


export default {
  name: "create",
  data() {
    return {
      clientLayoutStore: useClientLayoutStore(),
      form: {
        name: '',
        description: '',
        category_id: null
      },
      categories: []
    }
  },
  mounted() {
    this.clientLayoutStore.addTag({
      name: 'Topic Create',
      path: {
        name: 'topics-create',
        params: null
      }
    })
    // get categories
    axios.get(API_URL + 'categories').then(res => {
      console.log(res.data)
      this.categories = res.data.categories
    })
  },
  methods: {
    back() {
      this.$router.back()
    }
  }
}
</script>

<style scoped>

</style>