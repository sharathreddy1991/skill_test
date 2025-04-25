<?php
session_start();
?>

<link rel="stylesheet" type="text/css" href="../assets/style.css">

<form action="process_form.php" method="post">
<h1>Create New Employee</h1>
    <ul>
        <li>
            Employee Name: <span class="mandatory">*</span>
            <input name="name" type="text" required oninvalid="this.setCustomValidity('Please enter the employee name.')" oninput="this.setCustomValidity('')"/>
        </li>
        <li>
            Phone Number: <span class="mandatory">*</span>
            <input name="phone_number" type="text" inputmode="numeric" required pattern="\d{10}" oninvalid="this.setCustomValidity('Please enter a valid 10-digit phone number.')"  oninput="this.setCustomValidity('')"/>
        </li>
        <li>
            Gender: <span class="mandatory">*</span>
            <select name="gender" required oninvalid="this.setCustomValidity('Please select a gender.')" oninput="this.setCustomValidity('')">
                <option value="" disabled selected>Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Non-binary">Non-binary</option>
                <option value="Other">Other</option>
                <option value="Prefer not to say">Prefer not to say</option>
            </select>
        </li>
        <li>
            Password: <span class="mandatory">*</span>
            <input name="password" type="password" required oninvalid="this.setCustomValidity('Please enter a password.')"  oninput="this.setCustomValidity('')"/>
        </li>
        <li>
            Email: <span class="mandatory">*</span>
            <input name="email" type="email" required oninvalid="this.setCustomValidity('Please enter a valid email address.')" oninput="this.setCustomValidity('')" />
        </li>
        <li>
            Employee Type: <span class="mandatory">*</span>
            <select name="employee_type" required oninvalid="this.setCustomValidity('Please select an employee type.')" oninput="this.setCustomValidity('')">
                <option value="" disabled selected>Select</option>
                <option value="1">Part Time</option>
                <option value="2">Full Time</option>
            </select>
        </li>
    </ul>
    <input type="submit" value="Create">
</form>


<script src="../assets/skill_test_js.js"></script>
