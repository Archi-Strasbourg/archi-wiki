<a  class="customNewsFeed" href="{urlCustomNewsFeed}"><h2>Personnaliser mon flux d'actualité</h2></a>
<div class="favorisAccueil">
<h2><?_("Bâtiments favoris")?></h2>
<hr class="plain"/>
<div class="listeFavoris">
<!-- BEGIN message -->
	<div><p>{message.content}</p></div>
<!-- END message -->
<!-- BEGIN favoris -->
<div class="favorisElement clearfix">
	<div class="favorisMiniatureWrapper">
	<a href="{favoris.urlEvenement}">
		<img class="favorisMiniature" alt="" src="{favoris.urlMiniature}">
	</a>
	</div>
	<div class="favorisTextWrapper">
		<div>
			<a href="{favoris.urlEvenement}">
				{favoris.titre}
			</a>
		</div>
		<div>
			<a href="{favoris.urlEvenement}">
				{favoris.description}
			</a>
		</div>
	</div>
</div>
<!-- END favoris -->
</div>
<p>
init ?N
<?php 
echo gettext("Hello");
echo "salut";
echo _("Salut");
echo _("Ca va ?");
echo _("Traduction en carton");
echo _("Je te conchie");
?>
</p>
</div>