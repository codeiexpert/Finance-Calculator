<template>
  <div class="content d-flex flex-column flex-column-fluid height-100" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <div id="kt_content_container" class="container-fluid">
        <div class="row filter-demo-div">
          <div class="col-md-12">
            <div class="d-flex flex-stack">
              <div  class="page-title d-flex align-items-center flex-wrap lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder m-0 fs-3">{{ $t('Payment and Interest')}}</h1>
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1" v-if="user_id != ''">
                  <li class="breadcrumb-item fw-bold">
                    <router-link :to='{name:"ClientManagement"}' class="fw-bold text-hover-primary">{{ $t('Client Management') }}</router-link>
                  </li>
                  <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                  </li>
                  <li class="breadcrumb-item text-dark">{{ $t('Finance Finance') }}</li>
                </ul>
              </div>
              <div class="d-flex align-items-center py-1" v-if="user_id != ''">           
                <div>
                  <router-link :to='{name:"ClientManagement"}' exact class="btn btn-sm btn-secondary">
                    {{ $t('Back') }}
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row h-100">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title m-0 fw-bolder">{{ $t('Finance Finance') }}</h3>
                    </div>
                    <div class="card-body">
                      <!-- begin::row -->
                      <div class="row">
                        <div class="col-12">
                          <h6 class="fw-bolder mb-3">{{ $t('Loan Management') }}</h6>
                          <!-- begin::table -->
                          <div class="table-responsive bg-white">
                            <table class="table table-striped border m-0">
                              <thead>
                                  <tr>
                                      <th class="fw-bolder text-nowrap">{{ $t('Darlehensform') }}</th>
                                      <th class="fw-bolder text-nowrap">{{ $t('Kreditsumme') }}</th>
                                      <th class="fw-bolder text-nowrap">{{ $t('Finanzierung endfällig am') }}</th>
                                      <th class="fw-bolder text-nowrap">{{ $t('Zins') }}</th>
                                      <th class="fw-bolder text-nowrap">{{ $t('Unterjährige Tilgungsfrequenz') }}</th>
                                      <th class="fw-bolder text-nowrap">{{ $t('Date') }}</th>
                                      <th class="fw-bolder text-nowrap">{{ $t('Action') }}</th>
                                  </tr>
                              </thead>
                              <tbody v-if="Object.keys(FinanceList).length > 0">
                                  <tr v-for="(Finance, key) in FinanceList.data"  :key="key">
                                    <td>
                                      {{Finance.loan_type}}
                                      <code class="text-danger ms-0 text-nowrap fs-8 px-0">{{Finance.payment_data | jsonParse}}</code>  
                                    </td>
                                    <td>{{parseFloat(Finance.principal_amount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})}}</td>
                                    <td>{{Finance.finance_year == 1 ? Finance.finance_year+' Year' : Finance.finance_year+' Years'}}{{Finance.finance_month != 0 ?  Finance.finance_month == 1 ? ' & '+Finance.finance_month+' Month' : ' & '+Finance.finance_month+' Months' : ''}}</td>
                                    <td>{{Finance.interest_rate}} %</td>
                                    <td>{{Finance.payment_frequency}}</td>
                                    <td>{{Finance.created_at | formatDate }}</td>
                                    <td>
                                      <div class="d-flex align-items-center">
                                        <router-link v-if="Finance.shareholder_loan_check == 0" :to='{name:"FinancingWithoutPikView",params:{id: Finance.id}}' class="btn btn-icon btn-light btn-hover-primary btn-sm" v-tooltip="$t('Without Pik Options')">
                                            <span class="svg-icon svg-icon-info svg-icon-2">
                                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                      <rect x="0" y="0" width="24" height="24"/>
                                                      <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                      <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                                  </g>
                                              </svg>
                                            </span>
                                          </router-link>
                                          <router-link v-else :to='{name:"FinancingWithPikView",params:{id: Finance.id}}' class="btn btn-icon btn-light btn-hover-primary btn-sm" v-tooltip="$t('With Pik Options')">
                                            <span class="svg-icon svg-icon-info svg-icon-2">
                                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                      <rect x="0" y="0" width="24" height="24"/>
                                                      <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                      <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                                  </g>
                                              </svg>
                                            </span>
                                          </router-link>
                                          <button class="btn btn-icon btn-light btn-hover-primary btn-sm" v-tooltip="$t('Delete Finance Finance Data')" @click.prevent="removeFinanceData(Finance.id)">
                                            <span class="svg-icon svg-icon-primary svg-icon-2">
                                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect> <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path> <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg>
                                            </span>
                                          </button>
                                      </div>
                                    </td>
                                  </tr>                                 
                              </tbody>
                              <tbody v-if="Object.keys(FinanceList.data).length == 0">
                                 <tr class="align-middle">
                                      <td colspan="7" class="ps-3">
                                          <p class="text-dark m-0 fw-bold d-flex align-items-center"><span class="svg-icon svg-icon-2hx me-3"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect> <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle> <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"></rect> <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"></rect></g></svg></span> {{ $t('No record(s) found.')}}</p> 
                                      </td>
                                  </tr>     
                              </tbody>
                            </table>
                          </div>
                          <div class="row py-3">
                            <div class="col-md-12 col-12">
                              <div class="d-flex justify-content-end align-items-center flex-wrap">
                                <pagination :data="FinanceList" :limit="2" @pagination-change-page="showData"></pagination>
                              </div>
                            </div>
                          </div>
                          <!-- end::table -->
                        </div>
                      </div>
                      <!-- end::row -->
                    </div>
                </div>
                <!--end::Container-->
            </div>
        </div>
        </div>
    </div>    
    <div class="loading" v-if="loader">
      <div class="loader"></div>
    </div>
  </div> 
  
  
</template>

<script>
  import Finance from "../../apis/Finance"  
  import moment from 'moment';

  export default {
    name: 'FinancingWithoutPikView',
    data() {
      return {
        loader: false, 
        user_id: '',
        FinanceList: {
          data: []
        }   
      }
    },
    mounted() {
      if(this.$route.params.id){      
            this.user_id = this.$route.params.id     
      }else{
        if(localStorage.user_role == 'Admin') {
            this.$router.push({ name: "UserManagement" })
        } 
      }     
      this.showData()   
    },
    filters: {
      jsonParse(obj){

        var json_data = JSON.parse(obj)
        if(json_data.specialPayment.length > 0 && json_data.specialPayment[0].payment != null && json_data.specialPayment[0].date != null){
          return 'with special payment'
        }else{
          return ''
        }
      },
      formatDate(obj){
        return moment(String(obj)).format('lll')
      }
    },
    methods: {       
        async showData(page = 1){
            this.loader = true
            Finance.getFinanceList(this.user_id, page).then(res => {                
                this.FinanceList = res.data.list
                this.loader = false
            }).catch(error=> {
                this.$toast.error('Internal server error')
                this.loader = false
            })
        },
        async removeFinanceData(id){
            this.$confirm({
                title: this.$t('Are you sure?'),
                message: this.$t('Are you sure you want to delete this Finance finanace data?'),
                button: {
                    yes: this.$t('Yes'),
                    no: this.$t('No')
                },
                callback: confirm => {
                    if (confirm) {
                        this.loader = true
                        Finance.removeFinanceData(id).then(res => {                
                            this.showData(this.FinanceList.current_page)
                            this.$toast.error(res.data.message)
                            this.loader = false
                        }).catch(error=> {
                            this.$toast.error('Internal server error')
                            this.loader = false
                        })
                    }
                }
            })
        }
    }   
  }
</script>
