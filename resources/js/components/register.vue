<template>
    <title>ChallengeApp | Register </title>

    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <p class="h1"><b>Challenge</b>App</p>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Register to join the fun!</p>

                    <form action="#" method="post">
                        <div class="input-group mb-3">
                            <input v-model="form.email" type="email" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input v-model="form.username" type="text" class="form-control" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input v-model="form.phone_number" type="text" class="form-control" placeholder="Phone Number">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
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
                        <div class="input-group mb-3">
                            <input v-model="form.confirm_password" type="password" class="form-control" placeholder="Confirm Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button @click.prevent="registerUser" type="submit" class="btn btn-primary btn-block"> <i
                                        class="fas fa-sign-in mr-2"></i>Register Account</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mb-0 mt-2">
                        <router-link to="/" class="text-center">Already have an account?</router-link>
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
                username: '',
                phone_number: '',
                password: '',
                confirm_password: ''
            },
            errors: []
        }
    },
    methods: {
        registerUser() {
            const email = this.form.email;
            const username = this.form.username;
            const phone_number = this.form.phone_number;
            const password = this.form.password;
            const confirm_password = this.form.confirm_password;
            const self = this;

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email == '' || username == '' || phone_number == '' || password == '' || confirm_password == '' ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'System Message',
                    text: 'Please complete all required fields!'
                });
            }else if(password !== confirm_password){
                Swal.fire({
                    icon: 'warning',
                    title: 'System Message',
                    text: 'Passwords does not match! Please confirm your password correctly!'
                });
            }else if(emailRegex.test(email) == false){
                Swal.fire({
                    icon: 'warning',
                    title: 'System Message',
                    text: 'Invalid email format!'
                });
            } else {
                Swal.fire({
                    title: 'Please Wait...',
                    html: 'Processing your request ...',
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                axios.post('/api/register', self.form).then(respond => {
                    const data = respond.data;
                  
                    Swal.fire({
                        icon: 'success',
                        title: data.title,
                        text: data.message,
                        timer: 2500,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    setTimeout(function() {
                        self.$router.push({ name: "Login" }); 
                    }, 1500)

                    
                }).catch(error => {
                    console.log(error.response.message)
                    if(error.response.status == 422){
                        Swal.fire({
                            icon: 'error',
                            title: error.response.data.title,
                            text: error.response.data.message
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'System Message',
                            text: 'There was an error encountered registering your account. Please try again, if the issue persists, please contact support.'
                        });
                        
                    }
                });;
            }
        },
    },
    mounted() {
        // axios.get('/api/athenticated').then(()=>{
        //     this.$router.push({ name: "Dashboard" }); 
        // }).catch(()=>{
        //     this.$router.push({ name: "Login" }); 
        // })
    }
}
</script>