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

    <div class="conditions">

        <h1 class="titre">Conditions générales de ventes</h1>

        <div class="entete">
            Siège social :

            Vroomissimo SA <br>
            rue de la Course <br>
            75000 PARIS <br><br>

            RCS Créteil A 254 368 952 <br>
        </div><br>

        <h2>1. Conditions générales de ventes des produits sur Vroomissimo.com</h2><br>
        <p>
            Date de dernière mise à jour : 28/09/2022

            Il est préalablement précisé que les présentes conditions régissent exclusivement les ventes, par Vroomissimo SA (Siège social : Vroomissimo SA rue de la Course 75000 PARIS)
        </p><br>

        <h3>Article 1 - Prix</h3><br>
        <p>
            1.1 - Les prix de nos produits sont indiqués en euros toutes taxes comprises (TVA + autres taxes, éco-participation…) hors participation aux frais de traitement et d'expédition (voir Délais et coûts).
        </p><br>

        <p>
            1.2 - En cas de commande vers un pays autre que la France métropolitaine vous êtes l'importateur du ou des Pour tous les produits expédiés hors Union européenne et DOM-TOM, le prix sera calculé hors taxes automatiquement sur la facture. Des droits de douane ou autres taxes locales ou droits d'importation ou taxes d'état sont susceptibles d'être exigibles. Ces droits et sommes ne relèvent pas du ressort de Vroomissimo. Ils seront à votre charge et relèvent de votre entière responsabilité, tant en termes de déclarations que de paiements aux autorités et/organismes compétents de votre pays.
            Nous vous conseillons de vous renseigner sur ces aspects auprès de vos autorités locales.
        </p><br>
        <p>
            1.3 - Vroomissimo SA se réserve le droit de modifier ses prix à tout moment mais les produits seront facturés sur la base des tarifs en vigueur au moment de votre validation de commande.
        </p><br>

        <p>
            1.4 - Les produits demeurent la propriété de Vroomissimo jusqu'au complet paiement du prix. Nous vous rappelons
            qu'au moment où vous
            prenez possession physiquement des produits commandés, les risques de perte ou d'endommagement des produits vous
            sont transférés.
        </p><br>

        <p>
            1.5 - Vroomissimo SA n'a pas vocation à vendre à des professionnels, les produits et services vendus par Vroomissimo sont réservés aux particuliers.
        </p><br>

        <h2>2 - Commande</h2><br>

        <p>
            Vous pouvez passer commande :

            Sur Internet : www.vroomissimo.com.
            Par téléphone au 01-22-75-10-10 (Service 0,40€/min + prix appel) depuis la France métropolitaine. Du lundi au
            samedi de 9h à 19h30.

            Les informations contractuelles sont présentées en langue française et feront l'objet d'une confirmation
            reprenant ces informations
            contractuelles au plus tard au moment de votre validation de commande.
        </p><br>

        <h2>3 – Validation de votre commande</h2><br>

        <p>
            Vous déclarez avoir pris connaissance et accepté les présentes Conditions générales de vente avant la passation
            de votre commande.
            La validation de votre commande vaut donc acceptation de ces Conditions générales de vente.

            Un récapitulatif des informations de votre commande et des Conditions Générales de Vente, vous sera communiqué
            en format PDF via
            l'e-mail de confirmation de votre commande.

            En acceptant les présentes conditions, vous acceptez que votre facture soit mise à votre disposition de manière
            dématérialisée dans votre espace client.
        </p><br>

        <h2>4 - Disponibilité</h2><br>
        <p>
            Vroomissimo est un détaillant et n'a pas vocation à vendre en quantités importantes les produits proposés. En
            conséquence, Vroomissimo
            se réserve de le droit de refuser les commandes d'un même produit en quantité importante et ce dès 3 Articles
            identiques.

            Nos offres de produits sont valables tant qu'ils sont visibles sur le site, dans la limite des stocks
            disponibles hors opérations
            promotionnelles mentionnées comme telles sur les sites.
            Dans l'éventualité d'une indisponibilité de produit après passation de votre commande, nous vous en informerons
            par mail.
            Votre commande sera automatiquement annulée et aucun débit bancaire ne sera effectué. Pour information le débit
            n'intervient qu'au moment de l'expédition du colis.
        </p><br>

        <h2>Article 5 - Livraison</h2><br>

        <h3>5.1 - Généralités</h3><br>

        <p>
            Les produits sont livrés à l'adresse de livraison que vous avez indiquée au cours du processus de commande, sauf
            restrictions de livraison
            indiquées dans la rubrique « Conditions de livraison », dans le délai indiqué sur la page de validation de la
            commande par le client.

            Le délai de livraison correspond

            au délai d'expédition indiqué sur la fiche Article auquel s'ajoute
            le délai de traitement et d'acheminement.

            En cas de livraison par un transporteur nécessitant une prise de rendez-vous avec le client, ce dernier prendra
            contact avec vous dans les
            plus brefs délais pour convenir avec vous d'un rendez-vous de livraison, 30 jours au plus tard à compter de la
            date de votre validation de commande.
            Vroomissimo ne peut être responsable de retard de livraison dû exclusivement à une indisponibilité du client
            après plusieurs propositions
            de rendez-vous par le transporteur.

            Lorsque vous commandez plusieurs produits en même temps et que ceux-ci ont des délais de livraison différents,
            le délai de livraison de la commande
            est basé sur le délai le plus éloigné. Vroomissimo se réserve toutefois la possibilité de fractionner les
            expéditions. La participation aux frais
            de traitement et d'expédition ne sera facturée que pour un seul envoi.

            En cas de retard d'expédition, un mail vous sera adressé pour vous informer d'une éventuelle conséquence sur le
            délai de livraison qui vous a été indiqué.
            En cas de retard de livraison, nous vous proposerons par mail un nouveau délai de livraison.

            En tout état de cause, conformément aux dispositions légales, en cas de retard de livraison, vous bénéficiez de
            la possibilité de résoudre le contrat dans les conditions et modalités définies à l'Article L 216-2 du Code de la consommation.
            Dans ce cas, si vous avez reçu le produit, après votre annulation, nous procéderons au remboursement du produit
            et aux frais « aller » dans les conditions de l'Article L 216-3 du Code de la consommation.

            Nous vous invitons également à consulter régulièrement votre suivi de commande et à contacter le Service
            clientèle pour toute question ou en cas de problème. Nous mettons à votre disposition un numéro Azur
            (coût d'une communication locale à partir d'un poste fixe) indiqué dans l'email de confirmation de commande
            que vous recevrez après validation de votre commande, et accessible dans votre page "Mon Compte" ; pour cela il
            vous suffit de vous identifier à l'aide de votre adresse e-mail et votre mot de passe.

            En cas de paiement par carte bancaire ou privative et de livraisons fractionnées, seuls les produits expédiés
            sont débités.

            Nous vous rappelons qu'au moment où vous (ou un tiers désigné par vous) prenez possession physiquement des
            produits commandés, les risques de perte ou d'endommagement des produits vous sont transférés.
        </p><br>

        
        <h3>5.2 - Réserves</h3><br>
        <p>
            Vous devez notifier au transporteur et à Vroomissimo toutes réserves sur le produit livré (par exemple : colis
            endommagé, déjà ouvert...).
        </p><br>
        
        <h2>Article 6 - Paiement</h2><br>
        <p>
            Nous vous rappelons que le fait de valider votre commande implique l'obligation à votre charge de payer le prix
            indiqué. Le règlement de vos achats
            peut s'effectuer selon les moyens de paiement acceptés par Vroomissimo indiqués dans la rubrique « Moyens de paiement
            ».
        </p><br>

        <h2>Article 7 - Sécurisation</h2><br>
        <p>
            Notre site fait l'objet d'un système de sécurisation.

            Nous avons adopté le procédé de cryptage SSL, mais nous avons aussi renforcé l'ensemble des procédés de
            brouillage et de cryptage pour protéger le
            plus efficacement possible toutes les données sensibles liées aux moyens de paiement.
        </p><br>

        <h2>Article 8 - Droit de rétractation</h2><br>
        
        <h3>8.1 – Délai légal du droit de rétractation</h3><br>

        <p>
            Conformément aux dispositions légales en vigueur, vous disposez d'un délai de 14 jours à compter de la réception
            de vos produits pour exercer
            votre droit de rétractation sans avoir à justifier de motifs ni à payer de pénalité.
            Après communication de votre décision d'exercer votre droit de rétractation dans ce délai de 14 jours, vous
            disposez d'un autre délai de
            14 jours pour renvoyer le ou les produits concernés par la rétractation.
        </p><br>

        <p></p>
        <h3>8.2 - Délai contractuel de rétraction</h3><br>
        <p>
            Sur Vroomissimo.com (produits vendus et expédiés par Vroomissimo), nous vous offrons la possibilité d'exercer
            votre droit de rétractation dans un délai de
            15 jours à compter de la réception des produits. Ensuite vous disposez d'un autre délai de 15 jours à compter de
            la communication de votre
            décision de rétractation pour nous renvoyer le ou les produits concernés.

            En cas de commande contenant plusieurs produits, passée sur vroomissimo.com, le délai de 15 jours pour communiquer
            votre décision de rétractation court à
            compter de la réception du dernier produit.

            Les modalités d'exercice de votre droit de rétractation sont précisées au 8.3.
        </p><br>
        

        <h3>8.3 Conditions d'exercice du droit de rétractation</h3><br>

        <p>
            En cas d'exercice du droit de rétractation dans le délai visé au 8.2, seul le prix du ou des produits achetés et
            les frais d'envoi seront remboursés,
            les frais de retour restant à votre charge.

            Les retours sont à effectuer dans leur état d'origine et complets (emballage, accessoires, notice...) permettant
            leur recommercialisation à l'état neuf,
            et, si possible, accompagnés d'une copie de la facture d'achat pour une gestion optimisée. En cas de
            dépréciation du produit résultant de manipulations
            autres que celles nécessaires pour établir la nature, les caractéristiques et le bon fonctionnement du produit,
            votre responsabilité peut être engagée.
        </p><br>

        
        <h3>8.4 - Remboursement</h3><br>

        <p>
            En cas d'exercice du droit de rétractation, Vroomissimo procédera au remboursement des sommes versées (y compris
            les frais de livraison) au plus tard
            dans les 14 jours à compter de la date à laquelle Vroomissimo est informé de votre décision de vous rétracter et
            selon le même moyen de paiement que
            celui utilisé pour la commande (sauf votre accord exprès pour un remboursement selon un autre moyen de
            paiement).
            Cette date de remboursement pouvant être différée jusqu'à récupération du produit ou jusqu'à ce que vous ayez
            fourni une preuve de l'expédition du produit,
            la date retenue étant celle du premier de ces faits. Vroomissimo n'est pas tenu de vous rembourser les frais
            supplémentaires si vous avez expressément
            choisi un mode de livraison plus coûteux que le mode de livraison standard proposé sur vroomissimo.com.

            Aucun envoi en contre-remboursement ne sera accepté quel qu'en soit motif.
        </p><br>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>