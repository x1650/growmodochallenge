<template>
    <title>Dashboard | ChallengeTaskApp</title>
    <div class="lockscreen-wrapper" style="max-width:800px!important; margin-top:60px">
        <div class="lockscreen-logo">
            <a href="#"><b>ChallengeTask</b>App</a>
        </div>

        <div class="lockscreen-name text-center text-bold"> Welcome {{ appdata.username }} ({{ appdata.email }})!</div>


        <div class="help-block text-center">
            <router-link to="/portal/dashboard" class="btn btn-primary btn-sm mr-2">Dashboard</router-link>
            <button class="btn btn-primary btn-sm" @click="Logout()">Logout</button>
        </div>
        <div class="card" v-if="editstatus == 1">
            <div class="card-header">
                <h3 class="card-title">Editing User with ID#4</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-secondary btn-sm" @click="CancelEdit">cancel</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Username</label>
                            <input v-model="editdata.username" type="text" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input v-model="editdata.email" type="text" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input v-model="editdata.phone_number" type="text" class="form-control"
                                placeholder="Contact Number">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-primary float-right" @click="UpdateUser"><i class="fas fa-save mr-1"></i>
                            Save</button>
                    </div>
                </div>


            </div>

        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Records List</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" v-model="search" @keyup="fetchData" class="form-control float-right"
                            placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Date Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in data" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.username }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.phone_number }}</td>
                            <td>{{ new Date(item.created_at).toLocaleDateString('en-US', {
                                year: 'numeric', month: 'long',
                                day: 'numeric'
                            }) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm mr-2" @click="EditUser(item)">Edit</button>
                                <button class="btn btn-danger btn-sm"
                                    @click="DeleteUser(item.username, item.email, item.id)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>

        </div>

        <div class="lockscreen-footer text-center mt-5">
            Copyright &copy; 2023 <b><a href="#" class="text-black">Growmodo Challenge Task</a></b><br>
            All rights reserved
        </div>
    </div>
</template>


<script>


import store from '../../../store/index.js'

export default {
    data() {
        return {
            appdata: {
                username: store.state.username,
                email: store.state.email,
                userlevel: store.state.userlevel,
            },
            editdata: {
                edit_id: "",
                username: "",
                email: "",
                phone_number: "",
            },
            editstatus: 0,
            search: "",
            data: [], // Your data array
            errors: []
        }
    },
    computed: {
    },
    methods: {
        fetchData() {
            axios.get(`/api/records?search=${this.search}`, {
                headers: {
                    'Authorization': `Bearer ${store.state.token}`,
                    'Content-Type': 'application/json',
                }
            })
                .then(response => {
                    this.data = response.data;
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'System Message',
                        text: 'There was an error fetching the records. Please try again.'
                    });
                });;
        },
        DeleteUser(username, email, id) {
            Swal.fire({
                title: `Do you really want to delete ${username} (${email})?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6C757D',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.delete(`/api/records/delete/${id}`, {
                        headers: {
                            'Authorization': `Bearer ${store.state.token}`,
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(response => {
                            console.log(response)
                            Swal.fire({
                                icon: 'success',
                                title: response.data.title,
                                text: response.data.message
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'System Message',
                                text: `There was an error deleting user with id#${id}. Please try again.`
                            });
                        });;
                }
            })
        },

        EditUser(itemData) {
            
            this.editdata.edit_id = itemData.id
            this.editdata.username = itemData.username
            this.editdata.email = itemData.email
            this.editdata.phone_number = itemData.phone_number
            this.editstatus = 1;
        },

        CancelEdit() {
            this.editstatus = 0;
        },

        UpdateUser() {

            if (this.editdata.username == "" || this.editdata.email == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'System Message',
                    text: 'Username and Email are required fields.'
                });
            } else {
                axios.patch(`/api/records/update`, this.editdata, {
                    headers: {
                        'Authorization': `Bearer ${store.state.token}`,
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => {
                        this.editstatus = 0;
                        console.log(response)
                        Swal.fire({
                            icon: 'success',
                            title: response.data.title,
                            text: response.data.message
                        });
                        this.fetchData();
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'System Message',
                            text: 'There was an error updating the records. Please try again.'
                        });
                    });;
            }

        },

        Logout() {
            store.commit("logout");
            console.log("Logging you out ...")
            this.$router.push('/');
        }
    },
    mounted() {
        this.fetchData();

    }
}
</script>