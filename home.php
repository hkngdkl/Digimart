<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>DigiMart</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-1.png" alt="">
         </div>
         <div class="content">
            <h3>Yeni Telefonlar</h3>
            <a href="category.php?category=telefon" class="btn">Satın Al</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-2.avif" alt="">
         </div>
         <div class="content">
            <h3>Yeni Bilgisayarlar</h3>
            <a href="category.php?category=bilgisayar" class="btn">Satın Al</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-3.webp" alt="">
         </div>
         <div class="content">
            <h3>Yeni Televizyonlar</h3>
            <a href="category.php?category=televizyon" class="btn">Satın Al</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">


   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=telefon" class="swiper-slide slide">
      <img src="images/icon-7.png" alt="">
      <h3>Telefon</h3>
   </a>

   <a href="category.php?category=bilgisayar" class="swiper-slide slide">
      <img src="images/icon-1.png" alt="">
      <h3>Bilgisayar</h3>
   </a>

   <a href="category.php?category=tv" class="swiper-slide slide">
      <img src="images/icon-2.png" alt="">
      <h3>Televizyon</h3>
   </a>

   <a href="category.php?category=kamera" class="swiper-slide slide">
      <img src="images/icon-3.png" alt="">
      <h3>Kamera</h3>
   </a>

   <a href="category.php?category=ev" class="swiper-slide slide">
      <img src="images/icon-9.png" alt="">
      <h3>Ev</h3>
   </a>

   <a href="category.php?category=klima" class="swiper-slide slide">
      <img src="images/icon-6.png" alt="">
      <h3>Klima</h3>
   </a>

   <a href="category.php?category=hobi" class="swiper-slide slide">
      <img src="images/icon-8.png" alt="">
      <h3>Hobi</h3>
   </a>

   <a href="category.php?category=kisisel" class="swiper-slide slide">
      <img src="images/icon-10.png" alt="">
      <h3>Kişisel Bakım</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">Son Bakılanlar</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>">
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt=""></a>
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><?= number_format($fetch_product['price'],2,',','.'); ?><span>₺</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Sepete Ekle" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Henüz ürün eklenmemiştir!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>



<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>