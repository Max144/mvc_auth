<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="/auth/register" method="post">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
        <div class="col-md-1 offset-md-2">
            <a href="/auth/login">Login</a>
        </div>
    </div>
</body>
</html>