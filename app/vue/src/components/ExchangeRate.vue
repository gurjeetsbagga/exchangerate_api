<template>
  <div class="m-auto">
    <h1>Currency Converter</h1>
    <section v-if="errored">
      <p>We're sorry, we're not able to retrieve this information at the moment, please try back later</p>
    </section>
    <section v-else>
      <div v-if="loading">Loading...</div>
      <div v-else
          class="currency">
        <div class="box">
        <span class="lighten">
          <table class="table-auto">
            <tbody>
            <tr>
              <td></td>
              <td><strong>1 {{info.base_code}} = </strong></td>
            </tr>
            <tr v-for="(key, value) in codes" :key="key">
                <td>{{value}}</td>
                <td>{{key}}</td>
            </tr>
            <tr>
              <td>
              </td>
              <td>
                <button @click='reload' class="bg-red-100 px-4 py-3 hover:bg-red-300">Refresh</button>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Rates {{currentDate()}}</td>
            </tr>
            </tbody>
          </table>
        </span>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import axios from 'axios';
import '../assets/index.css';

export default {
  name: "ExchangeRate",
  data() {
    return {
      info: null,
      codes: null,
      loading: false,
      errored: false
    };
  },
  methods:{
    reload() {
      location.reload();
    },
    currentDate() {
      const current = new Date();
      const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
      const date = `${current.getDate()} ${month[current.getMonth()]} ${current.getFullYear()}`;
      return date;
    }
  },
  created() {
    axios.get('http://localhost:82/api/exchange_rate/usd')
        .then(response => {
          this.info = response.data;
          var items = {};
          Object.keys(this.info.conversion_rates).forEach((value) => {
            console.log(value)
            if (Object.keys(this.info.symbols).includes(value)) {
              items[this.info.symbols[value]] = this.info.conversion_rates[value];
            }
          });
          this.codes = items;
          // console.log(this.codes)
          this.errored=false;
        })
        .catch(e => {
          this.errored=true;
          console.log(e)
          this.errors.push(e)
        })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
