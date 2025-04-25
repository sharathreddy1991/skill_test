<?php
session_start();

if ($_POST) {
    // Database connection
    $dbConnection = mysqli_connect("localhost", "root", "", "test");
    if (!$dbConnection) {
        die("<h2>Connection failed: " . mysqli_connect_error() . "</h2>");
    }

    // Sanitize and prepare input data
    $name = mysqli_real_escape_string($dbConnection, $_POST['name']);
    $phoneNumber = mysqli_real_escape_string($dbConnection, $_POST['phone_number']);
    $email = mysqli_real_escape_string($dbConnection, $_POST['email']);
    $employeeType = mysqli_real_escape_string($dbConnection, $_POST['employee_type']);
    $gender = mysqli_real_escape_string($dbConnection, $_POST['gender']);
    $password = $_POST['password'];

    // Insert employee data
    $insertEmployeeQuery = "INSERT INTO employee (`name`, `phone_number`, `email`, `type`, `gender`) VALUES ('$name', '$phoneNumber', '$email', '$employeeType', '$gender')";
    if (!mysqli_query($dbConnection, $insertEmployeeQuery)) {
        die("<h2>Sorry, could not add employee: " . mysqli_error($dbConnection) . "</h2>");
    }

    // Log the action
    $timestamp = date("d/m/y h:i:s");
    $logMessage = "$name was added on $timestamp";
    $insertLogQuery = "INSERT INTO audit_log (`message`) VALUES ('$logMessage')";
    mysqli_query($dbConnection, $insertLogQuery);

    // Send email to the employee
    $emailSubject = "Thanks for registering";
    $emailBody = "Dear $name,\nThanks for registering with AwesomeCorp!! Your password is $password.\nYou can login at: http://www.awesomecorp.com/login.\nRegards,\nAwesomeCorp";
    mail($email, $emailSubject, $emailBody);

    // Get the newly inserted employee ID
    $employeeId = mysqli_insert_id($dbConnection);
    $_SESSION["logged_in_user_id"] = $employeeId;

    // Update employee record with hashed password and email status
    $hashedPassword = sha1($password);
    $updateEmployeeQuery = "UPDATE employee SET password = '$hashedPassword', email_sent = 1 WHERE id = $employeeId";
    mysqli_query($dbConnection, $updateEmployeeQuery);

    // Update CSV file
    $csvFile = '../assets/employee_report.csv';

    // Add headers to the CSV file if it doesn't exist
    if (!file_exists($csvFile)) {
        $headers = ['ID', 'Name', 'Gender', 'Phone Number', 'Email', 'Employee Type'];
        $fileHandle = fopen($csvFile, 'w');
        if ($fileHandle) {
            fputcsv($fileHandle, $headers);
            fclose($fileHandle);
        } else {
            throw new Exception("Failed to create CSV file for writing headers.");
        }
    }

    $csvData = [
        $employeeId, // Assuming $employeeId is the ID of the newly inserted employee
        $name,
        $gender,
        $phoneNumber,
        $email,
        $employeeType
        ];

    $fileHandle = fopen($csvFile, 'a');
    if ($fileHandle) {
        fputcsv($fileHandle, $csvData);
        fclose($fileHandle);
    } else {
        throw new Exception("Failed to open CSV file for writing.");
    }

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit;
}
?>