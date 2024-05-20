
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
   <title>Category</title>
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">
   
   <div class="toggleFilterAside"><button id="toggleFilterAside" class="toggleFilterAside">Filtrele <i class="sortFilter fa fa-sort-desc" aria-hidden="true"></i>
   </button></div>

   <div class="products-list-container">
      <div class="wrapper-filter-aside" id="filterAside">
         <form method="get" action="category.php" class="brand_form">
            <div class="filter_heading"><h4>Kategoriler</h4></div>
            <?php
                  if(isset($_GET["category"])){
                  $sqlCategory = "SELECT DISTINCT category FROM products ";
                  $resultCategory = $conn->query($sqlCategory);

                     if ($resultCategory->rowCount() > 0) {
                        while($rowCategory = $resultCategory->fetch(PDO::FETCH_ASSOC)) { 
                           $selectedCategory = isset($_GET['category']) && $_GET['category'] == $rowCategory['category'] ? 'checked' : '';
               ?>
                           <input type="radio" name="category" value="<?php echo $rowCategory['category']; ?>" id="<?php echo $rowCategory['category']; ?>" <?php echo $selectedCategory; ?> />
                           <label for="telefon"><?php echo $rowCategory["category"] ?></label><br>
                     <?php
                           }
                     }

                  }  
                     ?>


            <div class="filter_heading"><h4>Markalar</h4></div>
            <?php
               if(isset($_GET['category'])){
                  $selectedCategory = $_GET['category'];
                  $sqlBrand = "SELECT DISTINCT brand FROM products WHERE category=:category";
                  $stmtBrand = $conn->prepare($sqlBrand);
                  $stmtBrand->bindParam(':category', $selectedCategory, PDO::PARAM_STR);
                  $stmtBrand->execute();
                  $selectedBrands = isset($_GET['brand']) ? $_GET['brand'] : array();

                  if ($stmtBrand->rowCount() > 0) {
                        while ($rowBrand = $stmtBrand->fetch(PDO::FETCH_ASSOC)) { 
                           $selectedBrand = in_array($rowBrand['brand'], $selectedBrands) ? 'checked' : '';
                           ?>
                           <input type="checkbox" name="brand[]" value="<?php echo $rowBrand['brand']; ?>" id="<?php echo $rowBrand['brand']; ?>" <?php echo $selectedBrand; ?> />
                           <label for="<?php echo $rowBrand['brand']; ?>"><?php echo $rowBrand['brand']; ?></label><br>
                  <?php
                        }
                  }
               }
            ?>

            <div class="filter_heading" ><h4>Fiyat Aralığı</h4></div>
            <input type="number" name="min_price" placeholder="Min Fiyat" class="priceFilter" min="0" value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>" >
            <input type="number" name="max_price"  placeholder="Max Fiyat" class="priceFilter" min="0" value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>">
            <div class="filter_btn_div"><button type="submit" class="filter_btn">Filtrele</button></div>

         </form>  

      </div>

      <div class="wrapper-product-main">
         <div class="box-container">
        
      <?php
      $category = isset($_GET['category']) ? $_GET['category'] : '';
      $brands = isset($_GET['brand']) ? $_GET['brand'] : array();
      $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
      $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 9999999;

      $sql = "SELECT * FROM products WHERE 1=1"; 
      $bindParams = array();

      if (!empty($category)) {
         $sql .= " AND category = :category";
         $bindParams[':category'] = $category;
      }

      if (!empty($brands)) {
         $brandParams = array();
         foreach ($brands as $index => $brand) {
            $brandParams[] = ":brand" . $index;
            $bindParams[":brand" . $index] = $brand;
         }
         $sql .= " AND brand IN (" . implode(",", $brandParams) . ")";
      }

      if (!empty($min_price) || !empty($max_price) ) {
         $sql .= " AND price BETWEEN :min_price AND :max_price";
         $bindParams[':min_price'] = $min_price;
         $bindParams[':max_price'] = $max_price;
      }
      $stmt = $conn->prepare($sql);
      foreach ($bindParams as $key => $value) {
         $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($result) {
         foreach ($result as $row) { ?>
         <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $row['id']; ?>">
            <input type="hidden" name="name" value="<?= $row['name']; ?>">
            <input type="hidden" name="price" value="<?= $row['price']; ?>">
            <input type="hidden" name="image" value="<?= $row['image_01']; ?>">
            <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
            <a href="quick_view.php?pid=<?= $row['id']; ?>">
               <img src="uploaded_img/<?= $row['image_01']; ?>" alt="">
            </a>
            <div class="name"><?= $row['name']; ?></div>   
            <div class="flex">
               <div class="price"><?= number_format($row['price'],2,',','.'); ?><span> ₺ </span></div>
               <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
            <input type="submit" value="Sepete Ekle" class="btn" name="add_to_cart">
         </form> 
      <?php }
      } else {
         echo "<h1>Sonuç bulunamadı.</h1>";
      }
      ?>

            
         </div>
      </div>
   </div>


</section>




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>