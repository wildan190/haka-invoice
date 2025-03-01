<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Navbar */
        .navbar {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            position: fixed;
            top: 56px;
            left: 0;
            height: 100%;
            background: linear-gradient(135deg, #2c3e50, #1c2833);
            padding-top: 20px;
            transition: 0.3s;
        }

        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #f1c40f;
        }

        /* Content */
        .content {
            margin-left: 280px;
            padding: 20px;
            padding-top: 76px;
            /* Adjusted to avoid overlap with the fixed navbar */
            transition: margin-left 0.3s ease-in-out;
        }

        /* Bottom Navbar (Mobile) */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(135deg, #2c3e50, #1c2833);
            padding: 10px 0;
            display: none;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.1);
        }

        .bottom-nav a {
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
        }

        .bottom-nav a i {
            display: block;
            font-size: 18px;
            margin-bottom: 3px;
        }

        .bottom-nav a.active {
            color: #f1c40f;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-left: 0;
            }

            .bottom-nav {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Haka Rental</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="nav-link btn btn-link text-danger" type="submit">
                                <i class="fa-solid fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar (Desktop) -->
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fa-solid fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('customers.index') }}" class="nav-link"><i class="fa-solid fa-users"></i> Customer</a>
        <a href="{{ route('mobils.index') }}" class="nav-link"><i class="fa-solid fa-car"></i> Mobil</a>
        <a href="{{ route('rentals.index') }}" class="nav-link"><i class="fa-solid fa-key"></i> Rental</a>
        <a href="{{ route('invoices.index') }}" class="nav-link"><i class="fa-solid fa-file-invoice"></i> Invoice</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <div style="height: 60px;"></div> 

    <!-- Bottom Navbar (Mobile) -->
    <div class="bottom-nav">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fa-solid fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        <a href="{{ route('customers.index') }}" class="nav-link"><i class="fa-solid fa-users"></i>
            <span>Customer</span></a>
        <a href="{{ route('mobils.index') }}" class="nav-link"><i class="fa-solid fa-car"></i> <span>Mobil</span></a>
        <a href="{{ route('rentals.index') }}" class="nav-link"><i class="fa-solid fa-key"></i> <span>Rental</span></a>
        <a href="{{ route('invoices.index') }}" class="nav-link"><i class="fa-solid fa-file-invoice"></i>
            <span>Invoice</span></a>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let links = document.querySelectorAll(".nav-link");
            links.forEach(link => {
                if (link.href === window.location.href) {
                    link.classList.add("active");
                }
            });
        });
    </script>
</body>

</html>
