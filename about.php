
<?php
include 'components/config.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  
    <link rel="stylesheet" href="style.css" />

    <title>About</title>
  </head>
  <body>


  <!-- header section starts  -->

   <?php include 'components/header.php'; ?>

  <!-- header section ends -->

    <section class="about">
      <div class="section__container about_container">
        <div class="about_image">
          <div class="about_col">
            <img src="assets/recipes-1.jpg" alt="gallary" />
          </div>
          <div class="about_col">
            <img src="assets/recipes-2.jpg" alt="gallary" />
            <img src="assets/recipes-3.jpg" alt="gallary" />
          </div>
        </div>
        <div class="about_content">
          <div>
            <h2 class="section_title">About</h2>
            <h2 class="section__title">
             Want to know about us
            </h2>
            <p class="section__subtitle">
            join culinary adventures where we'll be using simple, 
            fresh ingredients and transforming them into sophisticated and elegant meals for the everyday home cook.


            </p>
           
          </div>
        </div>
      </div>
    </section>

    <section class="about">
     <div class="section__container">
        <div class="about_content">
             <h2 class="section_title" id="contact_us">Contact Us</h2>
             <h2 class="section__title">
             Get in touch
            </h2>             
        </div>

        <div class="contactus">
            <div class="contact_col">
              <h1>
              Admin :
              </h1>
          
              <p class="section__subtitle">
                admin@cookbook.com
              </p>
            </div>

            <div class="contact_col">
              <h1>
              Admin :
              </h1>
          
              <p class="section__subtitle">
                himans@cookbook.com
              </p>
            </div>

            <div class="contact_col">
              <h1>
              Admin :
              </h1>
          
              <p class="section__subtitle">
                bihara@cookbook.com
              </p>
            </div>

            <div class="contact_col">
              <h1>
              Admin :
              </h1>
          
              <p class="section__subtitle">
                sadith@cookbook.com
              </p>
            </div>

            <div class="contact_col">
              <h1>
              Admin :
              </h1>
          
              <p class="section__subtitle">
                akalanka@cookbook.com
              </p>
            </div>

        </div>
      </div>
    </section>

<!--------------------------------subscribe section--------------------------->



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

 <?php include 'components/footer.php'; ?>


<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alerts.php'; ?>


  </body>
</html>
