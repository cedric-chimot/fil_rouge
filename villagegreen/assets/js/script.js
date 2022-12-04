//Requête pour aller chercher la userbox
let profile = document.querySelector('.header .flex .profile');

//activation/désactivation de la userbox au click du bouton
document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}

//Requête pour aller chercher la navbar
let navbar = document.querySelector('.header .flex .navbar');

//gestion de l'affichage du menu burger en taille d'écran réduite
document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    profile.classList.remove('active');
}

//fermeture de la navbar en scrollant de haut en bas
window.onscroll = () => {
    profile.classList.remove('active');
    navbar.classList.remove('active');
};