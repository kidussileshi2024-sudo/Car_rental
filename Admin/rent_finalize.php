<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "db.php";

/* common fields */
$b_id        = $_POST['b_id'];
$amount      = $_POST['amount'];
$Type        = $_POST['Type'];      // Booking or Fine
$Method      = $_POST['Method'];
$Invoice     = $_POST['Invoice'];
$employee_id = $_POST['employee_id'];
$fine        = $_POST['fine'] ?? 0;

mysqli_begin_transaction($conn);

/* ===== INSERT PAYMENT ===== */
$sql = "
INSERT INTO Payment (B_id, Type, Invoice, Method, Emp_id, Amount)
VALUES ($b_id, '$Type', '$Invoice', '$Method', $employee_id, $amount)
";

if (!mysqli_query($conn, $sql)) {
    mysqli_rollback($conn);
    die(mysqli_error($conn));
}

mysqli_commit($conn);
?>

<!DOCTYPE html>
<html>
<body>

<?php if ($Type == "Booking"): ?>

    <?php if ($fine == 0 || $fine == "" || $fine == null): ?>
        <!-- NO FINE → FINISH -->
        <h3>Booking payment completed</h3>

        <form method="post" action="rent_done.php">
            <input type="hidden" name="b_id" value="<?= $b_id ?>">
            <input type="hidden" name="Type" value="Booking">
            <input type="submit" value="Finish Rental">
        </form>

    <?php else: ?>
        <!-- FINE EXISTS → GO TO FINE PAYMENT -->
        <h3>Booking payment completed</h3>
        <p>Fine detected. Fine payment required.</p>

        <form method="post" action="fine_payment.php">
            <input type="hidden" name="b_id" value="<?= $b_id ?>">
            <input type="hidden" name="fine" value="<?= $fine ?>">
            <input type="hidden" name="employee_id_fine" value="<?= $employee_id ?>">
            <input type="submit" value="Proceed to Fine Payment">
        </form>

    <?php endif; ?>

<?php elseif ($Type == "Fine"): ?>

    <!-- FINE PAYMENT FINISHED -->
    <h3>Fine payment completed</h3>

    <form method="post" action="rent_done.php">
        <input type="hidden" name="b_id" value="<?= $b_id ?>">
        <input type="hidden" name="Type" value="Fine">
        <input type="submit" value="Finish Rental">
    </form>

<?php endif; ?>

</body>
</html>