<?php

include 'components/config.php';

if (isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
} else {
   $get_id = '';
   header('location:index.php');
}

if (isset($_POST['submit'])) {

   $description = $_POST['description'];
   $rating = $_POST['rating'];

   $update_query = "UPDATE `reviews` SET Rating = '$rating', description = '$description' WHERE ReviewID = '$get_id' AND UserID = '$user_id'";
   $update_result = mysqli_query($conn, $update_query);

   if ($update_result) {
      $success_msg[] = 'Review updated!';
   }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update review</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>

<body>


   <!--------------------------------update reviews section----------------------------->

   <section class="form">

      <?php
      $select_query = "SELECT * FROM `reviews` WHERE ReviewID = '$get_id' AND UserID = '$user_id' LIMIT 1";
      $select_result = mysqli_query($conn, $select_query);

      if (mysqli_num_rows($select_result) > 0) {
         while ($fetch_review = mysqli_fetch_assoc($select_result)) {
      ?>
            <div>
               <form action="" method="post">
                  <h3>edit your review</h3>

                  <p class="placeholder">review description</p>
                  <textarea name="description" class="box" placeholder="enter review description" maxlength="1000" cols="30" rows="10"><?= $fetch_review['description']; ?></textarea>
                  <p class="placeholder">review rating <span>*</span></p>
                  <select name="rating" class="box" required>
                     <option value="<?= $fetch_review['Rating']; ?>"><?= $fetch_review['Rating']; ?></option>
                     <option value="1">1</option>
                     <option value="2">2</option>
                     <option value="3">3</option>
                     <option value="4">4</option>
                     <option value="5">5</option>
                  </select>
                  <input type="submit" value="update review" name="submit" class="btn">
                  <a href="view_recipe.php?get_id=<?= $fetch_review['RecipeID']; ?>" class="option-btn">go back</a>
               </form>
            </div>
      <?php
         }
      } else {
         echo '<p class="empty">something went wrong!</p>';
      }
      ?>

   </section>

  

   <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <?php include 'components/alerts.php'; ?>

</body>

</html>
