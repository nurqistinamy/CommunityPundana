<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

// Redirect if the user is not logged in
if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['attendees'])) {

    // Sanitize user input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $placed_on = date('d-M-Y');

    $register_total = 0;
    $register_events = []; // Initialize as an array

    // Retrieve registered events for the user
    $register_query = mysqli_query($conn, "SELECT * FROM `register` WHERE user_id = '$user_id'") or die('Query failed');
    if (mysqli_num_rows($register_query) > 0) {
        while ($register_item = mysqli_fetch_assoc($register_query)) {
            $register_events[] = $register_item['name'] . ' (' . $register_item['quantity'] . ')';
            $sub_total = ($register_item['price'] * $register_item['quantity']);
            $register_total += $sub_total;
        }
    }

    $total_events = implode(', ', $register_events);

    // Check if this registration already exists
    $attendees_query = mysqli_query($conn, "SELECT * FROM `attendees` WHERE name = '$name' AND student_id = '$student_id' AND faculty = '$faculty' AND course_code = '$course_code' AND phone_number = '$phone_number' AND email = '$email' AND total_events = '$total_events' AND total_price = '$register_total'") or die('Query failed');

    if ($register_total == 0) {
        $message[] = 'Registration is empty!';
    } elseif (mysqli_num_rows($attendees_query) > 0) {
        $message[] = 'Registration already placed!';
    } else {
        // Insert the registration into the attendees table
        mysqli_query($conn, "INSERT INTO `attendees` (user_id, name, student_id, faculty, course_code, phone_number, email, total_events, total_price, placed_on) VALUES ('$user_id', '$name', '$student_id', '$faculty', '$course_code', '$phone_number', '$email', '$total_events', '$register_total', '$placed_on')") or die('Query failed');

        // Clear the user's registered items
        mysqli_query($conn, "DELETE FROM `register` WHERE user_id = '$user_id'") or die('Query failed');
        $message[] = 'Registered successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom Admin CSS File Link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Register Form</h3>
    <p><a href="index.php">Home</a> / Register Form</p>
</section>

<section class="display-event">
    <?php
    $grand_total = 0;
    $select_register = mysqli_query($conn, "SELECT * FROM `register` WHERE user_id = '$user_id'") or die('Query failed');
    if (mysqli_num_rows($select_register) > 0) {
        while ($fetch_register = mysqli_fetch_assoc($select_register)) {
            $total_price = ($fetch_register['price'] * $fetch_register['quantity']);
            $grand_total += $total_price;
    ?>
    <p><?php echo $fetch_register['name']; ?> <span>(<?php echo 'RM' . $fetch_register['price'] . ' x ' . $fetch_register['quantity']; ?>)</span></p>
    <?php
        }
    } else {
        echo '<p class="empty">Your register is empty</p>';
    }
    ?>
    <div class="grand-total">Grand Total: <span>RM<?php echo $grand_total; ?></span></div>
</section>

<section class="checkout">
    <form action="" method="POST">
        <h3>Place Your Registration</h3>
        <div class="flex">
            <div class="inputBox">
                <span>Your Name:</span>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="inputBox">
                <span>Student ID:</span>
                <input type="number" name="student_id" min="0" placeholder="Enter your student ID" required>
            </div>
            <div class="inputBox">
                <span>Faculty:</span>
                <input type="text" name="faculty" placeholder="Enter your faculty" required>
            </div>
            <div class="inputBox">
                <span>Course Code:</span>
                <input type="text" name="course_code" placeholder="Enter course code" required>
            </div>
            <div class="inputBox">
                <span>Phone Number:</span>
                <input type="number" name="phone_number" min="0" placeholder="Enter your number" required>
            </div>
            <div class="inputBox">
                <span>Your Email:</span>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>
        <input type="submit" name="attendees" value="Register Now" class="btn">
    </form>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
