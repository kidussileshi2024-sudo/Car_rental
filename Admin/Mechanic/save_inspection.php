<?php
require "../db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);


$car_id  = $_POST['car_id'];
$book_id = $_POST['book_id'];
$em_id   = $_POST['em_id'];
$damage  = $_POST['damage'];
$fine    = $_POST['fine'];
$in_id = $_POST['i_id'];
#echo"$in_id ,hello, $car_id, $book_id, $em_id, $damage, $fine";
if ($fine === "") $fine = 0;

/*$sql = "
INSERT INTO Inspection (Car_id, Em_id, Book_id, date, Damages, Fine, Inspection_done)
VALUES ($car_id, $em_id, $book_id, CURDATE(), '$damage', $fine)";*/
$sql = "UPDATE Inspection SET Damages='$damage', Fine=$fine, Inspection_done=1
WHERE i_id = $in_id";
if(!mysqli_query($conn,$sql)){
    die(mysqli_error($conn));
}

echo "Inspection saved. Receptionist can now close booking.";
?>