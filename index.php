<?php
session_start();
ini_set('display_errors', 0); 
include "koneksi.php";
$connection = mysqli_connect($servername, $username, $password, $database);
require_once 'auth.php';
checkLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Lokasi Wisata Kota Pekanbaru</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
        <!-- Nav Header -->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="index.php">
                    <b class="logo-abbr"><img src="images/logo.png" alt=""></b>
                    <span class="brand-title">
                        <img src="images/logo-text.png" alt="">
                    </span>
                </a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Menu Utama</li>
                    <li>
                        <a href="index.php" class="d-flex align-items-center">
                            <i class="icon-home menu-icon mr-3"></i>
                            <span class="nav-text">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?menu=kecamatan" class="d-flex align-items-center">
                            <i class="icon-speedometer menu-icon mr-3"></i>
                            <span class="nav-text">Kecamatan</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?menu=desa" class="d-flex align-items-center">
                            <i class="icon-globe-alt menu-icon mr-3"></i>
                            <span class="nav-text">Desa</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?menu=wisata" class="d-flex align-items-center">
                            <i class="icon-map menu-icon mr-3"></i>
                            <span class="nav-text">Wisata</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?menu=user" class="d-flex align-items-center">
                            <i class="icon-user menu-icon mr-3"></i>
                            <span class="nav-text">User</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="d-flex align-items-center">
                            <i class="icon-logout menu-icon mr-3"></i>
                            <span class="nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Body -->
        <div class="content-body">
            <div class="container-fluid">
                <?php
                if (empty($_GET['menu'])) {
                    include "home.php";
                } else {
                    switch($_GET['menu']) {
                        case 'kecamatan':
                            include "data/kecamatan.php";
                            break;
                        case 'desa':
                            include "data/desa.php";
                            break;
                        case 'wisata':
                            include "data/wisata.php";
                            break;
                        case 'user':
                            include "data/user.php";
                            break;
                    }
                }
                ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer fixed-bottom">
            <div class="copyright text-center">
                <p>Copyright &copy; Wisata Pekanbaru 2024</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
    <script src="./js/dashboard/dashboard-1.js"></script>
</body>
</html>
