<?php
session_start();

// Establishing a connection to the database
$conn = mysqli_connect("localhost", "root", "", "oas");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Dropping and adding the foreign key constraint
$alter_query = "ALTER TABLE t_status
                DROP FOREIGN KEY t_status_ibfk_1";

if (!mysqli_query($conn, $alter_query)) {
    die("Error dropping foreign key constraint: " . mysqli_error($conn));
}

$alter_query = "ALTER TABLE t_status
                ADD CONSTRAINT t_status_ibfk_1 FOREIGN KEY (s_id)
                REFERENCES t_user_data (s_id)
                ON DELETE CASCADE";

if (!mysqli_query($conn, $alter_query)) {
    die("Error adding foreign key constraint: " . mysqli_error($conn));
}

// Verify session variable
if(isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    echo "<p>Session User ID: " . $user_id . "</p>";
    
    // Fetch user data from the t_user_data table based on a user ID
    $user_query = "SELECT * FROM t_user_data WHERE s_id = '$user_id'";
    $result = mysqli_query($conn, $user_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<h1>My Personal Details</h1>";
        echo "<p>User ID: " . $row["s_id"] . "</p>";
        echo "<p>Date of Birth: " . $row["s_dob"] . "</p>";
        echo "<p>Name: " . $row["s_name"] . "</p>";
        echo "<p>Email: " . $row["s_email"] . "</p>";
        echo "<p>Mobile: " . $row["s_mob"] . "</p>";
        echo "<p>Signup Date: " . $row["s_signupdate"] . "</p>";

        // Provide an option to drop from the admission process
        echo "<form method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $row["s_id"] . "'>";
        echo "<input type='submit' name='drop_admission' value='Drop from Admission Process'>";
        echo "</form>";

        // Check if the drop from admission form is submitted
        if (isset($_POST['drop_admission'])) {
            $user_id_to_delete = $_POST['user_id'];
            // Perform deletion from the t_user_data table
            $delete_query = "DELETE FROM t_user_data WHERE s_id = '$user_id_to_delete'";
            if (mysqli_query($conn, $delete_query)) {
                echo "<p>User deleted from the admission process successfully.</p>";
                // Redirect or perform any other action after deletion
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
        }
        // Free the result set
        mysqli_free_result($result);
    } else {
        echo "No user found.";
    }
} else {
    echo "Session user not set.";
}

// Close the database connection
mysqli_close($conn);
?>
