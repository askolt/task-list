<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form action="">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-bind:class="{'is-invalid' : errors.email }" name="email" v-model="email" required autocomplete="email" autofocus>

                                    <span class="invalid-feedback" role="alert" v-if="errors.email">
                                        <strong>{{ errors.email[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-bind:class="{'is-invalid' : errors.password }" v-model="password" name="password" required autocomplete="current-password">

                                    <span class="invalid-feedback" role="alert" v-if="errors.password">
                                        <strong>{{ errors.password[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="remember">

                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" v-on:click.prevent="login">
                                        Login
                                    </button>

                                    <router-link to="/password/reset" class="btn btn-link">Forgot Your Password?</router-link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoginComponent",
    data() {
        return {
            errors: {},
            email: '',
            password: '',
            remember: false,
        }
    },
    methods: {
        login() {
            let _this = this;
            axios.post('/public/login', {
                email: this.email,
                password: this.password,
                remember: this.remember,
            }).then(function(response) {
                _this.$root.$emit('get-user-after-login-on', response.data);
                localStorage.taskUser = JSON.stringify(response.data);
                _this.$router.push('/task-list');
           }).catch(function (error) {
                if (error.response.status === 422) {
                    _this.errors = error.response.data.errors;
                } else {
                    alert('Happened some error. Watch the error in Console Log (F12) for details.');
                    console.log(error);
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
