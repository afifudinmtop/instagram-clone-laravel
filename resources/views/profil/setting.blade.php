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

    <link rel="stylesheet" href="/profil/setting.css" />
  </head>
  <body class="mx-auto">
    <!-- nav header -->
    <div class="d-flex justify-content-between py-2 px-3 nav my-auto">
      <a class="text-decoration-none" href="/profile/">
        <div class="logo_arrow"></div>
      </a>
      <span class="header_title">Edit profile</span>
      <div></div>
    </div>

    <!-- form -->
    <form action="/save_setting" method="post" enctype="multipart/form-data">
        @csrf
      <!-- info 1 -->
      <div class="d-flex p-3">
        <img class="user_image" src="/storage/uploads/{{ $profil[0]->image }}" />

        <div class="ps-3 flex-fill">
          <div class="info1_username">{{ $profil[0]->username }}</div>

          <!-- input gambar -->
          <label class="custom-file-upload apip_pointer">
            <input
              id="file"
              type="file"
              name="file"
              class="d-none"
              accept="image/*"
              onchange="loadFile(event)"
            />
            Change profile photo
          </label>
        </div>
      </div>

      <!-- bio -->
      <div class="p-3">
        <div class="bio_label">Bio</div>
        <textarea class="form-control" id="bio" rows="2" name="bio">{{ $profil[0]->bio }}</textarea>
      </div>

      <!-- submit button -->
      <div class="d-flex justify-content-between p-3">
        <button type="submit" class="btn btn-primary btn_tombol_get border-0">
          Save changes
        </button>

        <a class="text-decoration-none" href="/logout">
          <button type="button" class="btn btn-danger border-0">Logout</button>
        </a>
      </div>
    </form>

    <!-- nav footer -->
    <div class="d-flex justify-content-between py-2 px-4 footer my-auto">
      <a class="text-decoration-none" href="/feed/">
        <img src="/img/home_selected.png" width="24px" height="24px" />
      </a>
      <a class="text-decoration-none" href="/search_feed/">
        <img src="/img/search.png" width="24px" height="24px" />
      </a>
      <a class="text-decoration-none" href="/reels/">
        <img src="/img/reels.png" width="24px" height="24px" />
      </a>
      <a class="text-decoration-none" href="/message/">
        <img src="/img/message.png" width="24px" height="24px" />
      </a>
      <a class="text-decoration-none" href="/profil/">
        <img class="profil_img my-auto" src="/storage/uploads/{{ $profil[0]->image }}" />
      </a>
    </div>

    <script>
      function loadFile(event) {
        let image = document.querySelector(".user_image");
        image.src = URL.createObjectURL(event.target.files[0]);
      }
    </script>
  </body>
</html>
