<?php
session_start();
?>

<h1>Create New Employee</h1>
<form action="" method="post">
    <ul>
        <li>
            Employee Name:
            <input name="name" type="text" />
        </li>
        <li>
            Phone Number:
            <input name="phone_number" type="text"/>
        </li>
        <li>
            Password:
            <input name="password" type="password" />
        </li>
        <li>
            Email:
            <input name="email" type="text"/>
        </li>
        <li>
            Employee Type:
            <select name="employee_type">
                <option value="1">Part Time</option>
                <option value="2">Full Time</option>
            </select>
        </li>
    </ul>
    <input type="submit" value="Create">
</form>

<?php

if ($_POST) {
    $dbConnection = mysqli_connect("localhost", "root", "", "test");
    if (!$dbConnection) {
        die("<h2>Connection failed: " . mysqli_connect_error() . "</h2>");
    }

    $sql = "INSERT INTO employee (`name`, `phone_number`, `email`, `type`) VALUES ('" .
        mysqli_real_escape_string($dbConnection, $_POST['name']) . "', '" . mysqli_real_escape_string($dbConnection, $_POST['phone_number']) . "', '" . mysqli_real_escape_string($dbConnection, $_POST['email']) . "', '" . mysqli_real_escape_string($dbConnection, $_POST['employee_type']) . "')";
    $result = mysqli_query($dbConnection, $sql);

    if (!$result) {
        die("<h2>Sorry could not add employee: " . mysqli_error($dbConnection) . "</h2>");
    }

    $timestamp = date("d/m/y h:i:s");
    $sql = "INSERT INTO audit_log (`message`) VALUES ('{$_POST['name']} was added on $timestamp')";
    mysqli_query($dbConnection, $sql);

    $uniq = $_POST['password'];
    mail($_POST['email'], "Thanks for registering", "Dear " . $_POST['name'] . ",\nThanks for registering with AwesomeCorp!! your password is $uniq.\nYou can login at: http://www.awesomecorp.com/login.\nRegards,\nAwesomeCorp");

    $sql = "SELECT MAX(id) FROM employee";
    $result = mysqli_query($dbConnection, $sql);
    $row = mysqli_fetch_row($result);
    $id = $row[0];
    $_SESSION["logged_in_user_id"] = $id;

    $sql = "UPDATE employee SET password = '" . sha1($uniq) . "', email_sent = 1 WHERE id = $id";
    mysqli_query($dbConnection, $sql);
    $newURL = "dashboard.php";
    header('Location: ' . $newURL);
}



