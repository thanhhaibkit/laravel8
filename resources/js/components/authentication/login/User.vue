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
                <label for="username">Username</label>
                <input type="text" id="username" class="form-control" v-model="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
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
      email: null,
      password: null,
      error: false,
    };
  },
  methods: {
    login() {
      var app = this;
      this.$auth.login({
        params: {
          email: app.email,
          password: app.password,
        },
        success: function () {},
        error: function () {},
        rememberMe: true,
        redirect: "/dashboard",
        fetchUser: true,
      });
    },
  },
};
</script>
