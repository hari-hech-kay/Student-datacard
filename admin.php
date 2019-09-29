<html lang="en">
<head>
    <title>Welcome</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="populate_modal.js"></script>

    <style>
        .brand{
            font-size:24px;
            color: white;
            text-decoration: none;
        }
        .brand:hover{
            text-decoration: none;
            color: white;
        }
        .header-container{
            display: flex;
            background: blueviolet;
            width: 100%;
            height:72px;
            padding-left: 32px;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .header{
            flex: 1;
            font-weight: bold;
            color: white;
            margin: 0;
        }
        nav ul{
            display: flex;
            align-items: flex-end;
            float:right;
            margin: 0;
            padding: 0;
        }
        nav li {
            display: inline-block;
            padding: 0 30px ;
            text-decoration: none;
            list-style: none;
        }

        nav ul li a{
            color:white;
            text-decoration: none;
        }
        nav ul li a:hover{
            text-decoration: none;
            color: white;
            opacity: 0.8;
        }

    </style>

</head>
<body style="margin: 0; background: rgba(159,44,255,0.09); font-family: Roboto">

<header class="header-container mb-3">
    <div class="header">
        <a href="homepage.html" class="brand">Admin's Dashboard</a>
    </div>
    <nav class="header">
        <ul>
            <li><a href="#"><span class="material-icons">input</span> Logout</a></li>
        </ul>
    </nav>
</header>

<form name="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"  class="mr-auto">
    <div class="input-group m-auto w-50 d-flex justify-content-center">
        <input type="text" class="form-control" placeholder="Enter student ID" name="search" style="border-radius: 50px;" required>
        <div class="input-group-append">
            <button class="btn" type="submit" name="submit" style="border-radius: 50px; margin-left: -50px;"><i class="material-icons"  >search</i> </button>
        </div>
    </div>
</form>

<div class="row" style="margin: 32px 32px;">

    <div class="card-columns">

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $search = $_POST["search"];

            $conn = new mysqli("localhost", "root", "", "student");
            if (!$conn) {
                $msg = "Database Connection failed: " . mysqli_connect_error();
                goto br;
            }

            $sql = "select * from users where sid = '$search'";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                $msg = "Could'nt find a student with ID $search";
                goto br;
            }

            if (mysqli_query($conn, "DESCRIBE $search")) {
                $sql = "SELECT name, description, filepath FROM $search";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) <= 0)
                    $msg = "Nothing to show here";

                mysqli_close($conn);
                br:
            } else
                $msg = "Nothing to show here";

            if (isset($msg)) {
                echo "<img class='img-fluid mt-5' src='undraw_empty_xct9.svg' alt='Card image'>";
            } else {
                $count = 0;
                echo"<h2>Certificates</h2>";
                while ($row = mysqli_fetch_assoc($result)) {
                    ++$count;
                    $file_path = $row["filepath"];
                    echo "<div class='card' id='$count' onclick='addModal(this)' style='max-width: 300px;'>";
                    echo "<img class='card-img-top img-fluid' src='$file_path' alt='Card image'>";
                    echo "<div class='card-body'>";
                    echo "<h4 class='card-title'>" . $row['name'] . "</h4>";
                    echo "<p class='card-text'>" . $row['description'] . "</p>";
                    echo "<a  class='btn btn-primary stretched-link text-white'  data-toggle='modal' data-target='#myModal'> Open </a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title" id="title"></h1>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body d-inline">
                    <p id="desc"></p>
                    <img class="img-fluid text-center" id="image" src="#">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
</body>



