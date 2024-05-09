<?php
include 'components/connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:home.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$messages = [];

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$fetch_profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Process form submission
if (isset($_POST['update'])) {
    // Update Name
    if (!empty($_POST['name'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $update_name = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $messages[] = 'Name updated successfully!';
    }

    // Update Email
    if (!empty($_POST['email']) && $_POST['email'] != $fetch_profile['email']) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_email->execute([$email]);
        if ($check_email->rowCount() > 0) {
            $messages[] = 'Email already taken!';
        } else {
            $update_email = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $messages[] = 'Email updated successfully!';
        }
    }

    // Update Phone Number
    if (!empty($_POST['number']) && $_POST['number'] != $fetch_profile['number']) {
        $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
        $update_number = $conn->prepare("UPDATE users SET number = ? WHERE id = ?");
        $update_number->execute([$number, $user_id]);
        $messages[] = 'Phone number updated successfully!';
    }

    // Update Password
    if (!empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
        if ($_POST['new_pass'] == $_POST['confirm_pass']) {
            $new_pass = sha1($_POST['new_pass']);
            $update_pass = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_pass->execute([$new_pass, $user_id]);
            $messages[] = 'Password updated successfully!';
        } else {
            $messages[] = 'Confirm password does not match!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <section class="form-container update-form">
        <?php foreach ($messages as $message): ?>
            <div class="alert"><?= $message; ?></div>
        <?php endforeach; ?>

        <form action="" method="post">
            <h3>Update Profile</h3>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box">
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box">
            <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>" class="box">
            <input type="password" name="new_pass" placeholder="Enter new password" class="box">
            <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
            <input type="submit" value="Update Now" name="update" class="btn">
        </form>
    </section>

    <?php include 'components/footer.php'; ?>
</body>
</html>
