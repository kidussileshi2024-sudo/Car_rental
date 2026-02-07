<?php
require "db.php";

$car_id     = $_POST['car_id'];
$cu_id      = $_POST['cu_id'];
$employee_id = $_POST['employee_id'];
$fine       = $_POST['fine'] ?? Null;
$booking_id_fine = $_POST['b_id'];
$employee_id_fine = $_POST['employee_id_fine'];

/* get price */
if ($fine == Null){
$sql = "SELECT Models.Price_per_day, Cars.Price_adjs FROM 
Cars JOIN Models ON Cars.Model_id = Models.M_id 
WHERE Cars.C_id = $car_id";

$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

$price = $row['Price_per_day'] * (1 - $row['Price_adjs']);

}
else {
    $price = $fine;
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Payment</h2>

<p>Price to pay  €<?= number_format($price,2) ?></p>

<form method="post" action="rent_finalize.php">
    <input type="hidden" name="car_id" value="<?= $car_id ?>">
    <input type="hidden" name="cu_id" value="<?= $cu_id ?>">
    <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
    <input type="hidden" name="amount" value="<?= $price ?>">
    <input type="hidden" name="b_id" value="<?= $booking_id_fine ?>">
    <input type="hidden" name="employee_id_fine" value="<?= $employee_id_fine ?>">

    Amount received:
    <input type="text" value="<?= $price ?>" readonly> </br>
    Payment Type:
    <select name="Type">
        <option value="Booking">Booking</option>
        <option value="Fine">Fine</option>
    </select><br><br>

    Payment Method:
    <select name="Method">
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
    </select><br><br>
    Invoice: 
    <input type="text" name="Invoice" value="Invoice" required><br><br>

    <input type="submit" value="Confirm Payment">
</form>

</body>
</html>