<template>
  <div style="text-align: center;font-size: x-large;font-weight: bold;">
    Create Room
  </div>
  <div style="display: flex;justify-content: center;">
    <el-form label-position="top" :model="room" style="width: 460px;">
      <el-form-item label="Name">
        <el-input v-model="room.name" />
      </el-form-item>
      <el-form-item label="Description">
        <el-input type="textarea" rows="4" v-model="room.description" />
      </el-form-item>
      <el-form-item label="Topic">
        <el-select v-model="room.topic_id" placeholder="Select topic for your room">
          <el-option v-for="topic in topics" :key="topic.id" :label="topic.name" :value="topic.id">
            <!-- image -->
            <span style="display: flex;align-items: center;">
              <img :src="topic.image" style="width: 60px;" />
              <span style="margin-left: 10px;">{{ topic.name }}</span>
            </span>
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="Password">
        <el-input v-model="room.password" :disabled="!room.hasPassword" />
      </el-form-item>
      <el-form-item>
        <el-checkbox v-model="room.hasPassword">Has Password</el-checkbox>
      </el-form-item>
      <el-button type="primary" @click="createRoom">Create</el-button>
    </el-form>
  </div>
</template>

<script>
  import axios from 'axios'
  import {
    useClientLayoutStore
  } from '~~/stores/clientStore/clientLayoutStore'
  import generateHeader from '~~/composables/common'
  export default {
    mounted() {
      this.clientLayoutStore.addTag({
        name: 'Create Room',
        path: {
          name: 'quiz-room',
          params: null
        }
      })
      this.getTopics()
    },
    data() {
      return {
        clientLayoutStore: useClientLayoutStore(),
        room: {
          name: 'Test Ai Eo',
          password: '1234567',
          hasPassword: true,
          description: 'Test Ai Eo',
          topic_id: 1
        },
        topics: []
      }
    },
    methods: {
      createRoom() {
        axios.post(`${API_URL}rooms`, this.room, generateHeader())
          .then((res) => {
            ElNotification({
              title: 'Success',
              message: 'Create room successfully',
              type: 'success'
            })
            let room = res.data.room
            console.log(room);
            this.$router.push({
              name: 'quiz-room-id',
              params: {
                id: room.id
              }
            })
          })
          .catch((err) => {
            console.log(err)
          })
      },
      getTopics() {
        axios.get(`${API_URL}topics`, generateHeader())
          .then((res) => {
            this.topics = res.data.topics
          })
          .catch((err) => {
            console.log(err)
          })
      },
    }
  }
</script>

<style>

</style>