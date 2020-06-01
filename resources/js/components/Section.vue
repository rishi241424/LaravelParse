<template>
  <div>
    <loading :active.sync="isLoading" :can-cancel="true" :is-full-page="true"></loading>
    <h2>Fetch Companies Data</h2>
    <button @click="fetchCompanydata()" class="btn btn-primary">Get Data!</button>
    <span class="link">http://mycorporateinfo.com/industry/section/F</span>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered" v-if="companies.length > 0">
          <thead>
            <tr>
              <th>ID</th>
              <th>CIN</th>
              <th>Company Name</th>
              <th>Class</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(company, index) in companies" :key="index">
              <td>{{++index}}</td>
              <td>{{company.cin}}</td>
              <td>{{company.company_name}}</td>
              <td>{{company.class}}</td>
              <td>{{company.status}}</td>
            </tr>
          </tbody>
        </table>
        <span v-else>No record found, please click on button</span>
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
    return { companies: [], isLoading: false, error: "" };
  },
  components: {
    Loading
  },
  methods: {
    fetchCompanydata() {
      this.isLoading = true;
      window.axios.get(`api/sections`).then(respose => {
        this.isLoading = false;
        if (!respose.data.error) {
          this.companies = respose.data.companies;
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
