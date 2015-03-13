<div class="lastVisitAccueil">
<h2>{lastVisitTitle}</h2>
<hr class="plain"/>
<!-- BEGIN lastVisitMessage -->
<div class="lastVisitMessage">
{lastVisitMessage.content}
</div>
<!-- END lastVisitMessage -->
<!-- BEGIN lastVisit -->
<div class="lastVisitElement">
	<div class="miniatureWrapper">
		<a href="{lastVisit.urlEvenement}">
		<img alt="" src="{lastVisit.urlMiniature}">
		<span class="miniatureLabel">
			<span class="miniatureLabelLeft">
			{lastVisit.miniatureLabelLeft}
			</span>
			<span class="miniatureLabelRight">
			{lastVisit.miniatureLabelRight}
			</span>
		</span>
		</a>
	</div>
	<div class="textLastVisit">
		<div class="titreLastvisit">
		<a href="{lastVisit.urlEvenement}">{lastVisit.titre}</a>
		</div>
		<div class="adresseLastModif">
		<a href="{lastVisit.urlEvenement}">{lastVisit.adresse}</a>
		</div>
		<div class="description">
		<a href="{lastVisit.urlEvenement}">{lastVisit.description}</a>
		</div>
	</div>
</div>
<!-- END lastVisit -->
</div>