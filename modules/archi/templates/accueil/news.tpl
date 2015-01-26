<!-- BEGIN newsAccueil -->
<div class="newsAccueil">
	<div class="newsTitle">	
		<h2>{newsAccueil.titreCategory}</h2>
		<a href="{newsAccueil.urlNewsList}">>Toutes les actualités</a>
	</div>
	
	<div class="newsContent">	
	<a class="linkNews" href="{newsAccueil.urlNews}">
		<div class="miniatureWrapper">
			<img alt="" class="miniature" src="{newsAccueil.urlMiniature}">
			<span class="miniatureLabel"><span class="miniatureLabelLeft"></span><span class="miniatureLabelRight">{newsAccueil.date}</span></span>
		</div>
	</a>
		<div class="textNews">
			<div><a class="" href="{newsAccueil.urlNews}">{newsAccueil.titre}</a></div>
			<div><a class="" href="{newsAccueil.urlNews}">{newsAccueil.description}</a></div>
			<div><a href="{newsAccueil.urlNews}">Lire la suite</a></div>
		</div>
	</div>

</div>
<!-- END newsAccueil -->