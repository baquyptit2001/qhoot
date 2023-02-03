<template>
  <div>
    <p>Hello Product {{ id }}</p>
  </div>
</template>


<script setup>
const {id} = useRoute().params
</script>

<script>
export default {
  name: "[id]"
}
</script>

<style scoped>

</style>