import Api from "./Api";
import Csrf from "./Csrf";

export default {

    async getBanks() {
        let token = localStorage.access_token;
        return Api.get("/banks", { headers: { "Authorization" : `Bearer ${token}`} });
    }, 
    
    async addBank(name) {
        let token = localStorage.access_token;
        return Api.post("/add-bank", {'bank_name':name}, { headers: { "Authorization" : `Bearer ${token}`} });
    }, 
    
    async saveFinanceData(payment_data) {
        let token = localStorage.access_token;
        return Api.post("/save-Finance-finance-data", payment_data, { headers: { "Authorization" : `Bearer ${token}`} });
    }, 

    async getFinanceData(id) {
        let token = localStorage.access_token;
        return Api.get("/get-Finance-finance-data/"+id, { headers: { "Authorization" : `Bearer ${token}`} });
    }, 

    async getFinanceList(id, page) {
        let token = localStorage.access_token;
        return Api.get("/get-Finance-finance-list?id="+id+"&page="+page, { headers: { "Authorization" : `Bearer ${token}`} });
    }, 

    async removeFinanceData(id) {
        let token = localStorage.access_token;
        return Api.get("/delete-Finance/"+id, { headers: { "Authorization" : `Bearer ${token}`} });
    }, 
};