<div class='fb-like right' data-send='false' data-layout='button_count' data-show-faces='true' data-action='recommend'></div>
<a href='https://twitter.com/share' class='twitter-share-button right' data-via='ArchiStrasbourg' data-lang='fr' data-related='ArchiStrasbourg'>Tweeter</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');</script>


<div class="part_one">
<h2>{title}</h2>
<!-- BEGIN CarteGoogle -->
	<div class="map_block inline-div">
	<iframe
					src='{CarteGoogle.src}' id='iFrameGoogleMap'
					style='width: 275px; height: 275px;' itemprop='map'></iframe><br>{CarteGoogle.lienVoirCarteGrand}{CarteGoogle.popupGoogleMap}</td>
	</div>
<!-- END CarteGoogle -->
<!-- BEGIN listeAdressesVoisines -->
	<div class="listAdressesVoisines inline-div">
		{listeAdressesVoisines.content}
		
		<div class="boutonsAutresBiens">
			<ul>
				<li class="seeAll"><a href="{listeAdressesVoisines.urlAutresBiensRue}"><?_("Voir tous les bâtiments de cette rue...")?>
				</a></li>
				<li class="seeAll"><a href="{listeAdressesVoisines.urlAutresBiensQuartier}"><?_("Voir tous les bâtiments de ce quartier...")?>
				</a></li>
			</ul>
		</div>
	</div>
<!-- END adressesVoisines -->
</div>
	
<div class="part_two">
<!-- BEGIN sommaireEvenements -->
	<div class="sommaireEvenements inline-div">
	<h2 class="black">Historique des événements</h2>
		<ul>
		<!-- BEGIN sommaireItem -->
		<li>
		<a href="{sommaireEvenements.sommaireItem.ancre}">{sommaireEvenements.sommaireItem.titre}{sommaireEvenements.sommaireItem.date}</a>
		</li>
		<!-- END sommaireItem -->
		</ul>
	</div>
	<!-- END sommaireEvenements -->
	
	<div class="actionsEvenement inline-div">
		<!-- BEGIN actionsSommaire -->
		<div class="addEvent">
			<a href="{actionsSommaire.urlAction}">{actionsSommaire.labelAction}</a>	
		</div>
		<!-- END actionsSommaire -->
	</div>
	
</div>	

<div class="detailEvenements">
<!-- BEGIN event -->
{event.content}
<!-- END event -->
</div>

{formulaireCommentaireAdresse}
{listeCommentairesAdresse}

<!-- BEGIN formEvenement -->
<form action='' name='formulaireEvenement' method='POST' enctype='multipart/form-data' id='formulaireEvenement'>
<input type='hidden' name='actionFormulaireEvenement' id='actionFormulaireEvenement' value=''>";
<!-- END formEvenement -->