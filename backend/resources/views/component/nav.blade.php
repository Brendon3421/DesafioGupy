@include('component.head')

<head>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="navbar-nav me-auto mb-2 mb-lg-0">NexusTalk</div>

            <form class="d-flex position-relative" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <span class="search-icon">
                    <i class="fas fa-search"></i>
                </span>
            </form>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#drop_menu_navbar" role="button"
                            data-bs-toggle="dropdown" aria-expanded="true">
                            Dropdown
                        </a>
                        <ul id="drop_menu_navbar" class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>`
                </ul>

            </div>
        </div>
    </nav>

</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", sans-serif;
    }

    :root {
        --primary-color: #12ac8e;
        --primary-color-dark: #0d846c;
        --primary-color-light: #e9f7f7;
        --secondary-color: #fb923c;
        --text-dark: #333333;
        --text-light: #767278;
        --white: #ffff;
        --max-witdh: 12000px;
        --background-section: #333333;
    }

    nav {
        align-items: center;
        justify-content: space-between;

        box-shadow: 7px 7px 6px rgba(0, 0, 0, 0.1);
    }

    .search-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 1rem
    }

    .form-control {
        padding-right: 2.5rem;
    }
</style>
