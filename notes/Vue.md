# Laravel and VueJS

## 1. Install node package
Install node package for vue / axios

```sh
npm install
npm install vue
```

After installing, the package.json should look like
```json
{
    ...
    "dependencies": {
        "vue": "^2.6.12"
    }
}
```

## 2. Start with very simple Vue page
Update the welcome template to embed a div tag with the id is "app" for rendering vue app, and include the app.js file
```html
<!-- file: \resources\views\welcome.blade.php-->
<body>
    <div class="container">
        <div id="app"></div>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
```

Create default component App.vue in resources/js
```html
<!-- file: /resources/js/App.vue -->
<template>
  <div id="main">
    <header id="header">
      <h1>Welcome to Laravel Vue SPA</h1>
    </header>
    <div id="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      //
    };
  },
  components: {
    //
  },
};
</script>
```

Update app.js to import vue and above default component
```js
// file: /resources/js/app.js
import Vue from 'vue';
import App from './App.vue';

const app = new Vue({
    render: app => app(App)
}).$mount("#app");
```

OK, run serve for the first test.
```sh
php artisan serve
npm run watch
```

Access http://localhost:8000, it should show
```
Welcome to Laravel Vue SPA
```

Imaging the flow
```
+---------------------------------------------------+   +----------------------------+
| browser: http://localhost:8000/                   +-=-+ Welcome to Laravel Vue SPA |  
+-------+-------------------------------------------+   +---^------------------------+
        |  (routes, e.g. web.php)                           |
        |  loading template                  +--------------+                
+-------v------------------------------------|------+
| welcome template                                  |
|   * <div id="app" />    <---------------------------------+
|   * <script scr="js/app.js" />  >-----+           |       |
+---------------------------------------|-----------+       |
                                        |                   |
+---------------------------------------V-----------+       | 
| app.js                                            |       | 
| * import vue and default component (App.vue) <--------+   |
| * create vue object,                              |   |   |
|     render app from App.vue  <--------+           |   |   |
|     and mount it to div id="app" >----|---------------|---+
+---------------------------------------|-----------+   |
                                        |               |
+---------------------------------------|-----------+   |
| App.vue        >----------------------|---------------+
| * render html  >----------------------+           |
+---------------------------------------------------+
```

## 3. Make it more complex
### Setup Vue JS Packages for Authentication

```sh
npm install axios es6-promise
npm install vue-axios vue-router vue-loader vue-template-compiler
npm install @websanova/vue-auth
```

Create Vue components: Dashboard and Login (User Login)
```html
<!-- file: \resources\js\components\Dashboard.vue -->
<template>
    <h1>Dashboard</h1>
</template>
```
```html
<!-- file: resources\js\components\authentication\login\User.vue -->
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
```

Create router.js to define and control vue router
```js
/* file: resources\js\router.js */
import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: () => import("./components/Dashboard.vue")
        },
        {
            path: "login",
            component: () => import("./components/authentication/login/User.vue")
        }
    ]
})
```

Update app.js to import vue router
```js
/* File: resources/js/router.js */
import Vue from 'vue';
import App from './App.vue';
import router from './router';

const app = new Vue({
    router,
    render: app => app(App)
}).$mount("#app");
```

And now, update Laravel web route to config every request using welcome view, so after Vue route will handle next
```php
// file: routes/web.php
Route::get('/{any?}', function () {
    return view('welcome');
});
```

Okay, testing time.
```sh
php artisan serve --port=9090
npm run watch
```

Access to http://localhost:9090/login, it should show vue login page


Re-cap
```
+--------------------------------------+
| Access: http://localhost:9090/login  |
+---|----------------------------------+
    | Laravel route load view
+---V----------------------------------+
| Load Welcome view                    |
+---|----------------------------------+
    | blade view will load scripts
+---V----------------------------------+
| Load app.js                          |
+---|----------------------------------+
    | app.js load Vue Route and route.js
+---V----------------------------------+
| Load Login.vue                       |
+---|----------------------------------+
    |
+---V----------------------------------+
| Retunr Login page                    |
+--------------------------------------+

```

Next, we will using websanova to process authentication


https://codebriefly.com/laravel-jwt-authentication-vue-js-spa-part-2/#Setup_Vue_Js
https://topdev.vn/blog/api-authentication-trong-laravel-vue-spa-su-dung-jwt-auth/#ftoc-heading-1
