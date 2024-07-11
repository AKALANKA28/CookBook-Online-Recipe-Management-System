<?php

include 'components/config.php';

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $pass = $_POST['pass'];

   $verify_email = "SELECT * FROM `users` WHERE email = '$email' LIMIT 1";
   $result = mysqli_query($conn, $verify_email);

   if(mysqli_num_rows($result) > 0){
      $fetch = mysqli_fetch_assoc($result);
      $verfiy_pass = password_verify($pass, $fetch['password']);
      if($verfiy_pass == 1){
         setcookie('user_id', $fetch['id'], time() + 60*60*24*30, '/');
         header('location:index.php');
      }else{
         $warning_msg[] = 'Incorrect password!';
      }
   }else{
      $warning_msg[] = 'Incorrect email!';
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   

<!-- login section starts  -->

<section style ="background-image: url(images/menu-bg.png); "class="form">
  

      <form action="" method="post" enctype="multipart/form-data">
         <h3>welcome back!</h3>
         <p class="placeholder">your email <span>*</span></p>
         <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
         <p class="placeholder">your password <span>*</span></p>
         <input type="password" name="pass" required maxlength="50" placeholder="enter your password" class="box">
         <p class="link">don't have an account? <a href="register.php">register now</a></p>
         <input type="submit" value="login now" name="submit" class="btn">
      </form>
</div>
</section>

<!-- login section ends -->

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alerts.php'; ?>

</body>
</html>
