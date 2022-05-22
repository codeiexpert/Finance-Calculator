import Api from "./Api";
import Csrf from "./Csrf";

export default {

  async index(page, sorting) {
    let token = localStorage.access_token;
    return Api.get("/users?page="+page+'&sorting_order='+sorting.order+'&sorting_column='+sorting.column, { headers: { "Authorization" : `Bearer ${token}`} });
  },

  async login(form) {
    await Csrf.getCookie();
    return Api.post("/login", form);
  },

  async logout(access_token) {
    await Csrf.getCookie();
    localStorage.removeItem("auth");
    localStorage.removeItem("access_token");
    localStorage.removeItem("user_name");
    localStorage.removeItem("user_email");
    localStorage.removeItem("user_role");
    localStorage.removeItem("user_profile");
    
    return Api.post("/logout");
  },

  async forgetPassword(form) {
    return Api.post("/reset-password", form);
  },

  async resetPassword(form) {
    return Api.post("/reset/password", form);
  },

  auth() {
    let token = localStorage.access_token;
    return Api.get("/user", { headers: { "Authorization" : `Bearer ${token}`} });
  },

  async updateUser(form) {
    let token = localStorage.access_token;
    return Api.post("/user", form, { headers: { "Authorization" : `Bearer ${token}`} });
  },

  async create(form) {
    let token = localStorage.access_token;
    return Api.post("/users", form, { headers: { "Authorization" : `Bearer ${token}`} });
  },

  async show(id) {
    let token = localStorage.access_token;
    return Api.get(`/users/${id}`, { headers: { "Authorization" : `Bearer ${token}`} });
  },

  async delete(id) {
    let token = localStorage.access_token;
    return Api.delete(`/users/${id}`, { headers: { "Authorization" : `Bearer ${token}`} });
  },

  async update(id, form) {
    let token = localStorage.access_token;
    return Api.put(`/users/${id}`, form, { headers: { "Authorization" : `Bearer ${token}`} });
  },  

  async uploadProfilePicture(avatar) {
    let token = localStorage.access_token;
    return Api.post(`/profile_upload`, avatar, { headers: { "Authorization" : `Bearer ${token}`} });
  },  

};
