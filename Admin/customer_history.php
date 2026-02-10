<?php
require "db.php";
ini_set('display_errors',1);
error_reporting(E_ALL);

$data = [];
$customer = null;

if(isset($_POST['phone'])){

    $phone = $_POST['phone'];

    $stmt = $conn->prepare("
        SELECT 
            cu.name,
            cu.phone_no,

            b.B_id,
            b.Start_date,
            b.End_date,

            c.Plate_no,
            c.IS_available,

            m.brand,
            m.Name

        FROM customers cu
        JOIN booking b   ON cu.C_id = b.Cu_id
        JOIN cars c      ON b.Car_id = c.C_id
        JOIN models m    ON c.Model_id = m.M_id

        WHERE cu.phone_no = ?
        ORDER BY b.Start_date DESC;
    ");

    $stmt->bind_param("s",$phone);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            $data[] = $row;
            $customer = [
                'name' => $row['name'],
                'phone' => $row['phone_no']
            ];
        }
    }else{
        $error = "No customer history found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Customer History</title>
</head>
<body>

<h2>Customer Rental History</h2>

<form method="post">
    Customer Phone:
    <input type="text" name="phone" required>
    <input type="submit" value="Search">
</form>

<hr>

<?php if(isset($customer)): ?>

<h3>Customer Info</h3>
Name: <?= $customer['name'] ?><br>
Phone: <?= $customer['phone'] ?><br>

<hr>

<h3>Rentals</h3>

<table border="1" cellpadding="6">
<tr>
    <th>Booking ID</th>
    <th>Car</th>
    <th>Plate</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Status</th>
</tr>

<?php foreach($data as $row): ?>

<?php
    if($row['IS_available'] == 0 && is_null($row['End_date'])){
        $status = "ACTIVE (On Rent)";
    }else{
        $status = "CLOSED";
    }
?>

<tr>
    <td><?= $row['B_id'] ?></td>
    <td><?= $row['brand'] ?> <?= $row['Name'] ?></td>
    <td><?= $row['Plate_no'] ?></td>
    <td><?= $row['Start_date'] ?></td>
    <td><?= $row['End_date'] ?? '-' ?></td>
    <td><?= $status ?></td>
</tr>

<?php endforeach; ?>
</table>

<?php endif; ?>

<?php if(isset($error)): ?>
<p style="color:red"><?= $error ?></p>
<?php endif; ?>

</body>
</html>