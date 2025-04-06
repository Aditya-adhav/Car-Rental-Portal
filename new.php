<?php 
include('includes/config.php');

$sql = "SELECT id, Password FROM tblusers";
$query = $dbh->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_OBJ);

foreach ($users as $user) {
    if (password_needs_rehash($user->Password, PASSWORD_DEFAULT)) {
        $newHashedPassword = password_hash($user->Password, PASSWORD_DEFAULT);
        $updateSQL = "UPDATE tblusers SET Password = :newPassword WHERE id = :id";
        $updateQuery = $dbh->prepare($updateSQL);
        $updateQuery->bindParam(':newPassword', $newHashedPassword, PDO::PARAM_STR);
        $updateQuery->bindParam(':id', $user->id, PDO::PARAM_INT);
        $updateQuery->execute();
    }
}

echo "Passwords updated successfully!"; ?>