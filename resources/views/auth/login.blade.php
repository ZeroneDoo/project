<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> GBI LEWI - Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.1/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
</head>

<style>
    * {
        font-family: 'Inter', sans-serif;
    }

    .image-fit {
        background-size: cover;
        background-position: center;
    }
</style>

<body class="overflow-y-hidden">

    <div class="sm:flex block w-full">
        <div class="bg-black sm:h-[100vh] h-[40vh]  sm:w-[50%]">
            <img src="/assets/logo.png" alt="" class="absolute top-5 left-8 w-24 z-50">

            <div class="swiper-container carousel w-full h-[100vh] relative overflow-hidden">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" id="item1">
                        <img src="https://renewedvision.com/blog/wp-content/uploads/2019/12/One-Church-to-Christmas-Stage-Design-2.jpg"
                            class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                    </div>
                    <div class="swiper-slide" id="item2">
                        <img src="https://images.unsplash.com/photo-1565804970157-19c1ade2403f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Y2h1cmNoJTIwc3RhZ2V8ZW58MHx8MHx8fDA%3D&w=1000&q=80"
                            class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                    </div>
                    <div class="swiper-slide" id="item3">
                        <img src="https://th.bing.com/th/id/R.a9b818f385f140ac197cc93194809a00?rik=EZv8bemiGyUIrA&riu=http%3a%2f%2fwww.thedestinationseeker.com%2fwp-content%2fuploads%2f2018%2f05%2fCinderellas-Castle-from-Pixabay.jpg&ehk=peByriaItzdXSrjTvPOMXCyTIs7xWLoRjAGG5GqfcAQ%3d&risl=&pid=ImgRaw&r=0"
                            class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                    </div>
                    <div class="swiper-slide" id="item4">
                        <img src="https://allears.net/wp-content/uploads/2021/04/2021-reopening-wdw-magic-kingdom-cinderella-castle-molly-guide-5-scaled.jpg"
                            class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white sm:h-[100vh] h-[70vh] w-full flex justify-center sm:items-center">
            <div class="sm:w-[25vw] h-fit bg-white px-5 py-5 sm:mt-0 mt-10">
                <div class="border-b-2  pb-3">
                    <p class="font-bold text-xl text-black">Masuk</p>
                </div>
                <form action="{{ route('auth.store.login') }}" method="post">
                    @csrf
                    <div class="w-full mt-5">
                        <p class="text-sm font-semibold opacity-60">Email</p>
                        <input type="email" id="nip_email" placeholder="Email"
                            class="border-2 rounded w-full h-10 text-sm px-5 mt-1 bg-white" name="nip_email" value="{{ old('nip') }}">
                    </div>
                    <div class="w-full mt-2">
                        <p class="text-sm font-semibold opacity-60">Password</p>
                        <input type="password" required name="password" value="{{ old('password') }}" id="password" placeholder="Password"
                            class="border-2 rounded w-full h-10 text-sm px-5 mt-1 bg-white">
                    </div>
                    <a href="index.html">
                        <button class="sm:mt-3 mt-3 w-full h-10 text-white text-[14px] font-semibold bg-black shadow-xl rounded-md ">
                            Masuk</button>
                    </a>
                </form>
            </div>
        </div>
    </div>

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