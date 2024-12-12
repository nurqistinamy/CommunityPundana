<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="index.php">home</a> / about </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/about-img-1.jpg" alt="">
        </div>

        <div class="content">
            <h3>Information Management Student Association</h3>
            <p>IMSA at UiTM is a student-led organization that represents and supports Information Management students. We organize events, workshops, and networking opportunities to help students develop key skills in information management.</p>
            <a href="event.php" class="btn">browse now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>College of Creative Arts</h3>
            <p>The CCA at UiTM manages a diverse range of extracurricular programs that promote student growth beyond academics. CCA offers opportunities to participation while enhancing their overall university experience.</p>
            <a href="event.php" class="btn">browse now</a>
        </div>

        <div class="image">
            <img src="images/about-img-2.png" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/about-img-3.png" alt="">
        </div>

        <div class="content">
            <h3>Persatuan Mahasiswa Hadhari</h3>
            <p>Persatuan Mahasiswa Hadhari (PMH) is the only Islamic association on the UiTM Puncak Perdana campus. This association is active in spreading Islam and bringing da'wah and tarbiyah programs to campus residents.</p>
            <a href="event.php" class="btn">browse now</a>
        </div>

    </div>
	
    <div class="flex">

        <div class="content">
            <h3>Jasmine Harmony</h3>
            <p>Kolej Jasmine UiTM Puncak Perdana is one of the residential colleges at UITM Puncak Perdana. It serves as a student accommodation facility, providing a comfortable and supportive environment for students living on campus.</p>
            <a href="event.php" class="btn">browse now</a>
        </div>

        <div class="image">
            <img src="images/about-img-4.jpg" alt="">
        </div>

    </div>

</section>

<section class="reviews" id="reviews">

    <h1 class="title">student says</h1>

    <div class="box-container">

        <div class="box">
            <img src="images/pic-1.jpg" alt="">
            <p>This app is awesome! I used to miss so many events, but now I know everything happening on campus. Love it!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>'Afifah</h3>
        </div>

        <div class="box">
            <img src="images/pic-2.jpg" alt="">
            <p>Community Pundana's stunning design and intuitive interface transformed my event planning for events organized by the clubs.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>Saifuddin</h3>
        </div>

        <div class="box">
            <img src="images/pic-3.jpg" alt="">
            <p>This Community Pundana system is very helpful for students. The layout is simple, and everything is easy to access.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Nadhrah</h3>
        </div>

    </div>

</section>











<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>