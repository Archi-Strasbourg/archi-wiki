<div class="lastVisitAccueil">
<h2>{lastModifTitle}</h2>
<hr class="plain"/>
<!-- BEGIN message -->
<div class="lastVisitMessage">
{message.content}
</div>
<!-- END message -->
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
		<div class="titreLastModif">
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