<!doctype html>
<html lang="en">

<head>
    <title>Signin User</title>
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
    <!-- navbar partial -->
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/escom-project/views/partials/navbar.php';
    ?>

    <div class="container-fluid">
        <div class="container p-5">

            <div id="app">
                <h1 class="mb-5">Sign In</h1>

                <div v-if="response">
                    <div v-if="response.ok" class="text-success">
                        {{ response.msg }} Token: {{ response.tkn }}
                    </div>
                    <div v-else class="text-danger">
                        {{ response.msg }}
                    </div>
                </div>

                <form @submit.prevent="signIn">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input v-model="email" type="email" class="form-control" name="email" id="email" aria-describedby="helpId" required>
                        <small id="helpId" class="form-text text-muted">Email registered</small>
                    </div>


                    <!-- input for password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input v-model="password" type="password" class="form-control" name="password" id="password" aria-describedby="helpId" required>
                        <small id="helpId" class="form-text text-muted">Password registered</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Sign In</button>


                </form>
            </div>

        </div>
    </div>


    <script>
        new Vue({
            el: "#app",
            data: {
                email: "",
                password: "",
                response: null,
            },
            methods: {
                signIn() {
                    // craete a form data
                    const formData = new FormData();
                    formData.append("email", this.email);
                    formData.append("password", this.password);
                    axios
                        .post("../api/v1/auth/signin.php", formData)
                        .then((res) => {
                            this.response = res.data;
                        })
                        .catch((err) => {
                            this.response = err.response.data;
                        });
                },
            },
        });
    </script>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>