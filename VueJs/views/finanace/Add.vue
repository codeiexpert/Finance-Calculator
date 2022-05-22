<template>
  <div class="content d-flex flex-column flex-column-fluid height-100" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <div id="kt_content_container" class="container-fluid">
        <div class="row filter-demo-div">
          <div class="col-md-12">
            <div class="d-flex flex-stack">
              <div class="d-inline-block">
                <h1 class="d-inline-block align-items-center text-dark fw-bolder m-0 fs-3">{{ $t('Finance Finance')}}</h1>
              </div>
              <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                <div class="btn btn-icon btn-active-light-primary" id="kt_aside_mobile_toggle">
                  <span class="svg-icon svg-icon-2x mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                        <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
                      </g>
                    </svg>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row h-100">
             <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title m-0 fw-bolder">{{$t('Finance Finance')}}</h3>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <!--begin::dropdown-->
                        <div class="col-md-6 col-12">
                            <label class="fw-bolder mb-2">{{$t('Darlehensgeber')}}</label>
                            <div class="input-group flex-nowrap">
                                <div class="custom-vselect w-100 theme-dropdown">
                                    <v-select class="select-bank" :placeholder="$t('Select Bank')" v-model="finanace_data.selectedBank" :options="banks.map(bank => ({label: bank.name, value: bank.id }))" :clearable="false" :searchable="false" single-line ></v-select>
                                </div>
                                <div class="input-group-append ms-1">
                                <button class="btn btn-secondary px-4 py-3 h-35px d-flex align-items-center justify-content-center" type="button" v-tooltip="$t('Add New Bank')" v-on:click="showBankModal">
                                    <span class="svg-icon svg-icon-primary m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1"
                                            fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11"
                                                width="16" height="2" rx="1"></rect>
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                x="4" y="11" width="16" height="2"
                                                rx="1"></rect>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                                </div>
                            </div>
                        </div>
                        <!--end::dropdown-->
                        <!--begin::dropdown-->
                        <div class="col-md-6 col-12">
                            <label class="fw-bolder mb-2">{{$t('Darlehensform')}}</label>
                            <div class="w-100">
                                <div class="custom-vselect w-100 theme-dropdown">
                                    <v-select class="select-loan" :placeholder="$t('Select Type Of Loan')" v-model="finanace_data.selectedLoanType" :options="type_of_loans.map(loan => ({label: loan.name, value: loan.value }))" :clearable="false" :searchable="false" single-line  v-on:change="checkLoanType"></v-select>
                                </div>
                            </div>
                        </div>
                        <!--end::dropdown-->
                        <!--begin::checkbox-->
                        <div class="col-12">
                            <div class="checkbox-list mt-md-5 mt-4">
                                <label class="checkbox cursor-pointer">
                                    <input type="checkbox" class="form-check-input align-middle" id="shareholderLoanCheck" v-on:change="checkShareholderLoan" v-model="finanace_data.shareholderLoanCheck" >
                                    {{$t('Gesellschafterdarlehen')}}
                                </label>
                            </div>
                        </div>
                        <!--end::checkbox-->
                    </div>
                    <!--begin:: annuity loan-->
                    <div class="bg-light p-md-6 mb-md-8 mt-md-6 rounded-2">
                        <!--begin:: sum and duration-->
                        <div class="row">
                            <!--begin:: principal amount-->
                            <div class="col-md-4 col-12">
                                <div class="w-100">
                                <label class="fw-bolder mb-2">{{$t('Kreditsumme')}}</label>
                                <div class="input-group align-items-center">
                                    <div class="input-group-prepend"><span class="input-group-text bg-white border-end-0 rounded-end-0 border-gray-200">€</span> 
                                    </div>
                                    <vue-numeric-input v-model="finanace_data.principleAmmount" class="h-auto" className="border-start-0 rounded-start-0 border-gray-200" :min="0" placeholder="250.00" :precision="2" controls-type="updown"></vue-numeric-input>
                                </div>
                                </div>
                            </div>
                            <!--end:: principal amount-->
                            <!-- begin:: month -->
                            <div class="col-md-8 col-12">
                                <label class="fw-bolder mb-2 w-100">{{$t('Finanzierung endfällig am')}}</label>
                                <div class="d-md-flex">
                                <!-- begin:: month -->
                                    <div class="w-md-50 me-md-3">
                                        <div class="custom-vselect w-100 theme-dropdown">
                                            <v-select class="select-month" :placeholder="$t('Select Month')" v-model="finanace_data.paymentPeriod.month" :options="payment_months.map(month => ({label: month.id, value: month.value }))" :clearable="false" :searchable="false" single-line  v-on:change="createPikOptions"></v-select>
                                        </div>
                                </div>
                                <!-- end:: month -->
                                <!-- begin:: year -->
                                <div class="w-md-50 ms-md-3">
                                    <div class="custom-vselect w-100 theme-dropdown">
                                        <v-select class="select-year" :placeholder="$t('Select Year')" v-model="finanace_data.paymentPeriod.year" :options="payment_years.map(year => ({label: year.id, value: year.value }))" :clearable="false" :searchable="false" single-line v-on:change="createPikOptions"></v-select>
                                    </div>
                                </div>
                                <!-- end:: year -->
                                </div>
                            </div>
                            <!-- end:: month -->
                        </div>
                        <!--begin:: interest rate-->
                        <div class="row mt-md-6 mt-4 d-md-flex align-items-end">
                            <!--begin:: interest rate-->
                            <div class="col-md-4 col-12">
                                <label class="fw-bolder mb-2">{{ $t('Zins') }}</label>
                                <div class="input-group align-items-center">
                                    <vue-numeric-input v-model="finanace_data.interestRate" class="h-auto" className="border-start-0 rounded-start-0 border-gray-200" :min="0" :placeholder="$t('Enter Interest Rate')" :precision="2" controls-type="updown"></vue-numeric-input>
                                    <div class="input-group-append"><span class="input-group-text bg-white border-end-0 rounded-end-0 border-gray-200">%</span> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <!--begin::dropdown-->
                                <label class="fw-bolder mb-2">{{$t('Unterjährige Tilgungsfrequenz')}}</label>
                                <div class="w-100">
                                    <div class="custom-vselect w-100 theme-dropdown">
                                        <v-select class="select-payment-frequencies" :placeholder="$t('Select Payment Frequency')" v-model="finanace_data.paymentFrequency" :options="payment_frequencies.map(frequency => ({label: frequency.name, value: frequency.value }))" :clearable="false" :searchable="false" single-line v-on:change="createPikOptions" ></v-select>
                                    </div>
                                </div>
                                <!--end::dropdown-->
                            </div>
                            <!--end:: interest rate-->
                            <!--begin:: date-->
                            <!-- <div class="col-md-6 col-12">
                                <label class="fw-bolder mb-2">{{ $t('Zinsberechnung') }}</label>
                                <div class="custom-vselect w-100 theme-dropdown">
                                    <v-select class="select-calc-type" :placeholder="$t('Select Calculation Type')" v-model="finanace_data.calculationType" :options="type_of_calcualtions.map(calc => ({label: calc.name, value: calc.value }))" :clearable="false" :searchable="false" single-line ></v-select>
                                </div>
                            </div> -->
                            <!--end:: date-->
                        </div>
                        <!--end:: interest rate-->
                        <hr class="border-gray-400 border-top my-md-7" v-show="showSpecialPayment || showBulletLoanPayment" />
                        <!--begin:: date and add button-->
                        <div  :class="showSpecialPayment == false ? 'row':'row d-md-flex align-items-end'" class="" v-for="(specialPayment, index) in dynamicSpecialPaymentFields" v-show="showSpecialPayment">
                            <!--begin:: interest rate-->
                            <div class="col-md-6 col-12">
                                <label class="fw-bolder mb-2">{{$t('Sonderzahlungen')}}</label>
                                <div class="w-100">
                                <vue-numeric-input v-model="finanace_data.specialPayment[index].payment" class="w-auto h-auto" className="border-start-0 rounded-start-0 border-gray-200" :min="0" :placeholder="'€ 250'" :precision="2" controls-type="updown"></vue-numeric-input>
                                </div>
                            </div>
                            <!--end:: interest rate-->
                            <!--begin:: select date-->
                            <div class="col-md-6 col-12">
                                <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <label class="fw-bolder mb-2">Select Date</label>
                                    <div class="w-100">
                                        <input class="form-control" type="date" id="select-date" v-model="finanace_data.specialPayment[index].date" />
                                    </div>
                                </div>
                                <button class="btn btn-secondary px-4 py-3 ms-2" type="button" v-on:click="appendSpecialPayemntField"  v-show="index == dynamicSpecialPaymentFields.length -1">
                                    <span class="svg-icon svg-icon-primary m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1"
                                            fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11"
                                                width="16" height="2" rx="1"></rect>
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                x="4" y="11" width="16" height="2"
                                                rx="1"></rect>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                                <button class="btn btn-secondary px-4 py-3 ms-2" type="button" v-on:click="removeSpecialPayemntField(index)"  v-show="dynamicSpecialPaymentFields.length > 1">
                                    <span class="svg-icon svg-icon-primary m-0">                                    
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                                </div>
                            </div>
                            <!--end:: select date-->
                        </div>
                        <div class="row" v-show="showBulletLoanPayment">
                            <div class="col-md-12">
                                <label class="fw-bolder mb-2">{{$t('Ballon Zahlung')}}</label>
                                <div class="input-group align-items-center">
                                    <div class="input-group-prepend"><span class="input-group-text bg-white border-end-0 rounded-end-0 border-gray-200">€</span> 
                                    </div>
                                    <vue-numeric-input v-model="finanace_data.bulletLoanPayment" class="w-auto h-auto" className="border-start-0 rounded-start-0 border-gray-200" :min="0" :max="finanace_data.principleAmmount ? finanace_data.principleAmmount/1.1 : 1000" placeholder="250.00" :precision="2" controls-type="updown"></vue-numeric-input>
                                </div>
                            </div>
                        </div>
                        <!--begin:: date and add button-->
                        <hr class="border-gray-400 border-top my-md-7" v-show="showSpecialPayment || showBulletLoanPayment" />                      
                    </div>
                    <!--end:: annuity loan-->
                    <!--begin::PIK options-->
                    <div class="shareholder-loan-div" v-show="finanace_data.shareholderLoanCheck">                            
                        <div class="row mt-md-6 mt-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-4" v-if="pikOptionsTitle.length > 0">
                                    <label class="fw-bolder">{{ $t('Choose PIK options') }}</label>                                   
                                </div>
                                <div v-else class="mb-4" >
                                    <label class="fw-bolder">{{ $t('Choose PIK options') }}</label>
                                    <div>
                                        <small>
                                            {{ $t('PIK options will be generated automatically according to First repayment date, Payment Frequency & Payment Period') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-cols-sm-6 row" v-if="pikOptionsTitle.length > 0">
                            <div class="col-md-12" v-for="title in pikOptionsTitle">

                                <div class="py-2">
                                    <div class="d-flex align-items-center gap-4 py-4">
                                        <label class="form-label fw-bolder m-0">{{title}}</label>  
                                        <div class="checkbox-list">
                                            <label class="checkbox cursor-pointer">
                                            <input type="checkbox" :class="'form-check-input select-all select-all-'+title" name="checkboxes-pik-all"  @click="selectAllPikOptions($event, title)">Select All {{ !isNaN(title) ? 'Months' : '' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 flex-wrap py-3">
                                        <div class="checkbox-list" v-for="(option, key) in pikOptions" v-if="option.for == title">
                                            <label :class="isNaN(title) ? 'checkbox cursor-pointer w-200px' : 'checkbox cursor-pointer' ">
                                            <input type="checkbox" :class="'form-check-input pik-option-'+option.for" name="checkboxes-pik" v-on:change="selectPikOptions(title)"  :value="option | filterValue(key)" v-model.lazy="finanace_data.unsortedPikOptionsData">
                                                {{ option.data }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <!--end::PIK options-->
                    <!--begin::datepickers-->
                    <div class="row mt-md-6 mt-4">
                        <!--begin:: date-->
                        <div class="col-md-4 col-12">
                            <label class="fw-bolder mb-2">{{$t('Zeitpunkt der ersten Tilgung')}}</label>
                            <div class="w-100">
                                <input class="form-control form-control-solid" type="date" id="select-date" v-model="finanace_data.firstFinanceRepaymentDate" v-on:change="createPikOptions">
                            </div>
                        </div>
                        <!--end:: date-->
                        <!--begin:: date-->
                        <div class="col-md-4 col-12">
                            <label class="fw-bolder mb-2">{{$t('Zinsbindung bis')}}</label>
                            <div class="w-100">
                                <input class="form-control form-control-solid" type="date" id="select-date-sec"  v-model="finanace_data.interestPayDate">
                            </div>
                        </div>
                        <!--end:: date-->
                        <!--begin:: date-->
                        <div class="col-md-4 col-12">
                            <label class="fw-bolder mb-2">{{$t('Zeitpunkt der ersten Zinszahlung')}}</label>
                            <div class="w-100">
                                <input class="form-control form-control-solid" type="date" id="select-date-three" v-model="finanace_data.dateOfFirstInterestPayment">
                            </div>
                        </div>
                        <!--end:: date-->
                    </div>
                    <!--end::datepickers-->
                    <!--begin::buttons-->
                    <div class="row mt-md-6 mt-4">
                        <div class="col-12 text-md-end">
                            <button class="btn btn-sm btn-demo" type="button" @click.prevent="SubmitData('with-pik')" :disabled="pikViewEnable">{{ $t('PIK Option') }}</button>
                            <button class="btn btn-sm btn-demo" type="button" @click.prevent="SubmitData('without-pik')" :disabled="withoutPikViewEnable">{{ $t('Without PIK Option') }}</button>
                        </div>
                    </div>
                    <!--end::buttons-->
                    </div>
                </div>
                <!--end::Container-->
            </div>
        </div>
    </div>    
    <div class="loading" v-if="loader">
      <div class="loader"></div>
    </div>
  </div>  
    <!-- Bank modal -->
    <div class="modal fade" id="bank-firm" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">       
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-between px-5">
                    <h5 class="modal-title">Add New Bank</h5>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" v-on:click="hideBankModal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                            </g>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y py-10 px-5">
                    <input class="form-control form-control-solid" id="select-opt-modal" v-model="addBank" type="text" placeholder="Type here">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" v-on:click="hideBankModal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" v-on:click="saveBank">Save</button>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  
</template>

<script>
  import Finance from "../../apis/Finance"  

  export default {
    name: 'FinancingView',
    data() {
      return {
        loader: false,  
        banks:[],
        disabled:true,
        type_of_loans:[
            {
                name: this.$t('Annuitätendarlehen'),
                value:"annuity-loan"
            },
            {
                name: this.$t('Tilgungsdarlehen'),
                value:"amortizing-loan"
            },
            {
                name: this.$t('Endfälliges Darlehen'),
                value:"bullet-loan"
            }
        ],
        type_of_calcualtions:[
            {
                name: 'act/360 ('+this.$t('Eurozinsmethode, französische Zinsmethode')+')',
                value:"act/360"
            },
            {
                name: 'act/365 ('+this.$t('englische Zinsmethode')+')',
                value:"act/365"
            },
            {
                name: 'act/act ('+this.$t('Effektivzinsmethode')+ ')',
                value:"act/act"
            },
            {
                name: '30/360 ('+this.$t('deutsche Zinsmethode')+')',
                value:"30/360"
            }
        ],
        payment_frequencies:[
            {
                name: this.$t('Monthly'),
                value:"monthly"
            },
            {
                name: this.$t('Quarterly'),
                value:"quaterly"
            },
            {
                name: this.$t('Semi-Yearly/Semi-Annually/Half-Yearly'),
                value:"semi-yearly"
            },
            {
                name: this.$t('Yearly/Annually'),
                value:"yearly"
            }
        ],
        pikCount: 0,
        pikOptions:[],
        pikOptionsTitle:[],
        payment_months: [],
        payment_years:[],
        addBank: null,
        showSpecialPayment: false,
        showBulletLoanPayment: false,
        dynamicSpecialPaymentFields:[0],
        validationErrors: [],
        checkPikAll: false,
        pikViewEnable: true,
        withoutPikViewEnable: false,
        finanace_data: {
            selectedBank:"No Bank Added",
            shareholderLoanCheck: false,
            selectedLoanType: null,
            principleAmmount: null,
            interestRate: null,
            paymentFrequency: null,
            specialPayment:[
                {
                    payment: null,
                    date:null,
                }
            ],
            paymentPeriod: {
                year: {
                    label: 0,
                    value: 0
                },
                month: {
                    label: 0,
                    value: 0
                } 
            },
            firstFinanceRepaymentDate: null,
            interestPayDate:null,
            dateOfFirstInterestPayment:null,
            bulletLoanPayment:null,
            unsortedPikOptionsData: [],   
            pikOptionsData:[]    
        }        
      }
    },
    filters: {
      filterValue(obj, key){
          var array = []
          if(obj.for == 'Quaterly' || obj.for == "Yearly" || obj.for == "Semi Yearly"){
            array.push({
                key:key,
                data:obj.data
            })
            return JSON.stringify(array)
          }else{
            array.push({
                key:key,
                data:obj.data+'-'+obj.for
            })
            return JSON.stringify(array)
          }
      }
    },
    mounted() {
        if(localStorage.user_role == 'Admin') {
                this.$router.push({ name: "UserManagement" })
        }else{
            this.getBanks()
            this.createMonthYearValues()
        }
    },
    methods: {
        async getBanks(){
            this.loader = true
            Finance.getBanks().then(res => {
                if(res.data.banks.length > 0){
                    this.banks = res.data.banks

                    if(this.finanace_data.selectedBank == 'No Bank Added'){
                        this.finanace_data.selectedBank = null
                    }
                }
                this.loader = false
            }).catch(error=> {
                this.loader = false
            })
        },
        async saveBank(event){
            if(this.addBank == null){
                this.$toast.error(this.$t('Please Enter Bank Name'))
                return false;
            }
            jQuery(event.target).addClass('disabled')
            Finance.addBank(this.addBank).then(res => {
                if(res.data.success == false){
                    jQuery(event.target).removeClass('disabled')
                    this.$toast.error(this.$t(res.data.message))
                }else{
                    jQuery(event.target).removeClass('disabled')
                    this.hideBankModal()
                    this.getBanks()
                    this.$toast.success(this.$t(res.data.message))
                }
                
            }).catch(error=> {
                this.$toast.error(this.$t(res.data.message))
            })
        },
        async createMonthYearValues(){  
            for(var i=0; i <= 11; i++){
                this.payment_months.push({
                    id: i,
                    value: i
                });
            }
            for(var j=0; j <= 50; j++){
                this.payment_years.push({
                    id: j,
                    value: j
                });
            }

        },
        async appendSpecialPayemntField(){

            this.finanace_data.specialPayment.push({
                payment:null,
                date:null
            })
            this.dynamicSpecialPaymentFields.push(this.dynamicSpecialPaymentFields.length)
            
        },   
        async removeSpecialPayemntField(index){
            this.$delete(this.dynamicSpecialPaymentFields, index)
            this.$delete(this.finanace_data.specialPayment, index)
        },  
        async selectAllPikOptions(event, title){
            if(title == 'Semi Yearly'){
                title = 'Semi'
            }
            if(event.target.checked){
                jQuery('.pik-option-'+title+'').prop('checked', false).trigger("click")
                // this.checkPikAll = true
            }else{
                jQuery('.pik-option-'+title+'').prop('checked', true).trigger("click")
                // this.checkPikAll = false
            }
        },
        async validateView(){
                this.validationErrors = []
                let translatedArray =  {
                    'payment_frequency' : 'Unterjährige Tilgungsfrequenz',
                    'payment_due' : 'Finanzierung endfällig am',
                    'first_deb_repay_date': 'Zeitpunkt der ersten Tilgung',
                    'select_bank': 'Darlehensgeber',
                    'select_loan': 'Darlehensform',
                    'principle_ammount': 'Kreditsumme',
                    'balloon_payment': 'Ballon Zahlung',
                    'interest_rate': 'Zins'
                }

              
                if(this.finanace_data.paymentFrequency == null){
                    this.validationErrors.push(translatedArray['payment_frequency'])
                }
                if(this.finanace_data.paymentPeriod.year.value == 0 && this.finanace_data.paymentPeriod.month.value == 0){
                    this.validationErrors.push(translatedArray['payment_due'])
                }
                if(this.finanace_data.firstFinanceRepaymentDate == null){
                    this.validationErrors.push(translatedArray['first_deb_repay_date'])
                }              
                if(this.finanace_data.principleAmmount == 0 || this.finanace_data.principleAmmount == null){
                    this.validationErrors.push(translatedArray['principle_ammount'])
                }
                if(this.finanace_data.principleAmmount == 0 || this.finanace_data.principleAmmount == null){
                    this.validationErrors.push(translatedArray['principle_ammount'])
                }
                if(this.finanace_data.interestRate == 0 || this.finanace_data.interestRate == null){
                    this.validationErrors.push(translatedArray['interest_rate'])
                }
                if(this.finanace_data.selectedBank == null){
                    this.validationErrors.push(translatedArray['select_bank'])
                }
                if(this.finanace_data.selectedLoanType == null){
                    this.validationErrors.push(translatedArray['select_loan'])
                }
                if(this.finanace_data.bulletLoanPayment == null && this.finanace_data.selectedLoanType != null && this.finanace_data.selectedLoanType.value == 'bullet-loan'){
                    this.validationErrors.push(translatedArray['balloon_payment'])
                }

              
                
               
        },       
        async SubmitData(type){

            this.validateView()
            if(this.validationErrors.length > 0){
                this.$toast.error(this.$t('Please fill all required fields: ( ')+this.validationErrors.join(", ")+' )')
            }else{
                var self = this
                if(this.finanace_data.specialPayment && this.finanace_data.selectedLoanType != null && this.finanace_data.selectedLoanType.value == 'amortizing-loan'){                    
                    var failed = 0
                    // console.log(this.finanace_data.specialPayment)
                    this.finanace_data.specialPayment.forEach( function(ele, index){
                        if(ele.payment == null && ele.date != null){
                            self.$toast.error(self.$t('Please fill payments for special payments with unfilled payments'))       
                            failed = 1                
                        }else if(ele.payment != null && ele.payment != 0 && ele.date == null){
                            self.$toast.error(self.$t('Please fill date for special payments with unfilled dates'))
                            failed = 1  
                        }
                    })
                    if(failed == 1){
                        return false
                    }
                }
                if(type == 'with-pik'){
                    if(this.finanace_data.shareholderLoanCheck == false){
                        this.$toast.error(this.$t('Please check shareholder loan checkbox to proceed'))
                        return false
                    }

                    if(this.finanace_data.unsortedPikOptionsData.length < 1){
                        this.$toast.error(this.$t('Please select atleast one Pik option'))
                        return false
                    }

                    var unSortedArray = this.finanace_data.unsortedPikOptionsData
                    var sortedArray = []
                    unSortedArray.forEach(function(ele){
                        var element_data = JSON.parse(ele)
                        sortedArray[element_data[0].key] = element_data[0].data
                    })
                    this.finanace_data.pikOptionsData = sortedArray.filter(function (item) { return item != undefined });
                }                
                this.loader = true
                Finance.saveFinanceData(this.finanace_data).then(res => {
                    if(type == 'with-pik'){
                        this.$router.push({ name: "FinancingWithPikView",params:{id: res.data.finance_id} })
                    }else{
                        this.$router.push({ name: "FinancingWithoutPikView",params:{id: res.data.finance_id} })
                    }                    
                    this.loader = false
                }).catch(error=> {
                    this.$toast.error('Internal server error')
                    this.loader = false
                })
                
            }
        },
        async selectPikOptions(title){
            if(title == 'Semi Yearly'){
                title = 'Semi'
            }

            var select_all_element = '.select-all-'+title
            var element_checkbox = '.pik-option-'+title
            

            var numberOfChecked = jQuery(element_checkbox+':checked').length;
            var totalCheckboxes = jQuery(element_checkbox).length;

            if(numberOfChecked == totalCheckboxes){
                jQuery(select_all_element).prop('checked', true)
            }else{
                jQuery(select_all_element).prop('checked', false)
            }
           
        },
        async checkLoanType(event){
            if(this.finanace_data.selectedLoanType.value == 'amortizing-loan'){
                this.showSpecialPayment = true
                this.showBulletLoanPayment = false
            }else if(this.finanace_data.selectedLoanType.value == 'bullet-loan'){
                this.showBulletLoanPayment = true
                this.showSpecialPayment = false
            }else{
                this.showBulletLoanPayment = false
                this.showSpecialPayment = false
            }
        },
        async checkShareholderLoan(){
            if(this.finanace_data.shareholderLoanCheck == true){
                this.withoutPikViewEnable = true
                this.pikViewEnable = false
            }else{
                this.withoutPikViewEnable = false
                this.pikViewEnable = true
            }
        },
        async createPikOptions(){ 
            this.finanace_data.unsortedPikOptionsData = []
            if((this.finanace_data.paymentPeriod.year.value != 0 || this.finanace_data.paymentPeriod.month.value != 0) && this.finanace_data.firstFinanceRepaymentDate != null && this.finanace_data.paymentFrequency != null){

                const months_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']   
                var month = this.finanace_data.paymentPeriod.month.value
                var year = this.finanace_data.paymentPeriod.year.value
                var freq = this.finanace_data.paymentFrequency.value
                var first_repayment_date = this.finanace_data.firstFinanceRepaymentDate
                var total_number_of_months = (parseInt(year)*12) + parseInt(month)  
                
                this.pikOptionsTitle = []
                this.pikOptions = []
                var years_arr = []
                this.pikCount = total_number_of_months
                jQuery('.select-all').prop('checked',false)
                if(freq == 'monthly'){
                    for( var i = 0; i < total_number_of_months; i++){

                        var repay_date = new Date(first_repayment_date)
                        repay_date.setMonth(repay_date.getMonth() + i) 

                        if(years_arr.indexOf(repay_date.getFullYear()) == -1){
                           years_arr.push(repay_date.getFullYear())                    
                           this.pikOptionsTitle.push(repay_date.getFullYear())
                        }  
                        this.pikOptions.push({
                            for: repay_date.getFullYear(),
                            data: months_arr[repay_date.getMonth()]
                        })
                    }
                    // console.log('this.pikOptionsYear: '+ this.pikOptionsYear)
                    // console.log('this.pikOptions: '+ this.pikOptions)
                }else if(freq == 'quaterly'){

                    if( parseInt(month) > 0 && parseInt(month) <= 3){
                        var total_number_quarters = (parseInt(year) * 4)+1                         
                    }else if(parseInt(month) <= 6 && parseInt(month) > 3){
                        var total_number_quarters = (parseInt(year) * 4)+2
                    }else if(parseInt(month) <= 9 && parseInt(month) > 6){
                        var total_number_quarters = (parseInt(year) * 4)+3
                    }else if(parseInt(month) <= 12 && parseInt(month) > 9){
                        var total_number_quarters = (parseInt(year) * 4)+4
                    }else{
                        var total_number_quarters  = (parseInt(year) * 4)
                    }    
                    var repay_date = new Date(first_repayment_date)
                    this.pikOptionsTitle.push('Quaterly')
                    this.pikCount = total_number_quarters
                    for( var i = 0; i < total_number_quarters; i++){
                        if(i == 0){
                            repay_date.setMonth(repay_date.getMonth() + 0) 
                        }else{
                            repay_date.setMonth(repay_date.getMonth() + 3) 
                        }

                        var select_date_key_1 = new Date(repay_date)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+2)

                        var selected_month =  months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+  select_date_key_2.getFullYear() 

                        this.pikOptions.push({
                            for: 'Quaterly',
                            data: selected_month
                        })
                    }
                }else if(freq == 'semi-yearly'){

                    if( parseInt(month) > 6){
                        var total_number_of_half_years = (parseInt(year) * 2)+2
                    }else if(parseInt(month) <= 6 && parseInt(month) > 0){
                        var total_number_of_half_years = (parseInt(year) * 2)+1
                    }else{
                        var total_number_of_half_years = (parseInt(year) * 2)
                    } 
                    var repay_date = new Date(first_repayment_date)
                    this.pikOptionsTitle.push('Semi Yearly')
                    this.pikCount = total_number_of_half_years
                    for( var i = 0; i < total_number_of_half_years; i++){
                        if(i == 0){
                            repay_date.setMonth(repay_date.getMonth() + 0) 
                        }else{
                            repay_date.setMonth(repay_date.getMonth() + 6) 
                        }
                        var select_date_key_1 = new Date(repay_date)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+5)

                        var selected_month =  months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+  select_date_key_2.getFullYear() 

                        this.pikOptions.push({
                            for: 'Semi Yearly',
                            data: selected_month
                        })
                    }
                }else {

                    var total_number_of_years = year
                    if(month > 0){
                        ++total_number_of_years
                    }
                    this.pikCount = total_number_of_years
                    this.pikOptionsTitle.push('Yearly')
                    for( var i = 0; i < total_number_of_years; i++){

                        var repay_year = new Date(first_repayment_date)
                        repay_year.setFullYear(repay_year.getFullYear() + i) 

                        var select_date_key_1 = new Date(repay_year)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+11)

                        var final_selected_year = months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+select_date_key_2.getFullYear() 
   
                        this.pikOptions.push({
                            for: 'Yearly',
                            data: final_selected_year
                        })
                    }
                }
            }else{
                this.pikCount = 0
                this.pikOptionsTitle = []
                this.pikOptions = []
            }
            
        },
        async showBankModal(){
            jQuery('#bank-firm').modal('show')
        },
        async hideBankModal(){
            jQuery('#bank-firm').modal('hide')
            this.addBank = null
        }
    }   
  }
</script>
