<!DOCTYPE html>
<html>
<head>

<script type="text/javascript">
 
    
function LoadContent(url,el) {
const elements = document.querySelectorAll('.nav-link');    
   elements.forEach((element) => {
  element.classList.remove('current');
});
    el.classList.add('current');
    document.getElementById('contentFrame').src = url;
} 

function LoadContentByURL(url) {
  alert()
    //document.getElementById('contentFrame').src = url;
} 

  </script>
<title>Professional profile</title>
<link rel="stylesheet" type="text/css" href="custom.css">
<link rel="stylesheet" href="css/style.css">
<style>
      .container {
    display: flex;
}

.sidebar {
    width: 20%;
    background-color: #f0f0f0;
    padding: 20px;
    text-align: center;
}

.profile-picture {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin-bottom: 20px;
}

.navigation-menu {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.navigation-menu li {
    margin-bottom: 10px;
}

.navigation-menu li a {
    text-decoration: none;
    color: #000;
    font-weight: bold;
}

.main-content {
  width: 80%;

}
h2{
  margin-bottom: 35px;
  font-size: 20px;
  font-weight: 600;
  }
    </style>
</head>
<body>


<!-- header section starts  -->

<?php include 'components/header.php'; ?>

<!-- header section ends -->



 <div class="container">
        <div class="sidebar">
           
<?php include  'components/config.php';?>
<?php
   $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
   $stmt->bind_param('s', $user_id);
   $stmt->execute();
   $result = $stmt->get_result();
   if($result->num_rows > 0){
      while($fetch_user = $result->fetch_assoc()){
    
   ?>
   <img src="uploaded_files/<?= $fetch_user['image']; ?>" class='profile-picture'/>";
   <br/><br/>
   <h2><?= $fetch_user['name']; ?></h2>
   <br/><br/>
   <?php
         }
      }else{
         echo '<p class="empty">something went wrong!</p>';
      }
      $stmt->close();
   ?>
 <ul class="navigation-menu">
  <li> <a href="#" class="nav-link current" onclick="LoadContent('UserRecipes.php',this)" >Added Recipes</a></li>
    <li><a  href="#" class="nav-link"onclick="LoadContent('recipe_form.php',this)" >Add New Recipe</a></li>
   <li> <a  href="#" class="nav-link" onclick="LoadContent('user_settings.php',this)" >Settings</a></li>
            </ul>


        </div>

        <div class="main-content">
        <div >
    <iframe id="contentFrame" frameBorder="0" class="contentFrame" src="UserRecipes.php"></iframe>
  </div>
        </div>
    </div>
 


</body>
</html>