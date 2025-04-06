<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin-login.php");
    exit();
}

// Fetch all bookings
$sql = "SELECT * FROM tblbooking";
$query = $dbh->prepare($sql);
$query->execute();
$bookings = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Car Rental</title>
    <link rel="stylesheet" href="\css\style.css">
    <style>
        /* Add CSS for the table and status indicators */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        .confirmed {
            color: green;
            font-weight: bold;
        }

        .not-confirmed {
            color: red;
            font-weight: bold;
        }

        .action-link {
            color: #007bff;
            text-decoration: none;
        }

        .action-link:hover {
            text-decoration: underline;
        }

        .reject-link {
            color: #dc3545;
            text-decoration: none;
        }

        .reject-link:hover {
            text-decoration: underline;
        }

        .disabled {
            color: #6c757d;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include('../includes/admin-header.php'); ?>

    <main>
        <section class="manage-bookings-section">
            <h1>Manage Bookings</h1>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User Email</th>
                        <th>Vehicle</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Reject</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking->id); ?></td>
                            <td><?php echo htmlspecialchars($booking->userEmail); ?></td>
                            <td><?php echo htmlspecialchars($booking->VehicleId); ?></td>
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
                            <td>
                                <?php if ($booking->Status != 1) { ?>
                                    <a href="confirm-booking.php?id=<?php echo $booking->id; ?>" class="action-link">Confirm</a>
                                <?php } else { ?>
                                    <span class="action-link disabled">Confirmed</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($booking->Status != 2) { ?>
                                    <a href="reject-booking.php?id=<?php echo $booking->id; ?>" class="reject-link">Reject</a>
                                <?php } else { ?>
                                    <span class="reject-link disabled">Rejected</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>