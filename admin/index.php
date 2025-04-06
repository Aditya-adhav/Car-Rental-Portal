<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin-login.php");
    exit();
}

// Debugging: Check if $dbh is set
if (!isset($dbh)) {
    die("Database connection failed!");
}

try {
    // Fetch total number of registered users
    $user_query = "SELECT COUNT(*) as total_users FROM tblusers";
    $user_stmt = $dbh->query($user_query);
    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
    $total_users = $user_data['total_users'];

    // Fetch total number of bookings
    $booking_query = "SELECT COUNT(*) as total_bookings FROM tblbooking";
    $booking_stmt = $dbh->query($booking_query);
    $booking_data = $booking_stmt->fetch(PDO::FETCH_ASSOC);
    $total_bookings = $booking_data['total_bookings'];

    // Fetch total number of available cars
    $car_query = "SELECT COUNT(*) as total_cars FROM tblvehicles";
    $car_stmt = $dbh->query($car_query);
    $car_data = $car_stmt->fetch(PDO::FETCH_ASSOC);
    $total_cars = $car_data['total_cars'];

    // Fetch recent bookings (last 5 bookings)
    $recent_bookings_query = "SELECT tblbooking.*, tblusers.FullName, tblvehicles.VehiclesTitle 
                              FROM tblbooking 
                              JOIN tblusers ON tblbooking.userEmail = tblusers.EmailId 
                              JOIN tblvehicles ON tblbooking.VehicleId = tblvehicles.id 
                              ORDER BY tblbooking.PostingDate DESC 
                              LIMIT 5";
    $recent_bookings_stmt = $dbh->query($recent_bookings_query);
    $recent_bookings = $recent_bookings_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Car Rental</title>
    <link rel="stylesheet" href="\css\style.css">
</head>
<body>
    <?php include('../includes/admin-header.php'); ?>

    <main>
        <section class="admin-dashboard">
            <h2>Welcome, <?php echo $_SESSION['admin_login']; ?></h2>

            <!-- Display Statistics -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <p><?php echo $total_users; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Bookings</h3>
                    <p><?php echo $total_bookings; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Available Cars</h3>
                    <p><?php echo $total_cars; ?></p>
                </div>
            </div>

            <!-- Display Recent Bookings -->
            <div class="recent-bookings">
                <h3>Recent Bookings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>User</th>
                            <th>Car</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_bookings as $booking): ?>
                            <tr>
                                <td><?php echo $booking['id']; ?></td>
                                <td><?php echo $booking['FullName']; ?></td>
                                <td><?php echo $booking['VehiclesTitle']; ?></td>
                                <td><?php echo $booking['FromDate']; ?></td>
                                <td><?php echo $booking['ToDate']; ?></td>
                                <td><?php echo ($booking['Status'] == 1) ? 'Confirmed' : 'Pending'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Admin Actions -->
        </section>
    </main>
</body>
</html>