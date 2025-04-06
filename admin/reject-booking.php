<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin-login.php");
    exit();
}

if (isset($_GET['id'])) {
    $bookingId = intval($_GET['id']);

    // Update the booking status to rejected (Status = 2)
    $sql = "UPDATE tblbooking SET Status = 2 WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $bookingId, PDO::PARAM_INT);
    $query->execute();

    // Redirect back to the manage bookings page
    header("Location: manage-bookings.php");
    exit();
}
?>