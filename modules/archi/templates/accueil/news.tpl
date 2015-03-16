<!-- BEGIN newsAccueil -->
<div class="newsAccueil">
	<div class="newsTitle">	
		<h2>{newsAccueil.titreCategory}</h2>
		<a href="{newsAccueil.urlNewsList}">> <?_("Toutes les actualités")?> </a>
	</div>
	<hr class="edgeFade"/>
	<div class="newsContent">	
		<a class="linkNews" href="{newsAccueil.urlNews}">
			<div class="miniatureWrapper newsMiniature">
				<img alt="" class="miniature" src="{newsAccueil.urlMiniature}">
				<span class="miniatureLabel"><span class="miniatureLabelLeft"></span><span class="miniatureLabelRight">{newsAccueil.date}</span></span>
			</div>
		</a>
		<div class="textNews">
			<div class="titreNews"><a  href="{newsAccueil.urlNews}">{newsAccueil.titre}</a></div>
			<div class="descriptionNews ellipsis">
			<div>
			<a class="" href="{newsAccueil.urlNews}">{newsAccueil.description}</a>
			</div>
			</div >
			<div class="readMore"><a href="{newsAccueil.urlNews}">Lire la suite</a></div>
		</div>
	</div>

</div>
<!-- END newsAccueil -->