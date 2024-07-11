<?php

include 'components/config.php';


if (isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
} else {
   $get_id = '';
   header('location:index.php');
}

if (isset($_POST['delete_review'])) {

   $delete_id = $_POST['delete_id'];

   $verify_delete_query = "SELECT * FROM `reviews` WHERE ReviewID = '$delete_id'";
   $verify_delete_result = mysqli_query($conn, $verify_delete_query);

   if (mysqli_num_rows($verify_delete_result) > 0) {
      $delete_review_query = "DELETE FROM `reviews` WHERE ReviewID = '$delete_id'";
      mysqli_query($conn, $delete_review_query);
      $success_msg[] = 'Review deleted!';
   } else {
      $warning_msg[] = 'Review already deleted!';
   }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>view post</title>


   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   


<!-- header section starts  -->

<?php include 'components/header.php'; ?>

<!-- header section ends -->





<!--------------------------------view recipes section starts----------------------------->


<section class="view_recipe">

  <?php

$select_post = mysqli_query($conn, "SELECT * FROM `recipe` WHERE id = '$get_id' LIMIT 1");

if(mysqli_num_rows($select_post) > 0){
    while($fetch_post = mysqli_fetch_assoc($select_post)){
        $total_ratings = 0;
        $rating_1 = 0;
        $rating_2 = 0;
        $rating_3 = 0;
        $rating_4 = 0;
        $rating_5 = 0;

        $select_ratings = mysqli_query($conn, "SELECT * FROM `reviews` WHERE RecipeID = '".$fetch_post['id']."'");
        $total_reivews = mysqli_num_rows($select_ratings);

        while($fetch_rating = mysqli_fetch_assoc($select_ratings)){
            $total_ratings += $fetch_rating['Rating'];
            if($fetch_rating['Rating'] == 1){
                $rating_1 += $fetch_rating['Rating'];
            }
            if($fetch_rating['Rating'] == 2){
                $rating_2 += $fetch_rating['Rating'];
            }
            if($fetch_rating['Rating'] == 3){
                $rating_3 += $fetch_rating['Rating'];
            }
            if($fetch_rating['Rating'] == 4){
                $rating_4 += $fetch_rating['Rating'];
            }
            if($fetch_rating['Rating'] == 5){
                $rating_5 += $fetch_rating['Rating'];
            }
        }

        if($total_reivews != 0){
            $average = round($total_ratings / $total_reivews, 1);
        }else{
            $average = 0;
        }

        $ingredients = explode("$ ", $fetch_post['ingredients']);
        $directions = explode("$ ", $fetch_post['directions']);
?>
<section class="view_recipe">
    <div class="row">
        <div class="col">
            <div class="flex">
                <div class="total-reviews">
                    <h2 class="title"><?= $fetch_post['title']; ?></h2>
                    <h2><?= $fetch_post['cuisine']; ?></h2>
                    <h3><?= $average; ?><i class="fas fa-star"></i></h3>
                    <p><?= $total_reivews; ?> reviews</p>
                    <a href="#reviews">read reviews</a> 
                </div>
            </div>
        </div>
        <div class="col">
            <img src="uploaded_files/<?= $fetch_post['image']; ?>" alt="" class="image">
        </div>
    </div>
</section>






<!--------------------------------View Ingredients section----------------------------->

<section style="background-image: url(images/menu-bg.png);" class="bg_image">
    <div class="ingredients_container">
        <div class="s_header">
            <p class="section__title">Ingredients</p> 
        </div>
        <div> 
            <ul>
               <?php if(isset($ingredients) && is_array($ingredients)): ?>
                  <?php foreach($ingredients as $ingredient): ?>
                     <span><li class="text-base"><?= $ingredient; ?></li></span>
                  <?php endforeach; ?>
               <?php endif; ?>
         </ul>
         </p>
        </div> 
    </div>
</section>





<!--------------------------------Directions section----------------------------->

<section class="directions">
    <div class="directions-container">
        <div class="s_header">
            <p class="section__title">Directions</p> 
        </div>
        <div> 
            <p class="text-base">
                <?php if(isset($directions) && is_array($directions)): ?>
                    <?php foreach($directions as $direction): ?>
                        <span><?= $direction; ?></span><br><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
</section>
<?php
    }
}else{
    echo '<p class="empty">Post is missing!</p>';
}
?>




<!--------------------------------reviews section starts----------------------------->


<section class="reviews-container" id="reviews">

   <div class="s_header">
      <p class="section__title">user's reviews</p> 
   </div>


  
   <!-- add review  -->
   <div>
   <?php

      if(isset($_POST['submit'])){
        if($user_id != ''){
            $id = create_unique_id();
            
            $description = $_POST['description'];
            $rating = $_POST['rating'];

            $verify_review = mysqli_query($conn, "SELECT * FROM `reviews` WHERE RecipeID = '$get_id' AND UserID = '$user_id'");
            $verify_review_result = mysqli_num_rows($verify_review);

            if($verify_review_result > 0){
              $warning_msg[] = 'Your review already added!';
            }else{
              $add_review = mysqli_query($conn, "INSERT INTO `reviews`(ReviewID, RecipeID, UserID, rating, description) VALUES('$id', '$get_id', '$user_id', '$rating', '$description')");
              $success_msg[] = 'Review added!';
            }
        }else{
            $warning_msg[] = 'Please login first!';
        }
      }

?>



<div class="review-form">
   <form action="" method="post">
      <h3>post your review</h3>
      
      <p class="placeholder">review description</p>
      <textarea name="description" class="box" placeholder="enter review description" maxlength="1000" cols="30" rows="10"></textarea>
      <p class="placeholder">review rating <span>*</span></p>
      <select name="rating" class="box" required>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
      </select>
      <input type="submit" value="submit review" name="submit" class="btn">
      
   </form>
</div>
  


<!-- display reviews  -->
   <div class="box-container">

   <?php
$select_reviews = mysqli_query($conn, "SELECT * FROM `reviews` WHERE RecipeID = '$get_id'");
if (mysqli_num_rows($select_reviews) > 0) {
   while ($fetch_review = mysqli_fetch_assoc($select_reviews)) {
?>
   <div class="box" <?php if ($fetch_review['UserID'] == $user_id) {
      echo 'style="order: -1;"'; } ?>>

      <?php
      $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '".$fetch_review['UserID']."'");
      while ($fetch_user = mysqli_fetch_assoc($select_user)) {
      ?>
     <div class="user">
            <?php if ($fetch_user['image'] != '') { ?>
               <img src="uploaded_files/<?= $fetch_user['image']; ?>" alt="">
            <?php } else { ?>
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
            <?php }; ?>
            <div>
               <p><?= $fetch_user['name']; ?> _ <span><?= $fetch_review['date']; ?></span></p>
               <div class="ratings">
                  <p>
                      <?php
                      $rating = $fetch_review['Rating'];
                      for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo '<i class="fas fa-star"></i> ';
                        } else {
                            echo '<i class="far fa-star"></i> ';
                        }
                      }
                      ?>
                  </p>
                </div>
            </div>
         </div>
      <?php }; ?>
      
      


      <?php if($fetch_review['description'] != ''){ ?>
         <p class="description"><?= $fetch_review['description']; ?></p>
      <?php }; ?>  
      <?php if($fetch_review['UserID'] == $user_id){ ?>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="delete_id" value="<?= $fetch_review['ReviewID']; ?>">
            <a href="update_review.php?get_id=<?= $fetch_review['ReviewID']; ?>" class="inline-option-btn"  id="show-form">edit review</a>
            <input type="submit" value="delete review" class="inline-delete-btn" name="delete_review" onclick="return confirm('delete this review?');">
         </form>
      <?php }; ?>   
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no reviews added yet!</p>';
      }
   ?>

   </div>

   </section>

<!--------------------------------subscribe section----------------------------->


<section class="subscribe" style="background-image: url(images/blog-pattern-bg.png);">
        <div class="wrap">
          <form action="">
            <p>Get the latest recipe right into your inbox:</p>
            <input type="text" placeholder="Email Address...">
            <button type="submit">Subscribe</button> 
          </form>
       </div> 
      </section>

<!--------------------------------Footer section--------------------------------->

<?php include 'components/footer.php'; ?>






<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alerts.php'; ?>

</body>
</html>
