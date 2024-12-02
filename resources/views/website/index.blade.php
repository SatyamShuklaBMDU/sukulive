<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>🔥 Discover Suku Live - Your Ultimate Live Video and Audio Chatroom Experience!</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shorBtcut icon" type="image/x-icon" href="{{ asset('website/img/favicon.ico') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('website/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('website/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/dripicons.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/responsive.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@5.4.5/css/swiper.min.css">
</head>

<body>
    <!-- header -->
    <header class="header-area">
        <div id="header-sticky" class="menu-area">
            <div class="container">
                <div class="second-menu">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo">
                                <a href="{{route('home')}}"><img src="{{ asset('website/img/logo/suku logo.png') }}"
                                        alt="logo"></a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-9">
                            <div class="responsive"><i class="icon dripicons-align-right" id="mobile-toggle"></i></div>
                            <div class="main-menu text-right text-xl-right" id="mobile-menu">
                                <nav>
                                    <ul>
                                        <li class="has-sub"><a href="{{route('home')}}" class="nav-link">Home</a></li>
                                        <li><a href="#aboutus" class="nav-link">About Us</a></li>
                                        <li><a href="#features" class="nav-link">Features</a></li>
                                        <li><a href="#screen" class="nav-link">Screenshots</a></li>
                                        <li><a href="#contact" class="nav-link">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-2 text-right d-none d-xl-block">
                            <div class="header-btn second-header-btn">
                                <a href="#" class="btn">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!-- header-end -->
    <!-- main-area -->
    <main>
        <!-- slider-area -->
        <section id="parallax" class="slider-area slider-bg2 second-slider-bg d-flex fix"
            style="background-image: url({{ asset('website/img/bg/pink-header-bg.png') }}); background-position:right 0; background-repeat: no-repeat; background-size: 65%;">

            <div class="slider-shape ss-one layer" data-depth="0.10"><img
                    src="{{ asset('website/img/shape/header-sape.png') }}" alt="shape"></div>

            <div class="slider-shape ss-eight layer" data-depth="0.50"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="slider-content second-slider-content left-center">
                            <ul class="small-title mb-30">
                                <li>New</li>
                                <li>Best Mobile App</li>
                            </ul>
                            <h2 data-animation="fadeInUp" data-delay=".4s">Chat & Earn Together on <span> Suku
                                    Live</span></h2>
                            <p data-animation="fadeInUp" data-delay=".6s"> Meet, Connect, & Earn on Video Call – Dive
                                into a World of Live Group Chat, Live Stream, and Rewards! Suku Live is your ultimate
                                destination for the best live social chatroom experiences. Connect with amazing hosts,
                                engage in PK Battles, and earn while making friends in a live social chatroom setting.
                                Explore new connections, chat, and unlock exciting rewards – all in one dynamic
                                platform!</p>
                            <div class="slider-btn mt-30 mb-30">
                                <a href="#" class="btn ss-btn" data-animation="fadeInUp" data-delay=".8s">Download
                                    Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="{{ asset('website/img/bg/mobile.png') }}" alt="shape" class="s-img"
                            style="width: 100%;">
                    </div>
                </div>

            </div>
        </section>
        <!-- slider-area-end -->
        <!-- services-area -->
        <section id="features" class="services-area services-bg pt-25 pb-20"
            style="background-image: url({{ asset('website/img/shape/header-sape2.png') }}); background-position: right top; background-size: auto;background-repeat: no-repeat;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-10">
                        <div class="section-title text-center pl-40 pr-40 mb-45">
                            <h2>Our Features</h2>
                            <p>**Our Features**

                                Suku Live offers engaging **Live Video and Audio Chatrooms**, thrilling **PK Battles**
                                for friendly competition, and interactive **Group Chats & Live Streaming**, making it
                                easy to connect and socialize with people worldwide.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-12 mb-30">
                        <div class="s-single-services active text-center">
                            <div class="services-icon">
                                <img src="{{ asset('website/img/icon/f-icon1.png') }}" />
                            </div>
                            <div class="second-services-content">
                                <h5>Live Video and Audio Chatrooms</h5>
                                <p>Connect with others in real-time through interactive video and audio chatrooms.</p>
                                <a href="#"><span>1</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-30">
                        <div class="s-single-services text-center">
                            <div class="services-icon">
                                <img src="{{ asset('website/img/icon/f-icon3.png') }}" />
                            </div>
                            <div class="second-services-content">
                                <h5>PK Battles</h5>
                                <p>Engage in friendly competitive live battles with other hosts, adding excitement to
                                    the experience.</p>
                                <a href="#"><span>2</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-30">
                        <div class="s-single-services text-center">
                            <div class="services-icon">
                                <img src="{{ asset('website/img/icon/f-icon2.png') }}" />
                            </div>
                            <div class="second-services-content">
                                <h5>Group Chat & Live Streaming</h5>
                                <p>Participate in group chats and stream live content, making it easy to socialize and
                                    build friendships.</p>
                                <a href="#"><span>3</span></a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- services-area-end -->
        <!-- choose-area -->
        <section id="aboutus" class="choose-area pt-0 pb-0 p-relative"
            style="background-image: url({{ asset('website/img/shape/header-sape3.png') }}); background-position: right center; background-size: auto;background-repeat: no-repeat;">
            <div class="chosse-img" style="background-image:url({{ asset('website/img/bg/easy-m-bg.png') }})"></div>
            <div class="chosse-img2"><img src="{{ asset('website/img/bg/mobile2.png') }}" alt="mobile" /></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-5">
                    </div>
                    <div class="col-xl-7">
                        <div class="choose-wrap">
                            <div class="section-title w-title left-align">
                                <h2>Welcome to Suku Live!</h2>
                            </div>
                            <div class="choose-content">
                                <p class="text-justify">At Suku Live, we revolutionize the way you connect and interact
                                    online. Our platform is designed to bring people together through immersive live
                                    video and audio chatrooms, creating a vibrant community where friendships flourish
                                    and entertainment thrives.</p>
                                <p class="text-justify">With our innovative PK Battles, you can engage in friendly
                                    competitions with other hosts, adding a thrilling edge to your interactions. Whether
                                    you're looking to meet new people, share your experiences, or simply have fun, Suku
                                    Live offers the perfect environment for meaningful social connections.</p>
                                <p class="text-justify"> Join us and dive into a world of live group chats and
                                    streaming, where every moment is an opportunity to connect, compete, and celebrate
                                    with others. Welcome to the ultimate live social chatroom experience—welcome to Suku
                                    Live!</p>

                                <div class="choose-btn mt-30">

                                    <a href="#" class="g-btn"><span class="icon"><img
                                                src="{{ asset('website/img/icon/g-play-icon.png') }}"
                                                alt="apple-icon"></span>
                                        <span class="text"> Available on <strong>GOOGLE PLAY</strong></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- choose-area-end -->


        <!-- screen-area -->
        <section id="screen" class="screen-area services-bg services-two pt-100"
            style="background-image: url({{ asset('website/img/shape/header-sape4.png') }}); background-position: right center; background-size: auto;background-repeat: no-repeat;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="section-title text-center pl-40 pr-40 mb-50">
                            <h2>Our App ScreenShots</h2>
                            <p>Experience immersive live video and audio chatrooms, thrilling PK Battles, and meaningful
                                connections on Suku Live. Join our vibrant community for live chats, competitions, and
                                endless social fun.</p>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- Swiper -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="{{ asset('website/img/gallery/bbn1.png') }}"
                                    alt="slide 1"></div>
                            <div class="swiper-slide"><img src="{{ asset('website/img/gallery/bbn2.png') }}"
                                    alt="slide 1"></div>
                            <div class="swiper-slide"><img src="{{ asset('website/img/gallery/bbn3.png') }}"
                                    alt="slide 1"></div>
                            <div class="swiper-slide"><img src="{{ asset('website/img/gallery/bbn4.png') }}"
                                    alt="slide 1"></div>
                            <div class="swiper-slide"><img src="{{ asset('website/img/gallery/bbn5.png') }}"
                                    alt="slide 1"></div>
                            <div class="swiper-slide"><img src="{{ asset('website/img/gallery/bbn6.png') }}"
                                    alt="slide 1"></div>

                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
            </div>


        </section>
        <!-- screen-area-end -->


        <!-- newslater-area -->
        <section class="newslater-area pt-40 pb-40"
            style="background-image: url({{ asset('website/img/bg/subscribe-bg.png') }});background-size: cover;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="section-title text-center pl-40 pr-40 mb-50">
                            <h2>Subscribe For New Features</h2>
                            <p>Subscribe now to stay updated on Suku Live’s latest features, exciting updates, and
                                exclusive content. Don’t miss out! </p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-10">
                        <form name="ajax-form" id="contact-form4" action="#" method="post"
                            class="contact-form newslater">
                            <div class="form-group">
                                <input class="form-control" id="email2" name="email" type="email"
                                    placeholder="Email Address..." value="" required="">
                                <button type="submit" class="btn btn-custom" id="send2">Subscribe Now</button>
                            </div>
                            <!-- /Form-email -->
                        </form>
                    </div>

                </div>
            </div>
        </section>
        <!-- newslater-aread-end -->







        <!-- contact-area -->
        <section id="contact" class="contact-area contact-bg  pt-50 pb-30 p-relative fix"
            style="background-image: url({{ asset('website/img/shape/header-sape8.png') }}); background-position: right center; background-size: auto;background-repeat: no-repeat;">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-img2">
                            <img src="{{ asset('website/img/bg/illustration.png') }}" alt="test">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-title mb-40">
                            <h2>Get In Touch</h2>
                            <p>Stay connected with us! Reach out anytime to get the latest updates, support, or
                                information. We’re here to help.</p>
                        </div>
                        <form action="#" class="contact-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="contact-field p-relative c-name mb-20">
                                        <input type="text" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-field p-relative c-email mb-20">
                                        <input type="text" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-field p-relative c-subject mb-20">
                                        <input type="text" placeholder="Phone">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="contact-field p-relative c-message mb-45">
                                        <textarea name="message" id="message" cols="10" rows="10" placeholder="Write comments"></textarea>
                                    </div>
                                    <button class="btn">Send Message</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </section>
        <!-- contact-area-end -->
    </main>
    <!-- main-area-end -->
    <!-- footer -->
    <!-- footer -->
    <footer class="footer-bg footer-p pt-60"
        style="background-image: url({{ asset('website/img/bg/f-bg.png') }});background-position: center top;background-size: auto;background-repeat: no-repeat;">
        <div class="footer-top">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="logo mt-15 mb-15">
                                <a href="#"><img src="{{ asset('website/img/logo/suku logo.png') }}"
                                        alt="logo" style="width: 30%" /></a>
                            </div>
                            <div class="footer-text mb-20">
                                <p>
                                    For any inquiries regarding our "About Us" section or to
                                    learn more about our services, please feel free to contact
                                    us. We're here to assist!
                                </p>
                            </div>
                            <div class="footer-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h5>Company News</h5>
                            </div>
                            <div class="footer-link">
                                <ul>
                                    <li><a href="{{ route('website.privacy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('website.terms') }}">Terms & Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h5>Useful Links</h5>
                            </div>
                            <div class="footer-link">
                                <ul>
                                    <li><a href="{{ route('home') }}#about">About Us</a></li>
                                    <li><a href="{{ route('home') }}#contact">Contact Us</a></li>
                                    <li><a href="{{ route('home') }}#features">Features</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h5>Contact Us</h5>
                            </div>
                            <div class="footer-link">
                                <div class="f-contact">
                                    <ul>
                                        <li>
                                            <i class="icon dripicons-phone"></i>
                                            <span>+91 8269252857</span>
                                        </li>
                                        <li>
                                            <i class="icon dripicons-mail"></i>
                                            <span><a href="mailto:info@sukulive.com">info@sukulive.com</a><br /><a
                                                    href="mailto:sale@sukulive.com">sale@sukulive.com</a></span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright-text">
                            <p>
                                &copy; 2024 Urmila Motors All Rights Reserved Created By
                                <a href="https://digitalutilization.com/" class="text-white" target="_blank">BMDU</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-end -->
    <script src="https://unpkg.com/swiper@5.4.5/js/swiper.min.js"></script>

    <script>
        var swiper = new Swiper('.swiper-container', {
            loop: true, // Enable looping
            slidesPerView: 4, // Show 4 images at once
            spaceBetween: 30, // Add some space between slides
            autoplay: {
                delay: 3000, // Auto-slide every 3 seconds
                disableOnInteraction: false // Keep autoplay running even after user interaction
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true, // Optional, makes pagination dots clickable
            },
        });
    </script>
    <!-- jQuery for Mobile Menu Toggle and Auto-Close on Click -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle mobile menu on hamburger click
            $('#mobile-toggle').on('click', function(e) {
                e.stopPropagation(); // Prevent event from bubbling up to the document
                $('#mobile-menu').toggleClass('open');
            });

            // Close the mobile menu when a navigation link is clicked
            $('.nav-link').on('click', function() {
                $('#mobile-menu').removeClass('open'); // Close the menu
            });

            // Close the mobile menu when clicking outside of it
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#mobile-menu, #mobile-toggle').length) {
                    $('#mobile-menu').removeClass('open'); // Close the menu
                }
            });
        });
    </script>
    <!-- JS here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <style>
        #mobile-menu {
            position: relative;
            /* Change from fixed to relative for larger screens */
            top: 0;
            right: 0;
            width: 100%;
            /* Full-width for larger screens */
            height: auto;
            background-color: transparent;
            /* No background for desktop view */
            box-shadow: none;
            /* Remove shadow for desktop */
            display: block;
            /* Always block-level by default */
            transition: none;
            /* No animation for larger screens */
        }

        /* Mobile specific styles */
        @media only screen and (max-width: 991px) {
            #mobile-menu {
                position: fixed;
                right: -300px;
                /* Initially off-screen on the right */
                width: 150px;
                /* Menu width for mobile */
                height: 100%;
                background-color: #fff;
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
                transition: right 0.3s ease;
                /* Animation for sliding */
            }

            #mobile-menu.open {
                right: 0;
                /* Slide in the menu when 'open' class is added */
            }

            .responsive {
                display: block;
                /* Show hamburger icon on small screens */
            }

            .main-menu {
                display: none;
                /* Hide default menu on small screens */
            }
        }

        /* Show default menu for laptops and desktops */
        @media only screen and (min-width: 992px) {
            .main-menu {
                display: block;
                /* Ensure the main menu is visible on larger screens */
            }

            .responsive {
                display: none;
                /* Hide the hamburger menu on larger screens */
            }
        }
    </style>
</body>

</html>
