<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Algen</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="?p=home">Algen4</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerContent" aria-controls="navbarTogglerContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?p=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page content-->
    <div class="container">
        <?php
        ini_set("display_errors", 1);
        #require_once "libraries/connect.php";
        #require_once "libraries/fungsi.php";

        if (isset($_GET['p']) == false) {
            $page = "home";
        } else {
            $page = $_GET['p'];
        }

        $file_to_open = "pages/".$page.".php";
        if (file_exists($file_to_open) == false) {
            $file_to_open = "pages/404.php";
        }

        include_once $file_to_open;
        ?>
    </div>
    <!-- Bootstrap core JS-->
    <script src="assets/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- Core theme JS <script src="assets/js/scripts.js"></script>-->
</body>
</html>
