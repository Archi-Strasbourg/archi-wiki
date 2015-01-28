<?php
class Utils{

	public function createArchiWikiPhotoUrl($idHistoriqueImage , $dateUpoad,$base='',$format='grand'){
		/*
		 * http://localhost/archi-wiki/photos--2015-01-06-1138216-grand.jpg
		 */
		$base = ($base=='')? dirname(dirname(__DIR__))."/" : $base ;
		$url=$base.'/photos--'.$dateUpoad.'-'.$idHistoriqueImage.'-'.$format.'.jpg';
		return $url;
	}
	
	
	public function creerUrl(
			$action= null, $affichage = null, $autre = array(), $keep=false, $clean=true
	) {
		$string = new stringObject();
		$amp=$clean?"&amp;":"&";

		if ($keep) {
			$url="?".htmlentities($_SERVER["QUERY_STRING"]).$amp;
			$url_existe = true;
		} else {
			$url = '?';
			$url_existe = false;
		}
		if (!empty($action)) {
			$url .= 'archiAction='.$action;
			$url_existe = true;
		}

		if (!empty($affichage)) {
			if ($url_existe == true) {
				$url .= $amp;
			}

			$url .= 'archiAffichage='.$affichage;
			$url_existe = true;
		}

		if (is_array($autre) && count($autre)>0) {
			$i = 0;
			foreach ($autre AS $nom => $val) {
				if (is_array($val)) {
					foreach ($val AS $case) {
						if ($url_existe == true) {
							$url .= $amp;
						}
						$url .= $nom.'%5B%5D='.urlencode($case);
					}
				} else {
					if ($url_existe == true || $i>0) {
						$url .= $amp;
					}
					$url .= $nom.'='.urlencode($val);
				}
				$i++;
			}
			if ($url_existe == false) {
				$url = '?'.pia_substr($url, 1);
			}
		}


		if (isset($affichage)
		&& $affichage=='afficheAccueil'
				&& isset($autre['archiNomVilleGeneral'])
				&& $autre['archiNomVilleGeneral']!=''
						) {
			$url = $autre['archiNomVilleGeneral']."/";
		}



		/* Si l'url est un appel simple a l'affichage d'une adresse,
		 * comme sur la page d'accueil par exemple, on rewrite
		* */
		if (isset($affichage)
		&& $affichage == 'adresseDetail'
				&& isset($autre['archiIdAdresse'])
				&& count($autre)==1
		) {
			// rewriting
			$adresse = new archiAdresse();

			$fetchAdresse = $adresse
			->getArrayAdresseFromIdAdresse($autre['archiIdAdresse']);
			$intitule = $adresse->getIntituleAdresse($fetchAdresse);
			$intitule = $string->convertStringToUrlRewrite($intitule);
			$url = 'adresse-'.$intitule."-".$autre['archiIdAdresse'].".html";
		}



		if (isset($affichage)
		&& $affichage == 'detailProfilPublique'
				&& isset($autre['archiIdUtilisateur'])
				&& count($autre)==1
		) {
			$url = 'profil-'.$autre['archiIdUtilisateur'].'.html';
		}

		if (isset($affichage)
		&& $affichage== 'detailProfilPublique'
				&& isset($autre['archiIdUtilisateur'])
				&& isset($autre['archiIdEvenementGroupeAdresseOrigine'])
				&& count($autre)==2
		) {
			$url = 'profil-'.$autre['archiIdUtilisateur'].'-'.
					$autre['archiIdEvenementGroupeAdresseOrigine'].'.html';
		}





		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='adresseDetail'
				&& isset($autre['archiIdAdresse'])
				&& count($autre)>2
		) {
			// rewriting
			$adresse = new archiAdresse();

			$fetchAdresse = $adresse->getArrayAdresseFromIdAdresse(
					$autre['archiIdAdresse']
			);
			$intitule = $adresse->getIntituleAdresse($fetchAdresse);
			$intitule = $string->convertStringToUrlRewrite($intitule);
			$url = 'adresse-'.$intitule."-".$autre['archiIdAdresse'].".html?check=1";
			$urlComplement="";
			foreach ($autre as $intitule => $valeur) {
				if ($intitule!='archiAffichage' || $intitule!='archiIdAdresse') {
					$urlComplement.=$amp.$intitule."=".$valeur;
				}
			}

			$url.=$urlComplement;
		}

		if (isset($affichage)
		&& $affichage=='evenementListe'
				&& isset($autre['selection'])
				&& $autre['selection']=='personne'
						&& isset($autre['id'])
		) {
			$personne = new archiPersonne();
			$nomPrenom=$personne->getPersonneLibelle($autre['id']);
			$url = "personnalite-".$string->convertStringToUrlRewrite($nomPrenom).
			"-".$autre['id'].".html";
		}

		if (isset($affichage)
		&& $affichage=='adresseListe'
				&& isset($autre['recherche_rue'])
				&& $autre['recherche_rue']!=''
						) {
			$adresse = new archiAdresse();
			$intituleRue = $adresse->getIntituleAdresseFrom(
					$autre['recherche_rue'], 'idRue'
			);
			$url = "rue-".$string->convertStringToUrlRewrite(trim($intituleRue)).
			"-".$autre['recherche_rue'].".html";
		}

		if (isset($affichage)
		&& $affichage=='listeDossiers'
				&& isset($autre['archiIdQuartier'])
				&& $autre['archiIdQuartier']!=''
						&& isset($autre['modeAffichageListe'])
						&& $autre['modeAffichageListe']=='parRuesDeQuartier'
								&& isset($autre['archiPageRuesQuartier'])
								&& $autre['archiPageRuesQuartier']!=''
										) {
			$adresse = new archiAdresse();
			$intituleRue = $adresse->getIntituleAdresseFrom(
					$autre['archiIdQuartier'], 'idQuartier'
			);
			$url = "quartier-".
					$string->convertStringToUrlRewrite(trim($intituleRue)).
					"-".$autre['archiIdQuartier']."-page".
					$autre['archiPageRuesQuartier'].".html";
		}




		if (isset($affichage)
		&& $affichage=='adresseListe'
				&& isset($autre['recherche_quartier'])
				&& $autre['recherche_quartier']!=''
						) {
			$adresse = new archiAdresse();
			$intituleRue = $adresse->getIntituleAdresseFrom(
					$autre['recherche_quartier'], 'idQuartier'
			);
			$url = "quartier-".
					$string->convertStringToUrlRewrite(trim($intituleRue)).
					"-".$autre['recherche_quartier'].".html";
		}

		if (isset($affichage)
		&& $affichage=='adresseListe'
				&& isset($autre['recherche_ville'])
				&& $autre['recherche_ville']!=''
						) {
			$adresse = new archiAdresse();
			$intituleRue = $adresse->getIntituleAdresseFrom(
					$autre['recherche_ville'], 'idVille'
			);
			$url = "ville-".$string->convertStringToUrlRewrite(trim($intituleRue)).
			"-".$autre['recherche_ville'].".html";
		}

		if (isset($affichage)
		&& $affichage=='listeAdressesFromRue'
				&& isset($autre['recherche_rue'])
				&& $autre['recherche_rue']!=''
						&& isset($autre['noAdresseSansNumero'])
						&& $autre['noAdresseSansNumero']==1
		) {
			$adresse = new archiAdresse();
			$intituleRue = $adresse->getIntituleAdresseFrom(
					$autre['recherche_rue'], 'idRue'
			);
			$url = "rue-adresses-".
					$string->convertStringToUrlRewrite(trim($intituleRue)).
					"-".$autre['recherche_rue'].".html";
		}

		if (isset($affichage) && $affichage=='listeAdressesFromRue'
				&& isset($autre['recherche_rue']) && $autre['recherche_rue']!=''
						&& !isset($autre['noAdresseSansNumero'])
		) {
			$adresse = new archiAdresse();
			$intituleRue = $adresse->getIntituleAdresseFrom(
					$autre['recherche_rue'], 'idRue'
			);
			$url = "rue-".$string
			->convertStringToUrlRewrite(trim($intituleRue)).
			"-".$autre['recherche_rue'].".html";
		}

		if (isset($affichage)
		&& $affichage=='statistiquesAccueil'
				&& count($autre)==0
		) {
			$url = "statistiques-adresses-photos-architectes-strasbourg.html";
		}




		// *************************************************************
		/* Ceci ne sert qu'au copier coller de lien,
		* vu que l'information est de toute facon passée en session
		* */
		if (isset($affichage)
		&& $affichage=='listeDossiers'
				&& isset($autre['archiIdVilleGeneral'])
				&& !isset($autre['modeAffichageListe'])
				&& !isset($autre['archiPageCouranteVille'])
		) {
			$adresse = new archiAdresse();
			$stringObj = new stringObject();
			$fetchInfosVille = $adresse->getInfosVille(
					$autre['archiIdVilleGeneral'],
					array('fieldList'=>'v.nom as nomVille')
			);

			$nomVilleGeneral = $stringObj
			->convertStringToUrlRewrite($fetchInfosVille['nomVille']);

			$url = "dossiers-rues-quartiers-adresses-photos-".$nomVilleGeneral
			."-".$autre['archiIdVilleGeneral'].".html";
		}

		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='listeDossiers'
				&& isset($autre['archiPageCouranteVille'])
				&& $autre['archiPageCouranteVille']!=''
						&& !isset($autre['modeAffichageListe'])
						&& isset($autre['archiIdVilleGeneral'])
						&& !isset($autre['lettreCourante'])
		) {
			$adresse = new archiAdresse();
			$stringObj = new stringObject();
			$fetchInfosVille = $adresse->getInfosVille(
					$autre['archiIdVilleGeneral'],
					array('fieldList'=>'v.nom as nomVille')
			);

			$nomVilleGeneral = $stringObj
			->convertStringToUrlRewrite($fetchInfosVille['nomVille']);

			$url = "dossiers-rues-quartiers-adresses-photos-".
					$nomVilleGeneral."-".$autre['archiIdVilleGeneral']."-page".
					$autre['archiPageCouranteVille'].".html";
		}

		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='listeDossiers'
				&& isset($autre['archiPageCouranteVille'])
				&& $autre['archiPageCouranteVille']!=''
						&& isset($autre['modeAffichageListe'])
						&& isset($autre['archiIdVilleGeneral'])
						&& !isset($autre['lettreCourante'])
		) {
			$adresse = new archiAdresse();
			$stringObj = new stringObject();
			$fetchInfosVille = $adresse->getInfosVille(
					$autre['archiIdVilleGeneral'],
					array('fieldList'=>'v.nom as nomVille')
			);

			$nomVilleGeneral = $stringObj
			->convertStringToUrlRewrite($fetchInfosVille['nomVille']);

			$url = "dossiers-rues-quartiers-adresses-photos-".
					$nomVilleGeneral."-".$autre['archiIdVilleGeneral']."-page".
					$autre['archiPageCouranteVille']."-".
					$autre['modeAffichageListe'].".html";
		}

		// modif lettre courante
		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='listeDossiers'
				&& isset($autre['archiPageCouranteVille'])
				&& $autre['archiPageCouranteVille']!=''
						&& isset($autre['modeAffichageListe'])
						&& isset($autre['archiIdVilleGeneral'])
						&& isset($autre['lettreCourante'])
						&& $autre['lettreCourante']!=''
								) {
			$adresse = new archiAdresse();
			$stringObj = new stringObject();
			$fetchInfosVille = $adresse
			->getInfosVille(
					$autre['archiIdVilleGeneral'],
					array('fieldList'=>'v.nom as nomVille')
			);

			$nomVilleGeneral = $stringObj
			->convertStringToUrlRewrite($fetchInfosVille['nomVille']);

			$url = "dossiers-rues-quartiers-adresses-photos-".
					$nomVilleGeneral."-".$autre['archiIdVilleGeneral']."-page".
					$autre['archiPageCouranteVille']."-".
					$autre['modeAffichageListe']."-lettre".
					$autre['lettreCourante'].".html";


		}



		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='listeDossiers'
				&& !isset($autre['archiPageCouranteVille'])
				&& isset($autre['modeAffichageListe'])
				&& $autre['modeAffichageListe']!=''
						&& isset($autre['archiIdVilleGeneral'])
						&& isset($autre['lettreCourante'])
		) {
			$adresse = new archiAdresse();
			$stringObj = new stringObject();
			$fetchInfosVille = $adresse
			->getInfosVille(
					$autre['archiIdVilleGeneral'],
					array('fieldList'=>'v.nom as nomVille')
			);

			$nomVilleGeneral = $stringObj
			->convertStringToUrlRewrite($fetchInfosVille['nomVille']);

			$url = "dossiers-rues-quartiers-adresses-photos-ville-".
					$nomVilleGeneral."-".$autre['archiIdVilleGeneral']."-".
					$autre['modeAffichageListe']."-lettre".
					$autre['lettreCourante'].".html";
		}




		if (isset($affichage)
		&& $affichage=='listeDossiers'
				&& !isset($autre['archiPageCouranteVille'])
				&& isset($autre['modeAffichageListe'])
				&& $autre['modeAffichageListe']!=''
						&& isset($autre['archiIdVilleGeneral'])
						&& !isset($autre['lettreCourante'])
		) {
			$adresse = new archiAdresse();
			$stringObj = new stringObject();
			$fetchInfosVille = $adresse
			->getInfosVille(
					$autre['archiIdVilleGeneral'],
					array('fieldList'=>'v.nom as nomVille')
			);

			$nomVilleGeneral = $stringObj
			->convertStringToUrlRewrite($fetchInfosVille['nomVille']);

			$url = "dossiers-rues-quartiers-adresses-photos-ville-".
					$nomVilleGeneral."-".$autre['archiIdVilleGeneral']."-".
					$autre['modeAffichageListe'].".html";
		}




		// ************************************************************



		if (count($autre)==2
		&& isset($autre['lettreCourante'])
		&& $autre['lettreCourante']!=''
				&& isset($autre['archiAffichage'])
				&& $autre['archiAffichage']=='listeDossiers'
						) {
			$url = "dossiers-rues-quartiers-adresses-photos-strasbourg-lettre".
					$autre['lettreCourante'].".html";
		}

		if (isset($affichage)
		&& $affichage=='listeDossiers'
				&& count($autre)==0
		) {
			$url = "dossiers-rues-quartiers-adresses-photos-strasbourg.html";
		}

		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='listeDossiers'
				&& isset($autre['archiPageCouranteVille'])
				&& $autre['archiPageCouranteVille']!=''
						&& !isset($autre['modeAffichageListe'])
						&& !isset($autre['archiIdVilleGeneral'])
						&& isset($autre['lettreCourante'])
						&& $autre['lettreCourante']!=''
								) {
			$url = "dossiers-rues-quartiers-adresses-photos-strasbourg-page".
					$autre['archiPageCouranteVille']."-lettre".
					$autre['lettreCourante'].".html";
		}





		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='listeDossiers'
				&& isset($autre['archiPageCouranteVille'])
				&& $autre['archiPageCouranteVille']!=''
						&& !isset($autre['modeAffichageListe'])
						&& !isset($autre['archiIdVilleGeneral'])
						&& !isset($autre['lettreCourante'])
		) {
			$url = "dossiers-rues-quartiers-adresses-photos-strasbourg-page".
					$autre['archiPageCouranteVille'].".html";
		}








		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='listeDossiers'
				&& isset($autre['archiPageCouranteVille'])
				&& $autre['archiPageCouranteVille']!=''
						&& isset($autre['modeAffichageListe'])
						&& !isset($autre['archiIdVilleGeneral'])
		) {
			$url = "dossiers-rues-quartiers-adresses-photos-strasbourg-page".
					$autre['archiPageCouranteVille']."-".
					$autre['modeAffichageListe'].".html";
		}



		if (isset($affichage)
		&& $affichage=='listeDossiers'
				&& !isset($autre['archiPageCouranteVille'])
				&& isset($autre['modeAffichageListe'])
				&& $autre['modeAffichageListe']!=''
						&& !isset($autre['archiIdVilleGeneral'])
						&& !isset($autre['archiPageRuesQuartier'])
						&& !isset($autre['lettreCourante'])
		) {
			$url = "dossiers-rues-quartiers-adresses-photos-strasbourg-ville-".
					$autre['modeAffichageListe'].".html";
		}


		if (isset($affichage)
		&& $affichage=='toutesLesDemolitions'
				&& count($autre)==0
		) {
			$url = "demolitions-toutes-adresses-strasbourg-archi.html";
		}

		if (isset($affichage)
		&& $affichage=='toutesLesDemolitions'
				&& isset($autre['archiIdVilleGeneral'])
				&& $autre['archiIdVilleGeneral']!=''
						&& isset($autre['archiIdPaysGeneral'])
						&& $autre['archiIdPaysGeneral']!=''
								) {
			$url = "demolitions-toutes-adresses-strasbourg-archi-".
					$autre['archiIdVilleGeneral']."-".
					$autre['archiIdPaysGeneral'].".html";
		}


		if (isset($affichage)
		&& $affichage=='tousLesTravaux'
				&& isset($autre['archiIdVilleGeneral'])
				&& $autre['archiIdVilleGeneral']!=''
						&& isset($autre['archiIdPaysGeneral'])
						&& $autre['archiIdPaysGeneral']!=''
								) {
			$url = "travaux-tous-adresses-strasbourg-archi-".
					$autre['archiIdVilleGeneral']."-".
					$autre['archiIdPaysGeneral'].".html";
		}


		if (isset($affichage)
		&& $affichage=='tousLesTravaux'
				&& count($autre)==0
		) {
			$url = "travaux-tous-adresses-strasbourg-archi.html";
		}


		if (isset($affichage)
		&& $affichage=='tousLesEvenementsCulturels'
				&& isset($autre['archiIdVilleGeneral'])
				&& $autre['archiIdVilleGeneral']!=''
						&& isset($autre['archiIdPaysGeneral'])
						&& $autre['archiIdPaysGeneral']!=''
								) {
			$url = "culture-evenements-culturels-adresses-strasbourg-archi-".
					$autre['archiIdVilleGeneral']."-".
					$autre['archiIdPaysGeneral'].".html";
		}

		if (isset($affichage)
		&& $affichage=='tousLesEvenementsCulturels'
				&& count($autre)==0
		) {
			$url = "culture-evenements-culturels-adresses-strasbourg-archi.html";
		}



		if (isset($affichage)
		&& $affichage=='recherche'
				&& isset($autre['archiIdVilleGeneral'])
				&& $autre['archiIdVilleGeneral']!=''
						&& isset($autre['archiIdPaysGeneral'])
						&& $autre['archiIdPaysGeneral']!=''
								&& isset($autre['motcle'])
								&& $autre['motcle']==''
										&& isset($autre['submit'])
										&& $autre['submit']=='Rechercher'
												) {
			$url = "adresses-nouvelles-toutes-rues-villes-quartiers".
					"-strasbourg-archi-".
					$autre['archiIdVilleGeneral']."-".
					$autre['archiIdPaysGeneral'].".html";
		}

		if (isset($affichage)
		&& $affichage=='recherche'
				&& !isset($autre['archiIdVilleGeneral'])
				&& !isset($autre['archiIdPaysGeneral'])
				&& isset($autre['motcle'])
				&& $autre['motcle']==''
						&& isset($autre['submit'])
						&& $autre['submit']=='Rechercher'
								) {
			$url = "adresses-nouvelles-toutes-rues-villes-quartiers".
					"-strasbourg-archi.html";
		}

		if (isset($affichage)
		&& $affichage=='tousLesArchitectesClasses'
				&& count($autre)==0
		) {
			$url = "architectes-strasbourg-photos-classes.html";
		}

		if (isset($affichage)
		&& $affichage=='toutesLesRuesCompletesClassees'
				&& count($autre)==0
		) {
			$url = "rues-strasbourg-photos-classees.html";
		}

		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='toutesLesRuesCompletesClassees'
				&& isset($autre['archiPageCouranteRue'])
		) {
			$url="rues-strasbourg-photos-classees-".
					$autre['archiPageCouranteRue'].".html";
		}

		if (isset($autre['archiAffichage'])
		&& $autre['archiAffichage']=='tousLesArchitectesClasses'
				&& isset($autre['archiPageCouranteArchitectes'])
		) {
			$url="architectes-strasbourg-photos-classes-".
					$autre['archiPageCouranteArchitectes'].".html";
		}



		if (isset($affichage)
		&& $affichage=='imageDetail'
				&& isset($autre['archiIdImage'])
				&& isset($autre['archiRetourAffichage'])
				&& isset($autre['archiRetourIdName'])
				&& isset($autre['archiRetourIdValue'])
				&& !isset($autre['archiSelectionZone'])
				&& !isset($action)
		) {
			$url="photo-detail-strasbourg-".$autre['archiIdImage']."-".
					$autre['archiRetourAffichage']."-".$autre['archiRetourIdName'].
					"-".$autre['archiRetourIdValue'].".html";
		}


		if (isset($affichage)
		&& $affichage=='imageDetail'
				&& isset($autre['archiIdImage'])
				&& isset($autre['archiRetourAffichage'])
				&& isset($autre['archiRetourIdName'])
				&& isset($autre['archiRetourIdValue'])
				&& isset($autre['formatPhoto'])
				&& !isset($autre['archiSelectionZone'])
				&& !isset($action)
		) {
			$url="photo-detail-strasbourg-".$autre['archiIdImage']."-".
					$autre['archiRetourAffichage']."-".$autre['archiRetourIdName'].
					"-".$autre['archiRetourIdValue']."-".
					$autre['formatPhoto'].".html";
		}

		if (isset($affichage)
		&& $affichage=='imageDetail'
				&& isset($autre['archiIdImage'])
				&& isset($autre['archiRetourAffichage'])
				&& isset($autre['archiRetourIdName'])
				&& isset($autre['archiIdAdresse'])
		) {
			$url="photo-detail-strasbourg-".$autre['archiIdImage']."-".
					$autre['archiRetourAffichage']."-".$autre['archiRetourIdName'].
					"-".$autre['archiRetourIdValue']."-adresse".
					$autre['archiIdAdresse'].".html";
		}


		if (isset($affichage)
		&& $affichage=='imageDetail'
				&& isset($autre['archiIdImage'])
				&& isset($autre['archiRetourAffichage'])
				&& isset($autre['archiRetourIdName'])
				&& isset($autre['archiIdAdresse'])
		) {

			$libelleAdresse = "";
			if ($autre['archiIdAdresse']!='') {
				$adresse = new archiAdresse();
				$fetchAdresse = $adresse
				->getArrayAdresseFromIdAdresse($autre['archiIdAdresse']);
				$libelleAdresse = $adresse
				->getIntituleAdresse($fetchAdresse);
				$libelleAdresse = $string
				->convertStringToUrlRewrite($libelleAdresse);

			}

			if ($libelleAdresse != '') {
				$url="photo-detail-".$libelleAdresse."-".
						$autre['archiIdImage']."-".$autre['archiRetourAffichage'].
						"-".$autre['archiRetourIdName']."-".$autre['archiRetourIdValue'].
						"-adresse".$autre['archiIdAdresse'].".html";
			} else {
				$url="photo-detail-strasbourg-".$autre['archiIdImage'].
				"-".$autre['archiRetourAffichage']."-".$autre['archiRetourIdName'].
				"-".$autre['archiRetourIdValue']."-adresse".
				$autre['archiIdAdresse'].".html";
			}
		}



		if (isset($affichage)
		&& $affichage=='tousLesCommentaires'
				&& count($autre)==0
		) {
			$url = "commentaires-archi-strasbourg.html";
		}

		if (isset($affichage)
		&& $affichage=='tousLesCommentaires'
				&& isset($autre['pageCourante'])
		) {
			$url = "commentaires-archi-strasbourg-".$autre['pageCourante'].".html";
		}

		if (isset($affichage)
		&& $affichage=='publiciteArticlesPresse'
				&& count($autre)==0
		) {
			$url = "archi-strasbourg-media-presse-publicite.html";
		}

		if (isset($affichage)
		&& $affichage=="afficheAccueil"
				&& isset($autre['archiIdVilleGeneral'])
				&& isset($autre['archiIdPaysGeneral'])
		) {
			$adresse = new archiAdresse();
			$infosVille = $adresse->getInfosVille(
					$autre['archiIdVilleGeneral'],
					array("fieldList"=>"v.nom as nomVille")
			);

			$url = "accueil-ville-photos-immeubles-".$infosVille['nomVille'].
			"-".$autre['archiIdVilleGeneral']."-".
			$autre['archiIdPaysGeneral'].".html";
		}


		if (isset($affichage)
		&& $affichage=="afficheSondageGrand"
				&& count($autre)==0
		) {
			$url = "sondage-financement-archi-strasbourg.html";
		}

		if (isset($affichage)
		&& $affichage=="afficheSondageResultatGrand"
				&& count($autre)==0
		) {
			$url = "sondage-financement-archi-strasbourg-statistiques.html";
		}

		if (isset($affichage)
		&& $affichage=="afficherActualite"
				&& isset($autre['archiIdActualite'])
		) {
			$url = "actualites-archi-strasbourg-".$autre['archiIdActualite'].".html";
		}

		if (isset($affichage)
		&& $affichage=="toutesLesActualites"
				&& count($autre)==0
		) {
			$url = "actualites-archi-strasbourg-liste.html";
		}

		if (isset($affichage) && $affichage=="toutesLesVues" && count($autre)==0) {
			$url = "vues-photos-archi-strasbourg.html";
		}

		if (isset($affichage)
		&& $affichage=="adresseListe"
				&& isset($autre['recherche_sousQuartier'])
				&& $autre['recherche_sousQuartier']!=''
						) {
			$adresse = new archiAdresse();
			$reqSousQuartier = "SELECT idSousQuartier, nom as nomSousQuartier ".
					"FROM sousQuartier WHERE idSousQuartier='".
					$autre['recherche_sousQuartier']."'";
			$resSousQuartier = $this
			->connexionBdd->requete($reqSousQuartier);
			$fetchSousQuartier = mysql_fetch_assoc($resSousQuartier);
			if ($fetchSousQuartier['nomSousQuartier']!=''
					&& $fetchSousQuartier['nomSousQuartier']!='autre'
							) {
				$url = "sous-quartier-".$string->convertStringToUrlRewrite(
						trim($fetchSousQuartier['nomSousQuartier'])
				)."-".$autre['recherche_sousQuartier'].".html";
			}
		}



		return $this->getUrlRacine().$url;
	}
	
	
	public function flat($array,$prefix=''){
		$returnArray = array();
		foreach ($array as $k=>$v){
			$returnArray[$k] = $this->flatten($v);
		}
		return $returnArray;
	}
	
	
	public function flatten($array, $prefix = '') {
		$arr = array();
		foreach($array as $k => $v) {
			if(is_array($v)) {
				$arr = array_merge($arr, $this->flatten($v));
			}
			else{
				$arr[$prefix . $k] = $v;
			}
		}
		return $arr;
	}
}
?>