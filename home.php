<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
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
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>


   <video autoplay loop muted plays-inline class="back-video">
      <source src="images/seiko-back-video.mp4" type="video/mp4">
   </video>

<!-- Categorie 
   <section class="category">


      <h1 class="title">watch category</h1>

      <div class="box-container">

         <a href="category.php?category=NEVO" class="box">
            <img src="images/NEVO.png" alt="">
            <h3>NEVO</h3>
         </a>

         <a href="category.php?category=NIXIE" class="box">
            <img src="images/NIXIE.png" alt="">
            <h3>NIXIE</h3>
         </a>

         <a href="category.php?category=PETRA" class="box">
            <img src="images/PETRA.png" alt="">
            <h3>PETRA</h3>
         </a>
         <a href="category.php?category=ZYRHA" class="box">
            <img src="images/ZYRHA.png" alt="">
            <h3>ZYRHA</h3>
         </a>

      </div>

   </section>

-->

<div class="container">
    <div class="left-section">
      <div>
        <h2>New<br>Arrival</h2>
        <p>Discover the new watches<br> which embody the brand’s<br>uncompromising approach<br> to craftsmanship.</p>
      </div>
    </div>

    <div class="right-section">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE `New` = 1");
        $select_products->execute();
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                </form>

                <div class="box">
                    <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                    <h3><div class="name"><?= $fetch_products['name']; ?></div></h3>
                    <p class="price"><div class="price"><?= $fetch_products['price']; ?><span>€</span></div></p>
                    <button class="order-btn"><a href="quick_view.php?pid=<?= $fetch_products['id']; ?>">Watch More</a></button>
                </div>
            <?php
            }
        } else {
            echo '<p class="empty">no products added yet!</p>';
        }
        ?>
    </div>
</div>


   <?php include 'components/footer.php'; ?>



   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>