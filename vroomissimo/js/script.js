//lien par des variables aux diférentes parties du HTML
let userBox = document.querySelector('.header .header-2 .user-box');

//activation/désactivation de la box compte d'utilisateur
document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active');
   navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .header-2 .navbar');

//gestion de l'affichage du menu burger en taille d'écran réduite
document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

window.onscroll = () =>{
   userBox.classList.remove('active');
   navbar.classList.remove('active');

   //affichage de la navbar en scrollant de haut en bas
   if(window.scrollY > 60){
      document.querySelector('.header .header-2').classList.add('active');
   }else{
      document.querySelector('.header .header-2').classList.remove('active');
   }
}
