<?php
session_start();
include('includes/config.php');

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    echo "<script>alert('You need to log in to book a vehicle.'); window.location.href='login.php';</script>";
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleId = intval($_POST['vehicle_id']);
    $fromDate = $_POST['from_date'];
    $toDate = $_POST['to_date'];
    $userEmail = $_SESSION['login'];

    // Generate a random booking number
    $bookingNumber = rand(100000000, 999999999);

    // Insert booking into the database
    $sql = "INSERT INTO tblbooking (BookingNumber, userEmail, VehicleId, FromDate, ToDate, Status) 
            VALUES (:bookingNumber, :userEmail, :vehicleId, :fromDate, :toDate, 0)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookingNumber', $bookingNumber, PDO::PARAM_STR);
    $query->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
    $query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $query->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);
    $query->bindParam(':toDate', $toDate, PDO::PARAM_STR);

    if ($query->execute()) {
        echo "<script>alert('Booking successful! Your booking number is $bookingNumber.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to book the vehicle. Please try again.'); window.location.href='vehicle-details.php?id=$vehicleId';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='index.php';</script>";
}
?>