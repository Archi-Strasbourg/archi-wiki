<div class='fb-like right' data-send='false' data-layout='button_count' data-show-faces='true' data-action='recommend'></div>
<a href='https://twitter.com/share' class='twitter-share-button right' data-via='ArchiStrasbourg' data-lang='fr' data-related='ArchiStrasbourg'>Tweeter</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');</script>


<div class="part_one">
<h2>{title}</h2>
<!-- BEGIN CarteGoogle -->
	<div class="map_block">
	<iframe
					src='{CarteGoogle.src}' id='iFrameGoogleMap'
					style='width: 275px; height: 275px;' itemprop='map'></iframe><br>{CarteGoogle.lienVoirCarteGrand}{CarteGoogle.popupGoogleMap}</td>
	</div>
<!-- END CarteGoogle -->

<!-- BEGIN listeAdressesVoisines -->
	<div class="listAdressesVoisines">
	<!-- BEGIN adresseVoisine -->
		<div class="adresseVoisine">
			<img alt="" src="{listeAdressesVoisines.adresseVoisine.urlImg}">
			<p>{listeAdressesVoisines.adresseVoisine.intitule}</p>
		</div>
	<!-- END adresseVoisine -->
	</div>
<!-- END adressesVoisines -->
</div>
	
<div class="part_two">
<!-- BEGIN sommaireEvenements -->
	<div class="sommaireEvenements">
		{sommaireEvenements.content}
	</div>
	<div class="actionsEvenement">
		<!-- BEGIN buttonAction -->
		{sommaireEvenements.buttonAction.actions}
		<!-- END buttonAction -->
	</div>
<!-- END sommaireEvenements -->
</div>	

<div class="detailEvenements">
	<!-- BEGIN evenement -->

<div class='evenement' itemprop='event' itemscope itemtype="http://schema.org/Event" style='position: relative; display: table;'>
	{evenement.urlEvenementExterne}
	<!-- BEGIN menuAction -->
	<div class="menuAction"	style="margin-left: 1em; float: right; padding: 5px; display: table">
		<ul style='margin: 0px; display: table;'>
			<!-- BEGIN rowName -->
				<li class='actionEvent'>{evenement.menuAction.rowName.actionName}</li>
				<li><a href="{evenement.menuAction.rowName.urlAction}" 
				<!-- BEGIN confirmMessage -->
					onclick="if(confirm('{evenement.menuAction.rowName.confirmMessage.message}')){location.href='{evenement.menuAction.rowName.confirmMessage.url}'};"
				<!-- END confirmMessage -->
				>{evenement.menuAction.rowName.actionTarget}</a>
				<!-- BEGIN secondAction -->
						| <a href="{evenement.menuAction.rowName.secondAction.urlAction}" 
					<!-- BEGIN confirmMessage -->
						onclick="if(confirm('{evenement.menuAction.rowName.secondAction.confirmMessage.message}')){location.{evenement.evenement.ref='{evenement.menuAction.rowName.secondAction.confirmMessage.url}'};"
					<!-- END confirmMessage -->
					>{evenement.menuAction.rowName.secondAction.actionTarget}</a>
				<!-- END secondAction -->
				</li>
				
			<!-- END rowName -->
		</ul>
	</div>
	<!-- END menuAction -->

	<div style='min-height: 150px;'>
		<h3 itemprop="titre">{evenement.titre}</h3> - {evenement.txtEnvoi} par {evenement.utilisateur} {evenement.dateEnvoi}
		
		<a href="{evenement.lienHistoriqueEvenementCourant}">(Consulter l'historique)</a>
		

		<div class="event">
			<p>
			<ul>
				<li>{evenement.dates}</li>
				<li>{evenement.source}</li>
				<li>Structure  : {evenement.typeStructure}</li>
				<li><?_("Type d'Évènement :")?> <a href="{evenement.urlTypeEvenement}">{evenement.typeEvenement}</a>
				</li>
			</ul>
			{evenement.numeroArchive}
			<!-- BEGIN pers -->
			{evenement.pers.metier} <a href="{evenement.pers.urlEvenement}">{evenement.pers.prenom}
				{evenement.pers.nom}</a>
			<br>
			<!-- END pers -->
			</p>
			<p>{evenement.description}</p>
			<!-- BEGIN isCourantArchi -->
			<div class="courantAchitectural">
				<h4>
					<?_("Courant Architectural")?>
				</h4>
				<ul>
					<!-- BEGIN archi -->
					<li><a href="{evenement.isCourantArchi.archi.url}">{evenement.isCourantArchi.archi.nom}</a></li>
					<!-- END archi -->
				</ul>
			</div>
			<!-- END isCourantArchi -->
			<div class="historiqueEvenement">
				<!-- BEGIN histo -->
				<br /> <a href="{evenement.histo.url}"><?_("Voir l'historique")?> </a>
				<!-- END histo -->
			</div>
			{evenement.imagesLiees} {evenement.evenementsParents} {evenement.listeAdressesLiees}
			{evenement.evenementsLiesPersonne}
		</div>

	</div>
	<!-- BEGIN commentaireEvenement -->
	<div class="commentaireEvenement">
		{evenement.listeCommentaireEvenement} 
		{evenement.formulaireCommentaireEvenement} 
	</div>
	<!-- END commentaireEvenement -->
</div>
	
	<!-- END evenement -->
</div>



<!-- BEGIN formEvenement -->
<form action='' name='formulaireEvenement' method='POST' enctype='multipart/form-data' id='formulaireEvenement'>
<input type='hidden' name='actionFormulaireEvenement' id='actionFormulaireEvenement' value=''>";
<!-- END formEvenement -->