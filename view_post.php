<?php

include 'components/config.php';

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:index.php');
}

if(isset($_POST['delete_review'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `reviews` WHERE ReviewID = ?");
   $verify_delete->bind_param("s", $delete_id);
   $verify_delete->execute();
   $verify_delete_result = $verify_delete->get_result();

   if($verify_delete_result->num_rows > 0){
      $delete_review = $conn->prepare("DELETE FROM `reviews` WHERE ReviewID = ?");
      $delete_review->bind_param("s", $delete_id);
      $delete_review->execute();
      $success_msg[] = 'Review deleted!';
   }else{  
      $warning_msg[] = 'Review already deleted!';
   }

}

?>

<?php


if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:all_posts.php');
}

if(isset($_POST['delete_recipe'])){
   
   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `recipe` WHERE id = ?");
   $verify_delete->bind_param("s", $get_id);
   $verify_delete->execute();
   $verify_delete_result = $verify_delete->get_result();

   if($verify_delete_result->num_rows > 0){
      $delete_review = $conn->prepare("DELETE FROM `recipe` WHERE id = ?");
      $delete_review->bind_param("s", $get_id);
      $delete_review->execute();
      $success_msg[] = 'Recipe deleted!';
      echo '<script>';
      echo 'function refreshPage() {';
      echo '   window.parent.location.reload();';
      echo '}';
      echo 'refreshPage();'; // Call the JavaScript function
      echo '</script>';
   }else{  
      $warning_msg[] = 'Recipe already deleted!';
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
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->

<!-- header section ends -->

<!-- view recipes section starts  -->

<section class="view-post">

  <?php
include 'components/connect.php';

$select_post = $conn->prepare("SELECT * FROM `recipe` WHERE id = ? LIMIT 1");
$select_post->bind_param("s", $get_id);
$select_post->execute();
$select_post_result = $select_post->get_result();

if($select_post_result->num_rows > 0){
    while($fetch_post = $select_post_result->fetch_assoc()){
        $total_ratings = 0;
        $rating_1 = 0;
        $rating_2 = 0;
        $rating_3 = 0;
        $rating_4 = 0;
        $rating_5 = 0;

        $select_ratings = $conn->prepare("SELECT * FROM `reviews` WHERE RecipeID = ?");
        $select_ratings->bind_param("s", $fetch_post['id']);
        $select_ratings->execute();
        $select_ratings_result = $select_ratings->get_result();
        $total_reivews = $select_ratings_result->num_rows;

        while($fetch_rating = $select_ratings_result->fetch_assoc()){
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

        $ingredients = explode(", ", $fetch_post['ingredients']);
        $directions = explode(", ", $fetch_post['directions']);
?>
<section class="view-post">
    <div class="row">
        <div class="col">
            <div class="flex">
                <div class="total-reviews">
                    <h2 class="title"><?= $fetch_post['title']; ?></h2>
                    <h3><?= $average; ?><i class="fas fa-star"></i></h3>
                    <p><?= $total_reivews; ?> reviews</p>
                    <a href="#reviews">read reviews</a> 
                </div>
           
            </div>
            <center>
            
            <form action="" method="post" class="flex-btn">
            <input type="hidden" name="delete_id" value="<?= $fetch_post['id']; ?>">
            <a href="update_recipe.php?get_id=<?= $fetch_post['id']; ?>" class="inline-option-btn">edit recipe</a>
            <input type="submit" value="delete recipe" class="inline-delete-btn" name="delete_recipe" onclick="return confirm('delete this recipe?');">
         </form>
    </center> 
        </div>
        <div class="col">
            <img src="uploaded_files/<?= $fetch_post['image']; ?>" alt="" class="image">
        </div>
    </div>
</section>

<!-- View Ingredients section -->
<section style="background-image: url(images/menu-bg.png);" class="bg_image">
    <div class="ingredients_container">
        <div class="section_header">
            <p class="section_title">Ingredients</p> 
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

<!-- Directions section -->
<section class="directions">
    <div class="directions-container">
        <div class="section_header">
            <p class="section_title">Directions</p> 
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

<!-- reviews section starts  -->

 <section class="reviews-container" id="reviews">

   <div class="section_header">
      <p class="section_title">user's reviews</p> 
   </div>
   
   <div>
      <a href="add_review.php?get_id=<?= $get_id; ?>" class="inline-btn" style="margin-top: 0;">add review</a>
   </div>

   <div class="box-container">

   <?php
      $select_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE RecipeID = ?");
      $select_reviews->bind_param("s", $get_id);
      $select_reviews->execute();
      $select_reviews_result = $select_reviews->get_result();
      if($select_reviews_result->num_rows > 0){
         while($fetch_review = $select_reviews_result->fetch_assoc()){
   ?>
   <div class="box" <?php if($fetch_review['UserID'] == $user_id){echo 'style="order: -1;"';}; ?>>
      <?php
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_user->bind_param("s", $fetch_review['UserID']);
         $select_user->execute();
         $select_user_result = $select_user->get_result();
         while($fetch_user = $select_user_result->fetch_assoc()){
      ?>
      <div class="user">
         <?php if($fetch_user['image'] != ''){ ?>
            <img src="uploaded_files/<?= $fetch_user['image']; ?>" alt="">
         <?php }else{ ?>   
            <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
         <?php }; ?>   
         <div>
            <p><?= $fetch_user['name']; ?></p>
            <span><?= $fetch_review['date']; ?></span>
         </div>
      </div>
      <?php }; ?>
      <div class="ratings">
         <p style="background:var(--orange);"><i class="fas fa-star"></i> <span><?= $fetch_review['Rating']; ?></span></p>
      </div>
      


      <?php if($fetch_review['description'] != ''){ ?>
         <p class="description"><?= $fetch_review['description']; ?></p>
      <?php }; ?>  
      <?php if($fetch_review['UserID'] == $user_id){ ?>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="delete_id" value="<?= $fetch_review['ReviewID']; ?>">
            <a href="update_review.php?get_id=<?= $fetch_review['ReviewID']; ?>" class="inline-option-btn">edit review</a>
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

<!-- reviews section ends -->


<section class="subscribe" style="background-image: url(images/blog-pattern-bg.png);">
        <div class="wrap">
          <form action="">
            <p>Get the latest recipe right into your inbox:</p>
            <input type="text" placeholder="Email Address...">
            <button type="submit">Subscribe</button> 
          </form>
       </div> 
      </section>

<!--------------------------------Footer section--------------------------->

<footer class="footer">
       <!---- <div class="book-table-shape">
          <img src="images/table-leaves-shape.png" alt="">
        </div> -->

        <div class="book-table-shape book-table-shape2">
          <img src="images/table-leaves-shape.png" alt="">
        </div>
        <div class="footer__container">
          <div class="footer__col">
            <h3>Cookbook<span>.</span></h3>
            <p>
              Explore your suitable and dream places around the world. Here you
              can find your right recipes.
            </p>
            <div class="social-icon">
              <ul>
                  <li>
                      <a href="#">
                          <i class="uil uil-facebook-f"></i>
                      </a>
                  </li>
                  <li>
                      <a href="#">
                          <i class="uil uil-instagram"></i>
                      </a>
                  </li>
                  <li>
                      <a href="#">
                          <i class="uil uil-github-alt"></i>
                      </a>
                  </li>
                  <li>
                      <a href="#">
                          <i class="uil uil-youtube"></i>
                      </a>
                  </li>
              </ul>
          </div>
          </div>
          <div class="footer-flex-box">
            <div class="footer__col">
              <h4>Links</h4>
              <ul class="column-2">
                <li>
                    <a href="#home" class="footer-active-menu">Home</a>
                </li>
                <li><a href="#about">About</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            </div>
            <div class="footer__col">
              <h4>Links</h4>
              <ul class="column-2">
                <li>
                    <a href="#home" class="footer-active-menu">Home</a>
                </li>
                <li><a href="#about">About</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            </div>
            <div class="footer__col">
              <h4>Company</h4>
              <ul class="column-2">
                <li><a href="#about">Terms & Conditions</a></li>
                <li><a href="#menu">Privacy Policy</a></li>
                <li><a href="#gallery">FAQ</a></li>
            </ul>
            </div>
          </div>   
        </div>
        <div class="footer__bar">
          Copyright © 2023 Cookbook. All rights reserved.
        </div>
      </footer>










<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alers.php'; ?>

</body>
</html>
