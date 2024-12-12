<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `register` WHERE id = '$delete_id'") or die('query failed');
    header('location:registration.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `register` WHERE user_id = '$user_id'") or die('query failed');
    header('location:registration.php');
};

if(isset($_POST['update_quantity'])){
    $register_id = $_POST['register_id'];
    $register_quantity = $_POST['register_quantity'];
    mysqli_query($conn, "UPDATE `register` SET quantity = '$register_quantity' WHERE id = '$register_id'") or die('query failed');
    $message[] = 'ticket quantity updated!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>event cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>event cart</h3>
    <p> <a href="index.php">home</a> / register </p>
</section>

<section class="registration-cart">

    <h1 class="title">events added</h1>

    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_register = mysqli_query($conn, "SELECT * FROM `register` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_register) > 0){
            while($fetch_register = mysqli_fetch_assoc($select_register)){
    ?>
    <div  class="box">
        <a href="registration.php?delete=<?php echo $fetch_register['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from register?');"></a>
        <a href="view_page.php?pid=<?php echo $fetch_register['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?php echo $fetch_register['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_register['name']; ?></div>
        <div class="price">RM<?php echo $fetch_register['price']; ?></div>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $fetch_register['id']; ?>" name="register_id">
            <input type="number" min="1" value="<?php echo $fetch_register['quantity']; ?>" name="register_quantity" class="qty">
            <input type="submit" value="update" class="option-btn" name="update_quantity">
        </form>
        <div class="sub-total"> sub-total : <span>RM<?php echo $sub_total = ($fetch_register['price'] * $fetch_register['quantity']); ?></span> </div>
    </div>
    <?php
    $grand_total += $sub_total;
        }
    }else{
        echo '<p class="empty">your cart is empty</p>';
    }
    ?>
    </div>

    <div class="more-btn">
		<a href="registration.php?delete_all" 
		   class="delete-btn" 
           onclick="return confirm('Delete all from register?');">
           Delete All
		</a>   
    </div>

	<div class="register-total">
		<p>Grand Total: 
			<span>RM<?php echo $grand_total; ?></span>
			<?php if ($grand_total == 0) echo '<span class="free-text">(Free Event)</span>'; ?>
		</p>
		<a href="event.php" class="option-btn">Continue Browsing</a>
		<a href="checkout.php" class="btn">Proceed to Checkout</a>
	</div>


</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>