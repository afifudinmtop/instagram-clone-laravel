<!DOCTYPE html>
<html lang="en" style="background: #f0ecec">
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

    <link rel="stylesheet" href="/feed/post_like.css" />
  </head>
  <body class="mx-auto">
    <!-- nav header -->
    <div class="d-flex justify-content-between py-2 px-3 nav my-auto">
      <a class="text-decoration-none" href="/feedx/">
        <div class="logo_x"></div>
      </a>
      <span class="header_title">Likes</span>
      <div></div>
    </div>

    <!-- main body -->
    <div class="pb-5 pt-3 main">
        @foreach ($list_like as $x)
            <div class="d-flex justify-content-between px-3 py-2">
                <a class="text-decoration-none" href="/user/{{ $x->user }}">
                    <div class="d-flex">
                        <img class="user_img my-auto" src="/storage/uploads/{{ $x->image }}" />
                        <div>
                        <div class="user_username my-auto ms-2">{{ $x->username }}</div>
                        <div class="user_fullname my-auto ms-2">
                            {{ $x->first_name }} {{ $x->last_name }}
                        </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- nav footer -->
    <div class="d-flex justify-content-between py-2 px-4 footer my-auto">
      <a class="text-decoration-none" href="/feedx/">
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
  </body>
</html>
