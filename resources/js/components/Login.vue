<template>
    <title>ChallengeApp | Login </title>

    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <p class="h1"><b>Challenge</b>App</p>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Login to start your session</p>

                    <form action="#" method="post">
                        <div class="input-group mb-3">
                            <input v-model="form.email" type="text" class="form-control" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input v-model="form.password" type="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button @click.prevent="loginUser" type="submit" class="btn btn-primary btn-block"> <i
                                        class="fas fa-sign-in mr-2"></i>Login</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mb-0 mt-2">
                        <router-link to="/register" class="text-center">Register a New Account</router-link>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</template>

<style scoped>
#login {
    margin: 20px;
}
</style>

<script>
import store from '../../store/index.js'

export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods: {
        loginUser() {
            console.log(store.state.token)

            const email = this.form.email;
            const password = this.form.password;
            const self = this;


            if (email == '' || password == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'System Message',
                    text: 'Please complete all required fields!'
                });
            } else {
                Swal.fire({
                    title: 'Please Wait...',
                    html: 'Checking User Credetials...',
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                axios.post('/api/login', self.form).then(respond => {
                    const data = respond.data;
                    const store_data = {
                        token: data.data.token,
                        username: data.data.username,
                        email: data.data.email,
                        userlevel: data.data.userlevel,
                    }
                    console.log(store_data)
                    store.commit('login', store_data)
                    setTimeout(function() {
                        setTimeout(function() {
                            self.$router.go(0);
                        }, 100)
                        self.$router.push('portal/dashboard');
                    }, 1500)
                    setTimeout(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'System Message',
                            text: 'Login success redirecting to Dashboard...',
                            timerProgressBar: true,
                            timer: 2500,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    }, 200)

                    self.form.email = '';
                    self.form.password = '';
                    
                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'System Message',
                        text: 'Email Address or Password is incorrect! Please try again!'
                    });
                });;
            }
        },
    }
}
</script>