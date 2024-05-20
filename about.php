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
   <title>About</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
   <!-- <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" /> -->
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="content">
         <h3>Hoş Geldiniz! Digimart Elektronik Ürünler Mağazası'na</h3>
         <p>
         Biz, Digimart olarak, teknolojinin ve yeniliklerin heyecanını yaşayan bir ekip olarak faaliyet gösteriyoruz. Müşterilerimize en yeni ve en kaliteli elektronik ürünleri sunmayı hedefleyen bir e-ticaret platformuyuz.
         Digimart, elektronik alanda geniş bir ürün yelpazesi sunar. Akıllı telefonlardan dizüstü bilgisayarlara, oyun konsollarından akıllı ev cihazlarına kadar her türden ürünü müşterilerimize sunuyoruz. Amacımız, müşterilerimize en son teknoloji ürünlerini uygun fiyatlarla sunarak onların ihtiyaçlarını karşılamak ve yaşamlarını kolaylaştırmaktır.
         Müşteri memnuniyeti, işimizin merkezinde yer alır. Her adımda müşterilerimizin ihtiyaçlarını ve beklentilerini karşılamak için çalışıyoruz. Güvenilirlik, şeffaflık ve kalite, işimizin temel değerleridir. Müşterilerimize en iyi alışveriş deneyimini sunmak için sürekli olarak kendimizi geliştiriyoruz.
         Biz, Digimart ailesi olarak, teknoloji tutkumuzu ve müşteri odaklı yaklaşımımızı birleştirerek müşterilerimize benzersiz bir alışveriş deneyimi sunmaktan gurur duyuyoruz. Siz de Digimart'ı tercih ettiğiniz için teşekkür ederiz.

         Teknolojiye adanmış bir dünyada, biz sizin yanınızdayız.
         </p>

         <a href="contact.php" class="btn">İletişim</a>
      </div>

   </div>

</section>










<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>