<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center align contents */
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .action-links {
            text-align: center; /* Center align action links */
        }

        .action-links a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
            padding: 5px 10px; /* Add padding to action links */
            border: 1px solid #007bff; /* Add border to action links */
            border-radius: 5px; /* Add border radius to action links */
        }

        .action-links a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .logout-link {
            float: right;
            margin-top: 20px;
            color: #dc3545;
            text-decoration: none;
        }

        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
        <a class="logout-link" href="logout.php">Logout</a>

        <h3>All Registered Accounts</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
            <?php 
            // Database connection
            $con = mysqli_connect("localhost", "root", "", "root");

            // Check connection
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }

            // Fetch all registered accounts
            $query = "SELECT * FROM user";
            $result = mysqli_query($con, $query);

            // Check if query executed successfully
            if ($result) {
                // Fetch and display results
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td class="action-links">
                            <a href="update.php?name=<?php echo $row['name']; ?>">Update</a>
                            <a href="delete.php?name=<?php echo $row['name']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php }
            } else {
                echo "Error executing query: " . mysqli_error($con);
            }
            
            // Close database connection
            mysqli_close($con);
            ?>
        </table>
    </div>
</body>
</html>
