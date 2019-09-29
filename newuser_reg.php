<?php
session_start();
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$pass = $_POST["pass"];
$dob = $_POST["dob"];
$gender = $_POST["Gender"];
$mobile = $_POST["mobile"];
$pincode = $_POST["pincode"];

if ($gender == "Male") $gender = 1;
else $gender = 0;
$sid = 's'.mt_rand(1011,9999);

$conn = new mysqli("localhost", "root", "", "student");

if (!$conn) {
    die("Database Connection failed: " . mysqli_connect_error());
}

$sql = "select * from users where email = '$email'";
$result = mysqli_query($conn, $sql);
if($result) {
    if (mysqli_num_rows($result) > 0) $msg = "User already exists. Try with another email";
}
else {
    $sql = "insert into users values('$firstname', '$lastname', '$email', '$pass', '$dob', $mobile, $pincode, $gender, $sid)";
    if (!mysqli_query($conn, $sql)) {
        $msg = "Couldn't create your account. Try again";
    }

    $_SESSION["password"] = $pass;
    $_SESSION["firstname"] = $firstname;
    $_SESSION["lastname"] = $lastname;
    $_SESSION["sid"] = $sid;
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Success</title>
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
<body>
<h1><?php if (isset($msg)) echo 'Registration Failed'; else echo'Registration Success'; ?></h1>
<div>
    <img src="<?php if (isset($msg)) echo 'undraw_High_five_u364.svg'; else echo'undraw_cancel_u1it.svg'; ?>" width="400px" height="400px"><br>
    <p><?php if (isset($msg)) echo $msg; ?></p>
    <a href="<?php if (isset($msg)) echo 'registration.html'; else echo'user_account.php'; ?>"> <button><?php if (isset($msg)) echo "Retry"; else echo"Continue to my account"; ?></button></a>
</div>
</body>
</html>