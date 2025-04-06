<?php
include('../includes/config.php');

// Fetch all admin users
$sql = "SELECT id, Password FROM admin";
$query = $dbh->prepare($sql);
$query->execute();
$admins = $query->fetchAll(PDO::FETCH_OBJ);

foreach ($admins as $admin) {
    // Check if the password needs rehashing
    if (password_needs_rehash($admin->Password, PASSWORD_DEFAULT)) {
        // Rehash the password
        $newHashedPassword = password_hash($admin->Password, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateSQL = "UPDATE admin SET Password = :newPassword WHERE id = :id";
        $updateQuery = $dbh->prepare($updateSQL);
        $updateQuery->bindParam(':newPassword', $newHashedPassword, PDO::PARAM_STR);
        $updateQuery->bindParam(':id', $admin->id, PDO::PARAM_INT);
        $updateQuery->execute();
    }
}

echo "Admin passwords updated successfully!";
?>