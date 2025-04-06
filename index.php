<?php include('includes/header.php'); ?>
<section class="hero">
    </section>
<main>
    <section class="car-listings">
        <?php
        include('includes/config.php');
        $sql = "SELECT * FROM tblvehicles";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
                echo "<div class='car'>";
                echo "<h2>" . htmlspecialchars($result->VehiclesTitle) . "</h2>";
                echo "<p>Price: $" . htmlspecialchars($result->PricePerDay) . "/Day</p>";
                echo "<p>Fuel Type: " . htmlspecialchars($result->FuelType) . "</p>";
                echo "<p>Seating Capacity: " . htmlspecialchars($result->SeatingCapacity) . "</p>";
                echo "<a href='vehicle-details.php?id=" . htmlspecialchars($result->id) . "'>
                <img src='images/Cars/" . htmlspecialchars($result->Vimage1) . "' alt='" . htmlspecialchars($result->VehiclesTitle) . "'>
                    </a>";echo "</div>";
            }
        } else {
            echo "<p>No cars available.</p>";
        }
        ?>
    </section>
</main>
<?php include('includes/footer.php'); ?>