<template>

  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <div id="kt_content_container" class="container-fluid">
        <div class="row filter-demo-div">
          <div class="col-md-12">

            <!-- ---- -->
            <div class="d-flex flex-stack">
              <div class="page-title d-flex align-items-center flex-wrap lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bolder m-0 fs-3">{{ $t('User Management')}}</h1>
              </div>


              <div class="d-flex align-items-center py-1">
                <div class="me-4">
                  <button class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" v-on:click="openModel">
                    <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <rect x="0" y="0" width="24" height="24"></rect>
                          <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"></path>
                        </g>
                      </svg>
                    </span>
                    {{ $t('Filter') }}
                  </button>
                </div>

                <div class="">
                  <router-link :to='{name:"UserManagementAdd"}' class="btn btn-sm btn-demo d-flex align-items-end">
                    <span class="svg-icon svg-icon-3 svg-icon-white">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                        <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                      </svg>
                    </span>
                    {{ $t('Add User') }}
                  </router-link>
                </div>

                <!-- sidebar toggle -->
                <div class="d-flex align-items-center d-lg-none ms-3 me-1" title="Show aside menu">
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
                <!-- sidebar toggle ends -->

              </div>

            </div>
            <!-- ---- -->

          </div>
        </div>
        <div class="row h-100">
          
          <div class="card p-0">
            <div class="card-body">
              <div class="w-100" v-show="openmodel">
                <div class="d-inline-block w-100 border border-secondary rounded p-6 mb-15">
                  <div class="fs-5 text-dark fw-bolder mb-4 d-flex align-items-center flex-stack">
                    {{ $t('Filter Options') }}
                    <span class="text-end" style="cursor:pointer;padding:2px;float:right;" v-on:click="closeModel">
                      <span class="svg-icon svg-icon-primary svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                              <rect x="0" y="7" width="16" height="2" rx="1"/>
                              <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                            </g>
                          </g>
                        </svg>
                      </span>
                    </span>
                  </div>
                  <div class="row">
                    <div class="col-md-12 text-end mt-3">
                      <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true" v-on:click="applyClick">{{ $t('Apply') }}</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-borderless">
                  <thead>
                    <tr class="fw-bolder align-top">
                      <th class="ps-3">{{ $t('Profile Picture') }}</th>
                      <th>{{ $t('Name') }} 
                            <i v-if="sorting.order === 'asc' && sorting.column== 'fname'"  v-on:click="sort('asc', 'fname')" class="fas fa-sort-up"></i>
                            <i v-if="sorting.order === 'desc' && sorting.column== 'fname'" v-on:click="sort('desc', 'fname')" class="fas fa-sort-down"></i>
                            <i v-if="sorting.column != 'fname'" v-on:click="sort('asc', 'fname')" class="fas fa-sort"></i>
                      </th>
                      <th>{{ $t('Email') }}
                           <i v-if="sorting.order === 'asc' && sorting.column== 'email'"  v-on:click="sort('asc', 'email')"  class="fas fa-sort-up"></i>
                           <i  v-if="sorting.order === 'desc' && sorting.column== 'email'" v-on:click="sort('desc', 'email')" class="fas fa-sort-down"></i>
                           <i v-if="sorting.column != 'email'" v-on:click="sort('asc' , 'email')" class="fas fa-sort"></i>
                      </th>
                      <th>{{ $t('Status') }}</th>
                      <th class="pe-3">{{ $t('Action') }}</th>
                    </tr>
                  </thead>
                  <tbody v-if="users.data && Object.keys(users.data).length > 0">
                    <tr class="align-middle" v-for="(user, index) in users.data" :key="index">
                      <td class="ps-3">
                        <span class="text-dark"><img class="user_profile_pic rounded-circle" width="35" height="35" alt="profile picture" :src="user.profile_picture ? user.profile_picture : '/uploads/blank.png'"></span>
                      </td>
                      <td>
                        <span class="text-dark">{{ user.fname }} {{user.lname}}</span>
                      </td>
                      <td >
                        <span class="text-dark">{{ user.email }}</span>
                      </td>
                      <td>
                        <span class=" fw-bold my-1 badge badge-light-success" v-if=" user ? user.status : 1">{{ $t('Enable') }}</span>
                        <span class="fw-bold my-1 badge badge-light-danger" v-else>{{ $t('Disable') }}</span>
                      </td>
                      <td class=" pe-3">
                        <ul class="list-unstyled list-inline m-0">
                           <li class="list-inline-item mb-2" v-tooltip="$t('Finanace List')" v-if="user.finance_list_count > 0">
                            <router-link :to='{name:"Dashboard", params:{id: user.id}}' class="btn btn-icon btn-light btn-hover-primary btn-sm">
                              <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <rect fill="#000000" opacity="0.3" x="2" y="5" width="20" height="14" rx="2"/>
                                        <rect fill="#000000" x="2" y="8" width="20" height="3"/>
                                        <rect fill="#000000" opacity="0.3" x="16" y="14" width="4" height="2" rx="1"/>
                                    </g>
                                </svg>
                              </span>
                            </router-link>
                          </li>
                          <li class="list-inline-item mb-2" v-tooltip="$t('Edit')">
                            <router-link :to='{name:"UserManagementEdit",params:{id: user.id}}' class="btn btn-icon btn-light btn-hover-primary btn-sm">
                              <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect> <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path> <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path></g></svg></span>
                            </router-link>
                          </li>
                          <li class="list-inline-item mb-2" v-tooltip="$t('Delete')">
                            <button class="btn btn-icon btn-light btn-hover-primary btn-sm" type="button" @click="deleteUser(user.id)">
                              <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect> <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path> <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span>
                            </button>
                          </li>
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="7">{{ $t('No any record found(s).') }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="d-flex justify-content-end align-items-center flex-wrap">
                    <pagination :data="users" :limit="2" @pagination-change-page="getUsers"></pagination>
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
</template>

<script>
  import User from "../../apis/User"

  export default {
    name: 'user-management',
    data() {
      return {
        users:{},
        loader: false,
        errors: {},
        sorting: {
          'order': 'asc',
          'column': 'fname'
        },
        openmodel: false,
        currentSort:'name',
        currentSortDir:'asc'
      }
    },
    mounted() {
      if(localStorage.user_role == 'Client') {
        this.$router.push({ name: "Dashboard" })
      }
      else {
        
        this.loader = true
        this.getUsers()
      }
    },
    methods:{
      async getUsers(page = 1) {
        User.index(page, this.sorting).then(res => {
          
          this.users = res.data.users
          this.loader = false
        })
        .catch(error=> {
          this.users = {}
          if(error.response.status === 401 && error.response.data.message == "Unauthenticated.") {
            localStorage.removeItem("auth")
            localStorage.removeItem("access_token")
            localStorage.removeItem("user_name")
            localStorage.removeItem("user_email")
            localStorage.removeItem("user_role")
            this.$router.push({name:"Login"})
          }
          this.loader = false
        });
      },
      async deleteUser(id) {
        this.$confirm({
            title: this.$t('Are you sure?'),
            message: this.$t('Are you sure to delete this user?'),
            button: {
                yes: this.$t('Yes'),
                no: this.$t('No')
            },
            callback: confirm => {
                if (confirm) {
                      this.loader = true
                  User.delete(id).then(res => {
                    this.loader = true
                    this.getUsers()
                    this.$toast.success(this.$t(res.data.message))
                    this.loader = false
                  }).catch(error=> {
                    this.loader = false 
                  });
                }
            }
        })
        setTimeout(function () {
            $('.vc-btn').addClass('btn-primary');
        }, 10);
      
      },
      async applyClick() {
        this.loader = true
        this.getUsers()
        this.openmodel = false
      },
      async openModel() {
        if(this.openmodel) {
          this.openmodel = false
        }
        else {
          this.openmodel = true
        }
      },
      async closeModel() {
        this.openmodel = false
      },
      async sort(dir, key) {
        if(dir == 'asc'){
          this.sorting.order = 'desc'     
         
        }else{
          this.sorting.order = 'asc'    
        }
        this.sorting.column = key
        this.getUsers(this.users.current_page);     
      },
      
    },
  };
</script>