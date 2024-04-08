<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="coll_pref.css"> <!-- Link to your CSS file -->
    <title>College Preferences</title>
    <style>
        p{
            display:none;
        }
    </style>
</head>
<body>

<?php
//error_reporting(0);
//$getid = $_GET["id"];
$conn = mysqli_connect("localhost", "root", "", "oas");
if (!isset($conn)) {
    die("Database Not Found");
}

session_start();

// Check if the user is logged in (you can adjust this according to your authentication mechanism)
if (!isset($_SESSION['user'])) {
    // Redirect the user to the login page or perform necessary actions
    //echo $_SESSION['user'];
    header("Location: login.php"); // Replace 'login.php' with your login page
    exit(); // Prevent further execution
}

// Fetch colleges and branches from the database
$colleges_query = "SELECT * FROM colleges WHERE seats_left > 0";
$colleges_result = $conn->query($colleges_query);

if (!$colleges_result) {
    die("Error fetching colleges: " . $conn->error);
}

$branches_query = "SELECT * FROM branches";
$branches_result = $conn->query($branches_query);

if (!$branches_result) {
    die("Error fetching branches: " . $conn->error);
}


?>

<div style="display: flex;">
<div style="width: 50%;">
    <h2>Selected Colleges</h2>
    <div class="selected-colleges">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["college_preferences"])) {
            echo "<ul>";
            foreach ($_POST["college_preferences"] as $selected_college) {
                $selected_college_query = "SELECT college_name FROM colleges WHERE college_id = $selected_college";
                $selected_college_result = $conn->query($selected_college_query);
                $college_name = $selected_college_result->fetch_assoc()["college_name"];
                echo "<li>$college_name</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No colleges selected yet.</p>";
        }
        ?>
        <p id="output1"></p>
    </div>
</div>

    <div style="width: 50%;">
        <h2>College Preferences</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php
            // Loop through colleges to display checkboxes
            while ($college = $colleges_result->fetch_assoc()) {
                $college_id = $college["college_id"];
                echo '<div>';
                echo '<h3>' . $college["college_name"] . '</h3>';
                
                $college_branches_query = "SELECT * FROM branches WHERE college_id = $college_id";
                $college_branches_result = $conn->query($college_branches_query);

                while ($branch = $college_branches_result->fetch_assoc()) {
                    echo '<label "><input type="checkbox" class="branch-checkbox" onclick="checkMe(this)"  data-collegeid="' . $college_id . '" name="branch_preferences[' . $college_id . '][]" value="' . $branch["branch_id"] . '"> ' . $branch["branch_name"]  . '</label><br>';
                }
                
                echo '</div>';
            }
            ?>
            <input type="submit" value="Submit Preferences">
        </form>
    </div>
</div>
<p id="output1" style="display:none"></p>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let selectedPreferences = [];

    function checkMe(checkbox) {
        var collegeName = $(checkbox).closest('div').find('h3').text().trim(); // Get the college name
        var collegeId = $(checkbox).attr("data-collegeid"); // Get the college ID
        var outp1 = document.getElementById("output1");

        if (checkbox.checked) {
            var branchId = checkbox.value;
            var branchName = $(checkbox).parent().text().trim(); // Get the branch name associated with the checkbox

            // Store the selected college and branch in the array
            selectedPreferences.push({
                collegeId: collegeId,
                collegeName: collegeName,
                branchId: branchId,
                branchName: branchName
            });

            // Display selected preferences in the output paragraph
            outp1.style.display = "block";
            outp1.innerHTML += collegeName + " - " + branchName + "<br>";
        } else {
            // Remove the unchecked college from the array
            selectedPreferences = selectedPreferences.filter(item => !(item.collegeId == collegeId && item.branchId == checkbox.value));
            // Update the display in the output paragraph
            outp1.innerHTML = selectedPreferences.map(item => item.collegeName + " - " + item.branchName).join("<br>");
            if (selectedPreferences.length === 0) {
                outp1.style.display = "none";
            }
        }
    }

    $('form').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: 'POST',
            url: 'insert_preferences.php', // Replace with the file to handle the insertion
            data: { selectedPreferences: selectedPreferences }, // Send the selected preferences array
            success: function (response) {
                console.log(response);

                // Redirect to homepageuser2.php on successful submission
                window.location.href = 'homepageuser2.php';
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });
</script>
</body>
</html>