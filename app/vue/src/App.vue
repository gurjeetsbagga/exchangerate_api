<template>
  <div id="app">
    <ExchangeRate/>
  </div>
</template>

<script>
import ExchangeRate from './components/ExchangeRate.vue'

export default {
  name: 'App',
  components: {
    ExchangeRate
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
