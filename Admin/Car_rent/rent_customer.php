<?php
require "../db.php";

$car_id = $_POST['car_id'];
$employee_id = $_POST['employee_id'];
?>

<!DOCTYPE html>
<html>
<body>

<h2>Customer Identification</h2>

<form method="post" action="rent_customer_process.php">
    <input type="hidden" name="car_id" value="<?= $car_id ?>">
    <input type="hidden" name="employee_id" value="<?= $employee_id ?>">

    Phone number:
    <input type="text" name="phone_no" required><br><br>

    <input type="submit" value="Continue">
</form>

</body>
</html>