<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('Location: home.php');
   exit;
}

// Fetch user profile data from the database
$fetch_profile = [];
try {
    $stmt = $conn->prepare("SELECT name, number, email, address FROM users WHERE id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $fetch_profile = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- Header section starts -->
<?php include 'components/user_header.php'; ?>
<!-- Header section ends -->

<section class="user-details">
   <div class="user">
      <img src="images/user-icon.png" alt="User Icon">
      <p><i class="fas fa-user"></i><span><?= htmlspecialchars($fetch_profile['name'] ?? 'N/A'); ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= htmlspecialchars($fetch_profile['number'] ?? 'N/A'); ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= htmlspecialchars($fetch_profile['email'] ?? 'N/A'); ?></span></p>
      <a href="update_profile.php" class="btn">Update Info</a>
      <p class="address"><i class="fas fa-map-marker-alt"></i><span><?= empty($fetch_profile['address']) ? 'Please enter your address' : htmlspecialchars($fetch_profile['address']); ?></span></p>
      <a href="update_address.php" class="btn">Update Address</a></br>
      <!-- Logout Button -->
      <a href="components/user_logout.php" class="btn">Logout</a> <!-- Adjust the path to reflect actual location -->
   </div>
</section>

<?php include 'components/footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>
</body>
</html>
