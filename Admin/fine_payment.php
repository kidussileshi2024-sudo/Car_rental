<?php
require "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* fine payment only */
$b_id        = $_POST['b_id'];
$fine        = $_POST['fine'];
$employee_id = $_POST['employee_id_fine'];
$type        = "Fine";
?>
<!DOCTYPE html>
<html>
<body>

<h2>Fine Payment</h2>

<p>Fine Amount to Pay: €<?= number_format($fine,2) ?></p>

<form method="post" action="rent_finalize.php">

    <input type="hidden" name="b_id" value="<?= $b_id ?>">
    <input type="hidden" name="amount" value="<?= $fine ?>">
    <input type="hidden" name="Type" value="Fine">
    <input type="hidden" name="employee_id" value="<?= $employee_id ?>">

    Amount received:
    <input type="text" value="<?= $fine ?>" readonly><br><br>

    Payment Method:
    <select name="Method" required>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
    </select><br><br>

    Invoice:
    <input type="text" name="Invoice" required><br><br>

    <input type="submit" value="Confirm Fine Payment">

</form>

</body>
</html>