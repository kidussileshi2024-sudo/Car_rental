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

if ($fine === "") $fine = 0;


$sql = "UPDATE Inspection SET Damages='$damage', Fine=$fine, Inspection_done=1
WHERE i_id = $in_id";
if(!mysqli_query($conn,$sql)){
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <title>Inspection Saved</title>
</head>
<body>
    <h2>Inspection Saved</h2>
    <p>Inspection saved. Receptionist can now close booking.</p>
    <a href="mechanic_home.php">Back to Mechanic Panel</a>
</body>
</html>