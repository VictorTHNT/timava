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
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>

   <form action="" method="post">
   <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
   <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
   <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
   <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
   <input type="hidden" name="description" value="<?= $fetch_products['description']; ?>">
   



   <div class = "card-wrapper">
      <div class = "card">

      <!-- Card Left -->
         <div class = "product-imgs">
            <div class = "img-display">
               <div class = "img-showcase">
                  <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               </div>
            </div>
         </div>

      <!-- Card Right -->

         <div class = "product-content">
            <h2 class = "product-title"><a href="category.php?category=<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></a></h2>
            <div class="name"><?= $fetch_products['name']; ?></div>
            <div class = "product-price">
               <p class = "new-price"> Price:<span><?= $fetch_products['price']; ?><span>€</span></span></p>
            </div>
            <div class = "product-detail">
               <h2>about this item: </h2>
               <p><?= $fetch_products['description']; ?></p>
               <ul>
                  <li>Color: <span>Black</span></li>
                  <li>Available: <span>in stock</span></li>
                  <li>Category: <span>Watch</span></li>
                  <li>Shipping Area: <span>All over the world</span></li>
                  <li>Shipping Fee: <span>Free</span></li>
               </ul>
            </div>

            <div class = "purchase-info">
               <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
               <button type="submit" name="add_to_cart" class="btn-prod">Add to Cart <i class = "fas fa-shopping-cart"></i></button>
            </div>
         </div>
      </div>
   </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>


















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>