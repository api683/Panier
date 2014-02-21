<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex perron isabelle
 * Date: 13-10-23
 * Time: 09:52
 * To change this template use File | Settings | File Templates.
 */
$refNiveau="../";
include_once $refNiveau.'inc/scripts/config.inc.php';
include_once $refNiveau.'inc/scripts/commun.php';
include_once $refNiveau.'inc/lib/Savant3.php';
include_once $refNiveau.'inc/lib/classes/Panier.class.php';
session_start();
$arrayConfigTpl = array(
    'template_path' => $refNiveau.'templates'
);
$objTpl = new Savant3($arrayConfigTpl);

if(isset($_SESSION['panier'])){
    $objPanier = unserialize($_SESSION['panier']);
}
else{
    $objPanier = new Panier();
}

//Fil d'ariane !
if(isset($_GET['page'])){
    $intPage = $_GET['page'];
    $objTpl->fils = "<a href='../catalogue/catalogue.php?page=$intPage&categorie=$strCategorie'>Catalogue</a>";
}
else if(isset($_GET['isbn'])){
    $strIsbn = $_GET['isbn'];
    $objTpl->fils = "<a href='../catalogue/fiche.php?isbn=$strIsbn'>Fiche</a>";
}
else{
    $objTpl->fils = "<a href='../index.php'>Accueil</a>";
}

$objTpl->validation = getValidation();
setValidation(null);

if(isset($_GET["supprimer"])){
    if(isset($_GET["isbn"]))
        $objPanier->supprimerItem($_GET["isbn"]);
}

if(isset($_GET['miseajour'])){
    if(isset($_GET['isbn']))
        $objPanier->miseAJourItem($_GET['isbn'],$_GET['miseajour']);
}

if(isset($_GET['valider'])){
    header("Location: ../ssl/index.php");
}

    $arrayAchats = $objPanier->getItems();
if($arrayAchats){
    if(isset($_GET['btnLivraison'])){
        $objTpl->livraison = $objPanier->calculerFraisDeLivraisonDesItems($_GET['livraison']);
        $objTpl->typeLivraison = $_GET['livraison'];
    }
    else{
        $objTpl->livraison = $objPanier->calculerFraisDeLivraisonDesItems("reg");
        $objTpl->typeLivraison = "reg";
    }
    $objTpl->achats = $arrayAchats;
    $objTpl->prixTotal = $objPanier->calculerSousTotalItem();
    $objTpl->montantTps = $objPanier->calculerTPSDesItems($objTpl->prixTotal);
    $objTpl->prixFinal = $objPanier->calculerTotalEstimeDesItems($objTpl->prixTotal, $objTpl->montantTps, $objTpl->livraison);
}

setlocale(LC_MONETARY, 'fr_CA');
$objTpl->niveau = $refNiveau;

$_SESSION['panier'] = serialize($objPanier);
$objTpl->entete = $objTpl->fetch('pieces/header.tpl.php');
$objTpl->piedDePage = $objTpl->fetch('pieces/footer.tpl.php');
$objTpl->display($refNiveau.'templates/panier.tpl.php');
