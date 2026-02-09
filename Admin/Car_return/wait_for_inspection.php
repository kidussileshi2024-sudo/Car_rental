<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../db.php";


list($b_id, $car_id) = explode('|', $_POST['selected_booking']);
$employee_id = $_POST['employee_id'];
$sql0 = "SELECT I_id FROM Inspection WHERE Car_id='$car_id' AND Book_id='$b_id'";
$result0 = mysqli_query($conn, $sql0);
if (!$result0) {
    die(mysqli_error($conn));
} 
if (mysqli_num_rows($result0) == 0) {

$sql="INSERT INTO Inspection (Car_id, Em_id, Book_id, date,Inspection_done)
VALUES ($car_id, $employee_id+1, $b_id, CURDATE(), 0)";
if (!mysqli_query($conn, $sql)) {
    die(mysqli_error($conn));
}
}


$check = mysqli_query($conn,"SELECT * FROM inspection WHERE Book_id=$b_id AND Inspection_done=1");
if(mysqli_num_rows($check)==0){
    die("Inspection not completed yet. Wait for mechanic.");
}

$insp = mysqli_fetch_assoc($check);
?>

<h3>Inspection Result</h3>
Damage: <?= $insp['Damages'] ?><br>
Fine: €<?= $insp['Fine'] ?><br><br>

<form method="post" action="close_booking.php">
    <input type="hidden" name="b_id" value="<?= $b_id ?>">
    <input type="hidden" name="car_id" value="<?= $car_id ?>">
    <input type="hidden" name="fine" value="<?= $insp['Fine'] ?>">
    <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
    <input type="submit" value="Close Booking">
</form>