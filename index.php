<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Web Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="#signupform">Sign Up</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="#">Login In</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="#">Shop</a>
            </li>

            <!-- Optional Dropdown -->
            <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
            </li> -->
        </ul>

        <!-- Search Bar -->
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        </div>
    </div>
    </nav>

    <!-- Home Page Images -->
    <section class="my-4">
        <div class="py-4">
            <h2 class="text-center">Welcome to the Web Shop!</h2>
        </div>
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/photo1.jpg" class="img-fluid pb-4" style="width:250px; height:250px; object-fit:cover;">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/photo2.jpg" class="img-fluid pb-4" style="width:250px; height:250px; object-fit:cover;">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/photo3.jpg" class="img-fluid pb-4" style="width:250px; height:250px; object-fit:cover;">
                </div>
            </div>
        </div>
    </section>

    <section class="my-4">
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/photo1.jpg" class="img-fluid pb-4" style="width:250px; height:250px; object-fit:cover;">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/photo2.jpg" class="img-fluid pb-4" style="width:250px; height:250px; object-fit:cover;">
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <img src="images/photo3.jpg" class="img-fluid pb-4" style="width:250px; height:250px; object-fit:cover;">
                </div>
            </div>
        </div>
    </section>

    <!-- Sign Up Form -->
    <a id="signupform">
        <section class="my-4">
            <div class="py-4">
                <h2 class="text-center">Sign Up</h2>
            </div>

            <div class="w-50 m-auto"> 
                <form action="signup.php" method="post">
                    <div class="form-group"> 
                        <label>Username: </label>
                        <input type="text" name="username" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group"> 
                        <label>Password: </label>
                        <input type="text" name="password" autocomplete="off" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Sign Up</button>
                </form>
            </div>
        </section>
    </a>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    <link rel="stylesheet" href="css/style.css">

</body>
</html>
