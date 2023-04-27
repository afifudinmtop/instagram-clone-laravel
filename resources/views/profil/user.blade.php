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

    <link rel="stylesheet" href="/user/user.css" />
  </head>
  <body class="mx-auto">
    <!-- nav header -->
    <div class="d-flex justify-content-between py-2 px-3 nav my-auto">
      <a class="text-decoration-none" href="/feedx/">
        <div class="logo_x"></div>
      </a>
      <span class="header_username">{{ $user[0]->username }}</span>
      <div></div>
    </div>

    <!-- info 1 -->
    <div class="d-flex p-3">
        <img class="user_image" src="/storage/uploads/{{ $user[0]->image }}" />

        <div class="ps-4 flex-fill">
            <div class="info1_username">{{ $user[0]->username }}</div>
            <div class="d-flex">
                <!-- uda follow -->
                @if ($follow->jumlah == "1")
                    <a class="text-decoration-none flex-fill" href="/unfollow/{{ $user[0]->uuid }}" >
                        <div class="following text-center p-1 rounded mt-2 apip_pointer me-1" >Following</div>
                    </a>
                    
                <!-- belum follow -->
                @else
                    <a class="text-decoration-none flex-fill" href="/follow/{{ $user[0]->uuid }}">
                        <div class="follow text-center p-1 rounded mt-2 apip_pointer me-1">Follow</div>
                    </a>
                @endif

                <a class="text-decoration-none flex-fill" href="/dm/{{ $user[0]->uuid }}">
                    <div class="message text-center p-1 rounded mt-2 apip_pointer ms-1">Message</div>
                </a>
            </div>
        </div>
    </div>

    <!-- info 2 -->
    <div class="px-3">
        <div class="info2_username">{{ $user[0]->first_name }} {{ $user[0]->last_name }}</div>
        <div class="info2_bio">{{ $user[0]->bio }}</div>
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
            href="/user_followers/{{ $user[0]->uuid }}"
            >
            <div class="stats_number">{{ $jumlah_followers->jumlah_followers }}</div>
            <div class="stats_sub">followers</div>
            </a>
        </div>
        <div>
            <a
            class="text-decoration-none flex-fill"
            href="/user_following/{{ $user[0]->uuid }}"
            >
            <div class="stats_number">{{ $jumlah_following->jumlah_following }}</div>
            <div class="stats_sub">following</div>
            </a>
        </div>
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
