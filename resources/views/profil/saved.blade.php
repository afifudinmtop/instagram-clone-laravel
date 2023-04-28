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

    <link rel="stylesheet" href="/profil/saved.css" />
  </head>
  <body class="mx-auto">
    <!-- nav header -->
    <div class="d-flex justify-content-between py-2 px-3 nav my-auto">
        <a class="text-decoration-none" href="/setting/">
            <div class="logo_setting"></div>
        </a>
        <span class="header_username">{{ $profil[0]->username }}</span>
        <a class="text-decoration-none" href="#">
            <div class="logo_discover"></div>
        </a>
    </div>

    <!-- info 1 -->
    <div class="d-flex p-3">
        <img class="user_image" src="/storage/uploads/{{ $profil[0]->image }}" />
        
        <div class="ps-4 flex-fill">
            <div class="info1_username">{{ $profil[0]->username }}</div>
            <a class="text-decoration-none" href="/setting/">
            <div class="edit_profile text-center p-1 rounded mt-2 apip_pointer">
                Edit Profile
            </div>
            </a>
        </div>
    </div>

    <!-- info 2 -->
    <div class="px-3">
        <div class="info2_username">{{ $profil[0]->first_name }} {{ $profil[0]->last_name }}</div>
        <div class="info2_bio">{{ $profil[0]->bio }}</div>
    </div>

    <!-- stats -->
    <div class="d-flex justify-content-between py-2 px-5 stats_div mt-4">
        <div>
            <div class="stats_number">{{ $jumlah_post->jumlah_post }}</div>
            <div class="stats_sub">posts</div>
        </div>
        <div>
            <a
            class="text-decoration-none flex-fill"
            href="/user_followers/{{ $profil[0]->uuid }}"
            >
            <div class="stats_number">{{ $jumlah_followers->jumlah_followers }}</div>
            <div class="stats_sub">followers</div>
            </a>
        </div>
        <div>
            <a
            class="text-decoration-none flex-fill"
            href="/user_following/{{ $profil[0]->uuid }}"
            >
            <div class="stats_number">{{ $jumlah_following->jumlah_following }}</div>
            <div class="stats_sub">following</div>
            </a>
        </div>
    </div>

    <!-- menu -->
    <div class="d-flex justify-content-between py-2 px-4 my-1">
        <!-- profil -->
        <div>
            <a class="text-decoration-none flex-fill" href="/profile/">
            <img src="/img/profil-feed.png" width="24px" height="24px" />
            </a>
        </div>

        <!-- reels -->
        <div><img src="/img/profil-reels.png" width="24px" height="24px" /></div>

        <!-- saved -->
        <div>
            <a class="text-decoration-none flex-fill" href="/saved/">
            <img src="/img/profil-saved.png" width="24px" height="24px" />
            </a>
        </div>

        <!-- tag -->
        <div><img src="/img/profil-tag.png" width="24px" height="24px" /></div>
    </div>

    <!-- list post -->
    <div class="row mx-0 px-0" style="padding-bottom: 45px">
      @foreach ($posts as $x)
        <a href="/post_detail/{{ $x->uuid }}" class="list_post col-4 mx-0 p-1" >
          <img src="/storage/uploads/{{ $x->image }}" />
        </a>
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
  </body>
</html>
