import Vue from 'vue'
import ApiFetcher from '@/ApiFetcher'

Vue.config.productionTip = false

export default new Vue({
    render: h => h(ApiFetcher),
}).$mount('#app')