//lien par des variables aux diférentes parties du HTML
let navbar = document.querySelector('.header .navbar');
let account = document.querySelector('.header .account-box');

//gestion de l'affichage du menu burger en taille d'écran réduite
document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    account.classList.remove('active');
}

//activation/désactivation de la box compte d'utilisateur
document.querySelector('#user-btn').onclick = () =>{
    account.classList.toggle('active');
    navbar.classList.remove('active');
}

//affichage de la navbar en scrollant de haut en bas
window.onscroll = () =>{
    navbar.classList.remove('active');
    account.classList.remove('active');
}

//annulation de la MAJ et fermeture du formulaire
document.querySelector('#close-update').onclick = () => {
    document.querySelector('.edit-annonce-form').style.display = 'none';
    window.location.href = 'admin_annonce.php';
}