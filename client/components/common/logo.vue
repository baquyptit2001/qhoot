<template>
  <NuxtLink :to="{name: 'index'}">
    <div class="logo">
      Q<span v-if="showText">HOOT</span>
    </div>
  </NuxtLink>
</template>

<script>
export default {
  name: "logo",
  props: {
    showText: Boolean
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap');

.logo {
  font-size: 2rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1rem;
  display: flex;
  font-family: 'Permanent Marker', serif;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  cursor: pointer;
  color: black;
}

a {
  text-decoration: none;
}

</style>