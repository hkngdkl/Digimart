<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'Ödeme durumu güncellendi!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Siparişler</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h3 class="heading">Siparişler</h3>

<div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Tarih: <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Ad Soyad : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Telefon : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Adres : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Ürünler : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Toplam Tutar : <span><?= number_format($fetch_orders['total_price'],2,',', '.'); ?>₺</span> </p>
      <p> Ödeme Yöntemi : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="Ödeme Bekliyor">Ödeme Bekliyor</option>
            <option value="Ödeme Tamamlandı">Ödeme Tamamlandı</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="Güncelle" class="option-btn" name="update_payment">
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Bu siparişi silmek istediğinize emin misiniz?');">Sil</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Henüz sipariş yok!</p>';
      }
   ?>

</div>

</section>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>