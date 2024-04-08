<?php

$con = mysqli_connect("localhost", "root", "", "oas");
if (!isset($con)) {
    die("Database Not Found");
}

session_start();
error_reporting(0);

// Function to generate student ID
/*function generateExamId($con)
{
    $rs = mysqli_query($con, "SELECT CONCAT('ST', LPAD(RIGHT(IFNULL(MAX(s_student_id), 'ST00000000'), 8) + 1, 8, '0')) FROM t_comedk_application");
    return mysqli_fetch_array($rs)[0];
}*/


function generateExamId($con)
{
    // Retrieve the maximum value for the specific user
    $userId = $_SESSION['user'];
    $query = mysqli_query($con, "SELECT MAX(exam_ID) FROM t_comedk_application WHERE s_student_id = '$userId'");
    $row = mysqli_fetch_array($query);
    $maxId = $row[0];

    // Extract the numeric part of the existing ID
    $numericPart = intval(substr($maxId, 2));

    // Increment the numeric part by 1
    $newNumericPart = $numericPart + 1;

    // Format the new ID by combining 'ST' with the incremented numeric part
    $newExamId = 'ST' . str_pad($newNumericPart, 8, '0', STR_PAD_LEFT);

    return $newExamId;

}


// Function to validate the form data
function validateForm()
{
    $errors = [];

    // Validate applicant name
    if (empty($_REQUEST["applicantName"])) {
        $errors[] = "Applicant Name is required.";
    }

    // Validate date of birth
    if (empty($_REQUEST["dateOfBirth"])) {
        $errors[] = "Date of Birth is required.";
    }

    // Validate unique ID proof type
    if (empty($_REQUEST["uniqueIdProofType"])) {
        $errors[] = "Unique ID Proof Type is required.";
    }

    // Validate unique ID proof number
    if (empty($_REQUEST["uniqueIdProofNumber"])) {
        $errors[] = "Unique ID Proof Number is required.";
    }

    // Validate unique ID proof file upload
    if (empty($_FILES["uniqueIdProofFile"]["name"])) {
        $errors[] = "Upload Unique ID Proof File is required.";
    }

    // Validate mobile number
    if (empty($_REQUEST["mobileNumber"])) {
        $errors[] = "Mobile Number is required.";
    }

    // Validate email
    if (empty($_REQUEST["email"])) {
        $errors[] = "Email is required.";
    }

    return $errors;
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "oas");

if (!$con) {
    die("Database Not Found: " . mysqli_connect_error());
}

// Step 2: Filling COMEDK Application Form 2024
if (isset($_REQUEST["applyPreComedkExam"])) {

        // Check if the user has already applied
        $studentId = $_SESSION['user'];
        $checkAppliedQuery = "SELECT * FROM t_comedk_application WHERE s_student_id = '$studentId'";
        $result = mysqli_query($con, $checkAppliedQuery);
    
        if (mysqli_num_rows($result) > 0) {
            echo '<script>';
            echo 'alert("You have already applied for COMEDK!");';
            echo 'window.location.href = "index.php";'; // Redirect to homepageuser2.php with URL parameter
            echo '</script>';
            exit(); // Stop further execution if already applied
        }
    


    // Validate form data (check if all required fields are filled)
    $validationErrors = validateForm();

    if (!empty($validationErrors)) {
        // Display validation errors
        echo "<h3>Validation Errors:</h3><ul>";
        foreach ($validationErrors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        // Generate student ID
        $examId = generateExamId($con);
        //echo $examId;
        $studentId = $_SESSION['user'];

        // Get file paths for uploaded files
        $uniqueIdProofFile = "uploads/" . basename($_FILES["uniqueIdProofFile"]["name"]);
        $casteFile = "uploads/" . basename($_FILES["casteFile"]["name"]);
        //$boardMarksFiles = "uploads/" . basename($_FILES["boardMarksFiles"]["name"]);
        $photoFile = "uploads/" . basename($_FILES["photoFile"]["name"]);
        $signatureFile = "uploads/" . basename($_FILES["signatureFile"]["name"]);

        // Move uploaded files to the 'uploads' directory
        move_uploaded_file($_FILES["uniqueIdProofFile"]["tmp_name"], $uniqueIdProofFile);
        move_uploaded_file($_FILES["casteFile"]["tmp_name"], $casteFile);
        //move_uploaded_file($_FILES["boardMarksFiles"]["tmp_name"], $boardMarksFiles);
        move_uploaded_file($_FILES["photoFile"]["tmp_name"], $photoFile);
        move_uploaded_file($_FILES["signatureFile"]["tmp_name"], $signatureFile);

        $boardMarksFiles = [];
foreach ($_FILES["boardMarksFiles"]["tmp_name"] as $index => $tmpName) {
    $fileName = "uploads/" . basename($_FILES["boardMarksFiles"]["name"][$index]);
    move_uploaded_file($tmpName, $fileName);
    $boardMarksFiles[] = $fileName;
}
// 
        // Insert form data into the database
        $sql = "INSERT INTO t_comedk_application (s_student_id, s_applicant_name, s_date_of_birth, s_unique_id_proof_type, s_unique_id_proof_number, s_unique_id_proof_file, s_mobile_number, s_email, s_applying_for, s_previous_allotment, s_gender, s_nationality, s_disability, s_father_name, s_mother_name, s_father_number, s_mother_number, s_father_occupation, s_parents_income, s_address, s_state, s_pincode, s_district, s_city, s_caste, s_caste_file, s_board_of_qualifying_exam, s_state_of_qualifying_exam, s_tenth_marks, s_twelfth_marks, s_board_marks_files, s_photo_file, s_signature_file, exam_ID) VALUES ('$studentId', '$_REQUEST[applicantName]', '$_REQUEST[dateOfBirth]', '$_REQUEST[uniqueIdProofType]', '$_REQUEST[uniqueIdProofNumber]', '$uniqueIdProofFile', '$_REQUEST[mobileNumber]', '$_REQUEST[email]', '$_REQUEST[applyingFor]', '$_REQUEST[previousAllotment]', '$_REQUEST[gender]', '$_REQUEST[nationality]', '$_REQUEST[disability]', '$_REQUEST[fatherName]', '$_REQUEST[motherName]', '$_REQUEST[fatherNumber]', '$_REQUEST[motherNumber]', '$_REQUEST[fatherOccupation]', '$_REQUEST[parentsIncome]', '$_REQUEST[address]', '$_REQUEST[state]', '$_REQUEST[pincode]', '$_REQUEST[district]', '$_REQUEST[city]', '$_REQUEST[caste]', '$casteFile', '$_REQUEST[boardOfQualifyingExam]', '$_REQUEST[stateOfQualifyingExam]', '$_REQUEST[tenthMarks]', '$_REQUEST[twelfthMarks]', '$boardMarksFiles', '$photoFile', '$signatureFile','$examId')";
//echo "Generated Exam ID: " . $examId; // Add this line to print the generated Exam ID

        $sql1  = "insert into t_status values(";
        $sql1 .= "'" . $_SESSION['user'] ."',";
        $sql1 .= "'Applied')";
        
         mysqli_query($con, $sql1);

        if (mysqli_query($con, $sql)) {
            echo '<script>';
            echo 'alert("Submission Completed\nYour COMEDK Application has been submitted successfully!\nAdmit Card and further details will be provided soon.");';
            echo 'window.location.href = "index.php";'; // Redirect to homepageuser2.php with URL parameter
            echo '</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        // Add any other messages or actions as needed
        exit();
    }
}
?>


<!-- Add HTML code for the pre-COMEDK exam application form -->
<html>
<head>
    <!-- Add any necessary meta tags, stylesheets, or scripts -->
    <title>Pre-COMEDK Exam Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 align="center">Pre-COMEDK Exam Application Form</h2>
    <form id="preComedkExamForm" action="#" method="post" enctype="multipart/form-data">
        <!-- Step 1: COMEDK UGET Registration 2024 -->
        <h3>Step 1: COMEDK UGET Registration 2024</h3>
        <label for="applicantName">Applicant Name:</label>
        <input type="text" id="applicantName" name="applicantName" required>

        <label for="dateOfBirth">Date of Birth:</label>
        <input type="date" id="dateOfBirth" name="dateOfBirth" required>

        <label for="uniqueIdProofType">Unique ID Proof Type:</label>
        <select id="uniqueIdProofType" name="uniqueIdProofType" required>
            <option value="aadharCard">Aadhar Card</option>
            <option value="panCard">PAN Card</option>
            <option value="passport">Passport</option>
            <!-- Add more options as needed -->
        </select>

        <label for="uniqueIdProofNumber">Unique ID Proof Number:</label>
        <input type="text" id="uniqueIdProofNumber" name="uniqueIdProofNumber" required>

        <label for="uniqueIdProofFile">Upload Unique ID Proof File:</label>
        <input type="file" id="uniqueIdProofFile" name="uniqueIdProofFile" accept=".pdf, .doc, .docx" required>

        <label for="mobileNumber">Mobile Number:</label>
        <input type="tel" id="mobileNumber" name="mobileNumber" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <!-- Step 2: Filling COMEDK Application Form 2024 -->
        <h3>Step 2: Filling COMEDK Application Form 2024</h3>
        <label for="applyingFor">Applying For:</label>
        <select id="applyingFor" name="applyingFor" required>
            <option value="pcm">PCM</option>
            <option value="pcmb">PCMB</option>
            <!-- Add more options as needed -->
        </select>

        <label for="previousAllotment">Have you been allotted a COMEDK seat in the previous year?</label>
        <select id="previousAllotment" name="previousAllotment" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <h3>Personal Details</h3>
        <label for="gender">Gender:</label>
        <input type="radio" id="male" name="gender" value="male" required>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female" required>
        <label for="female">Female</label>

        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" required>

        <label for="disability">Person with Disability:</label>
        <select id="disability" name="disability">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <h3>Parental Details</h3>
        <label for="fatherName">Father's Name:</label>
        <input type="text" id="fatherName" name="fatherName" required>

        <label for="motherName">Mother's Name:</label>
        <input type="text" id="motherName" name="motherName" required>

        <label for="fatherNumber">Father's Contact Number:</label>
        <input type="tel" id="fatherNumber" name="fatherNumber" required>

        <label for="motherNumber">Mother's Contact Number:</label>
        <input type="tel" id="motherNumber" name="motherNumber" required>

        <label for="fatherOccupation">Father's Occupation:</label>
        <input type="text" id="fatherOccupation" name="fatherOccupation" required>

        <label for="parentsIncome">Parents' Income:</label>
        <input type="text" id="parentsIncome" name="parentsIncome" required>

        <h3>Address Details</h3>
        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" cols="50" required></textarea>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" required>

        <label for="pincode">Pincode:</label>
        <input type="text" id="pincode" name="pincode" required>

        <label for="district">District:</label>
        <input type="text" id="district" name="district" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>

        <h3>Category Details</h3>
        <label for="caste">Caste:</label>
        <select id="caste" name="caste" required>
            <option value="general">General</option>
            <option value="obc">OBC</option>
            <option value="sc">SC</option>
            <option value="st">ST</option>
        </select>

        <label for="casteFile">Upload Caste Certificate:</label>
        <input type="file" id="casteFile" name="casteFile" accept=".pdf, .doc, .docx" required>

        <h3>Academic Details</h3>
        <label for="boardOfQualifyingExam">Board of Qualifying Exam:</label>
        <input type="text" id="boardOfQualifyingExam" name="boardOfQualifyingExam" required>

        <label for="stateOfQualifyingExam">State in which you wrote the exam:</label>
        <input type="text" id="stateOfQualifyingExam" name="stateOfQualifyingExam" required>

        <label for="tenthMarks">10th Marks:</label>
        <input type="text" id="tenthMarks" name="tenthMarks" placeholder="Enter 10th Marks" required>

        <label for="twelfthMarks">12th Marks:</label>
        <input type="text" id="twelfthMarks" name="twelfthMarks" placeholder="Enter 12th Marks" required>

        <label for="boardMarksFiles">Upload 10th and 12th Marks Sheets:</label>
        <input type="file" id="boardMarksFiles" name="boardMarksFiles[]" accept=".pdf, .doc, .docx" multiple required>

        <h3>Upload Images</h3>
        <label for="photoFile">Upload Photo of Applicant:</label>
        <input type="file" id="photoFile" name="photoFile" accept="image/*" required>

        <label for="signatureFile">Upload Signature of Applicant:</label>
        <input type="file" id="signatureFile" name="signatureFile" accept="image/*" required>

        <input type="submit" name="applyPreComedkExam" value="Apply for Pre-COMEDK Exam">
    </form>
</body>
</html>



<script src="bootstrap/jquery.min.js"></script>
<script src="jquery/jquery-1.8.3.min.js"></script>
