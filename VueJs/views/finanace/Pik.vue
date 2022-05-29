<template>
  <div class="content d-flex flex-column flex-column-fluid height-100" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="row filter-mxd-div">
                <div class="col-md-12">
                    <div class="d-flex flex-stack">
                        <div  class="page-title d-flex align-items-center flex-wrap lh-1">
                            <h1 class="d-flex align-items-center text-dark fw-bolder m-0 fs-3">{{ $t('Payment and Interest')}}</h1>
                            <span class="h-20px border-gray-200 border-start mx-4"></span>
                        </div>
                        <div class="d-flex align-items-center py-1" v-if="userRole == 'Admin'">           
                            <div>
                            <router-link :to='{name:"ClientManagement"}' exact class="btn btn-sm btn-secondary">
                                {{ $t('Back') }}
                            </router-link>
                            </div>
                        </div>
                        <div class="d-flex align-items-center py-1" v-else>           
                            <div>
                            <router-link :to="{ name: 'DebtList' }" exact class="btn btn-sm btn-secondary">
                                {{ $t('Back') }}
                            </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row h-100">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title m-0 fw-bolder">{{$t('Pik View')}}</h3>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <!--begin::dropdown-->
                        <div class="col-md-6 col-12">
                            <label class="fw-bolder mb-2">{{$t('Darlehensgeber')}}</label>
                            <input type="text" class="form-control text-dark opacity-75" disabled="disabled" :value="paymentData.selectedBank"/>
                        </div>
                        <!--end::dropdown-->
                        <!--begin::dropdown-->
                        <div class="col-md-6 col-12">
                            <label class="fw-bolder mb-2">{{$t('Darlehensform')}}</label>
                            <input type="text" class="form-control text-dark opacity-75" disabled="disabled" :value="paymentData.selectedLoanLabel"/>
                        </div>
                        <!--end::dropdown-->
                        <!--begin::checkbox-->
                        <div class="col-12">
                            <div class="checkbox-list mt-md-5 mt-4">
                                <label class="checkbox checkbox-disabled">
                                <input type="checkbox" class="form-check-input align-middle opacity-100" name="Checkboxes1" v-model="paymentData.shareHolderLoanCheck"  :disabled="true">{{ $t('Gesellschafterdarlehen') }}</label>
                            </div>
                        </div>
                        <!--end::checkbox-->
                        <!--begin::PIK options-->
                        <div class="row mt-md-8 mt-4">
                            <div class="col-12">
                                <label class="fw-bolder me-3">{{ $t('PIK options') }}</label>                                        
                            </div>
                            <div class="col-md-12" v-for="title in pikOptionsTitle">
                                <div class="py-2">
                                    <label class="form-label fw-bolder">{{title}}</label>
                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                        <div class="checkbox-list" v-for="option in pikOptions" v-if="option.for == title">
                                            <label class="checkbox checkbox-disabled">
                                            <input type="checkbox" class="form-check-input opacity-100" name="checkboxes-pik" :checked="true" :disabled="true">
                                                {{ option.data }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!--end::PIK options-->
                    </div>
                    <!--begin::datepickers-->
                    <div class="row mt-md-6 mt-4">
                        <!--begin:: date-->
                        <div class="col-md-4 col-12">
                            <label class="fw-bolder mb-2">{{$t('Zeitpunkt der ersten Tilgung')}}</label>
                            <div class="w-100">
                                <input type="date" id="select-date" class="form-control text-dark opacity-75 form-control-solid" disabled="disabled" :value="paymentData.firstDebtRepaymentDate"/>
                            </div>
                        </div>
                        <!--end:: date-->
                        <!--begin:: date-->
                        <div class="col-md-4 col-12">
                            <label class="fw-bolder mb-2">{{$t('Zinsbindung bis')}}</label>
                            <div class="w-100">
                                <input type="date" id="select-date-2" class="form-control text-dark opacity-75 form-control-solid" disabled="disabled"  :value="paymentData.interestPayDate != null ? paymentData.interestPayDate : ''"/>
                            </div>
                        </div>
                        <!--end:: date-->
                        <!--begin:: date-->
                        <div class="col-md-4 col-12">
                            <label class="fw-bolder mb-2">{{$t('Zeitpunkt der ersten Zinszahlung')}}</label>
                            <div class="w-100">
                                <input type="date" id="select-date-3" class="form-control text-dark opacity-75 form-control-solid" disabled="disabled"  :value="paymentData.dateOfFirstInterestPayment != null ? paymentData.dateOfFirstInterestPayment : ''"/>
                            </div>
                        </div>
                        <!--end:: date-->
                    </div>
                    <!--end::datepickers-->
                    <!-- begin::accordion -->
                                    
                    <div class="accordion accordion-flush" id="accordionDuration-data"> 
                        <div class="accordion-item mb-2" v-for="(year, key) in years">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button :class="key == 0 ? 'accordion-button fw-bolder text-dark fs-6 bg-light':'accordion-button fw-bolder text-dark fs-6 bg-light collapsed'" type="button" data-bs-toggle="collapse" :data-bs-target="'#year-'+key" aria-expanded="false" aria-controls="year-collapseOne">
                                <span class="svg-icon svg-icon-dark me-3 svg-icon-2 plus-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                        </g>
                                    </svg>
                                </span>
                                <span class="svg-icon svg-icon-dark me-3 svg-icon-2 minus-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                        </g>
                                    </svg>
                                </span>
                                <span> {{ year }}</span>
                                </button>
                            </h2>
                            <div :id="'year-'+key" :class="key == 0 ? ' accordion-collapse collapse show':'accordion-collapse collapse hide'" aria-labelledby="flush-headingOne" data-bs-parent="#accordionDuration-data">
                                <div class="accordion-body bg-white px-0">
                                <div class="table-responsive bg-white">
                                    <table class="table table-striped border m-0">
                                        <thead>
                                            <tr>
                                                <th class="fw-bolder align-top">{{ $t(table_dynamic_header) }}</th>
                                                <th class="fw-bolder align-top">{{ $t('Beginning Balance') }}</th>
                                                <th class="fw-bolder align-top">{{ $t('Periodic Payment') }} <br /><small class="fw-normal">({{ $t('Without Interest') }})</small></th>
                                                <th class="fw-bolder align-top">{{ $t('Interest Due') }}</th>
                                                <th class="fw-bolder align-top">{{ $t('Total Payment') }}</th>
                                                <th class="fw-bolder align-top">{{ $t('Ending Balance') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="data in years_data" v-if="data.for == year">
                                                <td>{{data.selected_month}}</td>
                                                <td>{{data.main_ammount}}</td>
                                                <td>{{data.periodic_payment}}</td>
                                                <td>{{data.interest_per_data}}</td>
                                                <td>{{data.total_payable_ammount}}</td>
                                                <td>{{data.ending_balance}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="loading" v-if="loader">
      <div class="loader"></div>
    </div>
  </div> 
  </div>
  
  
</template>

<script>
  import Debt from "../../apis/Debt"  

  export default {
    name: 'DebtFinancingWithPikView',
    data() {
      return {
        loader: false, 
        paymentFrequency: 'yearly', 
        years: [],
        years_data: [],
        table_dynamic_header: 'Year',
        special_payments_data: [],
        pikOptions:[],
        pikOptionsTitle:[],
        userRole: localStorage.user_role,
        paymentData:{
            paymentYear: 1,
            paymentMonth: 0,            
            selectedBank:null,
            selectedLoanType: null,
            selectedLoanLabel: null,
            firstDebtRepaymentDate: null,
            interestPayDate: null,
            dateOfFirstInterestPayment: null,
            specialPayments: null,
            principalAmmount: null,
            interestRate: null,
            bulletLoanPayment: null,
            shareHolderLoanCheck: false,
        }       
      }
    },
    mounted() {
        if(this.$route.params.id){
            this.loader = true
            Debt.getDebtFinanceData(this.$route.params.id).then(res => {
                
                let finance_data = res.data.finance_data
                let payment_data = JSON.parse(finance_data.payment_data)
                
                if(payment_data != null){
                    this.paymentFrequency = finance_data.payment_frequency
                    this.paymentData.paymentYear = finance_data.finance_year
                    this.paymentData.paymentMonth = finance_data.finance_month
                    this.paymentData.selectedLoanLabel = finance_data.loan_type
                    this.paymentData.firstDebtRepaymentDate = finance_data.first_deb_repay_date
                    this.paymentData.interestPayDate = finance_data.interest_pay_date
                    this.paymentData.dateOfFirstInterestPayment = finance_data.date_of_first_interest_payment
                    this.paymentData.selectedBank = finance_data.bank.name
                    this.paymentData.principleAmmount = finance_data.principal_amount
                    this.paymentData.interestRate = finance_data.interest_rate                
                    this.paymentData.selectedLoanType = payment_data.selectedLoanType.value 
                    this.paymentData.shareHolderLoanCheck = finance_data.shareholder_loan_check
                    if(finance_data.pik_options_data != ''){
                        this.paymentData.pikOptions = JSON.parse(finance_data.pik_options_data)
                        var pikOptions = JSON.parse(finance_data.pik_options_data)
                        
                        // console.log(pikOptions)
                        var self = this
                        if(this.paymentFrequency == 'monthly'){
                            var years_arr = []
                            
                            pikOptions.forEach(function(ele) {
                                var data =  ele.split('-');
                                var month = data[0]
                                var year = data[1]
                                if(years_arr.indexOf(year) == -1){
                                    years_arr.push(year)                    
                                    self.pikOptionsTitle.push(year)
                                }  
                                self.pikOptions.push({
                                    for: year,
                                    data: month
                                })
                            })
                        }else if(this.paymentFrequency == 'quaterly'){
                            this.pikOptionsTitle.push(this.$t('Quaterly'))
                            pikOptions.forEach(function(ele) {                            
                                self.pikOptions.push({
                                    for: self.$t('Quaterly'),
                                    data: ele
                                })
                            })

                        }else if(this.paymentFrequency == 'semi-yearly'){
                            this.pikOptionsTitle.push(this.$t('Semi Yearly'))
                            pikOptions.forEach(function(ele) {
                                self.pikOptions.push({
                                    for: self.$t('Semi Yearly'),
                                    data: ele
                                })
                            })
                        }else{
                            this.pikOptionsTitle.push(this.$t('Yearly'))
                            pikOptions.forEach(function(ele) {
                                self.pikOptions.push({
                                    for: self.$t('Yearly'),
                                    data: ele
                                })
                            })
                        }

                    }

                    if(payment_data.specialPayment.length > 0 && payment_data.specialPayment[0].payment != null && payment_data.specialPayment[0].date != null){
                        this.paymentData.specialPayments = payment_data.specialPayment
                    }else{
                        this.paymentData.specialPayments = ''
                    }

                    if(finance_data.bullet_loan_payment != null){
                        this.paymentData.bulletLoanPayment = finance_data.bullet_loan_payment
                    }else{
                        this.paymentData.bulletLoanPayment = 0
                    }
                    

                    
                    this.showTableData(this.paymentFrequency, this.paymentData)
                }else{
                    this.$router.push({ name: "DebtList"})  
                }
                this.loader = false
            }).catch(error=> {
                this.$router.push({ name: "DebtList"})
                this.loader = false
            })
        }else{
            this.$router.push({ name: "DebtFinancingView"})
        }   
    },
    methods: {
        async showTableData(freq, payment_data){

            let loan_type = payment_data.selectedLoanType
            let calc_type = payment_data.calculationType
            let year = payment_data.paymentYear
            let month = payment_data.paymentMonth
            let principal_ammount = payment_data.principleAmmount
            let interest_rate = payment_data.interestRate / 100
            let interest_rate_without_percent = payment_data.interestRate
            let first_repay_date = payment_data.firstDebtRepaymentDate
            let special_payments = payment_data.specialPayments
            let bullet_payment_data = payment_data.bulletLoanPayment
            let pikOptions = payment_data.pikOptions

            var interest_per_data = '' 
            const months_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']   
            var years_arr = []

            //days in month
            var getDaysInMonth = function(month,year) {
                return new Date(year, month, 0).getDate()
            };

            //days in year
            var getDaysOfYear = function(year) 
            {                        
                return isLeapYear(year) ? 366 : 365
            }
            
            //isLeapYear
            var isLeapYear = function(year) {
                return year % 400 === 0 || (year % 100 !== 0 && year % 4 === 0)
            }
            //Global Values
            var main_principal_ammount = parseFloat(principal_ammount)
            var  global_simple_interest_rate_per_month =  ( (parseFloat(interest_rate_without_percent)/12)/100 )
            var total_number_of_months = (parseInt(year)*12) + parseInt(month)   
            if(loan_type == 'amortizing-loan'){
                //amortizing Loan
                if(freq == 'monthly'){
                    this.table_dynamic_header = 'Month'
                                     
                    var total_year_months_arr = []
                    for( var i = 0; i < total_number_of_months; i++){
                        var repay_date = new Date(first_repay_date)
                        repay_date.setMonth(repay_date.getMonth() + i) 
                        total_year_months_arr.push({
                            year: repay_date.getFullYear(),
                            month: repay_date.getMonth()+1
                        })
                    }

                 
                    var self = this
                    var special_payment_months_arr = []

                    var in_count = 0

                    total_year_months_arr.forEach(function(ele) {
                        
                        if(years_arr.indexOf(ele.year) == -1){
                            years_arr.push(ele.year)                    
                            self.years.push(self.$t('Year')+' '+ele.year)
                        } 

                        var final_selected_month = months_arr[ele.month - 1]   

                        var pikOptionData = final_selected_month+'-'+ele.year
                        
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 

                        var total_payment_calc_1 = parseFloat(parseFloat(global_simple_interest_rate_per_month) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(global_simple_interest_rate_per_month)) , parseInt('-'+total_number_of_months) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))   

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(global_simple_interest_rate_per_month))

                        var data_for_year = self.$t('Year')+' '+ele.year                                   
                         

                        var final_interest_per_data = parseFloat(interest_per_data).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        var final_total_payable_ammount = parseFloat(total_payable_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        var periodic_payment = parseFloat(total_payable_ammount) - parseFloat(interest_per_data)   
                        var main_ele = ele
                          
                        var final_periodic_ammount  = parseFloat(periodic_payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        
                        // console.log(special_payments)
                        if(special_payments != '' || special_payments.length > 0){
                            var payment = 0
                            special_payments.forEach(function(ele) {
                                var special_payment_date = new Date(ele.date)
                                var special_payment_month = special_payment_date.getMonth()+1
                                var special_payment_year = special_payment_date.getFullYear()
                                
                                if(special_payment_month == main_ele.month && special_payment_year == main_ele.year){
                                    self.years_data.push(
                                        {
                                            special_payment: true,
                                            for : data_for_year,
                                            selected_month : months_arr[special_payment_month - 1],
                                            main_ammount :parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),
                                            periodic_payment : ele.payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})+' (Special Payment)',
                                            interest_per_data : '-',
                                            total_payable_ammount : '-',
                                            ending_balance : parseFloat(principal_ammount - ele.payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),

                                        }
                                    )
                                    principal_ammount = principal_ammount - ele.payment
                                }
                            })
                        }
                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        
                        var pikOptionData = final_selected_month+'-'+ele.year
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }


                        var final_ending_balance = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

  
                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            self.years_data.push(
                                {
                                    for : data_for_year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_ammount,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                        
                    })
                }else if(freq == 'quaterly'){
                    var amortizing_interest_rate_per_quarter = global_simple_interest_rate_per_month * 3
                    this.table_dynamic_header = 'Quater'
                     if( parseInt(month) > 0 && parseInt(month) <= 3){
                        var total_number_of_quarters = (parseInt(year) * 4)+1

                        if(parseInt(month) == 3){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+1
                        }else{
                             var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+'.'+month)
                        }
                         
                    }else if(parseInt(month) <= 6 && parseInt(month) > 3){
                        var total_number_of_quarters = (parseInt(year) * 4)+2

                        if(parseInt(month) == 6){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+2
                        }else{
                            var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+1+'.'+(month - 3))
                        }
                    }else if(parseInt(month) <= 9 && parseInt(month) > 6){
                        var total_number_of_quarters = (parseInt(year) * 4)+3

                        if(parseInt(month) == 9){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+3
                        }else{
                            var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+2+'.'+(month - 6))
                        }

                    }else if(parseInt(month) <= 12 && parseInt(month) > 9){
                        var total_number_of_quarters = (parseInt(year) * 4)+4

                        if(parseInt(month) == 9){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+4
                        }else{
                            var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+3+'.'+(month - 9))
                        }
                    }else{
                        var total_number_of_quarters = (parseInt(year) * 4)
                        var  total_number_of_quater_for_calc = (parseInt(year) * 4)
                    }   
                    
                    
                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))

                    var repay_date = new Date(first_repay_date)
                    var final_data = []
                    var in_count = 0
                    for( var i = 0; i < total_number_of_quarters; i++){
                        if(i == 0){
                            repay_date.setMonth(repay_date.getMonth() + 0) 
                        }else{
                            repay_date.setMonth(repay_date.getMonth() + 3) 
                        }
                     
                        var select_date_key_1 = new Date(repay_date)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+2)

                        var selected_month =  months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+  select_date_key_2.getFullYear() 

                        var for_year = select_date_key_2.getFullYear(); 
                        if(years_arr.indexOf(for_year) == -1){
                            years_arr.push(for_year)                    
                            this.years.push(this.$t('Year')+' '+for_year);
                        } 

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(amortizing_interest_rate_per_quarter))
                                            
                        var final_selected_month = selected_month                      
                          
                        var pikOptionData = final_selected_month
                        
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 

                        var total_payment_calc_1 = parseFloat(parseFloat(amortizing_interest_rate_per_quarter) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(amortizing_interest_rate_per_quarter)) , parseFloat('-'+total_number_of_quater_for_calc) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))   
                            
                        

                        var data_for_year = repay_date.getFullYear()    

                        var final_periodic_ammount  = parseFloat(periodic_payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var self = this
                        
                        if(special_payments != '' || special_payments.length > 0){
                            var payment = 0
                            special_payments.forEach(function(ele) {
                               
                                var special_payment_date = new Date(ele.date)
                                var special_payment_month =  special_payment_date.getMonth()
                                
                                var special_payment_year = special_payment_date.getFullYear()
                                
                                if(special_payment_month >= select_date_key_1.getMonth() && special_payment_month <= select_date_key_2.getMonth() && special_payment_year == data_for_year){
                                    
                                    self.years_data.push(
                                        {
                                            special_payment: true,
                                            for : this.$t('Year')+' '+for_year,
                                            selected_month : final_selected_month,
                                            main_ammount :parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),
                                            periodic_payment : ele.payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})+' (Special Payment)',
                                            interest_per_data : '-',
                                            total_payable_ammount : '-',
                                            ending_balance : parseFloat(principal_ammount - ele.payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),

                                        }
                                    )
                                    principal_ammount = principal_ammount - ele.payment
                                }
                            })
                        }

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})   
                    
                        var periodic_payment = parseFloat(total_payable_ammount) - parseFloat(interest_per_data)  

                        var final_periodic_ammount  = parseFloat(periodic_payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        var final_total_payable_ammount = parseFloat(total_payable_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})             

                        var final_interest_per_data = parseFloat(interest_per_data).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }
                        
                     

                        var final_ending_balance = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Year')+' '+for_year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_ammount,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                    }
                }else if(freq == 'semi-yearly'){
                    var amortizing_interest_rate_per_half_year = global_simple_interest_rate_per_month * 6            
                    
                    this.table_dynamic_header = 'Half Yearly'
                    if( parseInt(month) > 6){
                        var total_number_of_half_years = (parseInt(year) * 2)+2
                        
                        if(parseInt(month) < 12){
                            var total_number_of_half_years_for_calc = parseFloat((parseInt(year) * 2)+1+'.'+(month-6))
                        }

                    }else if(parseInt(month) <= 6 && parseInt(month) > 0){
                        var total_number_of_half_years = (parseInt(year) * 2)+1
                        
                        if( parseInt(month) == 6){
                            var total_number_of_half_years_for_calc = (parseInt(year) * 2)+1
                        }else{
                            var total_number_of_half_years_for_calc = parseFloat((parseInt(year) * 2)+'.'+month)
                        }
                        
                    }else{
                        var total_number_of_half_years = (parseInt(year) * 2)
                        var total_number_of_half_years_for_calc = (parseInt(year) * 2)
                    }


                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))

                    var repay_date = new Date(first_repay_date)
                   
                    var in_count = 0
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

                        var for_year = select_date_key_2.getFullYear(); 
                        if(years_arr.indexOf(for_year) == -1){
                            years_arr.push(for_year)                    
                            this.years.push(this.$t('Year')+' '+for_year);
                        } 

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(amortizing_interest_rate_per_half_year))

                        var final_selected_month = selected_month

                        var pikOptionData = final_selected_month

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 


                        var total_payment_calc_1 = parseFloat(parseFloat(amortizing_interest_rate_per_half_year) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(amortizing_interest_rate_per_half_year)) , parseFloat('-'+total_number_of_half_years_for_calc) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))   

                    
                        var data_for_year = repay_date.getFullYear()     
                        var self = this

                        if(special_payments != '' || special_payments.length > 0){
                            var payment = 0
                            special_payments.forEach(function(ele) {
                                var special_payment_date = new Date(ele.date)
                                
                                var special_payment_month = special_payment_date.getMonth()
                                
                                var special_payment_year = special_payment_date.getFullYear()
                                
                                if(special_payment_month >= select_date_key_1.getMonth() && special_payment_month <= select_date_key_2.getMonth() && special_payment_year == data_for_year){
                                    self.years_data.push(
                                        {
                                            special_payment: true,
                                            for : this.$t('Year')+' '+for_year,
                                            selected_month : final_selected_month,
                                            main_ammount :parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),
                                            periodic_payment : ele.payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})+' (Special Payment)',
                                            interest_per_data : '-',
                                            total_payable_ammount : '-',
                                            ending_balance : parseFloat(principal_ammount - ele.payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),

                                        }
                                    )
                                    principal_ammount = principal_ammount - ele.payment
                                }
                            })
                        }     
                                 
                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})   

                        var final_interest_per_data = parseFloat(interest_per_data).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})


                        var final_total_payable_ammount = parseFloat(total_payable_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                    
                        var periodic_payment = parseFloat(total_payable_ammount) - parseFloat(interest_per_data) 

                        var final_periodic_ammount  = parseFloat(periodic_payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }                     

                        var final_ending_balance = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Year')+' '+for_year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_ammount,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                    }
                   

                }else{    
                    var amortizing_interest_rate_per_year = global_simple_interest_rate_per_month * 12
                    this.table_dynamic_header = 'Year'                
                    var total_number_of_years = year
                    var total_number_of_years_for_calc = year
                    if(month > 0){
                        ++total_number_of_years
                        var total_number_of_years_for_calc = parseFloat(parseInt(year)+'.'+month)
                    }
                    
                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))
                    this.years.push(this.$t('Yearly'))
                    for( var i = 0; i < total_number_of_years; i++){

                        var repay_year = new Date(first_repay_date)
                        repay_year.setFullYear(repay_year.getFullYear() + i) 
                        
                        var data_for_year = repay_year.getFullYear()          

                        var select_date_key_1 = new Date(repay_year)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+11)

                        var final_selected_year = months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+select_date_key_2.getFullYear() 

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(amortizing_interest_rate_per_year))
                        
                        var pikOptionData = final_selected_year

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        }     
                        var total_payment_calc_1 = parseFloat(parseFloat(amortizing_interest_rate_per_year) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(amortizing_interest_rate_per_year)) , parseFloat('-'+total_number_of_years_for_calc) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))    

                        var self = this

                        if(special_payments != '' || special_payments.length > 0){
                            var payment = 0
                            special_payments.forEach(function(ele) {
                                var special_payment_date = new Date(ele.date)
                                var special_payment_year = special_payment_date.getFullYear()
                                
                                if(special_payment_year == data_for_year){
                                    self.years_data.push(
                                        {
                                            special_payment: true,
                                            for : this.$t('Yearly'),
                                            selected_month : final_selected_year,
                                            main_ammount :parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),
                                            periodic_payment : ele.payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})+' (Special Payment)',
                                            interest_per_data : '-',
                                            total_payable_ammount : '-',
                                            ending_balance : parseFloat(principal_ammount - ele.payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2}),

                                        }
                                    )
                                    principal_ammount = principal_ammount - ele.payment
                                }
                            })
                        }    


                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})   


                        var final_interest_per_data = parseFloat(interest_per_data).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        var final_total_payable_ammount = parseFloat(total_payable_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        var periodic_payment = parseFloat(total_payable_ammount) - parseFloat(interest_per_data)    

                        var final_periodic_ammount  = parseFloat(periodic_payment).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
        
                        
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }         

                        var final_ending_balance = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                         if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Yearly'),
                                    selected_month : final_selected_year,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_ammount,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }  
                    }
                    
                }
            }else if(loan_type == 'annuity-loan'){
                 //annuity Loan
               
                
                if(freq == 'monthly'){
                    this.table_dynamic_header = 'Month'
                    var total_year_months_arr = []
                    for( var i = 0; i < total_number_of_months; i++){
                        var repay_date = new Date(first_repay_date)
                        repay_date.setMonth(repay_date.getMonth() + i) 
                        total_year_months_arr.push({
                            year: repay_date.getFullYear(),
                            month: repay_date.getMonth()+1
                        })
                    }
                    var self = this
                   
                      
                    var in_count = 0
                    var first_count = 0
                    total_year_months_arr.forEach(function(ele) {

                        if(years_arr.indexOf(ele.year) == -1){
                           years_arr.push(ele.year)                    
                           self.years.push(self.$t('Year')+' '+ele.year)
                        }        

                        var final_selected_month = months_arr[ele.month - 1]     

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        
                        var pikOptionData = final_selected_month+'-'+ele.year

                         
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 


                        var total_payment_calc_1 = parseFloat(parseFloat(global_simple_interest_rate_per_month) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(global_simple_interest_rate_per_month)) , parseInt('-'+total_number_of_months) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))
                        
                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(global_simple_interest_rate_per_month))

                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }
                        
                        var ending_balance = parseFloat(principal_ammount)

                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            self.years_data.push(
                                {
                                    for : self.$t('Year')+' '+ele.year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                        
                    })
                   
                }else if(freq == 'quaterly'){
                    var annuity_interest_rate_per_quarter = global_simple_interest_rate_per_month * 3
                    this.table_dynamic_header = 'Quater'

                    if( parseInt(month) > 0 && parseInt(month) <= 3){
                        var total_number_quarter_for_periodic_val = (parseInt(year) * 4)+1

                        if(parseInt(month) == 3){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+1
                        }else{
                             var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+'.'+month)
                        }
                         
                    }else if(parseInt(month) <= 6 && parseInt(month) > 3){
                        var total_number_quarter_for_periodic_val = (parseInt(year) * 4)+2

                        if(parseInt(month) == 6){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+2
                        }else{
                            var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+1+'.'+(month - 3))
                        }
                    }else if(parseInt(month) <= 9 && parseInt(month) > 6){
                        var total_number_quarter_for_periodic_val = (parseInt(year) * 4)+3

                        if(parseInt(month) == 9){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+3
                        }else{
                            var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+2+'.'+(month - 6))
                        }

                    }else if(parseInt(month) <= 12 && parseInt(month) > 9){
                        var total_number_quarter_for_periodic_val = (parseInt(year) * 4)+4

                        if(parseInt(month) == 9){
                            var total_number_of_quater_for_calc = (parseInt(year) * 4)+4
                        }else{
                            var total_number_of_quater_for_calc = parseFloat((parseInt(year) * 4)+3+'.'+(month - 9))
                        }
                    }else{
                        var total_number_quarter_for_periodic_val  = (parseInt(year) * 4)
                        var total_number_of_quater_for_calc = (parseInt(year) * 4)
                    }    

                    // console.log(total_number_of_quater_for_calc)  
                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))
                    var in_count = 0
                    var repay_date = new Date(first_repay_date)
                    var final_data = []
                    for( var i = 0; i < total_number_quarter_for_periodic_val; i++){
                        if(i == 0){
                            repay_date.setMonth(repay_date.getMonth() + 0) 
                        }else{
                            repay_date.setMonth(repay_date.getMonth() + 3) 
                        }
                        var select_date_key_1 = new Date(repay_date)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+2)

                        var selected_month =  months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+  select_date_key_2.getFullYear() 

                        var for_year = select_date_key_2.getFullYear(); 
                        if(years_arr.indexOf(for_year) == -1){
                            years_arr.push(for_year)                    
                            this.years.push(this.$t('Year')+' '+for_year);
                        } 
              
                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(annuity_interest_rate_per_quarter))

                        var final_selected_month = selected_month

                        var pikOptionData = final_selected_month

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 

                        var total_payment_calc_1 = parseFloat(parseFloat(annuity_interest_rate_per_quarter) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(annuity_interest_rate_per_quarter)) , parseFloat('-'+total_number_of_quater_for_calc) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))    

                        var data_for_year = repay_date.getFullYear()  
                       
                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }
                        

                        // principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                        
                        var ending_balance = parseFloat(principal_ammount)

                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Year')+' '+for_year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                    }
                }else if(freq == 'semi-yearly'){
                    this.table_dynamic_header = 'Half Yearly'
                    var annuity_interest_rate_per_half_yearly = global_simple_interest_rate_per_month * 6
                    if( parseInt(month) > 6){
                        var total_number_year_for_periodic_val = (parseInt(year) * 2)+2

                        if(parseInt(month) < 12){
                            var total_number_of_half_yearly_for_calc = parseFloat((parseInt(year) * 2)+1+'.'+(month-6))
                        }

                    }else if(parseInt(month) <= 6 && parseInt(month) > 0){
                        var total_number_year_for_periodic_val = (parseInt(year) * 2)+1
                        
                        if( parseInt(month) == 6){
                            var total_number_of_half_yearly_for_calc = (parseInt(year) * 2)+1
                        }else{
                            var total_number_of_half_yearly_for_calc = parseFloat((parseInt(year) * 2)+'.'+month)
                        }
                        
                    }else{
                        var total_number_year_for_periodic_val = (parseInt(year) * 2)
                        var total_number_of_half_yearly_for_calc = (parseInt(year) * 2)
                    }
                    
                    
                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))

                    var repay_date = new Date(first_repay_date)
                    var in_count = 0
                    for( var i = 0; i < total_number_year_for_periodic_val; i++){
                        
                        if(i == 0){
                            repay_date.setMonth(repay_date.getMonth() + 0) 
                        }else{
                            repay_date.setMonth(repay_date.getMonth() + 6) 
                        }
                        var select_date_key_1 = new Date(repay_date)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+5)

                        var selected_month =  months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+  select_date_key_2.getFullYear() 
                        
                        var for_year = select_date_key_2.getFullYear(); 
                        if(years_arr.indexOf(for_year) == -1){
                            years_arr.push(for_year)                    
                            this.years.push(this.$t('Year')+' '+for_year);
                        } 

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(annuity_interest_rate_per_half_yearly))

                        var final_selected_month = selected_month

                        var pikOptionData = final_selected_month

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 

                        var total_payment_calc_1 = parseFloat(parseFloat(annuity_interest_rate_per_half_yearly) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(annuity_interest_rate_per_half_yearly)) , parseFloat('-'+total_number_of_half_yearly_for_calc) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))   
                        
                        var data_for_year = repay_date.getFullYear()     

                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }

                        var ending_balance = parseFloat(principal_ammount)

                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Year')+' '+for_year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                    }
                   

                }else{    
                    this.table_dynamic_header = 'Year'                
                    var total_number_of_years = year
                    var total_number_of_years_for_calc = year
                    if(month > 0){
                        ++total_number_of_years
                        var total_number_of_years_for_calc = parseFloat(parseInt(year)+'.'+month)
                    }
                    var annuity_interest_rate_per_year = global_simple_interest_rate_per_month * 12
                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))
                        //  console.log(total_number_of_years)
                   
                    this.years.push(this.$t('Yearly'))
                    var in_count = 0
                    for( var i = 0; i < total_number_of_years; i++){
                       
                        var repay_year = new Date(first_repay_date)
                        repay_year.setFullYear(repay_year.getFullYear() + i) 
                        
                        var data_for_year = repay_year.getFullYear()    

                        var select_date_key_1 = new Date(repay_year)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+11)

                        var final_selected_year = months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+select_date_key_2.getFullYear() 

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(annuity_interest_rate_per_year))

                        var pikOptionData = final_selected_year

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 

                        var total_payment_calc_1 = parseFloat(parseFloat(annuity_interest_rate_per_year) * parseFloat(main_principal_ammount)) 
                        var total_payment_calc_2 = parseFloat(1 - Math.pow( (1 + parseFloat(annuity_interest_rate_per_year)) , parseFloat('-'+total_number_of_years_for_calc) ) ) 
                        var total_payable_ammount = parseFloat(parseFloat(total_payment_calc_1) / parseFloat(total_payment_calc_2))  
                        

                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }

                        var ending_balance = parseFloat(principal_ammount)


                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})


                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Yearly'),
                                    selected_month : final_selected_year,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                        
                    }
                    
                }
            }else if(loan_type == 'bullet-loan'){


                // bullet_loan_calculation
                var calc_bullet_loan_total_payment = function (interest,num_of_payments,pv,fv = 0.00, Type = 0){
                    var xp = Math.pow((1+interest),num_of_payments)
                    var calc_fst = ( parseFloat(pv) * parseFloat(interest) * parseFloat(xp) / (parseFloat(xp)-1)-parseFloat(interest)/parseFloat(parseFloat(xp)-1) * parseFloat(fv))
                    var calc_scnd = (Type == 0 ? 1 : 1/(parseFloat(interest)+1))
                    return parseFloat(calc_fst) * parseFloat(calc_scnd)
                }
                //Bullet Loan
                if(freq == 'monthly'){
                    this.table_dynamic_header = 'Month'
                    var total_year_months_arr = []
                    for( var i = 0; i < total_number_of_months; i++){
                        var repay_date = new Date(first_repay_date)
                        repay_date.setMonth(repay_date.getMonth() + i) 
                        total_year_months_arr.push({
                            year: repay_date.getFullYear(),
                            month: repay_date.getMonth()+1
                        })
                    }
                    var self = this
                    var main_principal_ammount = parseFloat(principal_ammount)

                    total_year_months_arr.forEach(function(ele) {
                        if(years_arr.indexOf(ele.year) == -1){
                           years_arr.push(ele.year)                    
                           self.years.push(self.$t('Year')+' '+ele.year)
                        }       
                        var final_selected_month = months_arr[ele.month - 1]   

                        var pikOptionData = final_selected_month+'-'+ele.year
                        
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 

                        var total_payable_ammount =  calc_bullet_loan_total_payment(global_simple_interest_rate_per_month, total_number_of_months, main_principal_ammount, bullet_payment_data)
                                                        
                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(global_simple_interest_rate_per_month))
                        
                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                       
                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }

                        if(parseFloat(principal_ammount) <= 0 ){
                            principal_ammount = parseFloat(0)
                        }

                        var ending_balance = parseFloat(principal_ammount)

                        
                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            self.years_data.push(
                                {
                                    for : self.$t('Year')+' '+ele.year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                        
                    })
                   
                }else if(freq == 'quaterly'){

                    var bullet_interest_rate_per_quarter = global_simple_interest_rate_per_month * 3
                    this.table_dynamic_header = 'Quater'
                    if( parseInt(month) > 0 && parseInt(month) <= 3){
                        var total_number_of_quarters = (parseInt(year) * 4)+1
                    }else if(parseInt(month) <= 6 && parseInt(month) > 3){
                        var total_number_of_quarters = (parseInt(year) * 4)+2
                    }else if(parseInt(month) <= 9 && parseInt(month) > 6){
                        var total_number_of_quarters = (parseInt(year) * 4)+3
                    }else if(parseInt(month) <= 12 && parseInt(month) > 9){
                        var total_number_of_quarters = (parseInt(year) * 4)+4
                    }else{
                        var total_number_of_quarters = (parseInt(year) * 4)
                    }

                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))

                    var repay_date = new Date(first_repay_date)
                    var final_data = []

                    for( var i = 0; i < total_number_of_quarters; i++){
                        if(i == 0){
                            repay_date.setMonth(repay_date.getMonth() + 0) 
                        }else{
                            repay_date.setMonth(repay_date.getMonth() + 3) 
                        }
                                             
                        var select_date_key_1 = new Date(repay_date)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+2)

                        var selected_month =  months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+  select_date_key_2.getFullYear() 

                        var for_year = select_date_key_2.getFullYear(); 
                        if(years_arr.indexOf(for_year) == -1){
                            years_arr.push(for_year)                    
                            this.years.push(this.$t('Year')+' '+for_year);
                        } 

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(bullet_interest_rate_per_quarter))

                        if( repay_date.getFullYear() == last_date.getFullYear() && month > 0 && month <= 3 && repay_date.getMonth() >= 0 && repay_date.getMonth() < 3){
                            bullet_interest_rate_per_quarter = global_simple_interest_rate_per_month * last_date.getMonth()
                        }else if(repay_date.getFullYear() == last_date.getFullYear() && month > 3 && month <= 6 && repay_date.getMonth() >= 3 && repay_date.getMonth() < 6){
                            bullet_interest_rate_per_quarter = global_simple_interest_rate_per_month * (last_date.getMonth() - 3)
                        }else if(repay_date.getFullYear() == last_date.getFullYear() && month > 6 && month <= 9 && repay_date.getMonth() >= 6 && repay_date.getMonth() < 9){
                            bullet_interest_rate_per_quarter = global_simple_interest_rate_per_month * (last_date.getMonth() - 6)
                        }else if(repay_date.getFullYear() == last_date.getFullYear() && month > 9 && month <= 12 && repay_date.getMonth() >= 9){
                            bullet_interest_rate_per_quarter = global_simple_interest_rate_per_month * (last_date.getMonth() - 9)
                        }

                        // console.log(bullet_interest_rate_per_quarter)

                        var final_selected_month = selected_month

                        var pikOptionData = final_selected_month

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 

                        var total_payable_ammount =  calc_bullet_loan_total_payment(bullet_interest_rate_per_quarter, total_number_of_quarters, main_principal_ammount, bullet_payment_data)

                        

                        var data_for_year = repay_date.getFullYear()        

                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }
                        

                        var ending_balance = parseFloat(principal_ammount)


                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                     for : this.$t('Year')+' '+for_year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                    }
                }else if(freq == 'semi-yearly'){
                    this.table_dynamic_header = 'Half Yearly'
                    var bullet_interest_rate_per_half_year = global_simple_interest_rate_per_month * 6            
                    if( parseInt(month) > 6){
                        var total_number_year_for_periodic_val = (parseInt(year) * 2)+2
                    }else if(parseInt(month) <= 6 && parseInt(month) > 0){
                        var total_number_year_for_periodic_val = (parseInt(year) * 2)+1
                    }else{
                        var total_number_year_for_periodic_val = (parseInt(year) * 2)
                    }
                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))
                    var periodic_payment = parseFloat((principal_ammount/total_number_year_for_periodic_val))

                    var repay_date = new Date(first_repay_date)
                    for( var i = 0; i < total_number_year_for_periodic_val; i++){
                        if(i == 0){
                            repay_date.setMonth(repay_date.getMonth() + 0) 
                        }else{
                            repay_date.setMonth(repay_date.getMonth() + 6) 
                        }
                        // console.log(repay_date.getMonth())

                        var select_date_key_1 = new Date(repay_date)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+5)

                        var selected_month =  months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+  select_date_key_2.getFullYear() 

                        var for_year = select_date_key_2.getFullYear(); 
                        if(years_arr.indexOf(for_year) == -1){
                            years_arr.push(for_year)                    
                            this.years.push(this.$t('Year')+' '+for_year);
                        } 

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(bullet_interest_rate_per_half_year))

                        if(repay_date.getFullYear() == last_date.getFullYear() && month > 0 && month <= 6 && repay_date.getMonth() >= 0  && repay_date.getMonth() < 6){
                            bullet_interest_rate_per_half_year = global_simple_interest_rate_per_month * month
                        }else if(repay_date.getFullYear() == last_date.getFullYear() && month > 6 && repay_date.getMonth() >= 6){
                            bullet_interest_rate_per_half_year = global_simple_interest_rate_per_month * ( month - 6 )
                        }
                        var data_for_year = repay_date.getFullYear()  

                        var final_selected_month = selected_month

                        var pikOptionData = final_selected_month

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        } 


                        var total_payable_ammount =  calc_bullet_loan_total_payment(bullet_interest_rate_per_half_year, total_number_year_for_periodic_val, main_principal_ammount, bullet_payment_data)

                       

                        var data_for_year = repay_date.getFullYear()                        
                        var final_selected_month = selected_month   

                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }

                        var ending_balance = parseFloat(principal_ammount)


                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Year')+' '+for_year,
                                    selected_month : final_selected_month,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                    //    console.log(repay_date.getMonth())
                    }
                   

                }else{    
                    this.table_dynamic_header = 'Year'  
                    var bullet_interest_rate_per_year = global_simple_interest_rate_per_month * 12           
                    var total_number_of_years = year
                    if(month > 0){
                        ++total_number_of_years
                    }
                    var periodic_payment = parseFloat((principal_ammount/total_number_of_years)) 
                    
                    var last_date = new Date(first_repay_date)
                    last_date.setMonth(last_date.getMonth() + ((parseInt(year)*12) +  parseInt(month)))
                      this.years.push(this.$t('Yearly'))
                    
                    for( var i = 0; i < total_number_of_years; i++){
                        var repay_year = new Date(first_repay_date)
                        repay_year.setFullYear(repay_year.getFullYear() + i) 
                        
                        var data_for_year = repay_year.getFullYear()       
                        
                        var select_date_key_1 = new Date(repay_year)
                        var select_date_key_2 = new Date(select_date_key_1)
                        select_date_key_2.setMonth(select_date_key_2.getMonth()+11)

                        var final_selected_year = months_arr[select_date_key_1.getMonth()]+' '+select_date_key_1.getFullYear()+' - '+months_arr[select_date_key_2.getMonth()]+' '+select_date_key_2.getFullYear() 

                        var pikOptionData = final_selected_year

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            
                        }else{
                            main_principal_ammount = principal_ammount
                        }    

                        interest_per_data = parseFloat(parseFloat(principal_ammount) * parseFloat(bullet_interest_rate_per_year))

                        if(repay_year.getFullYear() == last_date.getFullYear() && month > 0  && repay_year.getMonth() >= 0){
                            bullet_interest_rate_per_year = global_simple_interest_rate_per_month * month
                        }   
                        var total_payable_ammount =  calc_bullet_loan_total_payment(bullet_interest_rate_per_year, total_number_of_years, main_principal_ammount, bullet_payment_data)


                        var periodic_payment = parseFloat(parseFloat(total_payable_ammount) - parseFloat(interest_per_data))

                        var previous_principal_ammount = parseFloat(principal_ammount).toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(pikOptions.indexOf(pikOptionData) != -1){
                            principal_ammount = parseFloat(principal_ammount) - parseFloat(periodic_payment)
                            if(in_count == 0){
                                main_principal_ammount = principal_ammount
                            }
                            in_count++
                            
                        }else{
                            in_count = 0
                            principal_ammount = parseFloat(principal_ammount) + parseFloat(interest_per_data)
                            main_principal_ammount = principal_ammount
                        }

                        var ending_balance = parseFloat(principal_ammount)



                        var final_periodic_payment = periodic_payment.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_interest_per_data = interest_per_data.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_total_payable_ammount = total_payable_ammount.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})
                        var final_ending_balance = ending_balance.toLocaleString('de-DE', {minimumFractionDigits:2, maximumFractionDigits:2})

                        if(principal_ammount >= 0 || final_ending_balance.toString() == '-0,00'){

                            if(final_ending_balance.toString() == '-0,00'){
                                final_ending_balance = '0,00'
                            }
                            this.years_data.push(
                                {
                                    for : this.$t('Yearly'),
                                    selected_month : final_selected_year,
                                    main_ammount : previous_principal_ammount,
                                    periodic_payment : final_periodic_payment,
                                    interest_per_data : final_interest_per_data,
                                    total_payable_ammount : final_total_payable_ammount,
                                    ending_balance : final_ending_balance,

                                }
                            )
                        }
                        
                    }
                    
                }
            }
           
        }
    }   
  }
</script>
