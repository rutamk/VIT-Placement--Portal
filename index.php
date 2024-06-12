<?php
$insert = false;
$invalidFilename = false;
$server = "localhost";
$username = "root";
$password = "";

if(isset($_POST["name"], $_POST["rollno"], $_POST["age"], $_POST["phno"], $_POST["email"], $_POST["branch"]) && isset($_FILES["resume"])) {

    $con = mysqli_connect($server, $username, $password);

    if(!$con){
        die("Connection to the database failed due to ". mysqli_connect_error());
    }

    $resume = $_FILES["resume"]["tmp_name"]; // Corrected file handling
    $resumeName = $_FILES["resume"]["name"]; // Assigned uploaded file name to $resumeName
    $name = $_POST["name"];
    $rollno = $_POST["rollno"];
    $age = $_POST["age"];
    $phno = $_POST["phno"];
    $email = $_POST["email"];
    $branch = $_POST["branch"];

    // Move uploaded file to specified directory
   
        $expectedFilename = $rollno . "_" . $name . ".pdf";
        if($resumeName != $expectedFilename){
            $invalidFilename = true;
        } 
        else{
        $sql = "INSERT INTO `Campus placements`.`Batch of 2025` (`name`, `rollno`, `age`, `phno`, `email`, `branch`, `resume`, `dt`) 
                VALUES ('$name','$rollno','$age', '$phno', '$email', '$branch', '$resumeName', current_timestamp())";

        if($con->query($sql) == true){
            $insert = true;
            if(move_uploaded_file($resume, 'resumes/' . $resumeName)){
                //pass
            }
            else {
                echo "Failed to upload resume.";
            }
        } else {
            echo " ERROR: $sql <br> $con->error";
        }
    }


    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placements Application</title>
    <link rel="stylesheet" href="style.css?v=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>Welcome to VIT student placement portal</h1>
        <p>Please fill out the placement form to confirm your participation in college campus placements!</p>
        <?php 
        if($insert == true){
            echo "<p class='submitMsg'> You have successfully registered for VIT college campus placements!!</p>";
        }
        ?>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <label for="name"><b>Full name:</b></label>
            <input type="text" name="name" id="name" placeholder="Enter your full name" required>

            <label for="rollno"><b>Roll number:</b></label>
            <input type="text" name="rollno" id="rollno" placeholder="Enter your roll number" required>

            <label for="age"><b>Age:</b></label>
            <input type="number" name="age" id="age" placeholder="Enter your age" required>

            <label for="phno"><b>Phone number:</b></label>
            <input type="number" name="phno" id="phno" placeholder="Enter your contact number" required>

            <label for="email"><b>Email:</b></label>
            <input type="email" name="email" id="email" placeholder="Enter your email address" required>

            <label for="branch"><b>Branch:</b></label>
            <select name="branch" id="branch" required>
                <option value="INFT">INFT</option>
                <option value="CMPN">CMPN</option>
                <option value="EXTC">EXTC</option>
                <option value="ETRX">ETRX</option>
                <option value="BIOM">BIOM</option>
            </select><br>

            <label for="resume"><b>Resume: Format (rollno_name.pdf)</b></label>
            <input type="file" name="resume" id="resume" accept=".pdf" required>
            <?php 
            if($invalidFilename == true){
            echo "<p class='errorMsg'> Invalid filename format</p>";
            }
            ?>
            <div class="form-group-buttons"> <!-- New div for the buttons -->
                <input type="reset" name="reset" id="reset" value="Reset">
                <input type="submit" name="submit" id="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
