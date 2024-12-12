<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_attendee'])){
   $attendee_id = $_POST['attendee_id'];
   $update_registration = $_POST['update_registration'];
   mysqli_query($conn, "UPDATE `attendees` SET registration_status = '$update_registration' WHERE id = '$attendee_id'") or die('query failed');
   $message[] = 'registration status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `attendees` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_attendees.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="placed-attendees">

   <h1 class="title">registered attendees</h1>

   <div class="box-container">

      <?php
      
      $select_attendees = mysqli_query($conn, "SELECT * FROM `attendees`") or die('query failed');
      if(mysqli_num_rows($select_attendees) > 0){
         while($fetch_attendees = mysqli_fetch_assoc($select_attendees)){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $fetch_attendees['user_id']; ?></span> </p>
         <p> placed on : <span><?php echo $fetch_attendees['placed_on']; ?></span> </p>		 
         <p> name : <span><?php echo $fetch_attendees['name']; ?></span> </p>
         <p> student id : <span><?php echo $fetch_attendees['student_id']; ?></span> </p>
         <p> faculty : <span><?php echo $fetch_attendees['faculty']; ?></span> </p>
         <p> course code : <span><?php echo $fetch_attendees['course_code']; ?></span> </p>
         <p> phone number : <span><?php echo $fetch_attendees['phone_number']; ?></span> </p>
         <p> email : <span><?php echo $fetch_attendees['email']; ?></span> </p>		 
         <p> total events : <span><?php echo $fetch_attendees['total_events']; ?></span> </p>
         <p> total price : <span>RM<?php echo $fetch_attendees['total_price']; ?>/-</span> </p>
         <form action="" method="post">
            <input type="hidden" name="attendee_id" value="<?php echo $fetch_attendees['id']; ?>">
            <select name="update_registration">
               <option disabled selected><?php echo $fetch_attendees['registration_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" name="update_attendee" value="update" class="option-btn">
            <a href="admin_attendees.php?delete=<?php echo $fetch_attendees['id']; ?>" class="delete-btn" onclick="return confirm('delete this attendee?');">delete</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no attendees registered yet!</p>';
      }
      ?>
   </div>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>