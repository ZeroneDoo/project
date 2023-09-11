<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.1/dist/full.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
</head>

<style>
    * {
        font-family: 'Inter', sans-serif;
        scroll-behavior: smooth;
    }

    p {
        color: black;
    }

    body,
    input,
    textarea {
        background-color: white;
    }

    .underline-animation {
        position: relative;
        transition: all 0.3s ease-in-out;
    }

    .underline-animation::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -2px;
        height: 2px;
        background-color: #fac213;
        transform: scaleX(0);
        transform-origin: left center;
        transition: transform 0.3s ease-in-out;
    }

    .underline-animation:hover::before {
        transform: scaleX(1);
    }

    .truncate-custom {
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        max-width: 200px;
    }

    .underline-profile-custom {
        position: relative;
        font-weight: bold;
    }

    .underline-profile-custom::after {
        content: "";
        position: absolute;
        left: 20px;
        bottom: -10px;
        width: 14%;
        height: 4px;
        background-color: #FAC213;
    }

    .underline-profile-custom {
        position: relative;
        font-weight: bold;
    }

    .underline-profile-custom::after {
        content: "";
        position: absolute;
        left: 20px;
        bottom: -10px;
        width: 14%;
        height: 4px;
        background-color: #FAC213;
    }

    .bg-image {
        background-image: url('assets/persembahan.jpg');
        background-size: cover;
        background-position: center;
    }

    .playfair {
        font-family: 'Playfair Display', serif;
    }

    .poppins {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body>
    <div class="">
        <nav class="w-screen fixed bg-black sm:h-16 h-14 flex justify-center items-center z-50">
            <ul class="flex sm:justify-center items-center justify-between gap-24 px-5 w-full">
                <li class="hidden sm:block"> <a href=""
                        class="text-white font-semibold text-sm opacity-90 tracking-wider underline-animation">
                        Beranda</a>
                </li>
                <li class="hidden sm:block"> <a href="#tentang-kami"
                        class="text-white font-semibold text-sm opacity-90 tracking-wider underline-animation"> Tentang
                        Kami</a></li>
                <li class="hidden sm:block"> <a href="ministry.html"
                        class="text-white font-semibold text-sm opacity-90 tracking-wider underline-animation">
                        Pelayanan</a>
                </li>
                <li class="block sm:hidden">
                    <div class="drawer">
                        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
                        <div class="drawer-content">
                            <!-- Page content here -->

                            <label for="my-drawer" class=" drawer-button"> <img src="assets/menu.png" alt=""
                                    class="w-4"></label>

                        </div>
                        <div class="drawer-side">
                            <label for="my-drawer" class="drawer-overlay"></label>
                            <ul class="menu p-4 w-80 h-full bg-black text-base-content">
                                <!-- Sidebar content here -->
                                <li><a>Beranda</a></li>
                                <li><a href="#tentang-kami">tentang Kami</a></li>
                                <li><a href="ministry.html">Pelayanan</a></li>
                                <li><a>Lokasi</a></li>
                                <li><a>Online</a></li>
                            </ul>
                        </div>
                    </div>


                </li>
                <li class="">
                    <img src="{{ url('assets/logo.png'); }}" for="my-drawer" alt="" class="w-20 sm:w-24 drawer-button">
                </li>
                <li class="block sm:hidden"></li>
                <li class="hidden sm:block">
                    <div class="dropdown dropdown-hover">
                        <label tabindex="0"
                            class="text-white font-semibold text-sm opacity-90 tracking-wider  dropdown">
                            Lokasi</label>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-black rounded-box w-52">
                            <li><a>Item 1</a></li>
                            <li><a>Item 2</a></li>
                        </ul>
                    </div>
                </li>
               
                <li class="hidden sm:block"> <a href=""
                        class="text-white font-semibold text-sm opacity-90 tracking-wider underline-animation"> Formulir
                        Online</a></li>
                <li class="hidden sm:block"> <a href=""
                        class="text-white font-semibold text-sm opacity-90 tracking-wider underline-animation">
                        COOL</a>
                </li>

            </ul>
        </nav>

        @yield('content')
        
    <footer>
        <div class="w-full bg-black sm:h-14 h-10 flex items-center sm:px-10 px-6">
            <p class="text-white font-semibold sm:text-[14px] text-[10px] opacity-80">© GLB Lewi | 2023</p>
        </div>
    </footer>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        const mySwiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });
        

    </script>
</body>

</html>