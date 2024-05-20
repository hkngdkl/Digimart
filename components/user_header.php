<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   if(isset($message2)){
      foreach($message2 as $message2){
         echo '
         <div class="message2">
            <span>'.$message2.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">DigiMart</a>

      <section class="search-form">
         <form action="search_page.php" method="post">
            <div class="search-area">
            <input class="search_input " type="text" name="search_box" placeholder="Aramak istediğiniz ürünü yazın" maxlength="100" required>
            <button type="submit" class="fas fa-search" name="search_btn"></button>
            </div>
         </form>
      </section>
      <div id="menu-btn" class="menu-btn fas fa-bars"></div>

      <div id="" class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="profile-name">Merhaba <?= $fetch_profile["name"]; ?></p>
         <a href="update_user.php" class="profile-btn">Profilini Düzenle</a>
         <a href="orders.php" class="profile-btn">Siparişlerim</a>

         <a href="components/user_logout.php" class="profile-btn" onclick="return confirm('Çıkış yapılsın mı?');">Çıkış Yap</a> 
         <?php
            }else{
         ?>
         <div class="flex-btn">
            <a href="user_login.php" class="profile-btn">Giriş Yap</a>
            <a href="user_register.php" class="profile-btn">Üye Ol</a>
         </div>
         <?php
            }
         ?>      
         

      </div>
   </section>

   <div class="navbar">
   <section class="search-form-2">
         <form action="search_page.php" method="post">
            <div class="search-area">
            <input class="search_input " type="text" name="search_box" placeholder="Aramak istediğiniz ürünü yazın" maxlength="100" required>
            <button type="submit" class="fas fa-search" name="search_btn"></button>
            </div>
         </form>
      </section>
   </div>
   

   </section>
      <div class="profile_min" >
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="profile_min_name">Merhaba <?= $fetch_profile["name"]; ?></p>
         <a href="update_user.php" class="profile_min_btn">Profilini Düzenle</a>
         <a href="orders.php" class="profile_min_btn">Siparişlerim</a>
         <a href="wishlist.php" class="profile_min_btn">Favorilerim</a>
         <a href="components/user_logout.php" class="profile_min_btn" onclick="return confirm('Çıkış yapılsın mı?');">Çıkış Yap</a> 
         <?php
            }else{
         ?>
            <a href="user_login.php" class="profile_min_btn">Giriş Yap</a>
            <a href="user_register.php" class="profile_min_btn">Üye Ol</a>
         <?php
            }
         ?>      
      </div>

   <section class="nav-section flex">
      <?php 
      
      
      
      ?>
      <nav class="navbar nav-bar">
         <form action="category.php" method="get">
         <a href="category.php?category=telefon" >Telefon</a>
         <a href="category.php?category=bilgisayar">Bilgisayar</a>
         <a href="category.php?category=televizyon">Televizyon</a>
         <a href="category.php?category=kamera">Kamera</a>
         <a href="category.php?category=ev">Ev</a>
         <a href="category.php?category=klima">Klima</a>
         <a href="category.php?category=hobi">Hobi</a>
         <a href="category.php?category=kisisel">Kişisel Bakım</a>

         </form>
      </nav>  

   </section>
</header>