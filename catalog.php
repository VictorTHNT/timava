<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Handle filter inputs
$selected_range = $_GET['range'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- Header section starts -->
<?php include 'components/user_header.php'; ?>

<!-- Filter sidebar section starts -->
<section class="filter-sidebar">
    <h2>Filters</h2>
    <form action="" method="get">
        <label for="range">Range:</label>
        <select name="range" id="range">
            <option value="" <?= $selected_range == '' ? 'selected' : ''; ?>>All</option>
            <option value="NEVO" <?= $selected_range == 'NEVO' ? 'selected' : ''; ?>>NEVO</option>
            <option value="NIXIE" <?= $selected_range == 'NIXIE' ? 'selected' : ''; ?>>NIXIE</option>
            <option value="PETRA" <?= $selected_range == 'PETRA' ? 'selected' : ''; ?>>PETRA</option>
            <option value="ZYRHA" <?= $selected_range == 'ZYRHA' ? 'selected' : ''; ?>>ZYRHA</option>
        </select>

        <label for="min_price">Min Price (€):</label>
        <input type="number" name="min_price" id="min_price" value="<?= htmlspecialchars($min_price); ?>" min="0">

        <label for="max_price">Max Price (€):</label>
        <input type="number" name="max_price" id="max_price" value="<?= htmlspecialchars($max_price); ?>" min="0">

        <input type="submit" value="Apply Filters">
    </form>
</section>

<!-- Product listing section starts -->
<section class="products">
    <h1 class="title">All Products</h1>
    <div class="box-container">
        <?php
        // Build the SQL query with filtering logic
        $query = "SELECT * FROM products WHERE 1";
        if (!empty($selected_range)) {
            $query .= " AND category = :range";
        }
        if (!empty($min_price)) {
            $query .= " AND price >= :min_price";
        }
        if (!empty($max_price)) {
            $query .= " AND price <= :max_price";
        }

        // Prepare and execute the query
        $stmt = $conn->prepare($query);
        if (!empty($selected_range)) {
            $stmt->bindParam(':range', $selected_range);
        }
        if (!empty($min_price)) {
            $stmt->bindParam(':min_price', $min_price);
        }
        if (!empty($max_price)) {
            $stmt->bindParam(':max_price', $max_price);
        }
        $stmt->execute();

        // Display the products
        if ($stmt->rowCount() > 0) {
            while ($fetch_products = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>"><img
                            src="uploaded_img/<?= $fetch_products['image']; ?>" alt=""></a>
                    <a href="category.php?category=<?= $fetch_products['category']; ?>"
                       class="cat"><?= $fetch_products['category']; ?></a>
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <div class="flex">
                        <div class="price"><?= $fetch_products['price']; ?><span>€</span></div>
                    </div>
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">No products found matching the criteria!</p>';
        }
        ?>
    </div>
</section>

<!-- Footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- Footer section ends -->

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
