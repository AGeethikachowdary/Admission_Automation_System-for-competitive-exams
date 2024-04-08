<?php

session_start();
//error_reporting(0);

$con=mysqli_connect("localhost","root","","oas");
$q=mysqli_query($con,"select s_name from t_user_data where s_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['s_name'];
$id=$_SESSION['user'];

//echo $id;
//$sta=mysqli_query($con,"select s_stat from t_status where s_id='".$_SESSION['user']."'");
//$stat=  mysqli_fetch_assoc($sta);
//$stval= $stat['s_stat'];
/*
$result = mysqli_query($con,"SELECT * FROM t_user WHERE s_id='".$_SESSION['user']."'");
                    
                    while($row = mysqli_fetch_array($result))
                      {*/
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
         <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
       <script src="bootstrap/jquery.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
        <link type="text/css" rel="stylesheet" href="css/admform.css"></link>
       
    </head>
    <body style="background-image:url(./images/inbg.jpg) ">
        
        <?php  
            include 'usersession.php';
        ?>
      <form id="admin" action="admin.php" method="post">
            <div class="container-fluid">    
                <div class="row">
                  <div class="col-sm-12">
                        <img src="images/cutm.jpg" width="100%" style="box-shadow: 0px 5px 5px #999999; "></img>
                  </div>
                 </div>    
             </div>
          
            <div class="container-fluid" id="dmid">    
                <div class="row">
                  <div class="col-sm-12">
                  <center>     <font style="color:white; font-family: Verdana; width:100%; font-size:20px;">
                <b>My Profile</b> </font></center>
                  </div>
                 </div>    
             </div>
          
             <div class="container">
             <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="My_Personal_details.php">Personal Details</a>
                </li>
                <li><a data-toggle="tab" href="#myapp">Exam Application Details</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="rank_generate.php">Check Rank</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#rankDisp">Display Rank</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="college_pref.php">College Preference</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#managePref">Manage Preference</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="SA.php">Seat Allocated</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admsnform.php">Admission Form</a>
                </li>
                <li><a data-toggle="tab" href="#admissiondetails">Admission Details</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            
<div class="tab-content">
    <div id="myapp" class="tab-pane fade in active">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">        
                <center>
                    <table class="table table-bordered" style="font-family: Verdana">
                    <td style="width:3%;"><img src="./images/Logo-T.jpg" width="50%"> </td>
                    <td style="width:8%;"><center><font style="font-family:Arial Black; font-size:20px;"></font></center>
                
                <center><font style="font-family:Verdana; font-size:18px;">
                   
                </font></center>
                
                <br>
                <br>
                <center><font style="font-family:Arial Black; font-size:20px;">
                    Exam application details
                </font></center>
                </td>
                    <?php
                        //echo $_SESSION['user'];
                        $resdata = mysqli_query($con,"SELECT * FROM t_comedk_application WHERE s_student_id='".$_SESSION['user']."'");                    
                        while ($rowdata = mysqli_fetch_array($resdata)) {        
                    ?>
                            <!-- Applicant Information -->
                            <tr>
                                <td><font style="font-family: Verdana;">Applicant ID:</font></td>
                                <td colspan="3"><?php echo $rowdata['exam_ID']; ?></td>
                            </tr>
                            <tr>
                                <td><font style="font-family: Verdana;">Applicant Name:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_applicant_name']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">Date of Birth:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_date_of_birth']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">Email:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_email']; ?></td>
                            </tr>

                            <!-- Unique ID Proof Information -->
                            <tr>
                                <td><font style="font-family: Verdana;">ID Proof Type:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_unique_id_proof_type']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">ID Proof Number:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_unique_id_proof_number']; ?></td>
                            </tr>

                            <!-- Mobile and Gender Information -->
                            <tr>
                                <td><font style="font-family: Verdana;">Mobile Number:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_mobile_number']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">Gender:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_gender']; ?></td>
                            </tr>

                            <!-- Parent Information -->
                            <tr>
                                <td><font style="font-family: Verdana;">Father's Name:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_father_name']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">Mother's Name:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_mother_name']; ?></td>
                            </tr>

                            <!-- Address Information -->
                            <tr>
                                <td><font style="font-family: Verdana;">Address:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_address']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">State:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_state']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">Pincode:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_pincode']; ?></td>
                            </tr>

                            <!-- Qualifying Exam Information -->
                            <tr>
                                <td><font style="font-family: Verdana;">Board of Qualifying Exam:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_board_of_qualifying_exam']; ?></td>
                            </tr>

                            <tr>
                                <td><font style="font-family: Verdana;">State of Qualifying Exam:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_state_of_qualifying_exam']; ?></td>
                            </tr>

                            <!-- Academic Qualification -->
                            <tr>
                                <td colspan="7">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><font style="font-family: Verdana;font-size: small">Exam Passed</font></th>
                                                <th><font style="font-family: Verdana;font-size: small">Board/University</font></th>
                                                <th><font style="font-family: Verdana;font-size: small">Year of Passing</font></th>
                                                <th><font style="font-family: Verdana;font-size: small">Total Marks</font></th>
                                                <th><font style="font-family: Verdana;font-size: small">Marks Obtained</font></th>
                                                <th><font style="font-family: Verdana;font-size: small">Division</font></th>
                                                <th><font style="font-family: Verdana;font-size: small">% Marks</font></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo "10th"; ?></td>
                                                <td><?php echo $rowdata['s_tenth_marks']; ?></td>
                                                <!-- Continue adding columns for other attributes as needed -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <!-- Other details -->
                            <tr>
                                <td><font style="font-family: Verdana;">Nationality:</font></td>
                                <td><?php echo $rowdata['s_nationality']; ?></td>
                                <td><font style="font-family: Verdana;">Caste:</font></td>
                                <td colspan="3"><?php echo $rowdata['s_caste']; ?></td>
                            </tr>

                            <!-- Add more rows for other attributes as needed -->

                        <?php
                        }
                        ?>
                    </table>
                </center>
            </div>
        </div>
    </div>
</div>
    
    
    
<div id="admissiondetails" class="tab-pane fade in active">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            <center>  <table class="table table-bordered" style="font-family: Verdana">  
                <tr>
                 <td style="width:3%;"><img src="./images/Logo-T.jpg" width="50%"> </td>
                 <td style="width:8%;"><center><font style="font-family:Arial Black; font-size:20px;"></font></center>
                
                <center><font style="font-family:Verdana; font-size:18px;"></font></center> 
                <br>
                <br>
                <center><font style="font-family:Arial Black; font-size:20px;">
                    College admission application details
                </font></center>
                </td>
                <td colspan="2" width="3%" >
                   <?php  
                    $result1 = mysqli_query($con,"SELECT * FROM t_user where s_id='".$_SESSION['user']."'");
                    while($rowdata = mysqli_fetch_array($resdata))
                      {
                   ?>
                </td>
                 </tr>       
                 
                 <tr>
                 <td style="width:4%;"> <font style="font-family: Verdana;">Name : </font> </td>
                    <td style="width:8%;" colspan="3"> <?php echo $stname;?> </td>
                 </tr>
                 
                 
                <tr>
                    <td> <font style="font-family: Verdana;">ID : </font> </td>
                    <td colspan="3"> <?php echo $id ?> </td>
                </tr>
                
                <tr>
                    <td> <font style="font-family: Verdana;">Date of Birth : </font> </td>
                    <td colspan="3"> <?php echo $rowdata[2] ?> </td>
                </tr>
                
                <tr>
                    <td> <font style="font-family: Verdana;">Email : </font> </td>
                      <td colspan="3"> <?php echo $rowdata[4]  ?> </td>
                </tr>
                  <?php
                      }
                      ?>
                  <tr>
                    <td > <font style="font-family: Verdana;"> Mobile No.</font>  </td>
                    <td colspan="3"> <?php echo 'Telephone - '. $row[2]. '   ' ?><br>
                    <?php echo ' Mobile - '.$row[3] ?></td>
                  </tr>
                
                  <tr>
                    <td><font style="font-family: Verdana;"> Father's Name</font></td>
                    <td  colspan="3"><?php echo $row[4] ?> </td>
                   </tr>
                 
                  <tr>
                    <td> <font style="font-family: Verdana;">Father's Occupation</font></td>
                    <td> <?php echo $row[5] ?></td>
                    <td><font style="font-family: Verdana;"> Mobile No.</font></td>
                    <td> <?php echo $row[6] ?> </td>
                  </tr>
                
                <tr>
                    <td> <font style="font-family: Verdana;">Mother's Name</font> </td>
                    <td colspan="3"> <?php echo $row[7] ?></td>
                </tr>
                
                <tr>
                    <td> <font style="font-family: Verdana;">Mother's Occupation</font></td>
                    <td> <?php echo $row[8] ?> </td>
                     <td> <font style="font-family: Verdana;">Mobile No.</font></td>
                    <td> <?php echo $row[9] ?></td>
                </tr>
                
                <tr>
                    <td><font style="font-family: Verdana;"> Income of Parents </font>
                     <td  colspan="3"><?php echo $row[10] ?></td>
                </tr>
                
                <tr>
                    <td> <font style="font-family: Verdana;">Sex </font>
                    <td colspan="3"><?php echo $row[11] ?></td>       
                    
                </tr>
                
                <tr>
                    <td><font style="font-family: Verdana;"> Correspondent Address</font>
                    <td colspan="3"><?php echo 'Address :'. $row[12] ?><br>
                          <?php echo 'State :'. $row[13] ?><br>
                          <?php echo 'Pin :'. $row[14] ?><br>
                          <?php echo 'Mobile :'. $row[15] ?><br>
                </td>
                
                <tr>
                    <td> <font style="font-family: Verdana;">Permanent Address</font>
                    <td colspan="3"><?php echo 'Address :'. $row[16] ?><br>
                          <?php echo 'State :'. $row[17] ?><br>
                          <?php echo 'Pin :'. $row[18] ?><br>
                          <?php echo 'Mobile :'. $row[19] ?><br>
                </td>
                </tr>   
               
                <tr>
                    <td> <font style="font-family: Verdana;">From</font>
                    <td colspan="3">  <?php echo  $row[20] ?>
                </td>
                </tr>  
                                
                <tr>
                    <td><font style="font-family: Verdana;"> Nationality</font>
                    <td> <?php echo $row[21] ?></td>
                    <td><font style="font-family: Verdana;"> Religion</font>
                    <td> <?php echo $row[22] ?></td>
                </tr>    
               
                <tr>
                    <td> <font style="font-family: Verdana;">Category</font>
                    <td colspan="3">  <?php echo $row[23] ?>
                </td>
                </tr> 
                  
                 
                 <tr>
                    <td><font style="font-family: Verdana;">Exam Appeared</font></td>
                    <td><?php echo $row[24] ?>
                            
                    </td>
                    <td><font style="font-family: Verdana;">Rank</font></td>
                    <td><?php echo $row[25] ?></td>
               </tr>  
               
               <tr>
                    <td><font style="font-family: Verdana;">Roll No.</font></td>
                    <td><?php echo $row[26] ?></td>
                    <td><font style="font-family: Verdana;">Alloted Branch</font></td>
                    <td><?php echo $row[27] ?></td>
               </tr>  
               
               
               <tr>
                    <td><font style="font-family: Verdana;">Choice of Branch</font></td>
                    <td colspan="3"><?php echo $row[28] ?>
                     </td>
               </tr>
               <tr>
                     <td><font style="font-family: Verdana;">College Name</font></td>
                     <td colspan="3"><?php echo $row[29] ?>
                     </td>
                     
                </tr>
              
                <tr>
                     <td><font style="font-family: Verdana;">Center for exam</font></td>
                     <td colspan="3"><?php echo $row[30] ?>
                     </td>
                     
                </tr>
                
                <tr>
                     <td><font style="font-family: Verdana;">Course Type</font></td>
                     <td colspan="3"><?php echo $row[31] ?>
                     </td>
                     
                </tr>
                
                
                <tr>
                     <td><font style="font-family: Verdana;">% in PCM</font></td>
                     <td colspan="3"><?php echo $row[32] ?></td>
                     
                </tr>
                
                
               <tr>
                   <td><font style="font-family: Verdana;">Academic Qualification</font></td>
                   <td colspan="3">
                       <table class="table table-hover">
                           <thead>
                               <tr>
                                    <th><font style="font-family: Verdana;font-size: small">Exam</font> <br><font style="font-family: Verdana; font-size: small">passed</font></th>
                                    <th><font style="font-family: Verdana;font-size: small">Name of</font> <br><font style="font-family: Verdana;font-size: small">Board/University</font></th>
                                    <th><font style="font-family: Verdana;font-size: small">Year of</font> <br><font style="font-family: Verdana;font-size: small"> Passing</font></th>
                                    <th><font style="font-family: Verdana;font-size: small">Total</font><br><font style="font-family: Verdana;font-size: small"> Mark</font></th>
                                    <th><font style="font-family: Verdana;font-size: small">Mark</font> <br><font style="font-family: Verdana;font-size: small">Obtained</font></th>
                                    <th><font style="font-family: Verdana;font-size: small">Division</font></th>
                                    <th><font style="font-family: Verdana;font-size: small">% of</font><br><font style="font-family: Verdana;font-size: small"> Marks</font></th>
                              </tr>   
                           </thead>
                            <tbody>
                           <tr>
                               <td><?php echo "10th"; ?></td>
                               <td><?php echo $row[33] ?></td>
                               <td><?php echo $row[34] ?></td>
                               <td><?php echo $row[35] ?></td>
                               <td><?php echo $row[36] ?></td>
                               <td><?php echo $row[37] ?></td>
                               <td><?php echo $row[38] ?></td>
                               
                           </tr>
                           <tr>
                               <td><?php echo "12th/Diploma"; ?> </td>
                               <td><?php echo $row[39] ?></td>
                               <td><?php echo $row[40] ?></td>
                               <td><?php echo $row[41] ?></td>
                               <td><?php echo $row[42] ?></td>
                               <td><?php echo $row[43] ?></td>
                               <td><?php echo $row[44] ?></td>
                           </tr>
                           
                            </tbody>
                       </table>
                       
                           <tr>
                               <td><font style="font-family: Verdana;">Medium of Instruction till class 10th</font></td>
                               
                                    <td colspan="3"><?php echo $row[45] ?></td>
                               
                           </tr>
                           
                           
                           <tr>
                               <td><font style="font-family: Verdana;">Mode of Payment</font></td>
                               
                               <td colspan="3"><?php echo $row[46] ?></td>
                               
                           </tr>
                 
                       </table></center>
                               </div>
                            </div>
            </div>
    
</div>

                 
                 
<div id="rankDisp" class="tab-pane fade in active">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            <center>  <table class="table table-bordered" style="font-family: Verdana">
            <tr>
                <td style="width:3%;"><img src="./images/Logo-T.jpg" width="50%"> </td>
                <td style="width:8%;"><center><font style="font-family:Arial Black; font-size:20px;"></font></center>
                    <center><font style="font-family:Verdana; font-size:18px;"> </font></center>
                    <br>
                    <br>
                    <center><font style="font-family:Arial Black; font-size:20px;">
                        Your Rank
                    </font></center>
                <!--</td>-->
            <td colspan="2" width="3%" >
            <?php
                //$rank = mysqli_query($con,"SELECT * FROM student_scores where student_id='".$_SESSION['user']."'");
                $rankQuery = mysqli_query($con, "SELECT * FROM student_scores WHERE student_id='" . $_SESSION['user'] . "'");
                $rankData = mysqli_fetch_assoc($rankQuery);
                $rankValue = $rankData['rank']; // Replace 'rank_column_name' with the actual column name in your 'student_scores' table that holds the rank

                if ($rankValue !== null) {
                    echo $rankValue; // Display the fetched rank value
                } else {
                    echo "Rank not available";
                }

            ?> 
                         
            <tr>
                <td><font style="font-family: Verdana;"></font></td>
                <center><td colspan="3"><?php echo $rank ?></center></td>           
            </tr>   
            </div>
        </div>
    </div>          
</div>
       
<div id="managePref" class="tab-pane fade in active">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            <center>  <table class="table table-bordered" style="font-family: Verdana">
            <tr>
                <td style="width:3%;"><img src="./images/Logo-T.jpg" width="50%"> </td>
                <td style="width:8%;"><center><font style="font-family:Arial Black; font-size:20px;"></font></center>
                    <center><font style="font-family:Verdana; font-size:18px;"> </font></center>
                    <br>
                    <br>
                    <center><font style="font-family:Arial Black; font-size:20px;">
                        Your Preferences
                    </font></center>
                <!--</td>-->
            <td colspan="2" width="3%" >
            <?php
// Assume $con is the database connection object

// Get student ID (you need to set this value accordingly)
$studentID = $_SESSION['user'];

// Fetch selected colleges and branches by student ID
$query = "SELECT sp.college_id, c.college_name, sp.branch_id, b.branch_name
          FROM student_preferences sp
          JOIN colleges c ON sp.college_id = c.college_id
          JOIN branches b ON sp.branch_id = b.branch_id
          WHERE sp.student_id = '$studentID'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    // Display selected colleges and branches along with delete option
    echo '<table class="table table-bordered" style="font-family: Verdana">';
    echo '<tr>
            <th>College ID</th>
            <th>College Name</th>
            <th>Branch ID</th>
            <th>Branch Name</th>
            <th>Delete</th>
          </tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        $collegeID = $row['college_id'];
        $collegeName = $row['college_name'];
        $branchID = $row['branch_id'];
        $branchName = $row['branch_name'];

        echo '<tr>';
        echo "<td>$collegeID</td>";
        echo "<td>$collegeName</td>";
        echo "<td>$branchID</td>";
        echo "<td>$branchName</td>";
        echo '<td><a href="delete_preference.php?college_id=' . $collegeID . '&branch_id=' . $branchID . '">Delete</a></td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No preferences found.';
}
?>
             
             
            </div>
        </div>
    </div>          
</div>



</div>
             
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle tab switching
        $('a[data-toggle="tab"]').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
<script>
$(document).ready(function() {
    // Get the URL parameter value
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');

    if (tabParam === 'myapp') {
        // Show the desired tab (Exam Application Details)
        $('a[data-toggle="tab"][href="#myapp"]').tab('show');
    }
});
</script>
