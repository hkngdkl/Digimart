<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">Siparişlerim</h1>

   <div class="box-container">
   
   <?php
      if($user_id == ''){
         echo '<div class="emptyDiv"><p class="empty">Siparişlerinizi görmek için giriş yapınız.</p></div>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Tarih : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Ad Soyad : <span><?= $fetch_orders['name']; ?></span></p>
      <p>Eposta : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Telefon : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Adres : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Ödeme Yöntemi : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Siparişiniz: <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Toplam Tutar : <span><?= $fetch_orders['total_price']; ?> ₺</span></p>
      <p>Ödeme Durumu : <span style="color:<?php if($fetch_orders['payment_status'] == 'Ödeme Bekliyor'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<div style="margin: auto"> <p class="empty">Henüz siparişiniz mevcut değil!</p></div>';
      }
      }
   ?>

   </div>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>