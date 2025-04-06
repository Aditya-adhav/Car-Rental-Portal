<?php
session_start();
include('../includes/config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin-login.php");
    exit();
}

if (isset($_POST['add_car'])) {
    // Retrieve form data
    $vehicleTitle = $_POST['vehicleTitle'];
    $vehicleBrand = $_POST['vehicleBrand'];
    $vehicleOverview = $_POST['vehicleOverview'];
    $pricePerDay = $_POST['pricePerDay'];
    $fuelType = $_POST['fuelType'];
    $modelYear = $_POST['modelYear'];
    $seatingCapacity = $_POST['seatingCapacity'];
    $airConditioner = isset($_POST['airConditioner']) ? 1 : 0;
    $powerDoorLocks = isset($_POST['powerDoorLocks']) ? 1 : 0;
    $antiLockBrakingSystem = isset($_POST['antiLockBrakingSystem']) ? 1 : 0;
    $brakeAssist = isset($_POST['brakeAssist']) ? 1 : 0;
    $powerSteering = isset($_POST['powerSteering']) ? 1 : 0;
    $driverAirbag = isset($_POST['driverAirbag']) ? 1 : 0;
    $passengerAirbag = isset($_POST['passengerAirbag']) ? 1 : 0;
    $powerWindows = isset($_POST['powerWindows']) ? 1 : 0;
    $cdPlayer = isset($_POST['cdPlayer']) ? 1 : 0;
    $centralLocking = isset($_POST['centralLocking']) ? 1 : 0;
    $crashSensor = isset($_POST['crashSensor']) ? 1 : 0;
    $leatherSeats = isset($_POST['leatherSeats']) ? 1 : 0;

    // Handle image uploads
    $imagePaths = [];
    $uploadDir = '../images/Cars/'; // Folder to store car images

    // Loop through each uploaded file
    foreach ($_FILES as $key => $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
            $targetFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $imagePaths[$key] = $fileName; // Store the file name in the array
            }
        }
    }

    // Insert new car into the database
    $sql = "INSERT INTO tblvehicles (
                VehiclesTitle, VehiclesBrand, VehiclesOverview, PricePerDay, FuelType, ModelYear, SeatingCapacity,
                Vimage1, Vimage2, Vimage3, Vimage4, Vimage5,
                AirConditioner, PowerDoorLocks, AntiLockBrakingSystem, BrakeAssist, PowerSteering,
                DriverAirbag, PassengerAirbag, PowerWindows, CDPlayer, CentralLocking, CrashSensor, LeatherSeats
            ) VALUES (
                :vehicleTitle, :vehicleBrand, :vehicleOverview, :pricePerDay, :fuelType, :modelYear, :seatingCapacity,
                :vimage1, :vimage2, :vimage3, :vimage4, :vimage5,
                :airConditioner, :powerDoorLocks, :antiLockBrakingSystem, :brakeAssist, :powerSteering,
                :driverAirbag, :passengerAirbag, :powerWindows, :cdPlayer, :centralLocking, :crashSensor, :leatherSeats
            )";

    $query = $dbh->prepare($sql);
    $query->bindParam(':vehicleTitle', $vehicleTitle, PDO::PARAM_STR);
    $query->bindParam(':vehicleBrand', $vehicleBrand, PDO::PARAM_STR);
    $query->bindParam(':vehicleOverview', $vehicleOverview, PDO::PARAM_STR);
    $query->bindParam(':pricePerDay', $pricePerDay, PDO::PARAM_STR);
    $query->bindParam(':fuelType', $fuelType, PDO::PARAM_STR);
    $query->bindParam(':modelYear', $modelYear, PDO::PARAM_STR);
    $query->bindParam(':seatingCapacity', $seatingCapacity, PDO::PARAM_STR);
    $query->bindParam(':vimage1', $imagePaths['vimage1'], PDO::PARAM_STR);
    $query->bindParam(':vimage2', $imagePaths['vimage2'], PDO::PARAM_STR);
    $query->bindParam(':vimage3', $imagePaths['vimage3'], PDO::PARAM_STR);
    $query->bindParam(':vimage4', $imagePaths['vimage4'], PDO::PARAM_STR);
    $query->bindParam(':vimage5', $imagePaths['vimage5'], PDO::PARAM_STR);
    $query->bindParam(':airConditioner', $airConditioner, PDO::PARAM_INT);
    $query->bindParam(':powerDoorLocks', $powerDoorLocks, PDO::PARAM_INT);
    $query->bindParam(':antiLockBrakingSystem', $antiLockBrakingSystem, PDO::PARAM_INT);
    $query->bindParam(':brakeAssist', $brakeAssist, PDO::PARAM_INT);
    $query->bindParam(':powerSteering', $powerSteering, PDO::PARAM_INT);
    $query->bindParam(':driverAirbag', $driverAirbag, PDO::PARAM_INT);
    $query->bindParam(':passengerAirbag', $passengerAirbag, PDO::PARAM_INT);
    $query->bindParam(':powerWindows', $powerWindows, PDO::PARAM_INT);
    $query->bindParam(':cdPlayer', $cdPlayer, PDO::PARAM_INT);
    $query->bindParam(':centralLocking', $centralLocking, PDO::PARAM_INT);
    $query->bindParam(':crashSensor', $crashSensor, PDO::PARAM_INT);
    $query->bindParam(':leatherSeats', $leatherSeats, PDO::PARAM_INT);

    if ($query->execute()) {
        echo "<script>alert('Car added successfully!');</script>";
    } else {
        echo "<script>alert('Failed to add car.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car - Car Rental</title>
    <link rel="stylesheet" href="\css\style.css"> <!-- Add this line -->
</head>
<body>
    <?php include('../includes/admin-header.php'); ?>

    <main>
        <section class="add-car-section">
            <h1>Add New Car</h1>
            <form method="post" enctype="multipart/form-data">
                <!-- Basic Car Details -->
                <label for="vehicleTitle">Vehicle Title:</label>
                <input type="text" id="vehicleTitle" name="vehicleTitle" required>

                <label for="vehicleBrand">Brand:</label>
                <select id="vehicleBrand" name="vehicleBrand" required>
                    <?php
                    $sql = "SELECT * FROM tblbrands";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $brands = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach ($brands as $brand) {
                        echo "<option value='{$brand->id}'>{$brand->BrandName}</option>";
                    }
                    ?>
                </select>

                <label for="vehicleOverview">Overview:</label>
                <textarea id="vehicleOverview" name="vehicleOverview" required></textarea>

                <label for="pricePerDay">Price Per Day:</label>
                <input type="number" id="pricePerDay" name="pricePerDay" required>

                <label for="fuelType">Fuel Type:</label>
                <select id="fuelType" name="fuelType" required>
                    <option value="">Select Fuel Type</option>
                   <option value="Petrol">Petrol</option>
                   <option value="Diesel">Diesel</option>
                   <option value="Electric">Electric</option>
                   <option value="Hybrid">Hybrid</option>
                   <option value="CNG">CNG</option>
                </select>


                <label for="modelYear">Model Year:</label>
                <input type="number" id="modelYear" name="modelYear" required>

                <label for="seatingCapacity">Seating Capacity:</label>
                <input type="number" id="seatingCapacity" name="seatingCapacity" required>

                <!-- Image Uploads -->
                <label for="vimage1">Image 1:</label>
                <input type="file" id="vimage1" name="vimage1" accept="image/*">

                <label for="vimage2">Image 2:</label>
                <input type="file" id="vimage2" name="vimage2" accept="image/*">

                <label for="vimage3">Image 3:</label>
                <input type="file" id="vimage3" name="vimage3" accept="image/*">

                <label for="vimage4">Image 4:</label>
                <input type="file" id="vimage4" name="vimage4" accept="image/*">

                <label for="vimage5">Image 5:</label>
                <input type="file" id="vimage5" name="vimage5" accept="image/*">

                <!-- Car Features -->
                <label> Air Conditioner<input type="checkbox" name="airConditioner"></label>
                <label>Power Door Locks<input type="checkbox" name="powerDoorLocks"> </label>
                <label>Anti-Lock Braking System<input type="checkbox" name="antiLockBrakingSystem"> </label>
                <label>Brake Assist<input type="checkbox" name="brakeAssist"> </label>
                <label>Power Steering<input type="checkbox" name="powerSteering"> </label>
                <label>Driver Airbag<input type="checkbox" name="driverAirbag"> </label>
                <label>Passenger Airbag<input type="checkbox" name="passengerAirbag"></label>
                <label>Power Windows<input type="checkbox" name="powerWindows"> </label>
                <label>CD Player<input type="checkbox" name="cdPlayer"> </label>
                <label>Central Locking<input type="checkbox" name="centralLocking"> </label>
                <label>Crash Sensor<input type="checkbox" name="crashSensor"> </label>
                <label>Leather Seats<input type="checkbox" name="leatherSeats"> </label>

                <button type="submit" name="add_car">Add Car</button>
            </form>
        </section>
    </main>
</body>
</html>