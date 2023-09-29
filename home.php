<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(isset($_SESSION["user_id"]))  
{  
  if((time() - $_SESSION['last_login_timestamp']) > 1800) // 900 = 15 * 60  
   {  
 header("location:logout.php");  
   }  
   else  
   {  
    $_SESSION['last_login_timestamp'] = time();   
   }  
}  
else  
{  
  header('location:index.php');  
}  

if(!isset($user_id)){
   header('location:index.php');
}

if(isset($_POST['add_to_wishlist'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_stock = $_POST['product_stock'];
   $product_image = $_POST['product_image'];
   
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
       $message[] = 'already added to wishlist';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   }else{
       mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, stock, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_stock', '$product_image')") or die('query failed');
       $message[] = 'product added to wishlist';
   }

}

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_stock = $_POST['product_stock'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   // $product_quantity = (int)$_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   $stock_query =  mysqli_query($conn, "SELECT `stock` FROM `products` WHERE id = '$product_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   }else{
      $stock_row = mysqli_fetch_assoc($stock_query);
      $current_stock = (int)$stock_row['stock'];

      if($current_stock >= $product_quantity){
         $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

         if(mysqli_num_rows($check_wishlist_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
         }

         mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, stock, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_stock', '$product_quantity', '$product_image')") or die('query failed');
         $message[] = 'product added to cart';

      }
      else{
         $message[] = 'The quantity added to the cart exceeds the available stock. Proceeding is not possible.';
      }

       
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Mato's Water</h3>
      <p>Equipment and Supplies Trading</p>
      <a href="about.php" class="btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <div class="price">₱<?php echo $fetch_products['price']; ?>/-</div>
      <?php if($fetch_products['stock'] > 9){ ?>
         <span class="notif" style="color: green;"><i class="fas fa-check"></i> in stock</span>
      <?php }elseif($fetch_products['stock'] == 0){ ?>
         <span class="notif" style="color: red;"><i class="fas fa-times"></i> out of stock</span>
      <?php }else{ ?>
         <span class="notif" style="color: red;">hurry, only <?= $fetch_products['stock']; ?> left</span>
      <?php } ?>
         <div class="stock"><?php echo $fetch_products['stock']; ?>pc/s.</div>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <input type="number" name="product_quantity" value="1" min="0" class="qty">
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_stock" value="<?php echo $fetch_products['stock']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">load more...</a>
   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Please click the button below</p>
      <a href="contact.php" class="btn">contact us</a>
   </div>

</section>

<section class="steps">

<h1 class="title">simple steps</h1>

<div class="box-container">

   <div class="box">
      <img src="images/2.gif" alt="">
      <h3>choose order</h3>
      <p>Add to Cart products you want to buy</p>
   </div>

   <div class="box">
      <img src="images/7.gif" alt="">
      <h3>fast delivery</h3>
      <p>Same day delivery!</p>
   </div>

   <div class="box">
      <img src="images/1.gif" alt="">
      <h3>Customer Satisfaction</h3>
      <p>Customer is the reason why we are here. If we take good care of them, they'll give us good reason to comeback.</p>
   </div>

</div>

</section>




<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>