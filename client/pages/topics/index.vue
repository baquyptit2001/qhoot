<template>
  <NuxtLink :to="{name: 'topics-create'}" style="text-decoration: none">
    <el-button type="primary" round>Add Topic</el-button>
  </NuxtLink>
  <el-table :data="topics" style="width: 100%">
    <el-table-column label="ID" width="100px" sortable prop="id"/>
    <el-table-column label="Image">
      <template #default="{row, column, $index}">
        <img :src="row.image" style="width: 100px;"/>
      </template>
    </el-table-column>
    <el-table-column prop="name" label="Name" sortable/>
    <el-table-column prop="description" label="Description"/>
    <el-table-column label="Category" :filters="categories" :filter-method="filterHandler">
      <template #default="{row, column, $index}">
        <span>{{ row.category.name }}</span>
      </template>
    </el-table-column>
    <el-table-column label="Action">
      <template #default="{row, column, $index}">
        <el-dropdown @command="handleCommand" trigger="click" style="cursor:pointer;">
          <span class="el-dropdown-link">
            <el-icon><More/></el-icon>
          </span>
          <template #dropdown>
            <el-dropdown-menu>
              <NuxtLink :to="{name: 'questions-edit-topic_id', params: {topic_id: row.id}}" style="text-decoration: none">
                <el-dropdown-item>Questions</el-dropdown-item>
              </NuxtLink>
              <el-dropdown-item command="b">Action 2</el-dropdown-item>
              <el-dropdown-item command="c">Action 3</el-dropdown-item>
            </el-dropdown-menu>
          </template>
        </el-dropdown>
      </template>
    </el-table-column>
  </el-table>
</template>

<script setup>
import {More} from '@element-plus/icons-vue'

const filterHandler = (
    value,
    row,
    column
) => {
  return row.category.id === value
}
</script>

<script>
import {useClientLayoutStore} from "~/stores/clientStore/clientLayoutStore";
import axios from "axios";
import generateHeader from "~/composables/common";

export default {
  name: "index",
  data() {
    return {
      clientLayoutStore: useClientLayoutStore(),
      topics: [],
      categories: new Set()
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
    this.getTopics()
    console.log(this.categories)
  },
  methods: {
    getTopics() {
      axios.get(API_URL + 'topics', generateHeader()).then(res => {
        console.log(res.data)
        this.topics = res.data.topics
        this.topics.forEach(topic => {
          this.categories.add({
            text: topic.category.name,
            value: topic.category.id
          })
        })
      }).finally(() => {
        this.categories = [...this.categories]
      })
    }
  }
}
</script>

<style scoped>

</style>