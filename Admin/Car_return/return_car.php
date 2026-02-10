
<?php
require "../db.php";
$rec= mysqli_query($conn,"SELECT Emp_id, Name FROM Employees WHERE Role='receptionist'");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <title>Return Car</title>
</head>
<body>

<h2>Return Car</h2>

<form method="post" action="find_booking.php">

Employee ID (receptionist):
<select name="employee_id" required>
    <option value="">-- Select Receptionist --</option>
    <?php while($e = mysqli_fetch_assoc($rec)): ?>
        <option value="<?= $e['Emp_id'] ?>">
            <?= $e['Name'] ?> (ID: <?= $e['Emp_id'] ?>)
        </option>
    <?php endwhile; ?>
</select><br><br>

Customer phone:
<input name="phone" required><br><br>

<input type="submit" value="Find Active Rental">

</form>

</body>
</html>