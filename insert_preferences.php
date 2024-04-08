<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect the user to the login page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["selectedPreferences"])) {
    $selectedPreferences = $_POST["selectedPreferences"];

    // Retrieve student_id from the session (assuming it's stored in the session upon login)
    $student_id = $_SESSION['user']; // Replace with your actual session variable name

    // Perform database connection
    $conn = mysqli_connect("localhost", "root", "", "oas");
    if (!$conn) {
        die("Database Not Found");
    }

    // Prepare the INSERT statement for efficiency and security
    $insert_query = "INSERT INTO student_preferences (student_id, college_id, branch_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);

    foreach ($selectedPreferences as $preference) {
        $collegeId = $preference['collegeId'];
        $branchId = $preference['branchId'];

        // Bind parameters and execute the prepared statement for each selected preference
        mysqli_stmt_bind_param($stmt, "sii", $student_id, $collegeId, $branchId);
        mysqli_stmt_execute($stmt);
    }

    // Close the prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    echo "Data inserted successfully!";
}
?>
