<?php
    session_start();

        $certificate_name = $_POST["certificate_name"];
        $description = $_POST["desc"];
        $sid = $_SESSION["sid"];
        $target_dir = "uploads/" . $sid . "/";
        $filename = basename($_FILES["files"]["name"]);
        $target_file = $target_dir . $filename;

        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists";
            goto br;
        }
        if ( ! is_dir($target_dir)) {
            mkdir($target_dir,0777, true);
        }


        $conn = new mysqli("localhost", "root", "", "student");

        if (!$conn) {
            $msg = "Database Connection failed: " . mysqli_connect_error();
            goto br;
        }
        $tablename = $sid;
        $sql = "create table if not exists $tablename(name varchar(25), description varchar(100), filepath varchar(30))";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $msg = "Database modification error! " . mysqli_error($conn);
            goto br;
        }

        if (move_uploaded_file($_FILES["files"]["tmp_name"], $target_file)) {
        } else {
            $msg = "Unable to save your file in server";
            goto br;
        }
        $sql = "insert into $tablename values('$certificate_name', '$description', '$target_file' )";

        if (!mysqli_query($conn, $sql)) {
            $msg = "A problem occurred while updating records";
            goto br;
        }
        mysqli_close($conn);
br:

/*else{
    $msg = "Some errors occurred while uploading your file";
    goto br;
}*/

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Success</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: Roboto;
            margin: 0;
            padding: 32px;
        }
        h1{
            text-align: center;
        }
        div{
            margin: auto;
            width: 400px;
            text-align: center;
        }
        button{
            font-family: Roboto;
            padding: 15px 25px;
            display: inline-block;
            background: blueviolet;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            opacity: 0.8;
        }

    </style>
</head>
<body style="font-family: Roboto">
<h1 style="font-weight: normal"><?php if(!isset($msg)) {echo $certificate_name. " Uploaded Successfully";} else echo "Upload Failed"?> </h1>
<div>
    <img src="<?php if(!isset($msg)) echo 'undraw_confirmation_2uy0.svg'; else echo 'undraw_cancel_u1it.svg'; ?> " width="400px" height="400px"><br>
    <p> <?php if(isset($msg)){ echo $msg;} ?> </p>
    <a href="user_account.php"> <button>Continue to my account</button></a>
</div>
</body>
</html>
