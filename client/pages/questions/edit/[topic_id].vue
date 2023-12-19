<template>
  <div>
    <h1>Topic: {{ topic.name }}</h1>
    <img :src="topic.image" alt="topic image" style="height: 200px;"/>
  </div>
  <el-form :inline="true" :model="question" class="demo-form-inline" v-for="(question, index) in questions">
    <h3>
      Question {{ index + 1 }}
      <el-button type="danger" @click="showConfirmDialog(index, question.id)">Delete
        <el-icon class="el-icon--right">
          <Delete/>
        </el-icon>
      </el-button>
    </h3>
    <el-form-item label="Question Description" style="width: 100%;">
      <el-input v-model="question.description" placeholder="Question Description"/>
    </el-form-item>
    <el-form-item label="Answer 1">
      <el-input v-model="question.answers[0].description" placeholder="Answer1"/>
    </el-form-item>
    <el-form-item label="Answer 2">
      <el-input v-model="question.answers[1].description" placeholder="Answer2"/>
    </el-form-item>
    <el-form-item label="Answer 3">
      <el-input v-model="question.answers[2].description" placeholder="Answer3"/>
    </el-form-item>
    <el-form-item label="Answer 4">
      <el-input v-model="question.answers[3].description" placeholder="Answer4"/>
    </el-form-item>
    <el-form-item label="Correct Answer">
      <el-radio-group v-model="question.correct_answer" size="large">
        <el-radio-button label="Answer1"/>
        <el-radio-button label="Answer2"/>
        <el-radio-button label="Answer3"/>
        <el-radio-button label="Answer4"/>
      </el-radio-group>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" v-if="question.is_update" @click="update(question, question.sort_order)">Update</el-button>
      <el-button type="primary" v-else @click="saveOne(question, index)">Save</el-button>
    </el-form-item>
    <el-divider></el-divider>
  </el-form>
  <el-button type="primary" @click="addQuestion">Add Question</el-button>
  <el-button type="primary" @click="saveAll()">Save All</el-button>
  <el-dialog
    v-model="confirmDialogVisible"
    title="Warning"
    width="30%"
    align-center
  >
    <span>Open the dialog from the center from the screen</span>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="confirmDialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="onDelete()">
          Confirm
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script>
import {useClientLayoutStore} from "~/stores/clientStore/clientLayoutStore";
import axios from "axios";
import { Delete } from '@element-plus/icons-vue'
import generateHeader from "~~/composables/common";


export default {
  name: "[topic_id]",
  components: {
    Delete
  },
  data() {
    return {
      clientLayoutStore: useClientLayoutStore(),
      topic: {},
      questions: [],
      correct_answer_mapping: {
        Answer1: 0,
        Answer2: 1,
        Answer3: 2,
        Answer4: 3
      },
      confirmDialogVisible: false,
      deleteIndex: null,
      deleteId: null
    }
  },
  mounted() {
    this.clientLayoutStore.addTag({
      name: 'Questions',
      path: {
        name: 'questions-edit-topic_id',
        params: {topic_id: this.$route.params.topic_id}
      }
    })
    this.getTopic()
  },
  methods: {
    getTopic() {
      axios.get(API_URL + 'topics/' + this.$route.params.topic_id, generateHeader()).then(res => {
        this.topic = res.data.topic
        this.topic.questions.forEach(question => {
          let correct_answer = question.answers.find(answer => {
            return answer.is_correct == 1
          })
          question.correct_answer = 'Answer' + (question.answers.indexOf(correct_answer) + 1)
          question.is_update = 1
        })
        console.log(this.topic)
        this.questions.push(...this.topic.questions)
      })
    },
    showConfirmDialog(index, id) {
      this.deleteIndex = index
      this.deleteId = id
      this.confirmDialogVisible = true
    },
    addQuestion() {
      this.questions.push({
        description: '',
        answers: [
          {description: ''},
          {description: ''},
          {description: ''},
          {description: ''}
        ],
        correct_answer: 'Answer1',
        is_update: 0,
        topic_id: this.$route.params.topic_id
      })
    },
    update(question, sort_order) {
      let saveData = {...question}
      saveData.sort_order = sort_order
      saveData.correct_answer = this.correct_answer_mapping[saveData.correct_answer]
      axios.post(API_URL + 'questions/' + question.id, saveData, generateHeader()).then(res => {
        console.log(res.data)
        ElNotification({
          title: 'Success',
          message: 'Update question successfully!!',
          type: 'success'
        })
      })
    },
    saveOne(question, index) {
      let post_data = {...question}
      post_data.sort_order = index
      post_data.correct_answer = this.correct_answer_mapping[post_data.correct_answer]
      axios.post(API_URL + 'questions', post_data, generateHeader()).then(res => {
        console.log(res.data);
        ElNotification({
          title: 'Success',
          message: 'Create question successfully!!',
          type: 'success'
        })
      })
    },
    onDelete() {
      this.questions.splice(this.deleteIndex, 1)
      console.log(this.deleteId)
      this.confirmDialogVisible = false
    },
  }
}
</script>

<style scoped>

</style>