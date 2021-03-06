<!-- BEGIN evenement -->
<div id="evenement{evenement.idEvenement}" class='evenement' itemprop='event' itemscope itemtype="http://schema.org/Event" style='position: relative; display: table;'>
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
		<div class="event">
			<h3 itemprop="titre">{evenement.titre}</h3>{evenement.infoTitre}
			<a href="{evenement.lienHistoriqueEvenementCourant}">{evenement.labelLienHistorique}</a>
			<p>
			<ul>
				<li>{evenement.dates}</li>
				<li>{evenement.source}</li>
				<li>{evenement.labelStructure}{evenement.typeStructure}</li>
				<li>{evenement.labelTypeEvenement}{evenement.lienTypeEvenement}</li>
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
	<div class="commentaireEvenement">
		{evenement.listeCommentaireEvenement} 
		{evenement.formulaireCommentaireEvenement} 
	</div>
</div>
<!-- END evenement -->
