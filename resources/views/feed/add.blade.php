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

    <link rel="stylesheet" href="/feed/add.css" />
  </head>
  <body class="mx-auto">
    <form action="/add_save" method="post" enctype="multipart/form-data">
        @csrf
      <!-- nav header -->
      <div class="d-flex justify-content-between py-2 px-3 nav my-auto">
        <a class="text-decoration-none" href="/feedx/">
          <div class="logo_arrow"></div>
        </a>
        <span class="new_post">New post</span>
        <button class="button_submit" type="submit">Share</button>
      </div>

      <!-- field -->
      <div class="d-flex p-3">
        <textarea
          class="flex-fill me-3 border-0"
          rows="3"
          name="caption"
          id="caption"
        ></textarea>

        <input name="image" type="text" class="d-none" value="{{ session('image') }}" />
        <img class="user_image my-auto" src="/storage/uploads/{{ session('image') }}" />
      </div>
    </form>

    <script>
      document.getElementById("caption").focus();
    </script>
  </body>
</html>
