<!DOCTYPE html>
<html lang="en" style="background: #f0ecec; overflow: auto">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      data-default-icon="/img/icon.png"
      rel="icon"
      sizes="192x192"
      href="/img/icon.png"
    />
    <title>Instagram</title>

    <!-- bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>

    <!-- font family -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="/home/login.css" />
  </head>
  <body class="mx-auto px-5">
    {{-- error validation --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mb-3">
                <div>{{ $error }}</div>
            </div>
        @endforeach
    @endif

    {{-- success message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- error message --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- logo ig -->
    <div class="mx-auto d-flex justify-content-center logo_ig_parent">
      <div class="logo_ig"></div>
    </div>

    <!-- form -->
    <form action="/login" method="post" class="mt-4">
        @csrf
      <!-- username -->
      <div class="form-floating mb-0" style="transform: scale(0.8)">
        <input
          type="text"
          class="form-control bg-secondary-subtle"
          id="username"
          name="username"
          placeholder="username"
        />
        <label for="username">username</label>
      </div>

      <!-- password -->
      <div class="form-floating mb-0" style="transform: scale(0.8)">
        <input
          type="password"
          class="form-control bg-secondary-subtle"
          id="password"
          name="password"
          placeholder="password"
        />
        <label for="password">password</label>
      </div>

      <!-- button login -->
      <div class="mx-auto d-flex justify-content-center mt-4">
        <button
          type="submit"
          class="btn btn-primary btn_tombol_get border-0 mx-auto"
        >
          Log In
        </button>
      </div>
    </form>

    <!-- separator -->
    <div class="row mx-0 mt-2 mb-5">
      <div class="col-5 mx-0 border-bottom border-2"></div>
      <div class="col-2 mx-0 text_or">OR</div>
      <div class="col-5 mx-0 border-bottom border-2"></div>
    </div>

    <!-- login facebook -->
    <div class="text-center" style="cursor: pointer">
      <span class="logo_fb"></span>
      <span class="text_fb">Log in with Facebook</span>
    </div>

    <!-- forgot password -->
    <div class="text-center mt-2">
      <a
        class="text-decoration-none text_forgot"
        href="https://www.instagram.com/accounts/password/reset/"
        >Forgot password?</a
      >
    </div>

    <!-- sign up -->
    <div class="text-center mt-5 text_signup pb-4">
      <span>Don't have an account?</span>
      <a class="text-decoration-none" href="/register">Sign up</a>
    </div>
  </body>
</html>
