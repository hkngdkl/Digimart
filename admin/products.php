<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = ucfirst($_POST['name']);
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $category = ucfirst($_POST['category']);
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $brand = ucfirst($_POST['brand']);
   $brand = filter_var($brand, FILTER_SANITIZE_STRING);
   $price = ucfirst($_POST['price']);
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = ucfirst($_POST['details']);
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message2[] = 'Ürün adı zaten mevcut!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, category, brand, details, price, image_01, image_02, image_03) VALUES(?,?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $category, $brand, $details, $price, $image_01, $image_02, $image_03]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message2[] = 'Resim boyutu çok büyük!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'Yeni ürün eklendi!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ürünler</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">Ürün Ekleyin</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Ürün Adı (Gerekli)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Ürün adını giriniz" name="name">
         </div>
         <div class="inputBox">
            <span>Ürün Kategorisi (Gerekli)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Ürün kategorisini giriniz" name="category">
         </div>
         <div class="inputBox">
            <span>Ürün Markası (Gerekli)</span>
            <input type="text" class="box" required maxlength="50" placeholder="Ürün markasını giriniz" name="brand">
         </div>
         <div class="inputBox">
            <span>Ürün Fiyatı (Gerekli)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="Ürün fiyatını giriniz" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
        <div class="inputBox">
            <span>Resim 1 (Gerekli)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Resim 2 (Gerekli)</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Resim 3 (Gerekli)</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>Ürün Açıklaması (Gerekli)</span>
            <textarea name="details" placeholder="Ürün açıklaması giriniz" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      
      <input type="submit" value="Ekle" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">Eklenen Ürünler</h1>
   <div class="box-container box-container-hidden" style="display:none">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price"><span><?= number_format($fetch_products['price'],2,',','.'); ?></span>₺</div>
      <div class="details"><span><?= $fetch_products['details']; ?></span></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Güncelle</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Henüz ürün eklenmedi!</p>';
      }
   ?>
   
   </div>
  

   <div class="table-container table-container-hidden">

      <table >
         <tr>
            <th class="idTd">İd</th> <th>Ürün Adı</th> <th>Kategori</th><th>Detay</th><th>Fiyat</th><th>Resim 1</th><th>Resim 2</th><th>Resim 3</th><th>  </th>
         </tr>
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
      ?>
      <table>
         <tr >
            <td class="idTd"><?= $fetch_products['id']; ?></td> 
            <td class="name"><?= $fetch_products['name']; ?></td>
            <td><?= $fetch_products['category']; ?></td>
            <td><div class="detailsTd"><?= $fetch_products['details']; ?></div></td>
            <td><?= number_format($fetch_products['price'], 2, ',', '.'); ?> ₺</td>

            <td><img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt=""></td>
            <td><img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt=""></td>
            <td><img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt=""></td>
            <td>
               <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn product-btn">Güncelle</a>
               <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn product-btn" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
            </td>
         
         </tr>



      </table>
      <?php
            }
         }else{
            echo '<p class="empty">Henüz ürün eklenmedi!</p>';
         }
      ?>
   
   </div>

</section>








<script src="../js/admin_script.js"></script>
   
</body>
</html>