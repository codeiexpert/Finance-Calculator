import Vue from "vue";
import App from "./App.vue";
import router from "./routes";

//Pagination
Vue.component('pagination', require('laravel-vue-pagination'));

//Alert Toast
import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"
const Options = {timeout: 5000, draggable: false};
Vue.use(Toast, Options)

//Tooltip
import VTooltip from 'v-tooltip'
Vue.use(VTooltip)

//Language
import VueInternationalization from 'vue-i18n'
Vue.use(VueInternationalization);

import VueNumeric from 'vue-numeric'
Vue.use(VueNumeric);

const i18n = new VueInternationalization({
    locale: 'en',
    messages: loadLocaleMessages()
});

import moment from 'moment'
Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD MMM, YYYY')
  }
})

Vue.filter('newFormatDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD.MM.YYYY')
  }
})

//number format
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0");
});

Vue.filter('reverse', function(value) {
  return value.slice().reverse();
});

//select
import vSelect from "vue-select"
Vue.component("v-select", vSelect)


//verticalScroll
import VueDragscroll from 'vue-dragscroll'
Vue.use(VueDragscroll)
Vue.component('dragscroll', VueDragscroll)

//ConfirmBox
import VueConfirmDialog from 'vue-confirm-dialog'
Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

//Vue-Numeric-Input
import VueNumericInput from 'vue-numeric-input';
Vue.use(VueNumericInput)
Vue.component('vue-numeric-input', VueNumericInput)

Vue.config.productionTip = false;

new Vue({
  router,
  i18n,
  render: h => h(App)
}).$mount("#app");

router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = to.meta.title || DEFAULT_TITLE;    
        var start = moment().subtract(89, 'days');
        var end = moment();   
        $("#kt_daterangepicker_1").daterangepicker({
            autoApply:true,
            startDate: start,
            endDate: end,
            showDropdowns: true,
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'Last 90 Days': [moment().subtract(89, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
         }, function(start, end, label) {
          $('#kt_daterangepicker_1').val( start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
        });
    });
    

});

function loadLocaleMessages () {
  const locales = require.context('./locales', true, /[A-Za-z0-9-_,\s]+\.json$/i)
  const messages = {}
  locales.keys().forEach(key => {
    const matched = key.match(/([A-Za-z0-9-_]+)\./i)
    if (matched && matched.length > 1) {
      const locale = matched[1]
      messages[locale] = locales(key)
    }
  })
  return messages
}
