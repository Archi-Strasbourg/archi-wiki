<div class="lastModifsAccueil">
<h2>{lastModifTitle}</h2>
<hr class="plain"/>
<!-- BEGIN lastModif -->
<div class="lastModifElement">
	<div class="miniatureWrapper">
		<a href="{lastModif.urlEvenement}">
		<img alt="" src="{lastModif.urlMiniature}">
		<span class="miniatureLabel">
			<span class="miniatureLabelLeft">
			{lastModif.miniatureLabelLeft}
			</span>
			<span class="miniatureLabelRight">
			{lastModif.miniatureLabelRight}
			</span>
		</span>
		</a>
	</div>
	<div class="textLastModif">
		<div class="titreLastModif">
		<a href="{lastModif.urlEvenement}">{lastModif.titre}</a>
		</div>
		<div class="adresseLastModif">
		<a class="lienAdresse" href="{lastModif.urlEvenement}">{lastModif.adresse}</a> <a class="lienVille" href="{lastModif.urlEvenement}">{lastModif.ville}</a>
		</div>
		<div class="description">
		<a href="{lastModif.urlEvenement}">{lastModif.description}</a>
		</div>
	</div>
</div>
<!-- END lastModif -->
</div>
<a  class="customNewsFeed orangeButton" href="{urlCustomNewsFeed}"><h3>Personnaliser mon flux d'actualité</h3></a>
