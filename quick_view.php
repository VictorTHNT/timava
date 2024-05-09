<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick View</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="quick-view">
    <?php
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $select_products->execute([$pid]);
    if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="" method="post" class="product-display">
        <div class="product-images">
            <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="<?= $fetch_products['name']; ?>">
        </div>
        <div class="product-details">
            <h2><?= $fetch_products['name']; ?> - <span><?= $fetch_products['category']; ?></span></h2>
            <p class="price"><?= $fetch_products['price']; ?>€</p>
            <p class="description"><?= $fetch_products['description']; ?></p>
            <div class="additional-info">
                <p><strong>Available:</strong> In stock</p>
                <p><strong>Shipping Area:</strong> Worldwide</p>
                <p><strong>Shipping Fee:</strong> Free</p>
            </div>
            <div class="actions">
               <form action="" method="post">
                  <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                  <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                  <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                   <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                   <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                  <button type="submit" name="add_to_cart" >Add to Cart <i class="fas fa-shopping-cart"></i></button>
               </form>

            </div>
        </div>
    </form>
    <?php
        }
    } else {
        echo '<p class="empty">No products found!</p>';
    }
    ?>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
