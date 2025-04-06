<?php

include('includes/header.php');
include('includes/config.php');

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $vehicleId = intval($_GET['id']);

    // Fetch vehicle details along with the brand name from the database
    $sql = "SELECT v.*, b.BrandName 
            FROM tblvehicles v 
            JOIN tblbrands b ON v.VehiclesBrand = b.id 
            WHERE v.id = :id";

    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $vehicleId, PDO::PARAM_INT);
    $query->execute();
    $vehicle = $query->fetch(PDO::FETCH_OBJ);

    if ($vehicle) {
        // Vehicle details found
?>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
<style>
    .swiper-container {
        width: 80%; /* Adjust width */
        height: 450px; /* Adjust height */
        margin: auto;
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Navigation buttons */
    .swiper-button-next, .swiper-button-prev {
        color: white;
    }

    /* Pagination styling */
    .swiper-pagination {
        position: absolute;
        bottom: 10px;
    }
</style>

<main>
    <section class="vehicle-details">
        <h1><?php echo htmlspecialchars($vehicle->VehiclesTitle); ?></h1>

        <!-- Slideshow Container -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="images/Cars/<?php echo htmlspecialchars($vehicle->Vimage1); ?>" alt="<?php echo htmlspecialchars($vehicle->VehiclesTitle); ?>"></div>
                <div class="swiper-slide"><img src="images/Cars/<?php echo htmlspecialchars($vehicle->Vimage2); ?>" alt="<?php echo htmlspecialchars($vehicle->VehiclesTitle); ?>"></div>
                <div class="swiper-slide"><img src="images/Cars/<?php echo htmlspecialchars($vehicle->Vimage3); ?>" alt="<?php echo htmlspecialchars($vehicle->VehiclesTitle); ?>"></div>
                <div class="swiper-slide"><img src="images/Cars/<?php echo htmlspecialchars($vehicle->Vimage4); ?>" alt="<?php echo htmlspecialchars($vehicle->VehiclesTitle); ?>"></div>
                <div class="swiper-slide"><img src="images/Cars/<?php echo htmlspecialchars($vehicle->Vimage5); ?>" alt="<?php echo htmlspecialchars($vehicle->VehiclesTitle); ?>"></div>
            </div>
            
            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>

        <div class="vehicle-info">
            <h2>Vehicle Details</h2>
            <p><strong>Brand:</strong> <?php echo htmlspecialchars($vehicle->BrandName); ?></p>
            <p><strong>Price Per Day:</strong> $<?php echo htmlspecialchars($vehicle->PricePerDay); ?></p>
            <p><strong>Fuel Type:</strong> <?php echo htmlspecialchars($vehicle->FuelType); ?></p>
            <p><strong>Model Year:</strong> <?php echo htmlspecialchars($vehicle->ModelYear); ?></p>
            <p><strong>Seating Capacity:</strong> <?php echo htmlspecialchars($vehicle->SeatingCapacity); ?></p>
            <p><strong>Overview:</strong> <?php echo htmlspecialchars($vehicle->VehiclesOverview); ?></p>
        </div>

        <div class="vehicle-features">
            <h2>Features</h2>
            <ul>
                <li><?php echo ($vehicle->AirConditioner) ? 'Air Conditioner' : 'No Air Conditioner'; ?></li>
                <li><?php echo ($vehicle->PowerDoorLocks) ? 'Power Door Locks' : 'No Power Door Locks'; ?></li>
                <li><?php echo ($vehicle->AntiLockBrakingSystem) ? 'Anti-Lock Braking System' : 'No Anti-Lock Braking System'; ?></li>
                <li><?php echo ($vehicle->BrakeAssist) ? 'Brake Assist' : 'No Brake Assist'; ?></li>
                <li><?php echo ($vehicle->PowerSteering) ? 'Power Steering' : 'No Power Steering'; ?></li>
                <li><?php echo ($vehicle->DriverAirbag) ? 'Driver Airbag' : 'No Driver Airbag'; ?></li>
                <li><?php echo ($vehicle->PassengerAirbag) ? 'Passenger Airbag' : 'No Passenger Airbag'; ?></li>
                <li><?php echo ($vehicle->PowerWindows) ? 'Power Windows' : 'No Power Windows'; ?></li>
                <li><?php echo ($vehicle->CDPlayer) ? 'CD Player' : 'No CD Player'; ?></li>
                <li><?php echo ($vehicle->CentralLocking) ? 'Central Locking' : 'No Central Locking'; ?></li>
                <li><?php echo ($vehicle->CrashSensor) ? 'Crash Sensor' : 'No Crash Sensor'; ?></li>
                <li><?php echo ($vehicle->LeatherSeats) ? 'Leather Seats' : 'No Leather Seats'; ?></li>
            </ul>
        </div>

        <div class="booking-section">
            <h2>Book This Vehicle</h2>
            <?php if (isset($_SESSION['login'])) { ?>
                <!-- Booking Form for Logged-In Users -->
                <form action="book-vehicle.php" method="post">
                    <input type="hidden" name="vehicle_id" value="<?php echo htmlspecialchars($vehicle->id); ?>">
                    <label for="from_date">From Date:</label>
                    <input type="date" id="from_date" name="from_date" required>
                    <label for="to_date">To Date:</label>
                    <input type="date" id="to_date" name="to_date" required>
                    <button type="submit" class="btn">Book Now</button>
                </form>
            <?php } else { ?>
                <!-- Login Button for Logged-Out Users -->
                <p>You need to log in to book this vehicle.</p>
                <a href="login.php" class="btn">Login</a>
            <?php } ?>
        </div>
    </section>
</main>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: {
            delay: 3000, // Change slide every 3 seconds
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });
</script>
<?php
    } else {
        echo "<p>Vehicle not found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
include('includes/footer.php');
?>