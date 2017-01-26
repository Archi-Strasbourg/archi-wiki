<?php
/**
 * Classe archiPersonne
 *
 * PHP Version 5.3.3
 *
 * @category Class
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     http://archi-wiki.org/
 *
 * */
require_once __DIR__."/ArchiContenu.class.php";
/**
 * Gère pages de biographie
 * (adresses, personnes, etc)
 *
 * PHP Version 5.3.3
 *
 * @category Class
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     http://archi-wiki.org/
 *
 * */
class ArchiPersonne extends ArchiContenu
{
    public $nom;
    public $prenom;
    public $dateNaissance;
    public $dateDeces;
    public $idMetier;

    /**
     * Constructeur d'archiPersonne
     *
     * @param int $id ID
     *
     * @return void
     * */
    public function __construct($id)
    {
        global $config;
        parent::__construct();
        $resPerson=$config->connexionBdd->requete(
            "SELECT * FROM `personne` WHERE idPersonne='".
            mysql_real_escape_string($id)."'"
        );
        foreach (mysql_fetch_object($resPerson) as $key => $value) {
            $this->$key=stripslashes($value);
        }
    }

    /**
     * Ajouter une personne
     *
     * @return void
     * */
    public function ajouter()
    {
        $newIdPersonne=0;
        $formulaire = new formGenerator();
        if (isset($this->variablesPost['submit'])) {
            $modeAffichage='';
            if (isset($this->variablesGet['modeAffichage']) && $this->variablesGet['modeAffichage']!='') {
                $modeAffichage = $this->variablesGet['modeAffichage'];
            }


            switch ($modeAffichage) {
                case 'nouveauDossier':
                case "modifEvenement":
                    $tabForm = array(
                    'prenom'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'text'),
                    'nom'        => array('default'=> '',  'value' => '',  'required'=>true, 'error'=>'', 'type'=>'text'),
                    'description'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'text'),
                    'dateNaissance'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'date'),
                    'dateDeces'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'date'),
                    'metier'    => array('default'=> 'aucune' ,  'value' => '',  'required'=>false , 'error'=>'', 'type'=>'numeric',  'checkExist'=>
                                    array('table'=> 'metier',  'primaryKey'=> 'idMetier')));

                    break;

                default:
                    $tabForm = array(
                    'prenom'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'text'),
                    'nom'        => array('default'=> '',  'value' => '',  'required'=>true, 'error'=>'', 'type'=>'text'),
                    'description'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'text'),
                    'nouveauMetier'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'text'),
                    'dateNaissance'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'date'),
                    'dateDeces'    => array('default'=> '',  'value' => '',  'required'=>false, 'error'=>'', 'type'=>'date'),
                    'metier'    => array('default'=> 'aucune' ,  'value' => '',  'required'=>false , 'error'=>'', 'type'=>'numeric',  'checkExist'=>
                                    array('table'=> 'metier',  'primaryKey'=> 'idMetier')));

                    break;
            }
            $erreur = $formulaire->getArrayFromPost($tabForm);

            if (count($erreur) === 0) {
                $prenom = mysql_escape_string($tabForm['prenom']['value']);
                $nom    = mysql_escape_string($tabForm['nom']['value']);
                $description   = isset($_POST['descriptionPerson'])?mysql_escape_string($_POST['descriptionPerson']):mysql_escape_string(htmlspecialchars($tabForm['description']['value']));
                $dateNaissance = $this->date->toBdd($this->date->convertYears($tabForm['dateNaissance']['value']));
                $dateDeces     = $this->date->toBdd($this->date->convertYears($tabForm['dateDeces']['value']));

                /*if (!empty($tabForm['nouveauMetier']['value']))
                {
                    // nouveau metier
                    $nomMetier = mysql_escape_string($tabForm['nouveauMetier']['value']);
                    $sql = "SELECT idMetier FROM metier WHERE nom='".$nomMetier."' LIMIT 1";
                    $rep = $this->connexionBdd->requete($sql);
                    if (mysql_num_rows($rep) === 1)
                    {
                        $res = mysql_fetch_object($rep);
                        $idMetier = $res->idMetier;
                        echo "métier existe";
                    }
                    else
                    {
                        $sql = "INSERT INTO metier (nom) VALUES ('".$nomMetier."')";
                        $this->connexionBdd->requete($sql);
                        $idMetier = mysql_insert_id();
                        echo 'métier existe pas';
                    }
                }
                else if (empty($tabForm['metier']['error']) AND !empty($tabForm['metier']['value']))
                {*/
                    // valeur du select
                    $idMetier      = $tabForm['metier']['value'];
                    //echo 'métier select';
                /*}
                else
                {
                    // choix par défaut
                    $idMetier = 1;
                    echo 'défaut';
                }*/
                $sql ="INSERT INTO personne (prenom,  nom,  dateNaissance,  dateDeces,  description,  idMetier ) VALUES
                    ('".$prenom."', '".$nom."', '".$dateNaissance."', '".$dateDeces."', '".$description."', ".$idMetier.")";


                $this->connexionBdd->requete($sql);

                $newIdPersonne = mysql_insert_id();
            } else {
                $this->erreurs->ajouter($tabForm);
            }
            $this->erreurs->ajouter($tabForm);
        }

        return $newIdPersonne;
    }

    /**
     * Affichage du formulaire d'ajout d'une personne
     *
     * @return string HTML
     * */
    public function afficherFormulaire()
    {
        $html = '';
        $t = new Template('modules/archi/templates');
        $t->set_filenames(array('formulaire'=>'personneFormulaire.tpl'));

        $modeAffichage='';
        if (isset($this->variablesGet['modeAffichage']) && $this->variablesGet['modeAffichage']!='') {
            $modeAffichage = $this->variablesGet['modeAffichage'];
        }


        switch ($modeAffichage) {
            case 'nouveauDossier':
            case "modifEvenement":
                $t->assign_vars(array('urlAction'=>$this->creerUrl('ajouterPersonne', '', array('noHeaderNoFooter'=>1, 'modeAffichage'=>$modeAffichage))));
                $t->assign_vars(array('boutonAnnulation'=>"location.href='".$this->creerUrl('', 'personneListe', array('noHeaderNoFooter'=>1, 'modeAffichage'=>$modeAffichage))."';"));
                break;
            default:
                $t->assign_block_vars('allowAjouterMetier', array());
                break;
        }

        // récupération des métiers
        $sql = "SELECT nom,  idMetier FROM metier";
        $rep = $this->connexionBdd->requete($sql);
        while ($res = mysql_fetch_object($rep)) {
            $t->assign_block_vars('metier', array('valeur'=>$res->idMetier,  'nom'=>$res->nom));
        }

        if ($this->erreurs->tabFormExiste()) {
            foreach ($this->erreurs->getErreursFromFormulaire() as $name => $value) {
                if ($value['type']=='date') {
                     $val = $this->date->toFrench($this->date->toBdd($value['value']));
                } else {
                    $val = htmlspecialchars(stripslashes($value["value"]));
                }

                $t->assign_vars(array( $name => $val));
                if ($value["error"]!='') {
                    $t->assign_vars(array($name."-error" => $value["error"]));
                }
            }
        }

        ob_start();
        $t->pparse('formulaire');
        $html .= ob_get_contents();
        ob_end_clean();

        return $html;
    }

     /**
     * Supprimer une personne
     *
     * @return void
     * */
    public function supprimer()
    {
        global $config;
        $config->connexionBdd->requete(
            "DELETE FROM `_personneEvenement` WHERE idPersonne='".
            mysql_real_escape_string($this->idPersonne)."'"
        );
        $config->connexionBdd->requete(
            "DELETE FROM `_evenementPersonne` WHERE idPersonne='".
            mysql_real_escape_string($this->idPersonne)."'"
        );
        return $config->connexionBdd->requete(
            "DELETE FROM `personne` WHERE idPersonne='".
            mysql_real_escape_string($this->idPersonne)."'"
        );
    }

    /**
     * Modifier une personne
     *
     * @param int    $id        ID
     * @param string $firstname Prénom
     * @param string $name      Nom
     * @param int    $job       ID du métier
     * @param string $birth     Date de naissance
     * @param string $death     Date de décès
     *
     * @return void
     * */
    public function modifier($id, $firstname, $name, $job, $birth, $death)
    {
        $res = $this->connexionBdd->requete(
            sprintf(
                file_get_contents("sql/editPerson.sql"),
                mysql_escape_string($firstname),
                mysql_escape_string($name),
                $job,
                $this->date->toBdd($this->date->convertYears($birth)),
                $this->date->toBdd($this->date->convertYears($death)),
                $id
            )
        );
    }

    /**
     * Afficher une personne
     *
     * @param int $id ID
     *
     * @return string HTML
     * */
    public function afficher($id)
    {
        $html = '';
        $formulaire = new formGenerator();
        if ($formulaire->estChiffre($id) == 1) {
            $sql = 'SELECT p.nom as nom, p.prenom as prenom,  m.nom as metier,  p.idPersonne as idPersonne,  p.dateNaissance as dateNaissance,  p.dateDeces as dateDeces,  p.description as description
                    FROM personne p
                    LEFT JOIN metier m ON m.idMetier = p.idMetier
                    WHERE p.idPersonne='.$id.' LIMIT 1';
            $rep = $this->connexionBdd->requete($sql);
            if (mysql_num_rows($rep) == 1) {
                $res = mysql_fetch_object($rep);

                $t = new Template('modules/archi/templates/');
                $t->set_filenames((array('pe'=>'personne.tpl')));

                $e = new archiEvenement();

                $t->assign_vars(
                    array(
                        'prenom' => $res->prenom,
                        'nom'    => $res->nom,
                        'metier' => $res->metier,
                        'dateNaissance'=> $this->date->toFrench($res->dateNaissance),
                        'dateDeces'    => $this->date->toFrench($res->dateDeces),
                        'description'  => $res->description,
                        'urlAjout'     => $this->creerUrl('ajouterPersonne'),
                        'evenementLies'=> $e->afficherListe(array( 'selection' => 'personne',  'id' => $res->idPersonne))
                    )
                );

                ob_start();
                $t->pparse('pe');
                $html .= ob_get_contents();
                ob_end_clean();
            } else {
                $html .= 'ERREUR aucun résultat !';
            }
        } else {
            $html .= 'ERREUR mauvais ID!';
        }
        return $html;
    }

    /**
     * Afficher une liste de personnes
     *
     * @param array  $criteres      Critères
     * @param string $modeAffichage Mode d'affichage
     *
     * @return string HTML
     * */
    public function afficherListe($criteres = array(), $modeAffichage = '')
    {
        $html="";




        $html.="<script  >

            function insertOptionInSelect(idSelect, OptionValue, libelleValue)
            {
                nbElems = idSelect.options.length;
                idSelect.options[nbElems] = new Option(libelleValue, OptionValue);
                idSelect.options[nbElems].selected=true;
            }
            </script>
        ";

        $isResultatRecherche = false;
        $sqlMotCle = "";
        if (isset($this->variablesGet['motCle']) && $this->variablesGet['motCle']!='') {
            $sqlMotCle = " AND CONCAT(p.prenom, ' ', p.nom, ' ', p.description) LIKE \"%".mysql_real_escape_string($this->variablesGet['motCle'])."%\"";


            $isResultatRecherche = true;
        }






        $t = new Template('modules/archi/templates/');
        $t->set_filenames((array('personnesListe'=>'listePersonnes.tpl')));


        if (isset($this->variablesGet['modeAffichage']) && $this->variablesGet['modeAffichage']!="") {
            $modeAffichage = $this->variablesGet['modeAffichage'];
        }


        //newIdPersonneAdded
        switch ($modeAffichage) {
            case "nouveauDossier":
            case "modifEvenement":
                // si c'est un affichage apres un ajout ,  on renvoi le nouvel element au formulaire
                if (isset($criteres['newIdPersonneAdded']) && $criteres['newIdPersonneAdded']!='0') {
                    /*$t->assign_vars(array('codeJavascriptReturnNewElementAjoute'=>"
                    parent.document.getElementById(parent.document.getElementById('paramChampsAppelantPersonne').value).innerHTML+='<option value=".$criteres['newIdPersonneAdded']." selected>".$this->getPersonneLibelle($criteres['newIdPersonneAdded'])."</option>';
                    "));
                    */

                    $t->assign_vars(array('codeJavascriptReturnNewElementAjoute'=>"insertOptionInSelect(parent.document.getElementById(parent.document.getElementById('paramChampsAppelantPersonne').value), '".$criteres['newIdPersonneAdded']."', '".str_replace("'", "\'", $this->getPersonneLibelle($criteres['newIdPersonneAdded']))."')"));
                }
                break;

            default:
                break;
        }







        // analyse des criteres
        $sqlLettreCourante = '';

        // récupération du nombre de résultats par lettres
        $tabLettres = array();
        $sqlComptageResultat = 'SELECT LOWER(SUBSTRING(p.nom,  1, 1)) AS lettre FROM personne p
            WHERE 1 GROUP BY LOWER(SUBSTRING(p.nom,  1, 1))';
        $rep = $this->connexionBdd->requete($sqlComptageResultat);
        while ($res = mysql_fetch_object($rep)) {
            $tabLettres[] = $res->lettre;
        }

        // si aucune lettre n'est précisée,  on indique la première lettre ayant des résultats
        // si le tableau de lettres est défini
        // et que la première lettre n'existe pas ou que la première lettre n'existe pas dans le tableau
        if (count($tabLettres) > 0 and  (!isset($criteres['alphaPersonne']) or (!in_array($criteres['alphaPersonne'], $tabLettres)))) {
            $criteres['alphaPersonne'] = $tabLettres[0];
        }

        if (isset($criteres['alphaPersonne']) && !$isResultatRecherche) {
            $sqlLettreCourante = " AND LOWER(SUBSTRING(p.nom, 1, 1)) = '".$criteres['alphaPersonne']."' ";
        }

        $nbEnregistrementsParPage='5';
        if (isset($criteres['nbEnregistrements'])) {
            $nbEnregistrementsParPage=$criteres['nbEnregistrements'];
        }

        $debutEnregistrement = '0';
        if (isset($criteres['archiPagePersonne'])) {
            $debutEnregistrement = ($criteres['archiPagePersonne']-1)*$nbEnregistrementsParPage;
        }



        if (!$isResultatRecherche) {
            $t->assign_vars(array('listeAlphabetique' => $this->afficherListeAlphabetique('personneListe', '', $tabLettres))); // 'personneListe' correspond au cas d'affichage de index.php
        }

        $t->assign_vars(
            array(
                'urlAjout'=> $this->creerUrl('', 'afficherAjouterPersonne', array('noHeaderNoFooter'=>1, 'modeAffichage'=>$modeAffichage)),
                'urlRecherchePersonne' => $this->creerUrl('', 'personneListe'),
                'modeAffichage'=>$modeAffichage,
                'archiAffichage'=>'personneListe'
            )
        ); // pour urlRecherchePersonne,  noHeaderNoFooter et modeAffichage sont dans le formulaire en hidden vu que les variables du formulaire sont transmises en GET



        $reqNbPersonnes = "
                            SELECT 0
                            FROM personne p
                            WHERE 1=1
                            ".$sqlLettreCourante."
                            ".$sqlMotCle."
                                    ";

        $resNbPersonnes = $this->connexionBdd->requete($reqNbPersonnes);

        $nbEnregistrementTotaux = mysql_num_rows($resNbPersonnes);

        // nombre d'images affichées sur une page
        $nbEnregistrementsParPage = 5;
        $arrayPagination=$this->pagination(
            array(
                'nomParamPageCourante'=>'archiPageCourantePersonne',
                'nbEnregistrementsParPage'=>$nbEnregistrementsParPage,
                'nbEnregistrementsTotaux'=>$nbEnregistrementTotaux,
                'typeLiens'=>'noformulaire'
            )
        );


        $t->assign_vars(array('pagination'=>$arrayPagination['html']));

        // recuperation du nombre de personne de la lettre courante ,  pour les numeros de pages
        $reqPersonnes = "
            SELECT p.idPersonne as idPersonne,  m.nom as metier,  p.nom as nom,  p.prenom as prenom,  p.dateNaissance as dateNaissance,  p.dateDeces as dateDeces,  p.description as description
            FROM personne p
            LEFT JOIN metier m ON m.idMetier = p.idMetier
            WHERE 1=1
            ".$sqlLettreCourante."
            ".$sqlMotCle."
            ORDER BY p.nom
            LIMIT ".$arrayPagination['limitSqlDebut'].", ".$nbEnregistrementsParPage;



        $resPersonnes=$this->connexionBdd->requete($reqPersonnes);
        $nbEnregistrements = mysql_num_rows($resPersonnes);

        // recuperation du nombre de pages a afficher

        if ($nbEnregistrements > $nbEnregistrementsParPage) {
            if ($nbEnregistrements%$nbEnregistrementsParPage!=0) {
                // on prend la partie entiere de la division + 1

                $nbPages = intval($nbEnregistrements/$nbEnregistrementsParPage)+1;
            } else {
                $nbPages = $nbEnregistrements/$nbEnregistrementsParPage;
            }

            for ($i=1; $i<=$nbPages; $i++) {
                switch ($modeAffichage) {
                    case "nouveauDossier":
                    case "modifEvenement":
                        $t->assign_block_vars(
                            'pages',
                            array(
                            'page'=>$i,
                            'url'=>$this->creerUrl('', '', array_merge($this->variablesGet, array('archiPagePersonne'=>$i, 'archiAffichage'=>'afficheRecherchePersonnePopup'))),
                            'onclick'=>""
                            )
                        );
                        break;
                    default:
                        $t->assign_block_vars(
                            'pages',
                            array(
                            'page'=>$i,
                            'url'=>$this->creerUrl('', '', array_merge($this->variablesGet, array('archiPagePersonne'=>$i, 'archiAffichage'=>'personneListe'))),
                            'onclick'=>""
                            )
                        );
                        break;
                }
            }
        } else {
            $nbPages=1;
        }


        if ($nbEnregistrements>0) {
            mysql_data_seek($resPersonnes, $debutEnregistrement);
            $i=0;
            while ($i<$nbEnregistrementsParPage) {
                $fetchPersonne=mysql_fetch_assoc($resPersonnes);


                switch ($modeAffichage) {
                    case "nouveauDossier":
                    case "modifEvenement":
                        $t->assign_block_vars(
                            'personne',
                            array(
                            'nom'=>stripslashes($fetchPersonne['nom']),
                            'prenom'=>stripslashes($fetchPersonne['prenom']),
                            'metier'=>stripslashes($fetchPersonne['metier']),
                            'url'=>'#',
                            'onclick'=>"insertOptionInSelect(parent.document.getElementById('personnes'), '".str_replace("'", "\'", $fetchPersonne['idPersonne'])."', '".str_replace("'", "\'", $fetchPersonne['nom'])." ".str_replace("'", "\'", $fetchPersonne['prenom'])."')"
                            )
                        );
                        break;
                    default:
                        $t->assign_block_vars(
                            'personne',
                            array(
                            'url'=>$this->creerUrl('', 'personne', array('idPersonne'=>$fetchPersonne['idPersonne'])),
                            'nom'=>stripslashes($fetchPersonne['nom']),
                            'prenom'=>stripslashes($fetchPersonne['prenom']),
                            'metier'=>stripslashes($fetchPersonne['metier'])
                            )
                        );
                        break;
                }

                $i++;
            }
        } else {
            $t->assign_block_vars('noPersonne', array());
        }

        ob_start();
        $t->pparse('personnesListe');
        $html .= ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
     * Afficher la liste des personnes par ordre alphabétique
     *
     * @param string $affichage      ?
     * @param string $lettreCourante Lettre en cours
     * @param array  $tableauLettres Liste de l'alphabet
     *
     * @return string HTML
     * */
    public function afficherListeAlphabetique($affichage = '', $lettreCourante = 'a', $tableauLettres = array())
    {
        $html="";
        $t = new Template('modules/archi/templates/');
        $t->set_filenames((array('listeAlpha'=>'listeAlphabetique.tpl')));

        //$liste = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $liste = $tableauLettres;

        foreach ($liste as $indice => $value) {
            $t->assign_block_vars('lettres', array('url'=>$this->creerUrl('', '', array_merge($this->variablesGet, array('archiAction'=>'',  'alphaPersonne'=>$value, 'archiPagePersonne'=>'1', 'archiAffichage'=>$affichage))), 'lettre'=>$value));
        }

        ob_start();
        $t->pparse('listeAlpha');
        $html .= ob_get_contents();
        ob_end_clean();

        return $html;
    }


    /**
     * Renvoie le nom, prenom d'une personne suivant son ID
     *
     * @param int $idPersonne ID
     *
     * @return string Nom et prénom
     * */
    public function getPersonneLibelle($idPersonne = 0)
    {
        $req = "SELECT nom, prenom FROM personne WHERE idPersonne = '".$idPersonne."'";
        $res = $this->connexionBdd->requete($req);
        $fetch = mysql_fetch_assoc($res);
        return $fetch['nom'].' '.$fetch['prenom'];
    }



    /**
     * ?
     *
     * @return void
     * */
    public function associerEvenement()
    {
    }

    /**
     * ?
     *
     * @return void
     * */
    public function dissocierEvenement()
    {
    }

    /**
     * Enregistrement de la liaison entre les personnes selectionnées et l'evenement
     *
     * @param int    $idEvenementALier           ID de l'événement
     * @param string $nomChampPersonneFormulaire ?
     *
     * @return void
     * */
    public function enregistreLiaisonEvenement($idEvenementALier = 0, $nomChampPersonneFormulaire = 'personnes')
    {

        if (isset($this->variablesPost[$nomChampPersonneFormulaire]) && is_array($this->variablesPost[$nomChampPersonneFormulaire]) && count($this->variablesPost[$nomChampPersonneFormulaire])>0) {
            // on supprime les anciennes liaison
            $resDelete = $this->connexionBdd->requete("delete from _evenementPersonne where idEvenement = '".$idEvenementALier."'");

            // on ajoute les nouvelles liaisons vers l'evenement
            foreach ($this->variablesPost[$nomChampPersonneFormulaire] as $indice => $value) {
                $resInsert=$this->connexionBdd->requete("insert into _evenementPersonne (idPersonne,  idEvenement) values ('".$value."', '".$idEvenementALier."')");
            }
        }
    }

    /**
     * Suppression des liaisons entre un événement donné et une personne
     *
     * @param int $idEvenement ID de l'événement
     *
     * @return void
     * */
    public function deleteLiaisonsPersonneFromIdEvenement($idEvenement = 0)
    {
        $req = "delete from _evenementPersonne where idEvenement = '".$idEvenement."'";
        $res = $this->connexionBdd->requete($req);
    }

    /**
     * Renvoi les infos d'une personne
     *
     * @param int $id ID
     *
     * @return array
     * */
    public function getInfosPersonne($id = 0)
    {
        $req = "
            SELECT idPersonne, p.nom as nom, p.prenom as prenom, m.nom as nomMetier , p.dateNaissance dateNaissance, p.dateDeces as dateDeces, p.description as description
            FROM personne p
            LEFT JOIN metier m ON m.idMetier = p.idMetier
            WHERE p.idPersonne = '".mysql_real_escape_string($id)."'
        ";


        $res = $this->connexionBdd->requete($req);

        $fetch = mysql_fetch_assoc($res);
        $fetch['nom']=stripslashes($fetch['nom']);
        $fetch['prenom']=stripslashes($fetch['prenom']);

        return $fetch;
    }

    /**
     * Permet de vérifier si un événement appartient à une personne
     *
     * @param int $id ID de l'événement
     *
     * @return mixed (ID personne ou false)
     * */
    public static function isPerson($id)
    {
        global $config;
        $req = "
            SELECT idPersonne
            FROM _personneEvenement
            WHERE idEvenement = '".mysql_real_escape_string($id)."'
        ";
        $res = $config->connexionBdd->requete($req);

        if ($fetch=mysql_fetch_assoc($res)) {
            return intval($fetch["idPersonne"]);
        } else {
            return false;
        }
    }

    /**
     * Obtenir les nom et prénom d'une personne
     *
     * @param int $id ID
     *
     * @return array
     * */
    public static function getName($id)
    {
        global $config;
        $req = "
            SELECT nom, prenom
            FROM personne
            WHERE idPersonne = '".mysql_real_escape_string($id)."'
        ";


        $res = $config->connexionBdd->requete($req);

        return mysql_fetch_object($res);
    }

    /**
     * Obtenir les événements liés à une personne
     *
     * @param int    $id    ID de la personne
     * @param string $date  Date de début de la période voulue
     * @param string $date2 Date de fin de la période voulue
     *
     * @return array
     * */
    public static function getEvenementsLies($id, $date, $date2)
    {
        global $config;
        $req = "
            SELECT idEvenement
            FROM _evenementPersonne
            WHERE idPersonne = '".$id."'
        ";
        $res = $config->connexionBdd->requete($req);
        $events=array();
        while ($event = mysql_fetch_assoc($res)) {
            $events[]=$event;
        }
        $return=array();
        foreach ($events as $event) {
            $idEvent=$event["idEvenement"];
            $req = "
                SELECT dateDebut
                FROM historiqueEvenement
                WHERE idEvenement = '".$idEvent."'
                ORDER BY `idHistoriqueEvenement` DESC
            ";
            $res = $config->connexionBdd->requete($req);
            $dateEvent = mysql_fetch_object($res)->dateDebut;
            if (($dateEvent >= $date && $dateEvent < $date2) || ($date2==3000 && $dateEvent=="0000-00-00")) {
                $return[] = $idEvent;
            }
        }
        return $return;
    }

    /**
     * Obtenir l'image principale d'une personne
     *
     * @param int    $id          ID de la personne
     * @param string $size        Taille de l'image
     * @param bool   $showDefault Afficher une image de remplacement si pas d'image ?
     *
     * @return string URL
     * */
    public static function getImage($id, $size = "moyen", $showDefault = true, $dimension = array('height'=>200,'width'=>200))
    {
        global $config;
        $req = "
            SELECT idImage
            FROM _personneImage
            WHERE idPersonne = '".mysql_real_escape_string($id)."'
        ";

        $res = $config->connexionBdd->requete($req);
        if ($fetch=mysql_fetch_object($res)) {
            $req = "
                SELECT dateUpload, idHistoriqueImage
                FROM historiqueImage
                WHERE idImage = '".$fetch->idImage."'
            ";
            $res = $config->connexionBdd->requete($req);
            $fetch = mysql_fetch_object($res);
            if (isset($fetch->idHistoriqueImage)) {
                if ($size=="resized") {
                    return "resizeImage.php?id=".$fetch->idHistoriqueImage."&height=".$dimension['height']."&width=".$dimension['width']."";
                }
                return $config->getUrlImage($size).$fetch->dateUpload.'/'.$fetch->idHistoriqueImage.'.jpg';
            }
        }
        if ($showDefault) {
            return "images/avatar/default.jpg";
        }

    }


    /**
     * Obtenir tous les événements d'une personne
     *
     * @param int $id ID de la personne
     *
     * @return array
     * */
    public static function getEvents($id)
    {
        global $config;
        $req = "
            SELECT idEvenement
            FROM _personneEvenement
            WHERE idPersonne = '".$id."'
        ";
        $res = $config->connexionBdd->requete($req);
        $e=new archiEvenement();
        return $e->getEvenementsLies(mysql_fetch_object($res)->idEvenement);
    }


    /**
     * Obtenir toutes les images des événements d'une personne
     *
     * @param int $id ID de la personne
     *
     * @return array
     * */
    public static function getImages($id)
    {
        global $config;
        $events=self::getEvents($id);
        $img=new archiImage();
        foreach ($events as $event) {
            $params = array("select"=>"hi1.idImage, hi1.dateUpload, hi1.idHistoriqueImage", "idEvenement"=>$event["idEvenementAssocie"]);
            $res=$config->connexionBdd->requete($img->getImagesFromEvenement($params));
            while ($image=mysql_fetch_object($res)) {
                $return[] =$image;
            }
        }
        return $return;
    }


    /**
     * Définit l'image principale d'une personne
     *
     * @param int $idPerson ID de la personne
     * @param int $idImage  ID de l'image
     *
     * @return bool
     * */
    public static function setImage($idPerson, $idImage)
    {
        global $config;
        $req = "
            SELECT idImage
            FROM _personneImage
            WHERE idPersonne = '".$idPerson."'
        ";

        $res = $config->connexionBdd->requete($req);

        if ($fetch=mysql_fetch_object($res)) {
            $req = "
                UPDATE _personneImage
                SET idImage='$idImage'
                WHERE idPersonne = '".$idPerson."'
            ";
        } else {
            $req = "
            INSERT INTO `_personneImage` (
                `idPersonne` ,
                `idImage`
            )
            VALUES (
                '$idPerson', '$idImage'
            )";
        }

        if ($config->connexionBdd->requete($req)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Afficher les événements liés à une personne
     *
     * @param int    $idPerson  ID de la personne
     * @param string $dateDebut Date de début de la période voulue
     * @param string $date2     Date de fin de la période voulue
     *
     * @return  string HTML
     * */
    public static function displayEvenementsLies($idPerson, $dateDebut, $date2)
    {
        global $config;
        $linkedEvents=archiPersonne::getEvenementsLies($idPerson, $dateDebut, $date2);
        if (count($linkedEvents)) {
            $linkedEventsHTML="<h4>"._("Adresses liées :")."</h4><ul>";
            foreach ($linkedEvents as $linkedEvent) {
                $req = "
                    SELECT titre, dateDebut, idTypeEvenement
                    FROM historiqueEvenement
                    WHERE idEvenement = '".$linkedEvent."'
                    ORDER BY idHistoriqueEvenement DESC
                ";

                $res = $config->connexionBdd->requete($req);
                $event=mysql_fetch_object($res);

                $a=new archiAdresse();
                $linkedEventAddress=$a->getIntituleAdresseFrom($linkedEvent, "idEvenement");
                $e = new archiEvenement();
                if (!empty($linkedEventAddress)) {
                    $req = "
                            SELECT  idAdresse
                            FROM _adresseEvenement
                            WHERE idEvenement = ".
                            $e->getIdEvenementGroupeAdresseFromIdEvenement($linkedEvent);
                    $res = $config->connexionBdd->requete($req);
                    $fetch = mysql_fetch_object($res);
                    if (isset($fetch->idAdresse)) {
                        $linkedEventIdAddress=$fetch->idAdresse;
                    }
                }

                $idEvenementGroupeAdresse = $a->getIdEvenementGroupeAdresseFromIdAdresse($linkedEventIdAddress);

                $reqAdresseDuGroupeAdresse = "
                    SELECT ha1.idAdresse as idAdresse,ha1.numero as numero,
                    ha1.idRue as idRue, IF(ha1.idIndicatif='0','',i.nom)
                    as nomIndicatif, ha1.idQuartier as idQuartier, ha1.idSousQuartier as idSousQuartier
                    FROM historiqueAdresse ha2, historiqueAdresse ha1
                    LEFT JOIN _adresseEvenement ae ON ae.idAdresse = ha1.idAdresse
                    LEFT JOIN indicatif i ON i.idIndicatif = ha1.idIndicatif
                    WHERE ha2.idAdresse = ha1.idAdresse
                    AND ae.idEvenement ='".mysql_real_escape_string($idEvenementGroupeAdresse)."'

                    GROUP BY ha1.idAdresse, ha1.idHistoriqueAdresse
                    HAVING ha1.idHistoriqueAdresse = max(ha2.idHistoriqueAdresse)
                    ORDER BY ha1.numero,ha1.idRue
                ";

                $resAdresseDuGroupeAdresse = $a->connexionBdd->requete($reqAdresseDuGroupeAdresse);

                if (mysql_num_rows($resAdresseDuGroupeAdresse) > 1) {
                    $txtAdresses = '';
                    $arrayNumero = [];
                    while ($fetchAdressesGroupeAdresse = mysql_fetch_assoc($resAdresseDuGroupeAdresse)) {
                        $isAdresseCourante = false;
                        if ($address['idAdresse'] == $fetchAdressesGroupeAdresse['idAdresse']) {
                            $isAdresseCourante = true;
                        }

                        if ($fetchAdressesGroupeAdresse['idRue'] == '0' || $fetchAdressesGroupeAdresse['idRue'] == '') {
                            if ($fetchAdressesGroupeAdresse['idQuartier'] != ''
                                && $fetchAdressesGroupeAdresse['idQuartier'] != '0'
                            ) {
                                $arrayNumero[$this->a->getIntituleAdresseFrom(
                                    $fetchAdressesGroupeAdresse['idAdresse'],
                                    'idAdresse',
                                    ['noSousQuartier' => true, 'noQuartier' => false, 'noVille' => true]
                                )][] =
                                    [
                                        'indicatif'         => $fetchAdressesGroupeAdresse['nomIndicatif'],
                                        'numero'            => $fetchAdressesGroupeAdresse['numero'],
                                        'isAdresseCourante' => $isAdresseCourante,
                                    ];
                            }

                            if ($fetchAdressesGroupeAdresse['idSousQuartier'] != ''
                                && $fetchAdressesGroupeAdresse['idSousQuartier'] != '0'
                            ) {
                                $arrayNumero[$this->a->getIntituleAdresseFrom(
                                    $fetchAdressesGroupeAdresse['idAdresse'],
                                    'idAdresse',
                                    ['noSousQuartier' => false, 'noQuartier' => true, 'noVille' => true]
                                )][] =
                                    [
                                        'indicatif'         => $fetchAdressesGroupeAdresse['nomIndicatif'],
                                        'numero'            => $fetchAdressesGroupeAdresse['numero'],
                                        'isAdresseCourante' => $isAdresseCourante,
                                    ];
                            }
                        } else {
                            $arrayNumero[$a->getIntituleAdresseFrom(
                                $fetchAdressesGroupeAdresse['idRue'],
                                'idRueWithNoNumeroAuthorized',
                                ['noSousQuartier' => true, 'noQuartier' => true, 'noVille' => true]
                            )][] =
                                [
                                    'indicatif'         => $fetchAdressesGroupeAdresse['nomIndicatif'],
                                    'numero'            => $fetchAdressesGroupeAdresse['numero'],
                                    'isAdresseCourante' => $isAdresseCourante,
                                ];
                        }
                    }

                    // affichage adresses regroupees
                    foreach ($arrayNumero as $intituleRue => $arrayInfosNumero) {
                        foreach ($arrayInfosNumero as $indice => $infosNumero) {
                            if ($infosNumero['numero'] == '' || $infosNumero['numero'] == '0') {
                                //rien
                            } else {
                                $txtAdresses .= $infosNumero['numero'].$infosNumero['indicatif'].'-';
                            }
                        }

                        $txtAdresses = trim($txtAdresses, '-');

                        $txtAdresses .= $intituleRue.', ';
                    }
                    $txtAdresses = trim($txtAdresses, ', ').
                        str_replace(
                            $a->getIntituleAdresseFrom($linkedEvent, "idEvenement", ['noQuartier'=>true, 'noSousQuartier'=>true, 'noVille'=>true]),
                            '',
                            $linkedEventAddress
                        );
                } else {
                    $txtAdresses = $linkedEventAddress;
                }

                //WIP sélection de l'image des personnes
                /*$req = "
                        SELECT  nom
                        FROM typeEvenement
                        WHERE idTypeEvenement = ".
                        mysql_real_escape_string($event->idTypeEvenement);
                $res = $config->connexionBdd->requete($req);
                $linkedEventType=mysql_fetch_object($res)->nom;

                 $req = "
                        SELECT idImage
                        FROM _personneAdresse
                        WHERE idPersonne = ".mysql_real_escape_string($idPerson)."
                        AND idAdresse = ".mysql_real_escape_string($linkedEventIdAddress)."
                        LIMIT 1";
                $res = $config->connexionBdd->requete($req);*/
                if ($idImage = mysql_fetch_object($res)->idImage) {
                    $img=new ArchiImage();
                    $img=($img->getInfosCompletesFromIdImage($idImage));
                    $linkedEventImg['url'] = $a->getUrlImage("mini").$img['dateUpload'].'/'.$idImage.'.jpg';
                } else {
                    $linkedEventImg=$a->getUrlImageFromEvenement($linkedEvent, "mini");
                    if ($linkedEventImg["url"]==$config->getUrlImage("", "transparent.gif")) {
                        $linkedEventImg=$a->getUrlImageFromAdresse($linkedEventIdAddress, "mini");
                    }
                }
                $linkedEventUrl=$config->creerUrl("", "adresseDetail", array("archiIdAdresse"=>$linkedEventIdAddress, "archiIdEvenementGroupeAdresse"=>$linkedEvent));
                $linkedEventsHTML.="<li class='linkedEvents'><img src='".
                $linkedEventImg["url"]."' alt='' /> <div><a href='$linkedEventUrl'>".$txtAdresses;
                $res=$e->getInfosEvenementsLiesForAncres($e->getIdEvenementGroupeAdresseFromIdEvenement($linkedEvent));
                $i=0;
                while ($rep=mysql_fetch_object($res)) {
                    if ($rep->idEvenement == $linkedEvent) {
                        $linkedEventPos=$i;
                    }
                    $i++;
                }
                $linkedEventsHTML.="</a>";
                $linkedEventsHTML.="<br/><small><a href='".$linkedEventUrl."#".$linkedEventPos."'>";
                if ($event->dateDebut != "0000-00-00") {
                    $linkedEventsHTML.=$config->date->toFrench($event->dateDebut);
                    if (!empty($event->titre)) {
                        $linkedEventsHTML.=", ";
                    }
                }
                if (!empty($event->titre)) {
                    $linkedEventsHTML.=stripslashes($event->titre);
                }
                if (!empty($linkedEventType)) {
                    $linkedEventsHTML.=", ";
                }
                $linkedEventsHTML.=$linkedEventType;
                $linkedEventsHTML.="</a></small>";
                $linkedEventsHTML.="</div></li>";
            }
            $linkedEventsHTML.="</ul>";
            return $linkedEventsHTML;
        }
    }


    /**
     * Recherche une personne
     *
     * @param string $keyword Mot recherché
     * @param int    $pos     Afficher à partir de quel élément
     *
     * @return string HTML
     * */
    public static function search($keyword, $pos = 1)
    {
        global $config;
        $html="<h1 id='personSearch'>"._("Personnes")."</h1>";
        $keyword = str_replace(' ', '%%', $keyword);
        $req="SELECT idPersonne
            FROM `personne`
            WHERE `prenom` LIKE '%".mysql_real_escape_string($keyword)."%'
            OR `nom` LIKE '%".mysql_real_escape_string($keyword)."%'
            OR CONCAT_WS(' ', nom, prenom) LIKE '%".mysql_real_escape_string($keyword)."%'
            OR CONCAT_WS(' ', prenom, nom) LIKE '%".mysql_real_escape_string($keyword)."%'";
        $res = $config->connexionBdd->requete($req);
        $nbPeople=mysql_num_rows($res);
        $maxPos=round($nbPeople/10);
        if ($maxPos<1) {
            $maxPos=1;
        }
        $minPos=1;
        $prevPos=$pos-1;
        $nextPos=$pos+1;
        if ($prevPos < $minPos) {
            $prevPos=$minPos;
        }

        if ($nextPos > $maxPos) {
            $nextPos=$maxPos;
        }
        $req="SELECT idPersonne, nom, prenom, idMetier
            FROM `personne`
            WHERE `prenom` LIKE '%".mysql_real_escape_string($keyword)."%'
            OR `nom` LIKE '%".mysql_real_escape_string($keyword)."%'
            OR CONCAT_WS(' ', nom, prenom) LIKE '%".mysql_real_escape_string($keyword)."%'
            OR CONCAT_WS(' ', prenom, nom) LIKE '%".mysql_real_escape_string($keyword)."%'
            LIMIT ".(($pos-1)*10).", ".($pos*10);
        $res = $config->connexionBdd->requete($req);
        while ($person=mysql_fetch_object($res)) {
            $people[]=($person);
        }
        $t=new Template('modules/archi/templates/');
        $t->set_filenames(array('listeAdresses'=>'listeAdresses.tpl'));
        $t->assign_block_vars(
            't',
            array(
                'urlPrecedent'         => $config->creerUrl("", "recherche", array("motcle"=>$_GET["motcle"], "pos"=>$prevPos, "submit"=>"Rechercher"))."#personSearch",
                'urlPrecedentOnClick'    => "",
                'urlSuivant'           => $config->creerUrl("", "recherche", array("motcle"=>$_GET["motcle"], "pos"=>$nextPos, "submit"=>"Rechercher"))."#personSearch",
                'urlSuivantOnClick'    => "",
                'nbReponses'           => $nbPeople." ".ngettext("réponse", "réponses", $nbPeople)
            )
        );
        for ($i=$minPos; $i<=$maxPos; $i++) {
            $t->assign_block_vars(
                "t.nav",
                array(
                    "nb"=>$i,
                    "urlNb"=>$config->creerUrl("", "recherche", array("motcle"=>$_GET["motcle"], "pos"=>$i, "submit"=>"Rechercher"))."#personSearch"
                )
            );
            if ($i==$pos) {
                $t->assign_block_vars("t.nav.courant", array());
            }
        }
        if (isset($people)) {
            foreach ($people as $person) {
                $req="SELECT nom
                    FROM `metier`
                    WHERE `idMetier` =".$person->idMetier;
                $res = $config->connexionBdd->requete($req);
                $job=mysql_fetch_object($res)->nom;
                $t->assign_block_vars(
                    "t.adresses",
                    array(
                        "nom"=>stripslashes($person->prenom." ".$person->nom),
                        "urlDetailHref"=>$config->creerUrl(
                            "",
                            "evenementListe",
                            array("selection"=>"personne", "id"=>$person->idPersonne)
                        ),
                        "urlImageIllustration"=>archiPersonne::getImage($person->idPersonne, "mini", false),
                        "titresEvenements"=>$job
                    )
                );
            }
        }
        ob_start();
        $t->pparse('listeAdresses');
        $html.=ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * Affiche les personnes liées
     *
     * @param int $id ID de la personne
     *
     * @return array
     * */
    public static function getRelatedPeople($id)
    {
        global $config;
        $req="SELECT idEvenement
            FROM `_evenementPersonne`
            WHERE `idPersonne` = '".mysql_real_escape_string($id)."';";
        $res = $config->connexionBdd->requete($req);
        $return = array();
        while ($event=mysql_fetch_object($res)) {
            $req2="SELECT DISTINCT idPersonne
                FROM `_evenementPersonne`
                WHERE `idEvenement` =".$event->idEvenement;
            $res2 = $config->connexionBdd->requete($req2);
            while ($person=mysql_fetch_object($res2)) {
                if ($person->idPersonne != $id && !in_array($person->idPersonne, $return)) {
                    $return[]=$person->idPersonne;
                }
            }
        }
        return $return;
    }

    /**
     * Affiche la liste des personnes liées à une source
     *
     * @param int $idSource ID de la source
     *
     * @return void
     * */
    public static function getPersonsFromSource($idSource)
    {
        global $config;
        $req="SELECT idEvenement
            FROM `historiqueEvenement`
            WHERE `idSource` =".$idSource;
        $res = $config->connexionBdd->requete($req);
        $e = new archiEvenement();
        while ($event=mysql_fetch_object($res)) {
            $idEvenementGroupeAdresse = $e->getIdEvenementGroupeAdresseFromIdEvenement($event->idEvenement);
            if ($idPerson=archiPersonne::isPerson($idEvenementGroupeAdresse)) {
                $person= new archiPersonne($idPerson);
                $people[]=$person->getInfosPersonne($idPerson);
            }
        }

        if (isset($people)) {
            $already=array();
            print "<b>Voici la liste des personnes auxquelles cette source est attachée</b>";
            print('<table class="results">');
            foreach ($people as $person) {
                if (!in_array($person['idPersonne'], $already)) {
                    $already[]=$person['idPersonne'];
                    print('<tr class="listAddressItem">
                    <td><a href="'.
                    $config->creerUrl(
                        "",
                        "evenementListe",
                        array("selection"=>"personne", "id"=>$person['idPersonne'])
                    ).'"><img src="'.archiPersonne::getImage($person['idPersonne'], "mini", false).'" border=0 alt=""></a> <span><br/><a href="'.$config->creerUrl(
                        "",
                        "evenementListe",
                        array("selection"=>"personne", "id"=>$person['idPersonne'])
                    ).'" >'.stripslashes($person['prenom']." ".$person['nom']).'</a></span><br/><span style="font-size:11px;">'.$person['nomMetier'].'</span></td>
                    </tr>');
                }
            }
            print('</table>');
        }
    }
}
