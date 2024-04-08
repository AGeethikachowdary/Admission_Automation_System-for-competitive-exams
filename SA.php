<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the current round
$current_round = 1; // Set the initial round
$max_rounds = 3;    // Set the maximum number of rounds

do {
    // Fetch the top-ranked student who hasn't confirmed a seat yet
    $unconfirmed_sql = "SELECT student_id, rank FROM student_scores WHERE confirmed_seat = 0 ORDER BY rank ASC LIMIT 1";
    $unconfirmed_result = $conn->query($unconfirmed_sql);

    if ($unconfirmed_result->num_rows > 0) {
        $unconfirmed_row = $unconfirmed_result->fetch_assoc();
        $student_id = $unconfirmed_row["student_id"];
        $student_rank = $unconfirmed_row["rank"];
        //echo $student_rank;
        // Fetch any preference for the student from the student_preferences table
        $preference_sql = "SELECT college_id, branch_id FROM student_preferences WHERE student_id = '$student_id' LIMIT 1";
        $preference_result = $conn->query($preference_sql);

        if ($preference_result->num_rows > 0) {
            $preference_row = $preference_result->fetch_assoc();
            $selected_college = $preference_row["college_id"];
            $selected_branch = $preference_row["branch_id"];

            // Check if the selected college and branch are eligible based on the student's rank
            $eligible_sql = "SELECT c.college_id, c.college_name, b.branch_name FROM colleges c
                JOIN branches b ON c.college_id = b.college_id
                WHERE c.college_id = '$selected_college' AND b.branch_id = '$selected_branch'
                AND c.cutoff >= $student_rank AND c.seats_left > 0";
            //echo "Debug SQL: $eligible_sql";
            $eligible_result = $conn->query($eligible_sql);

            if ($eligible_result->num_rows > 0) {
                echo "Round: $current_round\n";
                echo "Student ID: $student_id, Rank: $student_rank\n";
                echo "You are eligible for the following college and branch:\n";

                $eligible_row = $eligible_result->fetch_assoc();
                $college_id = $eligible_row["college_id"];
                $college_name = $eligible_row["college_name"];
                $branch_name = $eligible_row["branch_name"];

                echo "$college_id - $college_name, $branch_name\n";

                // Provide options for the student to confirm the seat
                // You can add HTML form elements here for confirmation
                echo "Please confirm your seat 
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                            <label for='confirmSeat'>Confirm Seat:</label>
                            <input type='submit' name='confirmSeat' value='Confirm'>
                        </form>\n";

                // Assuming the form submits to this PHP file
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Update the database with the confirmed college and branch, and decrease the seats_left
                    $update_sql = "UPDATE colleges SET seats_left = seats_left - 1 WHERE college_id = '$selected_college'";
                    $conn->query($update_sql);

                    // Mark the student as having a confirmed seat
                    $confirm_student_sql = "UPDATE student_scores SET confirmed_seat = 1 WHERE student_id = '$student_id'";
                    $conn->query($confirm_student_sql);

                    echo "Congratulations! You have confirmed your seat at College $selected_college, Branch $selected_branch.\n";
                }
            } else {
                echo "Sorry, the selected college and branch are not eligible based on your rank or all available seats are filled.\n";
            }
        } else {
            echo "No preferences found for the student.\n";
        }
    } else {
        echo "All students have confirmed their seats.\n";
        break;  // Exit the loop if all students have confirmed seats
    }

    // Increment the round
    $current_round++;

    // If the maximum number of rounds is reached, exit the loop
} while ($current_round <= $max_rounds);

// If a student didn't confirm the seat after the maximum rounds, revert back to college preferences
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmSeat"])) {
    // Check if the student confirmed the seat
    // If confirmed, you can provide a success message
    echo "Congratulations!.\n";
} else {
    // Revert back to college preferences
    $delete_preferences_sql = "DELETE FROM student_preferences";
    $conn->query($delete_preferences_sql);
    echo "All students have completed $max_rounds rounds without confirming a seat. Reverted back to college preferences.\n";
}

$conn->close();
?>