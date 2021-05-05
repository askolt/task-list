<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                Task List
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="+">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item" v-if="!user">
                        <router-link to="/login" class="nav-link">Login</router-link>
                    </li>

                    <li class="nav-item" v-if="!user">
                        <router-link to="/sign-up" class="nav-link">Sign up</router-link>
                    </li>
                    <li class="nav-item dropdown" v-else>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ user.first_name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#" v-on:click="logout">
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "NavbarComponent",
    data() {
        return {
            user: {}
        }
    },
    created() {
        this.$root.$on('get-user-after-login-on', this.getUserAfterLogin);
    },
    beforeDestroy() {
        this.$root.$off('get-user-after-login-on', this.getUserAfterLogin)
    },
    methods: {
        getUserAfterLogin(oUser) {
            this.user = oUser;
        },
        getUser() {
            if (localStorage.getItem('taskUser')) {
                try {
                    this.user = JSON.parse(localStorage.getItem('taskUser'));
                    return;
                } catch (e) {
                    localStorage.removeItem('taskUser');
                }
            }
            let _this = this;
            axios.get('/user').then(function(response) {
                _this.getUserAfterLogin(response.data)
            }).catch(function (error) {
                if (error.response.status === 401) {
                    _this.$router.push('/login');
                } else {
                    alert('Happened some error. Watch the error in Console Log (F12) for details.');
                    console.log(error);
                }
            });
        },
        logout() {
            let _this = this;
            axios.post('/public/logout',{}).then(function() {
                _this.user = {};
                localStorage.removeItem('taskUser');
                _this.$router.push('/login');
            }).catch(function (e) {
                alert('Sorry. Happened an error when logout');
                console.log(e);
            })
        }
    },
    mounted() {
        this.getUser();
    }
}
</script>

<style scoped>

</style>
