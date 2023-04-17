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

    <link rel="stylesheet" href="/feed/feed.css" />
  </head>
  <body class="mx-auto">
    <!-- nav header -->
    <div class="d-flex justify-content-between py-2 px-3 nav my-auto">
      <a class="text-decoration-none" href="/feed/">
        <div class="logo_ig"></div>
      </a>
      <div class="d-flex justify-content-between my-auto">
        <!-- form input image -->
        <form action="/add" method="post" enctype="multipart/form-data">
            @csrf
            <input
                id="file"
                type="file"
                name="file"
                class="d-none"
                accept="image/*"
                onchange="document.getElementById('button_submit').click()"
            />
            <button id="button_submit" type="submit" class="d-none"></button>
            <div
                class="logo_add"
                onclick="document.getElementById('file').click()"
            ></div>
        </form>

        <a class="text-decoration-none" href="/notif/">
          <div class="logo_notif ms-3"></div>
        </a>
      </div>
    </div>

    <!-- body feed loop -->
    <div class="pb-5 main">
        @foreach ($list_post as $x)
            <!-- post head -->
            <div class="d-flex justify-content-between p-3">
                <a class="text-decoration-none" href="/user/?uuid={{ $x->user }}">
                <div class="d-flex">
                    <img class="user_img my-auto" src="/uploads/{{ $x->user_image }}" />
                    <span class="user_username my-auto ms-2">{{ $x->username }}</span>
                </div>
                </a>
            </div>

            <!-- post img -->
            <a class="text-decoration-none" href="/post_detail/?uuid={{ $x->uuid }}">
                <img class="feed_img" src="/uploads/{{ $x->image }}" />
            </a>

            <!-- nav footer -->
            <div class="d-flex justify-content-between py-2 px-3 my-auto">
                <div class="d-flex">
                <img
                    id="likes_{{ $x->uuid }}"
                    class="me-3 apip_pointer"
                    onclick="likes('{{ $x->uuid }}')"
                    src="/img/{{ $x->likex }}"
                    width="22px"
                    height="24px"
                    style="margin-top: 2px"
                />

                <a
                    class="text-decoration-none me-3"
                    href="/post_comment/?uuid={{ $x->uuid }}"
                >
                    <img src="/img/comment.png" width="22px" height="22px" />
                </a>
                <a class="text-decoration-none me-3" href="/share/">
                    <img src="/img/share.png" width="22px" height="22px" />
                </a>
                </div>

                <img
                id="saved_{{ $x->uuid }}"
                class="apip_pointer"
                onclick="saved('{{ $x->uuid }}')"
                src="/img/{{ $x->saved_status }}"
                width="22px"
                height="22px"
                />
            </div>

            <!-- post likes -->
            <a class="text-decoration-none" href="/post_like/?uuid={{ $x->uuid }}">
                <div class="post_like px-3 pt-2">{{ $x->num_likes }} likes</div>
            </a>

            <!-- post caption -->
            <div class="post_caption px-3 pt-1">
                <a class="text-decoration-none" href="/user/?uuid={{ $x->user }}">
                <span class="post_caption_username">{{ $x->username }} </span></a
                >
                <span class="post_caption_body">{{ $x->caption }}</span>
            </div>

            <!-- post comment -->
            <a class="text-decoration-none" href="/post_comment/?uuid={{ $x->uuid }}">
                <div class="post_comment px-3 pt-1">
                view all {{ $x->num_comments }} comments
                </div>
            </a>

            <!-- post ts -->
            <div class="post_ts px-3 pt-1">{{ $x->ts }}</div>

        @endforeach
        <!-- body feed loop end -->
    </div>

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
      // middleware likes
      function likes(uuid_post) {
        let data_upload = new FormData();
        data_upload.append("uuid_post", uuid_post);

        // dislike
        if (
          document
            .getElementById(`likes_${uuid_post}`)
            .src.includes("/img/lovex.png")
        ) {
          let xhttp = new XMLHttpRequest();
          xhttp.onload = () => {
            document.getElementById(`likes_${uuid_post}`).src = "/img/love.png";
          };
          xhttp.open("POST", "/dislike", true);
          xhttp.send(data_upload);
        }
        // like
        else {
          let xhttp = new XMLHttpRequest();
          xhttp.onload = () => {
            document.getElementById(`likes_${uuid_post}`).src =
              "/img/lovex.png";
          };
          xhttp.open("POST", "/likes", true);
          xhttp.send(data_upload);
        }
      }

      // middleware saved
      function saved(uuid_post) {
        let data_upload = new FormData();
        data_upload.append("uuid_post", uuid_post);

        // unsaved
        if (
          document
            .getElementById(`saved_${uuid_post}`)
            .src.includes("/img/unsaved.png")
        ) {
          let xhttp = new XMLHttpRequest();
          xhttp.onload = () => {
            document.getElementById(`saved_${uuid_post}`).src =
              "/img/saved.png";
          };
          xhttp.open("POST", "/unsaved", true);
          xhttp.send(data_upload);
        }
        // saved
        else {
          let xhttp = new XMLHttpRequest();
          xhttp.onload = () => {
            document.getElementById(`saved_${uuid_post}`).src =
              "/img/unsaved.png";
          };
          xhttp.open("POST", "/saved", true);
          xhttp.send(data_upload);
        }
      }
    </script>
  </body>
</html>
