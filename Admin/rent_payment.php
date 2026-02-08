<?php
require "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* booking payment only */
$b_id        = $_POST['b_id'];
$employee_id = $_POST['employee_id'];
$amount      = $_POST['amount'];   // already calculated in close_booking
$type        = $_POST["Type"];
$cu_id       = $_POST["cu_id"];
$price = $_POST["price"];
$days = $_POST["days"];
$car_id = $_POST["car_id"];
$fine = $_POST['fine'] ?? 0;
?>
<!DOCTYPE html>
<html>
<body>

<h2>Booking Payment</h2>

<p>Rental Price to Pay: €<?= number_format($amount,2) ?></p>

<form method="post" action="rent_finalize.php">

    <input type="hidden" name="b_id" value="<?= $b_id ?>">
    <input type="hidden" name="Type" value="Booking">
    <input type="hidden" name="amount" value="<?= $amount ?>">
    <input type="hidden" name="Type" value="Booking">
    <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
    <input type="hidden" name="fine" value="<?= $fine ?>">
    Price per day: €<?= number_format($price,2) ?><br><br>
    Total days: <?= $days ?><br><br>
     Amount received: <input type="text" value="<?= $amount ?>" readonly><br><br>

    Payment Method:
    <select name="Method" required>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
    </select><br><br>

    Invoice:
    <input type="text" name="Invoice" required><br><br>

    <input type="submit" value="Confirm Booking Payment">

</form>

</body>
</html>