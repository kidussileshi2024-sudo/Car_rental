<?php
require "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$b_id = $_POST['b_id'];
$car_id = $_POST['car_id'];
$fine = $_POST['fine'];
$employee_id = $_POST['employee_id'];

mysqli_begin_transaction($conn);

/* close booking */
mysqli_query($conn,"UPDATE Booking SET End_date = CURDATE() WHERE B_id=$b_id");

/* if no fine */
if($fine == 0){

    mysqli_query($conn,"UPDATE cars SET IS_available=1 WHERE C_id=$car_id");

    mysqli_commit($conn);
    header("Location: return_done.php");
    exit;

}else{
    /* send to maintenance */
    mysqli_query($conn,"
        INSERT INTO maintenance (Car_id, Start_date, Description)
        VALUES ($car_id, CURDATE(), 'Damage from inspection')
    ");

    mysqli_commit($conn);
    ?>

    <form method="post" action="rent_payment.php">
        <input type="hidden" name="b_id" value="<?= $b_id ?>">
        <input type="hidden" name="fine" value="<?= $fine ?>">
        <input type="hidden" name="employee_id_fine" value="<?= $employee_id ?>">
        <input type="submit" value="Proceed to Fine Payment">
    </form>

    <?php
}
?>