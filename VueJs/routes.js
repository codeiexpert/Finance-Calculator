import Vue from "vue";
import VueRouter from "vue-router";

import PublicLayout from "./layouts/Public.vue";
import DashboardLayout from "./layouts/Dashboard.vue";

import Login from "./views/Login.vue";
import ForgotPassword from "./views/ForgotPassword.vue";
import ResetPassword from "./views/ResetPassword.vue";
import Profile from "./views/Profile.vue";

import UserManageList from "./views/userManage/List.vue";
import UserManageAdd from "./views/userManage/Add.vue";
import UserManageEdit from "./views/userManage/Edit.vue";

import FinanceAdd from "./views/Finance/Add.vue"; 
import FinanceWithoutPikView from "./views/Finance/WithoutPik.vue";
import FinanceWithPikView from "./views/Finance/Pik.vue";
import FinanceList from "./views/Finance/List.vue";  

import PageNotFound from "./views/PageNotFound.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: '/login',
    component: PublicLayout,
    children: [
      {
        path: '',
        component: Login,
        name: 'Login',
        meta: { title: 'Login | Finance calculator', guestOnly: true }
      }
    ],
  },
  {
    path: '/forgot-password',
    component: PublicLayout,
    children: [
      {
        path: '',
        component: ForgotPassword,
        name: 'ForgotPassword',
        meta: { title: 'Forgot Password | Finance calculator', guestOnly: true }
      }
    ],
  },
  {
    path: '/reset-password/:token/:id',
    component: PublicLayout,
    children: [
      {
        path: '',
        component: ResetPassword,
        name: 'ResetPassword',
        meta: { title: 'Reset Password | Finance calculator', guestOnly: true }
      }
    ],
  },
  {
    path: '/financing-screen',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: FinanceAdd,
        name: 'FinancingView',
        meta: { title: 'Financing Screen | Finance calculator', authOnly: true }
      }
    ],
  },
  {
    path: '/my-profile',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: Profile,
        name: 'Profile',
        meta: { title: 'My Profile | Finance calculator', authOnly: true }
      }
    ],
  },
  {
    path: '/finanance-list/:id?',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: FinanceList,
        name: 'Dashboard',
        meta: { title: 'Finance list | Finance calculator', authOnly: true }
      }
    ],
  },
  {
    path: '/payment/:id',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: FinanceWithoutPikView,
        name: 'FinancingWithoutPikView',
        meta: { title: 'Financing Periodic Payment and Interest View | Finance calculator', authOnly: true }
      }
    ],
  },
  {
    path: '/pik-view/:id?',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: FinanceWithPikView,
        name: 'FinancingWithPikView',
        meta: { title: 'Financing Pik View | demo', authOnly: true }
      }
    ],
  },  
  {
    path: '/user-management',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: UserManageList,
        name: 'UserManagement',
        meta: { title: 'User Management | demo', authOnly: true }
      }
    ],
  },
  {
    path: '/user-management/add',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: UserManageAdd,
        name: 'UserManagementAdd',
        meta: { title: 'Add User | demo', authOnly: true }
      }
    ],
  },
  {
    path: '/user-management/edit/:id',
    component: DashboardLayout,
    children: [
      {
        path: '',
        component: UserManageEdit,
        name: 'UserManagementEdit',
        meta: { title: 'Edit User | demo', authOnly: true }
      }
    ],
  },

  { path: "*", component: PageNotFound }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

function isLoggedIn() {
  return localStorage.getItem("auth");
}


router.beforeEach((to, from, next) => {
  
  if (to.matched.some(record => record.meta.authOnly)) {
    if (!isLoggedIn()) {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.guestOnly)) {
    if (isLoggedIn()) {
      next({
        path: '/user-management'
      });
      // next({
      //   path: "/",
      //   // query: { redirect: to.fullPath }
      // });
    }
    else {
      next();
    }
  } else {
    next();
  }
  
});

export default router;