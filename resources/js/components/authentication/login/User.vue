<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-6">
        <div class="card card-default">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div class="alert alert-danger" v-if="has_error && !success">
              <p v-if="error == 'login_error'">Validation Errors.</p>
              <p v-else>Error, unable to connect with these credentials.</p>
            </div>
            <form autocomplete="off" @submit.prevent="login" method="post">
              <div class="form-group">
                <label for="account">Account</label>
                <input
                  type="text"
                  id="account"
                  class="form-control"
                  v-model="account"
                  required
                />
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input
                  type="text"
                  id="username"
                  class="form-control"
                  v-model="username"
                  required
                />
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input
                  type="password"
                  id="password"
                  class="form-control"
                  v-model="password"
                  required
                />
              </div>
              <button type="submit" class="btn btn-primary">Signin</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      account: null,
      username: null,
      password: null,
      success: false,
      has_error: false,
      error: "",
    };
  },
  mounted() {
    //
  },
  methods: {
    login() {
      var app = this;
      this.$auth.login({
        data: {
          account_code: app.account,
          username: app.username,
          password: app.password,
        },
        success: function () {
          // handle redirection
          app.success = true;
          const redirectTo = "dashboard";
          this.$router.push({ name: redirectTo });
        },
        error: function () {
          app.has_error = true;
          app.error = res.response.data.error;
        },
        rememberMe: true,
        redirect: {name: 'dashboard'},
        staySignedIn: true,
        fetchUser: false,
      });
    },
  },
};
</script>
