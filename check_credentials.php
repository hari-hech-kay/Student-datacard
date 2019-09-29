<?php
session_start();
$givenemail = $_POST["emailid"];
$givenpass = $_POST["passw"];

$conn = new mysqli("localhost", "root", "", "student");

if (!$conn) {
    die("Database Connection failed: " . mysqli_connect_error());
}

$sql = "select firstname, lastname, password, sid from users where email = '$givenemail'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);
    $_SESSION["password"] = $row["password"];
    $_SESSION["firstname"] = $row["firstname"];
    $_SESSION["lastname"] = $row["lastname"];
    $_SESSION["sid"] = $row["sid"];

    if ($givenpass !== $_SESSION["password"])
        die("The password you entered is wrong!");

}
else{
    die("No such user exists!");
}
header("Location:user_account.php");
exit();

?>
