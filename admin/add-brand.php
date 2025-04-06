<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin-login.php");
    exit();
}

if (isset($_POST['add_brand'])) {
    $brandName = $_POST['brandName'];

    // Insert new brand into the database
    $sql = "INSERT INTO tblbrands (BrandName) VALUES (:brandName)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':brandName', $brandName, PDO::PARAM_STR);

    if ($query->execute()) {
        echo "<script>alert('Brand added successfully!');</script>";
    } else {
        echo "<script>alert('Failed to add brand.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Brand - Car Rental</title>
    <link rel="stylesheet" href="\css\style.css">
</head>
<body>
    <?php include('../includes/admin-header.php'); ?>

    <main>
        <section class="add-brand-section">
            <h1>Add New Brand</h1>
            <form method="post">
                <label for="brandName">Brand Name:</label>
                <input type="text" id="brandName" name="brandName" required>

                <button type="submit" name="add_brand">Add Brand</button>
            </form>
        </section>
    </main>
</body>
</html>