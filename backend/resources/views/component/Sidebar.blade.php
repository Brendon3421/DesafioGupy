<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- ICONS -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- STYLESHEET -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <title>Sidebar</title>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="menu-btn">
                <i class="ph-bold ph-caret-left"></i>
            </div>
            <div class="head">
                <div class="user-img">
                    <img src="user.jpg" alt="" />
                </div>
                <div class="user-details">
                    <p class="name">{{ auth()->user()->name }}</p>
                </div>
            </div>
            <div class="nav">
                <div class="menu">
                    <p class="title">Main</p>
                    <ul>
                        <li>
                            <a href="{{ route('/dashboard') }}">
                                <i class="icon ph-bold ph-house-simple"></i>
                                <span class="text">Dashboard</span>
                            </a>
                        </li>
                        <li>

                        </li>
                        <li class="active">
                            <a href="{{ route('/Tarefa') }}">
                                <i class="icon ph-bold ph-file-text"></i>
                                <span class="text">Tarefa</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon ph-bold ph-gear"></i>
                                <span class="text">Settings</span>
                                <i class="arrow ph-bold ph-caret-down"></i>

                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">
                                        <span class="text">Categoria</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="text">Genero</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="text">Situacao</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="menu">

                </div>
            </div>
            <div class="menu">
                <p class="title">Account</p>
                <ul>
                    <li>
                        <a href="{{ route('logout') }}">
                            <i class="icon ph-bold ph-sign-out"></i>
                            <span class="text">Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"
        integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw=="
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>

<script>
    $(".menu > ul > li").click(function(e) {
        // remove active from already active
        $(this).siblings().removeClass("active");
        // add active to clicked
        $(this).toggleClass("active");
        // if has sub menu open it
        $(this).find("ul").slideToggle();
        // close other sub menu if any open
        $(this).siblings().find("ul").slideUp();
        // remove active class of sub menu items
        $(this).siblings().find("ul").find("li").removeClass("active");
    });

    $(".menu-btn").click(function() {
        $(".sidebar").toggleClass("active");
    });
</script>
