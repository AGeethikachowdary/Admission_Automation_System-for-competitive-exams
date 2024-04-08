<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMEDK Application Form</title>
</head>
<body>
    
    <?php
    session_start();
    error_reporting(0);

    $conn = mysqli_connect("localhost", "root", "", "oas");
    if (!$conn) {
        die("Database Not Found");
    }
    $student_id = $_SESSION['user'];

    // Check if the user already has a rank
    $checkRankQuery = "SELECT rank FROM student_scores WHERE student_id = '$student_id'";
    $result = $conn->query($checkRankQuery);
    if ($result && $result->num_rows > 0) {
        // User already has a rank
        $_SESSION['rank_exists'] = true; // Set session variable to indicate rank exists
        echo '<script type="text/javascript">
            alert("You already have a rank.");
          </script>';
        // Redirect to homepageuser2.php
        header("Location: homepageuser2.php");
        exit();
    }
    function calculateCOMEDKRank($physics, $chemistry, $maths) {
        // Calculation logic for COMEDK rank based on provided scores
        // Modify the logic as needed
        $rawScore = $physics + $chemistry + $maths;
        $comedkScore = $rawScore; // For simplicity, using raw score as COMEDK score
        return $comedkScore;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $student_id = $_POST["student_id"];
        $marks_in_physics = $_POST["marks_in_physics"];
        $marks_in_chemistry = $_POST["marks_in_chemistry"];
        $marks_in_maths = $_POST["marks_in_maths"];

        $comedk_rank = calculateCOMEDKRank($marks_in_physics, $marks_in_chemistry, $marks_in_maths);

        // Insert new student's information with rank
        $insertNewStudent = "INSERT INTO student_scores (student_Name, student_id, marks_in_physics, marks_in_chemistry, marks_in_maths, comedk_score) VALUES ('$name', '$student_id', '$marks_in_physics', '$marks_in_chemistry', '$marks_in_maths', '$comedk_rank')";
        if ($conn->query($insertNewStudent) === TRUE) {
            //echo "New student's information and rank inserted successfully. <br>";

            // Calculate ranks for all students after insertion
            $rankQuery = "SET @rank=0; UPDATE student_scores SET rank = @rank:=@rank+1 ORDER BY comedk_score DESC";
            if ($conn->multi_query($rankQuery) === TRUE) {
                //echo "Ranks updated for all students. <br>";
            ?>
                <script type="text/javascript">
                    alert("Ranks updated for all students.");
                    window.location = "homepageuser2.php";
                </script>
            <?php            
            } else {
            
                //echo "Error updating ranks for all students: " . $conn->error;
                ?>
                <script type="text/javascript">
                    alert("Error updating ranks for all students: <?php echo $conn->error; ?>");
                    window.location = "homepageuser2.php";
                </script>
                <?php
            }
        } else {
            //echo "Error inserting new student's information: " . $conn->error;
            ?>
            <script type="text/javascript">
                alert("Error inserting new student's information: <?php echo $conn->error; ?>");
                window.location = "homepageuser2.php";
            </script>
            <?php
        }

        $conn->close();
    }
    ?>

    <h3>Enter Your Details</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" required><br>

        <label for="marks_in_physics">Marks in Physics:</label>
        <input type="number" name="marks_in_physics" required><br>

        <label for="marks_in_chemistry">Marks in Chemistry:</label>
        <input type="number" name="marks_in_chemistry" required><br>

        <label for="marks_in_maths">Marks in Maths:</label>
        <input type="number" name="marks_in_maths" required><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
