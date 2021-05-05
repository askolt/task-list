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
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">First name</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control" v-bind:class="{'is-invalid' : errors.first_name }" name="first_name" v-model="first_name" required autocomplete="first_name">

                                    <span class="invalid-feedback" role="alert" v-if="errors.first_name">
                                        <strong>{{ errors.first_name[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" v-bind:class="{'is-invalid' : errors.last_name }" name="last_name" v-model="last_name" required autocomplete="last_name">

                                    <span class="invalid-feedback" role="alert" v-if="errors.last_name">
                                        <strong>{{ errors.last_name[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-bind:class="{'is-invalid' : errors.password }" v-model="password" name="password" required autocomplete="new-password">

                                    <span class="invalid-feedback" role="alert" v-if="errors.password">
                                        <strong>{{ errors.password[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" v-on:click.prevent="register">
                                        Sign Up
                                    </button>
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
    name: "RegisterComponent",
    data() {
        return {
            errors: {},
            email: '',
            password: '',
            password_confirmation: '',
            first_name: '',
            last_name: ''
        }
    },
    methods: {
        register() {
            let _this = this;
            axios.post('/public/register', {
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                first_name: this.first_name,
                last_name: this.last_name,
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
