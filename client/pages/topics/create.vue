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
    <el-form-item label="Thumbnail">
      <div style="width: 100%">
        <input type="file" class="file-upload" @change="upload">
      </div>
      <img
          style="width: 200px;"
          id="preview"
          :src="image" alt="img">
    </el-form-item>
    <el-form-item>
      <el-button type="primary" v-loading="loading" @click="onSubmit">Create</el-button>
      <el-button @click="back">Cancel</el-button>
    </el-form-item>
  </el-form>
</template>


<script setup>
import {More} from '@element-plus/icons-vue'
</script>

<script>
import {useClientLayoutStore} from "~/stores/clientStore/clientLayoutStore";
import axios from "axios";

import generateHeader from "~/composables/common";
import {getErrorMessage} from "~/composables/validateMessage";
import {ElNotification} from "element-plus";


export default {
  name: "create",
  data() {
    return {
      clientLayoutStore: useClientLayoutStore(),
      form: {
        name: 'Đề Ai Eo 10.0',
        description: 'Test ielts 10.0',
        category_id: 1,
        image: null
      },

      categories: [],
      loading: false,
      image: 'https://media.istockphoto.com/id/1308046488/vector/preview-stamp-preview-label-round-grunge-sign.jpg?s=612x612&w=0&k=20&c=t_y8OryF2EJbVhGqfvOSFsDY-UfylV1hGkmvzagtNhU='
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
    axios.get(API_URL + 'categories', generateHeader()).then(res => {
      console.log(res.data)
      this.categories = res.data.categories
    })
  },
  methods: {
    back() {
      this.$router.back()
    },
    onSubmit() {
      this.loading = true
      axios.post(API_URL + 'topics', this.form, generateHeader()).then(res => {
        ElNotification({
          title: 'Success',
          message: 'Create topic successfully',
          type: 'success'
        })
        this.$router.push({name: 'questions-edit-topic_id', params: {topic_id: res.data.topic.id}})
      })
          .catch(err => {
            console.log(err)
            ElNotification({
              title: 'Error',
              message: err.response.data.message,
              type: 'error'
            })
          })
          .finally(() => {
            this.loading = false
          })
    },
    upload(event) {
      const file = event.target.files[0]
      const reader = new FileReader();
      reader.readAsDataURL(file);
      this.createImage(file);
      reader.onload = () => {
        this.image = reader.result;
      };
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.form.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
  }
}
</script>

<style scoped>
.file-upload {
  border: 1px solid #ccc;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
}
</style>