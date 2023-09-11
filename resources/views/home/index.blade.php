@extends('layout')
@section('content')


<div class=" bg-black sm:h-22 h-14 sm:mb-14 mb-12 pt-10"></div>
        <div
            class=" bg-black sm:h-[520px] h-[190px] sm:mx-20 mx-6 sm:rounded-2xl rounded-md flex justify-center align-center sm:py-5 py-4 sm:px-8 px-3">
            <div class="w-2/3 sm:h-12 h-10 absolute bg-black top-20 rounded-2xl flex items-center justify-center">
                <ul class="flex justify-between w-full sm:mx-14 mx-5">
                    <li class="text-white truncate-custom font-bold sm:text-[18px] text-[10px] ">Welcome Home</li>
                    <li class="text-white sm:text-[18px] text-[10px] ">|</li>
                    <li class="text-white truncate-custom font-bold sm:text-[18px] text-[10px] sm:block hidden">Senin,
                        09 Juli 2023</li>
                    <li class="text-white sm:text-[18px] text-[10px] sm:block hidden">|</li>
                    <li class="text-white truncate-custom font-bold sm:text-[18px] text-[10px] sm:block hidden">GLB Lewi
                    </li>
                    <li class="text-white sm:text-[18px] text-[10px] sm:block hidden">|</li>
                    <li class="text-white truncate-custom font-bold sm:text-[18px] text-[10px] "><a
                            href="">http://linkstreaming</a></li>
                </ul>
            </div>

            <div class="w-full bg-white sm:h-[480px] h-[160px] sm:rounded-2xl rounded-md relative carousel">
                <div
                    class="swiper-container carousel-item w-full h-full relative sm:rounded-2xl rounded-md overflow-hidden">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide carousel-item" id="item1">
                            <img src="https://th.bing.com/th/id/R.a9b818f385f140ac197cc93194809a00?rik=EZv8bemiGyUIrA&riu=http%3a%2f%2fwww.thedestinationseeker.com%2fwp-content%2fuploads%2f2018%2f05%2fCinderellas-Castle-from-Pixabay.jpg&ehk=peByriaItzdXSrjTvPOMXCyTIs7xWLoRjAGG5GqfcAQ%3d&risl=&pid=ImgRaw&r=0"
                                class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                        </div>
                        <div class="swiper-slide carousel-item" id="item2">
                            <img src="https://th.bing.com/th/id/R.a9b818f385f140ac197cc93194809a00?rik=EZv8bemiGyUIrA&riu=http%3a%2f%2fwww.thedestinationseeker.com%2fwp-content%2fuploads%2f2018%2f05%2fCinderellas-Castle-from-Pixabay.jpg&ehk=peByriaItzdXSrjTvPOMXCyTIs7xWLoRjAGG5GqfcAQ%3d&risl=&pid=ImgRaw&r=0"
                                class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                        </div>
                        <div class="swiper-slide carousel-item" id="item3">
                            <img src="https://th.bing.com/th/id/R.a9b818f385f140ac197cc93194809a00?rik=EZv8bemiGyUIrA&riu=http%3a%2f%2fwww.thedestinationseeker.com%2fwp-content%2fuploads%2f2018%2f05%2fCinderellas-Castle-from-Pixabay.jpg&ehk=peByriaItzdXSrjTvPOMXCyTIs7xWLoRjAGG5GqfcAQ%3d&risl=&pid=ImgRaw&r=0"
                                class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                        </div>
                        <div class="swiper-slide carousel-item" id="item4">
                            <img src="https://allears.net/wp-content/uploads/2021/04/2021-reopening-wdw-magic-kingdom-cinderella-castle-molly-guide-5-scaled.jpg"
                                class="w-full sm:h-[100vh] h-[40vh] image-fit" />
                        </div>
                    </div>
                </div>
                <!-- <img src="assets/img/slider.jpg" class="object-cover w-full h-full sm:rounded-2xl rounded-md" alt=""> -->
                <!-- <div class="absolute inset-0 bg-black o pacity-20 z-10"></div> -->
            </div>

        </div>
        <div class="flex justify-between sm:px-20 px-5 mt-6 gap-4">
            <div id="tentang-kami"
                class="w-[400px] sm:h-64 bg-white border-2 shadow-xl border-yellow-400 rounded-xl sm:py-5 py-2 sm:px-5 px-4">
                <div class="flex items-center gap-3 sm:mb-3 mb-1">
                    <img class="sm:w-7 w-3" src="assets/info.png" alt="">
                    <p class="sm:text-sm text-[10px] font-semibold">Tentang kami</p>
                </div>
                <p class="sm:text-sm text-[7px]">GBI Lewi berdiri dari tahun 2011, dimulai dengan COOL Legenda Wisata
                    dan Kota Wisata.
                    Hingga sekarang GBI telah memiliki beberapa cabang & ranting yang tersebar di Cibubur, Jawa Barat,
                    Jawa tengah, Kalimantan Utara hingga Sumba. GBI Lewi adalah Gereja yang bergerak dalam hal karunia
                    Healing & Blessing. Dan fokus bertumbuh dan membangun Bersama didalam COOL yang menjadi dasar
                    kegerakan GBI Lewi.
                </p>
            </div>
            <div
                class="w-[400px] h-64 bg-white border-2 shadow-xl border-yellow-400 rounded-xl py-5 px-5 hidden sm:block">
                <div class="flex items-center gap-3 mb-3">
                    <img class="w-7" src="assets/info.png" alt="">
                    <p class="text-md font-semibold">Visi</p>
                </div>
                <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa fugit quidem, et fugiat
                    blanditiis itaque similique consequuntur iusto deserunt saepe voluptatibus placeat illum nisi, quis
                    libero molestiae voluptate aliquid exercitationem.
                    Aut deserunt, saepe quidem porro, asperiores officia id placeat voluptatibus eligendi blanditiis
                    unde! Accusantium esse

                </p>
            </div>
            <div
                class="w-[400px] h-64 bg-white border-2 shadow-xl border-yellow-400 rounded-xl py-5 px-5 hidden sm:block">
                <div class="flex items-center gap-3 mb-3">
                    <img class="w-7" src="assets/info.png" alt="">
                    <p class="text-md font-semibold">Misi</p>
                </div>
                <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa fugit quidem, et fugiat
                    blanditiis itaque similique consequuntur iusto deserunt saepe voluptatibus placeat illum nisi, quis
                    libero molestiae voluptate aliquid exercitationem.
                    Aut deserunt, saepe quidem porro, asperiores officia id placeat voluptatibus eligendi blanditiis
                    unde! Accusantium esse

                </p>
            </div>
        </div>
        <div class="sm:pl-32 pl-10 sm:pr-20 pr-5 sm:mt-10 mt-5 sm:mb-52 mb-32">
            <p class="sm:text-3xl text-sm font-bold underline-profile-custom  ">Profil Gembala</p>
            <div class="sm:mt-8 mt-2 flex  sm:gap-10 gap-3">
                <img class="sm:w-[400px] w-32 h-fit sm:rounded-xl rounded-md" src="assets/gembala.jpg" alt="">
                <div class="">
                    <p class="sm:text-sm text-[8px] ">
                        Pdt. Darmayanto Rawatan, M.Th lahir di Jakarta,09 Desember 1962. Tinggal dan besar di Rawangun
                        Jakarta Timur. Mengambil kuliah Di Atmajaya. lalu tahun 1986 melanjutkan studi di California
                        State University, USA dan lulus tahun 1988. Setelah pulang ke Indonesia Pdt. Darmayanto Rawatan,
                        M.Th  membuka usaha sendiri , dan juga bergabung diPerusahaan Keluarga, hingga pada tahun 1997
                        terimbas krisis moneter, dan melanjutkan karir di Development Perusahaan Perumahan Alam Sutera
                        hingga tahun 2023. Tahun 1995 menikah dengan Ibu Gembala kita terkasih Pdp. Fifi Suharlie dan
                        dikaruniai 3 orang Anak yaitu Lidya Zefanya Rawatan, Nathanael David Rawatan, Joshua Efraim
                        Rawatan.
                    </p>
                    <p class="sm:text-sm text-[8px] sm:mt-4 mt-2">
                        Awal mula melayani adalah pada saat Pdt. Darmayanto Rawatan bertempat tinggal di Alam sutera dan
                        akhirnya pindah ke Kota Wisata Cibubur hingga sekarang. DiawalI dengan menjadi Ketua COOL dan
                        berkembang dengan cepat hingga melahirkan beberapa COOL baru, hingga tahun 2005 dipercayakan
                        dalam pengembalaan. Hingga tahun 2011 memiliki Pengembalaan sendiri yaitu GBI Lewi dibawah
                        naungan Rayon 1H. hingga sekarang sudah berkembang semakin luas yaitu 23 Cabang dan berjumlah
                        kurang lebih 5000 Jemaat.  Pada Tahun 2021 Pdt. Darmayanto Rawatan, M.Th Menulis sebuah  buku
                        yang berjudul Healing And Blessing (Kebenaran Kasih Karunia, Kebenaran dan Iman).
                    </p>
                </div>
            </div>
        </div>

        <div
            class="w-10/12 bg-[#DDB05B] sm:h-52 h-22 sm:rounded-2xl rounded-xl sm:py-5 py-2 sm:px-20 px-6 absolute z-10 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div class="flex justify-center items-center sm:gap-3 gap-2">
                <img class="sm:w-10 w-3" src="assets/bible.png" alt="">
                <p class="font-bold sm:text-2xl text-[12px] text-white playfair">Bible</p>
            </div>
            <div class="carousel ">
                <div class="carousel-item w-full flex flex-col">
                    <p
                        class="sm:mt-5 mt-1 text-center sm:text-xl text-[8px] font-semibold text-white opacity-90 playfair italic">
                        “ For God so
                        loved the world that he gave his one and only begotten Son, that who ever believes in him shall
                        not
                        perish but have eternal life “</p>
                    <p
                        class="sm:mt-3 mt-1 text-center sm:text-xl text-[8px] font-semibold text-white opacity-90 playfair ">
                        -John 3:16 (KJV)
                    </p>
                </div>
                <div class="carousel-item w-full flex flex-col">
                    <p
                        class="sm:mt-5 mt-1 text-center sm:text-xl text-[8px] font-semibold text-white opacity-90 playfair italic">
                        “ lah iya“</p>
                    <p
                        class="sm:mt-3 mt-1 text-center sm:text-xl text-[8px] font-semibold text-white opacity-90 playfair ">
                        -John 3:16 (KJV)
                    </p>
                </div>
                <div class="carousel-item w-full flex flex-col">
                    <p
                        class="sm:mt-5 mt-1 text-center sm:text-xl text-[8px] font-semibold text-white opacity-90 playfair italic">
                        “Iya Lah“</p>
                    <p
                        class="sm:mt-3 mt-1 text-center sm:text-xl text-[8px] font-semibold text-white opacity-90 playfair ">
                        -John 3:16 (KJV)
                    </p>
                </div>
            </div>
        </div>


        <div
            class="w-full bg-black bg-image sm:h-[450px] h-52 sm:rounded-br-[120px] rounded-br-[50px] shadow-xl flex items-center justify-center ">
            <div class="sm:mt-24 mt-12 flex items-center justify-center sm:gap-32 gap-10">

                <div class="sm:w-[550px] w-[200px]">
                    <p class=" sm:text-2xl text-[14px] font-bold text-white">Berikan Persembahan</p>
                    <p class="sm:mt-2 mt-1 sm:text-xl text-[8px] text-white">Lorem ipsum dolor sit amet consectetur.
                        Cursus arcu sit ac tincidunt sapien eget. Fames penatibus venenatis justo enim pharetra. Ut
                        morbi faucibus donec rhoncus sem a. Lorem ipsum dolor sit amet consectetur. Cursus arcu sit ac
                        tincidunt sapien eget. Fames penatibus venenatis </p>
                </div>
                <img class="sm:w-52 w-24" src="assets/qrcode.png" alt="">
            </div>
        </div>

        <div class="mt-10 mb-16">
            <div class="">
                <p class="sm:text-2xl text-xl font-extrabold text-center poppins">Hubungi Kami</p>
                <p class="sm:text-xl text-[15px] font-bold tracking-wider text-center poppins text-[#1E1E1E]">Berikan
                    Masukan Untuk Kami</p>
            </div>
            <div class="w-10/12 h-fit mx-auto mt-5 border-[#DDB05B] border-2 flex">
                <div class="w-6/12  bg-[#DDB05B] sm:px-10 px-3 py-5 flex flex-col justify-start items-start">
                    <p class="sm:text-xl text-[12px] font-bold tracking-wider text-white">Sekretariat GBL Lewi</p>
                    <div class="flex sm:gap-5 gap-4 items-center justify-center sm:mt-6 mt-2">
                        <div class="sm:w-24 w-16 sm:h-12 h-8 rounded-[50%] border-2 border-white flex justify-center items-center">
                          <img src="assets/pin.png" class="sm:w-6 w-12" alt="">
                        </div>
                        <p class="text-white font-semibold sm:text-[12px] text-[7px]">
                            JL CIBUBUR CBD RUKO NO FR03/16, RT.002/RW.006, Jatirangga, Kec. Jatisampurna, Kota Bekasi,
                            Jawa Barat 17434
                        </p>
                    </div>
                    <div class="flex sm:gap-5 gap-2 items-center justify-center sm:mt-5 mt-2">
                        <div class="sm:w-12 w-8 sm:h-12 h-8 rounded-[50%] border-2 border-white flex justify-center items-center">
                            <img src="assets/phone-call.png" class="sm:w-6 w-8" alt="">
                        </div>
                        <div class="">
                            <p class="text-white font-semibold sm:text-[12px] text-[7px]">02184343584</p>
                            <p class="text-white font-semibold sm:text-[12px] text-[7px]">08111 98 6677</p>
                        </div>
                    </div>
                    <div class="flex sm:gap-5 gap-2 items-center justify-center sm:mt-5 mt-3">
                        <div class="sm:w-12 w-8 sm:h-12 h-8 rounded-[50%] border-2 border-white flex justify-center items-center">
                            <img src="assets/clock.png" class="sm:w-6 w-4" alt="">
                        </div>
                        <p class="text-white font-semibold sm:text-[12px] text-[7px]">
                            08.00 - 20.00 WIB
                        </p>
                    </div>


                </div>
                <div class="w-12/12 bg-white sm:px-10 px-3 py-5">
                    <div class="sm:flex block gap-5">
                        <div class="">
                            <p class="sm:text-[16px] text-[10px] ">Nama</p>
                            <input class="border-2 border-[#DDB05B] shadow-md sm:w-60 w-full sm:h-10 h-7" type="text">
                        </div>
                        <div class="">
                            <p class="sm:text-[16px] text-[10px] ">Email</p>
                            <input class="border-2 border-[#DDB05B] shadow-md sm:w-60 w-full sm:h-10 h-7" type="email">
                        </div>
                    </div>
                    <div class="mt-2">

                        <p class="sm:text-[16px] text-[10px] ">Pesan</p>
                        <textarea class=" border-2 border-[#DDB05B] shadow-md w-full sm:h-32 h-10" name="" id=""
                            cols="57" rows="5"></textarea>
                    </div>
                    <button
                        class="mt-2 w-full sm:h-10 h-6 text-white sm:text-[16px] text-[10px] font-semibold bg-[#DDB05B] shadow-xl">Kirim</button>
                </div>
            </div>
        </div>
    </div>
@endsection