<template>
  <div id="vue-frontend-app">
    <h2>App - </h2>
    <router-link to="/Home">Home</router-link>

    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>

.frontend-ninja-vue {
  display: flex;
  list-style: none;
  align-items: center;
}
.frontend-ninja-vue li + li {
  margin-left: 10px;
}
.frontend-ninja-vue li a {
  text-decoration: none;
  padding: 3px 8px;
  border-radius: 3px;
}
.frontend-ninja-vue li a.router-link-exact-active {
  background: #fff;
}
.frontend-ninja-vue li a:focus {
  outline: none !important;
  text-decoration: none !important;
}
</style>
