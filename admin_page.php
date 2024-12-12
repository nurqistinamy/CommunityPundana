<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

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

<section class="dashboard">

   <h1 class="title">dashboard</h1>
   
   <div class="box-container">

     <div class="box">  
         <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `attendees` WHERE registration_status = 'pending'") or die('query failed');		 
            while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
               $total_pendings += $fetch_pendings['total_price'];
            };
         ?>	
         <h3>RM<?php echo $total_pendings; ?>/-</h3>
         <p>total pendings</p>		 
     </div>	 
	 
      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `attendees` WHERE registration_status = 'completed'") or die('query failed');
            while($fetch_completes = mysqli_fetch_assoc($select_completes)){
               $total_completes += $fetch_completes['total_price'];
            };
         ?>
         <h3>RM<?php echo $total_completes; ?>/-</h3>
         <p>completed registers</p>
      </div>	 
	  
      <div class="box">
         <?php
            $select_attendees = mysqli_query($conn, "SELECT * FROM `attendees`") or die('query failed');
            $number_of_attendees = mysqli_num_rows($select_attendees);
         ?>
         <h3><?php echo $number_of_attendees; ?></h3>
         <p>attendees joined</p>
      </div>	  

      <div class="box">
         <?php
            $select_posts = mysqli_query($conn, "SELECT * FROM `posts`") or die('query failed');
            $number_of_posts = mysqli_num_rows($select_posts);
         ?>
         <h3><?php echo $number_of_posts; ?></h3>
         <p>posts added</p>
      </div>
	  
      <div class="box">
         <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>normal users</p>
      </div>

      <div class="box">
         <?php
            $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admin = mysqli_num_rows($select_admin);
         ?>
         <h3><?php echo $number_of_admin; ?></h3>
         <p>admin users</p>
      </div>
	  
      <div class="box">
         <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
         ?>
         <h3><?php echo $number_of_account; ?></h3>
         <p>total accounts</p>
      </div>	  
	  
      <div class="box">
         <?php
            $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            $number_of_message = mysqli_num_rows($select_message);
         ?>
         <h3><?php echo $number_of_message; ?></h3>
         <p>new messages</p>
      </div>	  
	  
   </div>
   
</section>











<script src="js/admin_script.js"></script>

</body>
</html>