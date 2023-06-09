<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #F9F9F9;
        }

        .card-transparent {
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: #363636;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .form-group label {
            color: #363636;
            font-weight: bold;
        }

        .form-control {
            border-color: #363636;
        }

        .btn-primary {
            background-color: #2525e8;
            border-color: #2525e8;
        }

        .btn-primary:hover {
            background-color: #672af5;
            border-color: #672af5;
        }

        .text-center a {
            color: #2525e8;
            font-weight: bold;
        }
        .text-center a:hover {
            color: #672af5;
            font-weight: bold;
        }

        .input-group-append .btn {
            background-color: #363636;
            border-color: #363636;
            color: #F9F9F9;
        }

        .input-group-append .btn:hover {
            background-color: #2C2C2C;
            border-color: #2C2C2C;
        }
    </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        @if(Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>success!</strong> Your account has been created successfully!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Oops!</strong> Email atau password salah.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <div class="card card-transparent" style="border-radius: 20px;">
          <div class="card-body">
            <h1 class="card-title text-center">Login</h1>
            <form method="post" action="{{ route('login.authenticate') }}">
              @csrf
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="pass">Password</label>
                  <div class="input-group">
                    <input type="password" id="pass" name="password" class="form-control" required>
                    <div class="input-group-append">
                      <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i id="toggleIcon" class="bi bi-eye-fill"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" >Login</button>
              </form>
            <p class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
            <p class="text-center mt-3"><a href="">Forgot password? </a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
  function togglePasswordVisibility() {
    var passwordInput = document.getElementById("pass");
    var toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.classList.remove("bi-eye-fill");
      toggleIcon.classList.add("bi-eye-slash-fill");
    } else {
      passwordInput.type = "password";
      toggleIcon.classList.remove("bi-eye-slash-fill");
      toggleIcon.classList.add("bi-eye-fill");
    }
  }
</script>

</body>
</html>