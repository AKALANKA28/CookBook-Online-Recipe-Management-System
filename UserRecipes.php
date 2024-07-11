<!DOCTYPE html>
<html>
<head>
    <title>Photo Gallery</title>
    <link rel="stylesheet" type="text/css" href="custom.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
       
       .searchBox{
        box-shadow: inset 10px 10px 15px #c7c4c4, inset -10px -10px 15px #ffffff;
        border-radius: 50px;
        padding-left: 30px;
        height:40px;
       }

        div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 150px;
  border-radius: 50px;
    padding: 10px;
    text-align: center;
    height:200px;
}


div.gallery img {
  width: 90%;
  height: 150px;
  border-radius: 50px;
}

    
      
    </style>
</head>
<body style="margin-left: 4%;">
    <form action="" method="GET">
        <input type="text" class="box searchBox" name="search" placeholder="Search Recipe" style='width:75%;text-align:left;margin:5px;' value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
        <input type="submit" value="Search" class="f-btn">
    </form>
<?php

include 'components/config.php';
$search = $_GET['search'];
$sql ="SELECT * FROM `recipe` WHERE userid =?";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    // Add WHERE clause to filter based on search text field value
    $sql .= " And title LIKE '%$search%'";
}
$select_post = $conn->prepare($sql);
$select_post->bind_param("s", $user_id);
$select_post->execute();
$result = $select_post->get_result();
if($result->num_rows > 0){
    while($fetch_recipe = $result->fetch_assoc()){
    
?>
 <div class="gallery">
            <a href="view_post.php?get_id=<?= $fetch_recipe['id']; ?>" >
            <img class="photo" src="uploaded_files/<?= $fetch_recipe['image']; ?>" alt="<?= $fetch_recipe['title']; ?>" width="300" height="200">
    </a>
            <div class="desc"><?= $fetch_recipe['title']; ?></div>
            </div>
   

<?php
         }
      }else{
         echo '<p class="empty">No Recipes found!</p>';
      }
      $select_post->close();
   ?>              



    
</body>
</html>