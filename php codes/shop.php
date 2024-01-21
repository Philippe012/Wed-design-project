<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <style>


/* Apply basic styling to the sub-header section */
.sub-header {
  display: flex;
  justify-content: space-around;
  align-items: center;
  background-color: #f2f2f2; /* Set a background color */
  padding: 10px; /* Add some padding to the labels */
}

/* Style the labels within the sub-header section */
.sub-header label {
  cursor: pointer;
  padding: 8px 12px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  display: inline-block; /* Display labels as inline-block for rectangular format */
}

/* Apply different styles for the 'All' label */
.sub-header label[for="all"] {
  font-weight: bold;
  background-color:rgb(64, 38, 193);
  color: #fff;
}

/* Apply styles for other labels */
.sub-header label:not([for="all"]) {
  background-color: #e0e0e0;
}

/* Hover effect for all labels */
.sub-header label:hover {
  background-color: #dcdcdc;
}
      </style>


   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<!-- sub header -->
<section class="sub-header">
<label for="all">All</label>
   <label for="all">Potoflio</label>
   <label for="all">Business</label>
   <label for="all">RSB</label>
   <label for="all">Organization</label>
   <label for="all">Data collection</label>
   <label for="all">Event</label>
   <label for="all">Education</label>
  

</section>

<div class="heading">
   <img src="logo.jpg" width="400" height="260">
   <h3>Our shop</h3>
   <p> <a href="home.php">Home</a> / shop </p>
   
</div>

<section class="Products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
      <button>View Demo</button>
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>