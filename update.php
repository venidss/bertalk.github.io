<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['name'])) {
    $con = mysqli_connect("localhost", "root", "", "root");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $name = mysqli_real_escape_string($con, $_GET['name']);

    $query = "SELECT * FROM user WHERE name='$name'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $password = $row['password'];
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "User name not provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "root");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $newName = mysqli_real_escape_string($con, $_POST['newName']);
    $newPassword = mysqli_real_escape_string($con, $_POST['newPassword']);

    $updateQuery = "UPDATE user SET name='$newName', password='$newPassword' WHERE name='$name'";
    if (mysqli_query($con, $updateQuery)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }

    mysqli_close($con);

    header("Location: welcome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 8px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update User: <?php echo htmlspecialchars($name); ?></h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?name=' . $name; ?>">
            <label for="newName">New Name:</label>
            <input type="text" id="newName" name="newName" value="<?php echo htmlspecialchars($name); ?>"><br><br>
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" value="<?php echo htmlspecialchars($password); ?>"><br><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
