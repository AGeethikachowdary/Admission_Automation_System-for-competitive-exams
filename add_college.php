<!DOCTYPE html>
<html>
<head>
    <title>Add College</title>
</head>
<body>
    <h2>Add College</h2>
    <form action="add_college.php" method="post">
        <label for="college_id">College Id:</label>
        <input type="text" id="college_id" name="college_id" required><br><br>

        <label for="college_name">College Name:</label>
        <input type="text" id="college_name" name="college_name" required><br><br>
        
        <label for="college_details">College Details:</label>
        <input type="text" id="college_details" name="college_details" required><br><br>
        
        <label for="cutoff">Cutoff:</label>
        <input type="number" id="cutoff" name="cutoff" required><br><br>
        
        <label for="seats_left">Seats Left:</label>
        <input type="number" id="seats_left" name="seats_left" required><br><br>

        <h3>Add Branch</h3>
        <label for="branch_id">Branch Id:</label>
        <input type="text" id="branch_id" name="branch_id" required><br><br>

        <label for="branch_name">Branch Name:</label>
        <input type="text" id="branch_name" name="branch_name" required><br><br>
        
        <label for="seats_in_branch">Seats in Branch:</label>
        <input type="number" id="seats_in_branch" name="seats_in_branch" required><br><br>
        
        <label for="available_seats">Available Seats:</label>
        <input type="number" id="available_seats" name="available_seats" required><br><br>
        
        <input type="submit" value="Add College" name="add_college">
    </form>
</body>
</html>


<?php
if (isset($_POST['add_college'])) {
    $college_id = $_POST['college_id'];
    $college_name = $_POST['college_name'];
    $college_details = $_POST['college_details'];
    $cutoff = $_POST['cutoff'];
    $seats_left = $_POST['seats_left'];
    $branch_id = $_POST['branch_id'];
    $branch_name = $_POST['branch_name'];
    $seats_in_branch = $_POST['seats_in_branch'];
    $available_seats = $_POST['available_seats'];

    $con = mysqli_connect("localhost", "root", "", "oas");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_autocommit($con, false);

    $success = true;

    $insertCollegeQuery = "INSERT INTO colleges (college_id, college_name, college_details, cutoff, seats_left) VALUES ('$college_id', '$college_name', '$college_details', '$cutoff', '$seats_left')";

    if (!mysqli_query($con, $insertCollegeQuery)) {
        $success = false;
    }

    $insertBranchQuery = "INSERT INTO branches (branch_id, college_id, branch_name, seats_in_branch, available_seats) VALUES ('$branch_id', '$college_id', '$branch_name', '$seats_in_branch', '$available_seats')";

    if (!mysqli_query($con, $insertBranchQuery)) {
        $success = false;
    }

    if ($success) {
        mysqli_commit($con);
        echo "New college and branch added successfully";
    } else {
        mysqli_rollback($con);
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
