<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex Perron Isabelle
 * Date: 13-10-23
 * Time: 09:52
 * To change this template use File | Settings | File Templates.
 */

?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Fiche du live : <?php echo $this->titre;?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="<?php echo $this->niveau; ?>css/normalize.min.css">
    <link rel="stylesheet" href="<?php echo $this->niveau; ?>css/main.css">
    <link rel="stylesheet" href="<?php echo $this->niveau; ?>css/main_MP.css">
    <link rel="stylesheet" href="<?php echo $this->niveau; ?>css/panier.css">

    <title>ACCUEIL TRACES</title>
</head>
<body>
<?php echo $this->entete  ?>
<div id="contenuPanier">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" />
        <?php if($this->validation!="oui"){ ?>
            <p><?php echo $this->fils ?> < Panier</p>
        <?php } ?>
        <hr />

        <?php if($this->achats){ ?>
            <?php if($this->validation!="oui"){ ?>
                <input class="bouton" type="submit" name="valider" value="Valider ma commande">
            <?php } ?>
            <p>Prix final : <?php echo money_format('%.2n', $this->prixFinal) ?></p>
            <hr />
            <?php
            foreach($this->achats as $livre){?>
                <h2><?php echo arrangerTitre($livre["titre"]); ?></h2>
                <div class="imageLivre">
                    <?php if (file_exists($strFilename)) {?>
                    <img src="<?php echo $this->niveau . "img/L" . ISBNToEAN($livre['isbn']) ."1.jpg"; ?>" alt="<?php echo $this->titre ?>">
                    <?php }
                    else {  ?>
                    <img src="<?php echo $this->niveau . "img/traceVignette.jpg"?>" alt="<?php echo $this->titre ?>">
                    <?php } ?>
                </div>

                <p><?php echo "Auteur(s) : " . $livre["auteur"] ?></p>
                <p><?php echo "prix unitaire du livre : " . money_format('%.2n', $livre["prix"]) ?></p>
                <p class="pourQte">
                    <a class="bouton" href="?miseajour=-1&isbn=<?php echo $livre['isbn'] ?>"> - </a>
                    <span id="laQte"><?php echo $livre["qte"] ?></span>
                    <a class="bouton" href="?miseajour=1&isbn=<?php echo $livre['isbn'] ?>"> + </a>
                </p>
                <p><?php echo "Sous total : " . money_format('%.2n', $livre["sousTotal"]) ?></p>
                <p><a class="bouton" href="?supprimer&isbn=<?php echo $livre['isbn'] ?>">Supprimer du panier</a></p>
            <?php } ?>

            <hr />
            <p>Sous Total : <?php echo money_format('%.2n', $this->prixTotal) ?></p>
            <p>TPS : <?php echo money_format('%.2n', $this->montantTps) ?></p>
            <hr />
            <p>Livraison : <?php echo money_format('%.2n', $this->livraison) ?></p>
            <select name="livraison" id="SelectLivraison">
                <?php if($this->typeLivraison == "exp"){ ?>
                    <option value="reg">Régulière</option>
                    <option value="exp" selected="selected">Express</option>
                <?php }
                else { ?>
                    <option value="reg" selected="selected">Régulière</option>
                    <option value="exp">Express</option>
                <?php } ?>
            </select>
            <input class="bouton" type="submit" name="btnLivraison" value="Mettre à jour le type de livraison" />
            <hr />

            <p>Prix final : <?php echo money_format('%.2n', $this->prixFinal) ?></p>
            <?php echo $validation ?>
            <?php if($this->validation!="oui"){ ?>
                <input class="bouton" type="submit" name="valider" value="Valider ma commande">
            <?php } ?>

            <hr />
        <?php }
        else{ ?>
            <p>Votre panier est vide !</p>
            <hr />
        <?php } ?>
        <?php if($this->validation!="oui"){ ?>
            <h3><a class="bouton" href="../catalogue/catalogue.php">Continuer mon magasinage</a></h3>
        <?php } ?>
    <form/>
</div>
<?php echo $this->piedDePage  ?>
</body>
</html>