<?php
// Initialize notification message
$notification = "";

// Check if the name is provided in the URL
if (isset($_GET['name'])) {
    // Establish connection to the database
    $con = mysqli_connect("localhost", "root", "", "root");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Sanitize user input to prevent SQL Injection
    $name = mysqli_real_escape_string($con, $_GET['name']);

    // Delete user from the database
    $query = "DELETE FROM user WHERE name='$name'";
    if (mysqli_query($con, $query)) {
        $notification = "Record deleted successfully";
    } else {
        $notification = "Error deleting record: " . mysqli_error($con);
    }

    // Close database connection
    mysqli_close($con);
}

// Redirect to dashboard page after deletion
header("Location: welcome.php?notification=" . urlencode($notification));
exit();
?>

<script>
    // Display alert based on the notification
    <?php if ($notification !== "") { ?>
        alert("<?php echo $notification; ?>");
    <?php } ?>
</script>
