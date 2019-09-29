<?php
session_start();
if (!isset($_SESSION["firstname"]) && !isset($_SESSION["lastname"])) {
    header("Location:login_form.html");
    die();
}

$conn = new mysqli("localhost", "root", "", "student");

if (!$conn) {
    $msg = "Database Connection failed: " . mysqli_connect_error();
    goto br;
}
$tablename = $_SESSION["sid"];

if(mysqli_query($conn,"DESCRIBE $tablename")) {
    $sql = "SELECT name, description, filepath FROM $tablename";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) <= 0)
        $msg = "Nothing to show here";

    mysqli_close($conn);
    br:
}
else
    $msg = "Nothing to show here";

?>

<html lang="en">
<head>
    <title>Welcome</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
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
<body style="margin: 0; background: rgba(159,44,255,0.09); font-family:  Roboto ;">

<header class="header-container">

    <div class="header">
        <a href="#" class="brand"><?php echo "{$_SESSION["firstname"]}'s Dashboard ({$_SESSION["sid"]})"; ?></a>
    </div>
    <nav class="header">
        <ul>
            <li><a  href="add_certificate.html"><span class="material-icons">library_add</span> Add a certificate</a></li>
            <li><a href="logout.php"><span class="material-icons">input</span> Logout</a></li>
        </ul>
    </nav>

</header>

    <div class="row" style="margin: 32px 32px;">
            <h2>My Certificates</h2>

            <div class="card-columns">

                        <?php
                        if(isset($msg)){
                            echo"<img class='img-fluid' src='undraw_empty_xct9.svg' alt='Card image'>";
                            echo"<p>$msg</p>";
                        }
                        else {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ++$count;
                                $file_path = $row["filepath"] ;
                                echo "<div class='card' id='$count' onclick='addModal(this)' style='max-width: 300px;'>";
                                echo "<img class='card-img-top img-fluid' src='$file_path' alt='Card image'>";
                                echo "<div class='card-body'>";
                                echo "<h4 class='card-title'>".$row['name']."</h4>";
                                echo "<p class='card-text'>".$row['description']."</p>";
                                echo "<a  class='btn btn-primary stretched-link text-white'  data-toggle='modal' data-target='#myModal'> Open </a>";
                                echo "</div>";
                                echo "</div>";
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
</html>