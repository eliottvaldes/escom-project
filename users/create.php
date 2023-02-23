<!doctype html>
<html lang="en">

<head>
    <title>Create user</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <!-- vuejs cdn -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
    <!-- axios cdn -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="container p-5">
            <div id="app">

                <!-- header for create new user -->
                <h1 class="mb-4">Create New User</h1>

                <div v-if="message" :class="{ 'alert alert-success alert-dismissible fade show': success, 'alert alert-danger alert-dismissible fade show': !success }" class="" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div>{{ message }}</div>
                </div>


                <form @submit.prevent="createUser">
                    <div class="mb-3">
                        <label for="" class="form-label">Username:</label>
                        <input v-model="username" type="text" maxlength="10" id="username" class="form-control" name="username" aria-describedby="helpId" required>
                        <small id="helpId" class="form-text text-muted">Must be unique</small>
                    </div>

                    <!-- input for email -->
                    <div class="mb-3">
                        <label for="" class="form-label">Email:</label>
                        <input v-model="email" type="email" maxlength="50" id="email" class="form-control" name="email" aria-describedby="helpId" required>
                        <small id="helpId" class="form-text text-muted">Must be unique</small>
                    </div>

                    <!-- input for password -->
                    <div class="mb-3">
                        <label for="" class="form-label">Password:</label>
                        <input v-model="password" type="password" maxlength="36" id="password" class="form-control" name="password" aria-describedby="helpId" required>
                        <small id="helpId" class="form-text text-muted">Must be unique</small>
                    </div>

                    <button type="submit">Create User</button>
                </form>
            </div>

        </div>
    </div>



    <!-- app script -->
    <script>
        new Vue({
            el: '#app',
            data: {
                username: '',
                email: '',
                password: '',
                message: '',
                success: false
            },
            methods: {
                createUser: function() {
                    const self = this;
                    // create a form data object
                    const formData = new FormData();
                    formData.append('username', this.username);
                    formData.append('email', this.email);
                    formData.append('password', this.password);

                    axios.post('../api/v1/users/create.php', formData)
                        .then(function(response) {
                            self.message = response.data.msg;
                            self.success = true;
                            self.clearForm();
                        })
                        .catch(function(error) {
                            self.message = error.response.data.msg;
                            self.success = false;
                        });
                },
                clearForm: function() {
                    this.username = '';
                    this.email = '';
                    this.password = '';
                }
            }
        });
    </script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>