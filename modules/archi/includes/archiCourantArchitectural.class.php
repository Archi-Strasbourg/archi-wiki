<?php
/** @file
 * Classe archiCourantArchitectural
 * 
 * PHP Version 5.3.3
 * 
 * @category General
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Laurent Dorer <laurent_dorer@yahoo.fr>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * @addtogroup Classes
 * @{
 * */

/**
 * G�re les courants architecturaux
 * 
 * PHP Version 5.3.3
 * 
 * @category General
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Laurent Dorer <laurent_dorer@yahoo.fr>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * 
 * */
class ArchiCourantArchitectural extends config {
    private $idCourantArchitectural;
    private $nom;

    function __construct() {
        parent::__construct();
    }

    private function ajouter() {
    }

    private function supprimer() {
    }

    private function modifier() {
    }

    private function associerEvenement() {
    }

    private function dissocierEvenement() {
    }
    
    // *************************************************************************************************************************************
    // enregistrement de la liaison entre les courants architecturaux selectionn� et l'evenement
    // *************************************************************************************************************************************
    public function enregistreLiaisonEvenement($idEvenementALier=0,$nomChampCourantFormulaire='courantArchitectural')
    {
        if(isset($this->variablesPost[$nomChampCourantFormulaire]) && is_array($this->variablesPost[$nomChampCourantFormulaire]) && count($this->variablesPost[$nomChampCourantFormulaire])>0)
        {
        
            // on supprime les anciennes liaison 
            $resDelete = $this->connexionBdd->requete("delete from _evenementCourantArchitectural where idEvenement = '".$idEvenementALier."'");
        
            // on ajoute les nouvelles liaisons vers l'evenement
            foreach($this->variablesPost[$nomChampCourantFormulaire] as $indice =>$value)
            {
                $resInsert=$this->connexionBdd->requete("insert into _evenementCourantArchitectural (idCourantArchitectural, idEvenement) values ('".$value."','".$idEvenementALier."')");
            }
        }
    }
    
    // *************************************************************************************************************************************
    // suppression des liaisons entre l'evenement donn� et les courant architecturaux
    // *************************************************************************************************************************************
    public function deleteLiaisonsCourantFromIdEvenement($idEvenement=0)
    {
        $req = "delete from _evenementCourantArchitectural where idEvenement = '".$idEvenement."'";
        $res = $this->connexionBdd->requete($req);
    }
}

?>
