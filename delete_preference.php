<?php
session_start();

// Establish database connection
$con = mysqli_connect("localhost", "root", "", "oas");

// Check if the college_id and branch_id parameters are set in the URL
if (isset($_GET['college_id']) && isset($_GET['branch_id'])) {
    // Sanitize input to prevent SQL injection
    $collegeID = mysqli_real_escape_string($con, $_GET['college_id']);
    $branchID = mysqli_real_escape_string($con, $_GET['branch_id']);

    // Get student ID from session
    $studentID = $_SESSION['user'];

    // Delete the student's preference for the specified college and branch
    $deleteQuery = "DELETE FROM student_preferences 
                    WHERE student_id = '$studentID' 
                    AND college_id = '$collegeID' 
                    AND branch_id = '$branchID'";

    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        // Preference successfully deleted
        //echo "Preference deleted successfully.";
        echo "<script>alert('Preference deleted successfully.');</script>";
        // Redirect back to the previous page or any other desired location
        header("Location: homepageuser2.php");
        exit();
    } else {
        // Error occurred while deleting preference
        echo "Error deleting preference: " . mysqli_error($con);
    }
} else {
    // If college_id or branch_id parameters are not set in the URL
    echo "College ID or Branch ID not specified.";
}
?>
