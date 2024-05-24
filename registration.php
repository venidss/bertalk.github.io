<?php
$con = mysqli_connect("localhost", "root", "", "root");

$name = $_POST['name'];
$password = $_POST['password'];

mysqli_query($con, "INSERT INTO user VALUES ('$name', '$password')");
?>

<script>
    alert("New User Appended!");
    windows.location = "login.php";
</script>
