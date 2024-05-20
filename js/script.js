let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');
let icons = document.querySelector('.header .flex .icons');
let profile_min = document.querySelector('.header .profile_min');



document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile_min.classList.toggle('active');
   profile.classList.remove('active');
   
}

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
   
}
let mainImage = document.querySelector('.quick-view .box .row .image-container .main-image img');
let subImages = document.querySelectorAll('.quick-view .box .row .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});
window.onload = () => {
   let toggleFilterAside = document.querySelector('#toggleFilterAside');
   let wrapperFilterAside = document.querySelector('.wrapper-filter-aside');

   toggleFilterAside.onclick = () => {
      wrapperFilterAside.classList.toggle('active');
   }
};
