<?php require "../db.php";

/* get categories */
$cats = mysqli_query($conn, "SELECT * FROM Category ORDER BY Name");
$rec= mysqli_query($conn,"SELECT Emp_id, Name FROM Employees WHERE Role='receptionist'");
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <title>Rent a Car</title>
</head>
<body>

<h2>Rent a Car</h2>

<form method="post" action="rent_select_car.php">

Employee ID :  
<select name="employee_id" required>
    <option value="">-- Select Receptionist --</option>
    <?php while($e = mysqli_fetch_assoc($rec)): ?>
        <option value="<?= $e['Emp_id'] ?>">
            <?= $e['Name'] ?> (ID: <?= $e['Emp_id'] ?>)
        </option>
    <?php endwhile; ?>
</select>
<br>

<h3>Select categories</h3>

<?php while($c = mysqli_fetch_assoc($cats)): ?>
    <input type="checkbox" name="cat[]" value="<?= $c['C_id'] ?>">
    <?= $c['Name'] ?><br>
<?php endwhile; ?>

<br>
<input type="submit" name="filter" value="Show available cars">

</form>

</body>
</html>