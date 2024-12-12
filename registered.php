<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

// Redirect if the user is not logged in
if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom Admin CSS File Link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Your Registration</h3>
    <p><a href="index.php">Home</a> / Registered</p>
</section>

<section class="placed-attendees">

    <h1 class="title">Placed Registers</h1>

    <div class="box-container">

    <?php
    // Fetch all attendees for the logged-in user
    $select_attendees = mysqli_query($conn, "SELECT * FROM `attendees` WHERE user_id = '$user_id'") or die('Query failed');
    if (mysqli_num_rows($select_attendees) > 0) {
        while ($fetch_attendees = mysqli_fetch_assoc($select_attendees)) {
            // Set default value for payment status if not present
            $payment_status = isset($fetch_attendees['payment_status']) ? $fetch_attendees['payment_status'] : 'complete';
    ?>
    <div class="box">
        <p>Placed on: <span><?php echo $fetch_attendees['placed_on']; ?></span></p>
        <p>Name: <span><?php echo $fetch_attendees['name']; ?></span></p>
        <p>Student ID: <span><?php echo $fetch_attendees['student_id']; ?></span></p>
        <p>Faculty: <span><?php echo $fetch_attendees['faculty']; ?></span></p>
        <p>Course Code: <span><?php echo $fetch_attendees['course_code']; ?></span></p>
        <p>Phone Number: <span><?php echo $fetch_attendees['phone_number']; ?></span></p>
        <p>Email: <span><?php echo $fetch_attendees['email']; ?></span></p>
        <p>Your Events: <span><?php echo $fetch_attendees['total_events']; ?></span></p>
        <p>Total Price: <span>RM<?php echo $fetch_attendees['total_price']; ?></span></p>
        <p>Payment Status: 
            <span style="color:<?php echo ($payment_status == 'pending') ? 'tomato' : 'green'; ?>">
                <?php echo $payment_status; ?>
            </span>
        </p>
    </div>
    <?php
        }
    } else {
        echo '<p class="empty">No registers placed yet!</p>';
    }
    ?>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
