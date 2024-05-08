<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$login_url = $is_logged_in ? 'profile.php' : 'login.php';
?>

<link rel="stylesheet" href="css/style.css">

<!-- Nav Bar + Video -->
<div class="hero">
   <nav>
      <img src="images/logo_blanc.png" class="logo">
      <ul class="navbar">
         <li><a href="home.php">Home</a></li>
         <li><a href="catalog.php">Catalog</a></li>
         <li><a href="orders.php">Order</a></li>
         <li><a href="about.php">About</a></li>
      </ul>

      <div class="logo-nav">
         <div class="icons">
            <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
            ?>
            <a href="search.php"><i class="fas fa-search"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
            <a href="<?= $login_url; ?>"><div id="user-btn" class="fas fa-user"></div></a>
            <div id="menu-btn" class="fas fa-bars"></div>
         </div>
      </div>
   </nav>
</div>
