<?php
include 'components/config.php';

if (isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
} else {
   $get_id = '';
   header('location:index.php');
}

if (isset($_POST['submit'])) {
   if ($user_id != '') {
      $id = create_unique_id();
      
      $description = $_POST['description'];
      $rating = $_POST['rating'];

      $verify_review_query = "SELECT * FROM `reviews` WHERE RecipeID = '$get_id' AND UserID = '$user_id'";
      $verify_review_result = mysqli_query($conn, $verify_review_query);

      if (mysqli_num_rows($verify_review_result) > 0) {
         $warning_msg[] = 'Your review has already been added!';
      } else {
         $add_review_query = "INSERT INTO `reviews`(ReviewID, RecipeID, UserID, rating, description) VALUES('$id', '$get_id', '$user_id', '$rating', '$description')";
         $add_review_result = mysqli_query($conn, $add_review_query);
         
         if ($add_review_result) {
            $success_msg[] = 'Review added!';
         } else {
            $warning_msg[] = 'Error occurred while adding the review!';
         }
      }
   } else {
      $warning_msg[] = 'Please login first!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>add review</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>
<body>
   


<!-- add review section starts  -->


<section class="account-form">
   <?php
   if ($user_id == '') {
      echo "<p>Please login first to add a review.</p>";
   } else {
   ?>
      <form action="" method="post">
         <h3>Post Your Review</h3>
      
         <p class="placeholder">Review Description</p>
         <textarea name="description" class="box" placeholder="Enter review description" maxlength="1000" cols="30" rows="10"></textarea>
      
         <p class="placeholder">Review Rating <span>*</span></p>
         <select name="rating" class="box" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select>
      
         <input type="submit" value="Submit Review" name="submit" class="btn">
      </form>
   <?php
   }
   ?>
</section>

<!-- add review section ends -->

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alerts.php'; ?>

</body>
</html>
