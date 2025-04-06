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

    // Update booking status to confirmed
    $sql = "UPDATE tblbooking SET Status = 1 WHERE id = :bookingId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);

    if ($query->execute()) {
        echo "<script>alert('Booking confirmed!'); window.location.href='manage-bookings.php';</script>";
    } else {
        echo "<script>alert('Failed to confirm booking.');</script>";
    }
}
?>