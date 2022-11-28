<?php

//connexion à la base de données
include 'admin/admins/config.php';

//ouverture de la session
session_start();

$client_id = $_SESSION['client_id'];

//si la personne n'est pas connectée, on la renvoie vers la page login
if (!isset($client_id)) {
    header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>CGV</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="cookies">

        <h1 class="titre">COOKIES Vroomissimo SA</h1>

        <div class="entete">
        
        <p>Les données personnelles collectées notamment via les cookies sur le site ou lors de vos
            commandes sont traitées par :</p><br>

            Vroomissimo SA <br>
            rue de la Course <br>
            75000 PARIS <br><br>

            RCS Créteil A 254 368 952 <br><br>

            Ci-après dénommé « Vroomissimo »<br><br>

            <p>Lors de la consultation de notre site vroomissimo.com, des cookies sont déposés par Vroomissimo et/ou
            des tiers sur votre ordinateur, votre mobile ou votre tablette.

            Cette page vous permet de mieux comprendre comment fonctionnent les cookies ou traceurs et comment utiliser
            les outils mis à votre disposition afin de les paramétrer.</p>

        </div><br><br>

        <h2>Qu'est-ce qu'un cookie ?</h2><br>
        <p>
            Un cookie est un petit fichier texte déposé sur votre ordinateur lors de la visite d'un site ou de la consultation
            d'une publicité. Comme d’autres technologies de traçage ils ont notamment pour but de collecter des informations
            relatives à votre navigation sur les sites et de vous adresser des services personnalisés. Différents types de traceurs
            peuvent être utilisés sur notre site : cookies http, cookies en stockage local, cookies flash, fingerprinting,
            pixels ou autres identifiants de traçage...</p>
        <p>
            Notre site est conçu pour être particulièrement attentif aux besoins et attentes de nos clients. C'est entre autres
            pour cela que nous faisons usage de cookies afin par exemple de vous identifier et accéder à votre compte, gérer
            votre panier de commande, mémoriser vos consultations et personnaliser les offres que nous vous proposons et
            les publicités que vous visualisez sur notre site ou en dehors.
        </p><br><br>

        <h2>Comment gérer mes cookies ?</h2><br>
        
        <p>
            Le dépôt des traceurs est soumis au consentement sauf s’ils sont strictement nécessaires au fonctionnement du
            site et à la fourniture de nos services. Vous consentez au dépôt des cookies dont l'information vous est communiquée
            dans le bandeau d'information cookies visible lors de votre première connexion au site en cliquant sur le bouton
            « Accepter » figurant sur le bandeau ; L'accord ainsi donné est valable pour une durée maximum de six (6) mois
            à compter du premier dépôt dans l'équipement du terminal.

            A noter : Les cookies et traceurs nécessaires ne peuvent pas être refusés car ils sont nécessaires au fonctionnement
            du site et à la fourniture de nos services. Les traceurs de lutte contre la fraude et les cookies analytiques qu
            permettent uniquement la mesure d'audience sont déposés dès l'arrivée sur le site mais peuvent être refusés en les
            paramétrant dans le gestionnaire.
            Si vous refusez le dépôt des traceurs, vous êtes informé que votre navigation et votre expérience sur le site peuvent
            être dégradées. Des publicités continueront à s'afficher sur les pages internet visitées, mais elles ne seront
            personnalisées.
            Vous êtes informé que les partenaires de l'Editeur et tout autre tiers peuvent être amenés à déposer des cookies
            sur le site en tant que responsables des traitements de données qui peuvent en résulter. L'émission et l'utilisation
            de cookies par des tiers sont également soumises aux politiques de confidentialité de ces tiers en complément des
            présentes. En conséquence, nous vous recommandons de vous rendre sur les sites de ces tiers pour plus d'informations
            sur les cookies qu'ils enregistrent et comment les gérer.
        </p><br><br>

        <h2>D'où viennent les cookies ?</h2><br>
           
        <p>Les cookies peuvent être déposés par Vroomissimo en tant qu'Editeur du site, ou par des tiers.</p><br><br>

        <h2>Les cookies Vroomissimo :</h2><br>

            <p>Il s'agit des cookies déposés par Vroomissimo (ou par ses prestataires (sous-traitant) agissant pour le
            compte de Vroomissimo) sur votre terminal pour les besoins de la navigation sur notre site internet, l'optimisation
            et la personnalisation de nos services sur le site.</p><br><br>

        <h2>Les cookies tiers :</h2><br>

        <p>
            Il s'agit des cookies déposés par des sociétés tierces (par exemple des régies publicitaires ou par des partenaires)
            afin d'identifier vos centres d'intérêt au travers des produits consultés ou achetés sur notre site et personnaliser
            l'offre publicitaire qui vous est adressée sur notre site ou en dehors de notre site.
            Ils peuvent être déposés à l'occasion de la navigation sur notre site ou lorsque vous cliquez dans les espaces
            publicitaires de notre site.
        </p><br><br>

        <h2>Pourquoi utilisons-nous des cookies ?</h2><br>

        <p>
            Les cookies ont des finalités qui peuvent être différentes. Certains sont nécessaires à votre utilisation de
            notre site d'autres ont des finalités plus accessoires. Les cookies nécessaires au fonctionnement
            du site et de nos services

            Il s'agit des cookies nécessaires au fonctionnement de notre site ou des services que vous sollicités. Ils
            vous permettent d'utiliser les principales fonctionnalités de notre site (par exemple utilisation du panier
            d'achat ou l'accès à votre compte, l'accès à nos recommandations personnalisées de nos produits et services).
            Sans ces cookies, vous ne pourrez pas utiliser notre site conformément à vos attentes. Il s'agit de cookies
            déposés par Vroomissimo qui concernent le fonctionnement optimal de notre site.
            L'enseigne Vroomissimo est connue et reconnue pour la valeur de ses conseils et les compétences de ses vendeurs
            experts. Vroomissimo utilise des cookies pour vous offrir un service personnalisé car notre site est conçu,
            à l'image de nos magasins, pour vous proposer les produits et services les plus pertinents et adaptés à vos
            besoins et vos envies.
            Ces recommandations personnalisées font partie intégrante de notre devoir de conseil. Elles sont essentielles
            et intrinsèques à la mise en avant de nos services et nous permettent de vous conseiller au mieux.
            Les traceurs de lutte contre la fraude

            Pour vous fournir un service sécurisé conformément à vos attentes, Vroomissimo collecte des informations
            dans le cadre de la lutte contre la fraude pour sécuriser l'authentification à notre site ou sécuriser vos
            transactions (commandes). Il s'agit d'informations relatives à votre terminal nécessaires à la reconnaissance
            des équipements (ordinateur, tablette ou téléphone portable). Un identifiant machine de type « empreinte »
            (device fingerprinting) est donc utilisé pour sécuriser les transactions. Vous êtes informés de cette finalité
            dès votre arrivée sur le site. Cette sécurisation des transactions réalisées sur notre site fait partie
            intégrante de nos services conformément à nos CGU. Le suivi de cet identifiant technique repose sur les
            intérêts légitimes de Vroomissimo et des utilisateurs du services afin de se prémunir contre la fraude et de
            prévenir une usurpation de carte bancaire des clients.

            Vous pouvez exprimer votre choix ici pour vous opposer à la collecte de votre identifiant de terminal pour la
            sécurisation de vos transactions : oui non concernant la collecte de mon identifiant de terminal. En cas de
            refus, vos commandes pourront être soumises à des vérifications complémentaires lors de la validation de
            celles-ci par les équipes de lutte contre la fraude. 
        </p><br><br>

        <h2>Les cookies analytiques, nécessaires à la mesure d'audience</h2><br>

        <p>
            Il s'agit des cookies qui nous permettent de connaître l'utilisation, les volumes de fréquentation
            et d'utilisation ainsi que les performances de notre site. Ces cookies permettent à Vroomissimo
            d'améliorer l'intérêt, l'ergonomie et le fonctionnement des services proposés sur le site (par exemple,
            les pages le plus souvent consultées, recherches des internautes dans le moteur du site...).
            Il s'agit des cookies qui nous permettent de connaître l'utilisation, les volumes de fréquentation
            et d'utilisation ainsi que les performances de notre site. Ces cookies permettent à Vroomissimo
            d'améliorer l'intérêt, l'ergonomie et le fonctionnement des services proposés sur le site (par exemple,
            les pages le plus souvent consultées, recherches des internautes dans le moteur du site...).
        </p><br><br>
            
        <h2>Les cookies fonctionnels :</h2><br>
        
            <p>
                Il s'agit des cookies qui nous permettent de vous fournir certaines fonctionnalités non essentielles au service mais qui permettent d'améliorer de façon significative votre expérience comme l'adaptation de certaines parties de notre site à votre parcours ou la proposition
                d'outils adaptés à votre usage. Nous pouvons déposer un cookie de géolocalisation sur le site,
                afin de vous localiser pour vous permettre de bénéficier de certaines fonctionnalités telles que
                la recommandation d'adresses de magasins, l'affichage des produits disponibles dans les magasins
                les plus proches de vous ou encore la prise de rendez-vous.
                Les cookies de géolocalisation sont conservés pour une durée limitée aux besoins du service.
            </p><br><br>

        <h2>Les cookies publicitaires</h2><br>

            <p>
                Il s'agit des cookies utilisés pour vous présenter des publicités ou vous adresser des informations
                adaptées à vos centres d'intérêts sur notre site ou en dehors de notre site lors de votre navigation
                sur Internet. Vroomissimo utilise aussi des cookies dans le cadre de son activité de régie publicitaire
                RETAILINK pour la création de profils publicitaire publicitaires basés sur la combinaison de données
                de navigation et d'informations fournies dans le cadre de nos services.

                Les cookies publicitaires peuvent être déposés et lus par la régie publicitaire Vroomissimo, ses
                prestataires, partenaires ainsi que par les annonceurs dont la publicité s'affiche.

                Ils permettent, pendant la durée de validité de ces cookies, de :<br><br>

                    - diffuser de la publicité dans tous les emplacements réservés à la publicité de tiers,<br>
                    - comptabiliser le nombre d'affichages des contenus publicitaires diffusés via nos espaces
                    publicitaires, d'identifier les publicités ainsi affichées et le nombre d'utilisateurs ayant
                    cliqué sur chaque publicité, de calculer les sommes dues de ce fait et d'établir des statistiques,<br>
                    - reconnaître votre terminal lors de sa navigation ultérieure sur tout autre site ou service
                    sur lequel ces annonceurs ou ces tiers émettent également des cookies et, le cas échéant,
                    d'adapter ces sites et services tiers ou les publicités qu'ils diffusent, à la navigation de
                    votre terminal dont ils peuvent avoir connaissance.
            </p><br><br>


    <?php include 'footer.php'; ?>

</body>

</html>