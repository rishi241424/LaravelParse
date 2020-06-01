<template>
  <div>
    <loading :active.sync="isLoading" :can-cancel="true" :is-full-page="true"></loading>
    <h2>Fetch Industries Data</h2>
    <button @click="fetchIndustrydata()" class="btn btn-primary">Get Data!</button>
    <span class="link">http://mycorporateinfo.com/industry</span>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered" v-if="industries.length > 0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Industry Name</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(industry, index) in industries" :key="index">
              <td>{{++index}}</td>
              <td>{{industry}}</td>
            </tr>
          </tbody>
        </table>
        <span v-else>Please click on button</span>
        <span class="error" v-if="error" v-html="error"></span>
      </div>
    </div>
  </div>
</template>

<script>
// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  data() {
    return { industries: [], isLoading: false, error: "" };
  },
  components: {
    Loading
  },
  methods: {
    fetchIndustrydata() {
      this.isLoading = true;
      window.axios.get(`api/industries`).then(respose => {
        this.isLoading = false;
        if (!respose.data.error) {
          this.industries = respose.data.industries;
          return;
        }
        this.error = respose.data.msg;
      });
    }
  }
};
</script>

<style>
.link {
  background: darkmagenta;
  padding: 10px;
  color: #ffffff;
}
.error {
  color: red;
}
</style>
