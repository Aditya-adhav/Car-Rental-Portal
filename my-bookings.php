<?php
session_start();
include('includes/config.php');
include('includes/header.php');
// Check if user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's bookings from the database
$userEmail = $_SESSION['login'];
$sql = "SELECT tblbooking.*, tblvehicles.VehiclesTitle 
        FROM tblbooking 
        JOIN tblvehicles ON tblbooking.VehicleId = tblvehicles.id 
        WHERE tblbooking.userEmail = :email 
        ORDER BY tblbooking.PostingDate DESC";
$query = $dbh->prepare($sql);
$query->bindParam(':email', $userEmail, PDO::PARAM_STR);
$query->execute();
$bookings = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Rent Rush</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* My Bookings Page Styles */
        .bookings-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .bookings-container h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bookings-table th, .bookings-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .bookings-table th {
            background-color: #f4f4f4;
        }

        .bookings-table tr:hover {
            background-color: #f9f9f9;
        }

        .no-bookings {
            text-align: center;
            color: #777;
            font-size: 1.2rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <main>
        <div class="bookings-container">
            <h1>My Bookings</h1>
            <?php if ($bookings) { ?>
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Vehicle</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking->id); ?></td>
                                <td><?php echo htmlspecialchars($booking->VehiclesTitle); ?></td>
                                <td><?php echo htmlspecialchars($booking->FromDate); ?></td>
                                <td><?php echo htmlspecialchars($booking->ToDate); ?></td>
                                <td>
                                    <?php
                                         if ($booking->Status == 1) {
                                               echo '<span class="confirmed">Confirmed</span>';
                                          } elseif ($booking->Status == 2) {
                                               echo '<span class="rejected">Rejected</span>';
                                         } else {
                                                 echo '<span class="not-confirmed">Not Confirmed</span>';
                                         }
                                            ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="no-bookings">No bookings found.</p>
            <?php } ?>
        </div>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>