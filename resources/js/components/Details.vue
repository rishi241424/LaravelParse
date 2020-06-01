<template>
  <div>
    <loading :active.sync="isLoading" :can-cancel="true" :is-full-page="true"></loading>
    <h2>Fetch Detail Data</h2>
    <button @click="fetchDetailData()" class="btn btn-primary">Get Data!</button>
    <span class="link">http://mycorporateinfo.com/business/shilpi-builders-limited-1</span>
    <div class="row">
      <div class="col-md-12">
        <div v-html="company.description"></div>
      </div>
      <div class="col-md-12">
        <div v-html="company.company_information"></div>
      </div>
      <div class="col-md-12">
        <div v-html="company.company_detail"></div>
      </div>
      <div class="col-md-12">
        <div v-html="company.listingandannualcomplaincedetails"></div>
      </div>
      <div class="col-md-12">
        <div v-html="company.otherinformation"></div>
      </div>
      <div class="col-md-12">
        <div v-html="company.faq"></div>
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
    return {
      company: {
        description: "",
        company_information: "",
        company_detail: "",
        listingandannualcomplaincedetails: "",
        otherinformation: "",
        faq: ""
      },
      isLoading: false,
      error: ""
    };
  },
  components: {
    Loading
  },
  methods: {
    fetchDetailData() {
      this.isLoading = true;
      window.axios.get(`api/detail`).then(respose => {
        this.isLoading = false;
        if (!respose.data.error) {
          this.company = respose.data.data;
        }
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
