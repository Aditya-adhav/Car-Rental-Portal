<?php include('includes/header.php'); ?>

<main>
    <h1>Car Listings</h1>

    <!-- Filter Section -->
    <section class="filters">
        <form method="GET" action="">
            <label for="brand">Brand:</label>
            <select name="brand" id="brand">
                <option value="">All Brands</option>
                <?php
                // Fetch all brands from the database
                $brandSql = "SELECT * FROM tblbrands";
                $brandQuery = $dbh->prepare($brandSql);
                $brandQuery->execute();
                $brands = $brandQuery->fetchAll(PDO::FETCH_OBJ);

                foreach ($brands as $brand) {
                    $selected = (isset($_GET['brand']) && $_GET['brand'] == $brand->id) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($brand->id) . "' $selected>" . htmlspecialchars($brand->BrandName) . "</option>";
                }
                ?>
            </select>

            <label for="fuelType">Fuel Type:</label>
            <select name="fuelType" id="fuelType">
                <option value="">All Fuel Types</option>
                <?php
                // Fetch all unique fuel types from the database
                $fuelSql = "SELECT DISTINCT FuelType FROM tblvehicles";
                $fuelQuery = $dbh->prepare($fuelSql);
                $fuelQuery->execute();
                $fuelTypes = $fuelQuery->fetchAll(PDO::FETCH_OBJ);

                foreach ($fuelTypes as $fuel) {
                    $selected = (isset($_GET['fuelType']) && $_GET['fuelType'] == $fuel->FuelType) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($fuel->FuelType) . "' $selected>" . htmlspecialchars($fuel->FuelType) . "</option>";
                }
                ?>
            </select>

            <button type="submit">Apply Filters</button>
        </form>
    </section>

    <!-- Car Listings Section -->
    <section class="car-listings">
        <?php
        // Build the base SQL query
        $sql = "SELECT * FROM tblvehicles WHERE 1";

        // Add filters based on user input
        if (isset($_GET['brand']) && !empty($_GET['brand'])) {
            $brandId = intval($_GET['brand']);
            $sql .= " AND VehiclesBrand = :brandId";
        }

        if (isset($_GET['fuelType']) && !empty($_GET['fuelType'])) {
            $fuelType = htmlspecialchars($_GET['fuelType']);
            $sql .= " AND FuelType = :fuelType";
        }

        // Prepare and execute the query
        $query = $dbh->prepare($sql);

        if (isset($brandId)) {
            $query->bindParam(':brandId', $brandId, PDO::PARAM_INT);
        }

        if (isset($fuelType)) {
            $query->bindParam(':fuelType', $fuelType, PDO::PARAM_STR);
        }

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
                echo "<div class='car'>";
                echo "<h2>" . htmlspecialchars($result->VehiclesTitle) . "</h2>";
                echo "<p>Brand: " . htmlspecialchars($result->VehiclesBrand) . "</p>";
                echo "<p>Price: $" . htmlspecialchars($result->PricePerDay) . "/Day</p>";
                echo "<p>Fuel Type: " . htmlspecialchars($result->FuelType) . "</p>";
                echo "<p>Seating Capacity: " . htmlspecialchars($result->SeatingCapacity) . "</p>";
                echo "<a href='vehicle-details.php?id=" . htmlspecialchars($result->id) . "'>
                      <img src='images/Cars/" . htmlspecialchars($result->Vimage1) . "' alt='" . htmlspecialchars($result->VehiclesTitle) . "'>
                      </a>";
                echo "</div>";
            }
        } else {
            echo "<p>No cars available.</p>";
        }
        ?>
    </section>
</main>

<?php include('includes/footer.php'); ?>