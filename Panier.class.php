<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex Perron Isabelle
 * Date: 13-10-21
 * Time: 15:17
 * To change this template use File | Settings | File Templates.
 */
    class Panier {

        public $_ArrPanier = null;
        public function __construct() {

        }

        public function ajouterItem($arrayLivre){
            if(isset($this->_ArrPanier[$arrayLivre["isbn"]])){
                $this->_ArrPanier[$arrayLivre["isbn"]]['qte'] = $this->_ArrPanier[$arrayLivre["isbn"]]['qte'] + 1;
            }
            else{
                $this->_ArrPanier[$arrayLivre["isbn"]] = $arrayLivre;
                $this->_ArrPanier[$arrayLivre["isbn"]]['qte'] = 1;
            }
            $this->calculerMontantItem($arrayLivre["isbn"]);
        }

        public function supprimerItem($isbn){
            unset($this->_ArrPanier[$isbn]);
        }

        public function miseAJourItem($strIsbn,$intSymbole){
            if(preg_match('#^[0-9]+$#', $this->_ArrPanier[$strIsbn]['qte'])){
                if($intSymbole==-1){
                    if($this->_ArrPanier[$strIsbn]['qte']>1)
                        $this->_ArrPanier[$strIsbn]['qte'] = $this->_ArrPanier[$strIsbn]['qte'] - 1;
                }
                else{
                    echo "lol";
                    $this->_ArrPanier[$strIsbn]['qte'] = $this->_ArrPanier[$strIsbn]['qte'] + 1;
                }
                $this->calculerMontantItem($strIsbn);
                $this->calculerSousTotalItem();
            }
            var_dump($this->_ArrPanier[$strIsbn]['qte']);
        }

        public function calculerMontantItem($strIsbn){
            $this->_ArrPanier[$strIsbn]['sousTotal'] = money_format('%.2n', $this->_ArrPanier[$strIsbn]['qte'] * $this->_ArrPanier[$strIsbn]['prix']);
        }

        public function calculerSousTotalItem(){
            $prixItemTotal = null;
            foreach ($this->_ArrPanier as $itemPanier){
                $prixItemTotal = $prixItemTotal + $itemPanier['sousTotal'];
            }
            return $prixItemTotal;
        }

        public function calculerTPSDesItems($intMontantTotal){
            return $intMontantTotal * 0.05;
        }

        public function calculerFraisDeLivraisonDesItems($strLivraison){
            $intNombreItems = $this->calculerLaQteDeTousLesItems();
            if($strLivraison=="exp"){
                return (($intNombreItems*3.50)+4)*1.5;
            }
            else{
                return ($intNombreItems*3.50)+4;
            }
        }

        public function calculerTotalEstimeDesItems($fltPrix, $fltTps, $fltLivraison){
            $this->_prixTotalFinal = $fltPrix + $fltTps + $fltLivraison;
            return $fltPrix + $fltTps + $fltLivraison;
        }

        public function getItems(){
            return $this->_ArrPanier;
        }

        public function calculerLaQteDeTousLesItems(){
            $itemTotal = null;
            foreach ($this->_ArrPanier as $itemPanier){
                $itemTotal = $itemTotal + $itemPanier['qte'];
            }
            return $itemTotal;
        }
    }

?>