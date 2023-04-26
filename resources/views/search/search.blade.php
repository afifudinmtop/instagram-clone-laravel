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

    <link rel="stylesheet" href="/search/search.css" />

    <!-- icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  </head>
  <body class="mx-auto">
    <!-- search bar -->
    <div class="search_bar_parent p-2">
      <input
        id="search_bar"
        type="text"
        class="form-control search_bar py-1 px-2 rounded"
        placeholder="search"
        onkeyup="cari()"
      />
    </div>

    <!-- main body -->
    <div id="main" class="pb-5 pt-3 main">
        @foreach ($list_user as $x)
            <div class="d-flex justify-content-between px-3 py-2">
                <a class="text-decoration-none" href="/user/{{$x->uuid}}">
                <div class="d-flex">
                    <img class="user_img my-auto" src="/storage/uploads/{{$x->image}}" />
                    <div>
                    <div class="user_username my-auto ms-2">{{$x->username}}</div>
                    <div class="user_fullname my-auto ms-2">
                        {{$x->first_name}} {{$x->last_name}}
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
        <a class="text-decoration-none" href="/profile/">
            <img class="profil_img my-auto" src="/storage/uploads/{{ $profil[0]->image }}" />
        </a>
    </div>

    <script>
      function cari() {
        let token = document.querySelector('meta[name="csrf-token"]').content;
        const cari_value = document.getElementById("search_bar").value;

        let data_upload = new FormData();
        data_upload.append("cari_value", cari_value);

        let xhttp = new XMLHttpRequest();
        xhttp.onload = () => {
          const balasan = xhttp.responseText;
          const data = JSON.parse(balasan);
          let cetak = "";
          data.forEach((x) => {
            cetak += `<div class="d-flex justify-content-between px-3 py-2">`;
            cetak += `<a class="text-decoration-none" href="/user/${x.uuid}">`;
            cetak += `<div class="d-flex">`;
            cetak += `<img class="user_img my-auto" src="/storage/uploads/${x.image}" />`;

            cetak += `<div>`;
            cetak += `<div class="user_username my-auto ms-2">${x.username}</div>`;
            cetak += `<div class="user_fullname my-auto ms-2">`;
            cetak += `${x.first_name} ${x.last_name}`;
            cetak += `</div>`;
            cetak += `</div>`;

            cetak += `</div>`;
            cetak += `</a>`;
            cetak += `</div>`;
          });
          document.getElementById("main").innerHTML = cetak;
        };
        xhttp.open("POST", "/search_post", true);
        xhttp.setRequestHeader('X-CSRF-TOKEN', token);
        xhttp.send(data_upload);
      }
    </script>
  </body>
</html>
