<div class="rechercheBlock">
	<!-- BEGIN titreEtLiens -->
	<h1><?_("Recherche")?></h1>
	<!-- END titreEtLiens -->
	
	<form action="{formAction}" method="get">
	<div class="switchSearch">
		<div>
			<b>Texte</b>
		</div> 
		<div>
			<a href="index.php?query={motcle}&archiAffichage=imageSearch&licence_1=on&licence_2=on&licence_3=on">Images</a>
		</div>
	</div>
	<input type='hidden' name='archiAffichage' value='recherche'>
	<input type='hidden' name='submit' value='Rechercher'>
	
	<!-- BEGIN noHeaderNoFooter -->
	<input type='hidden' name='noHeaderNoFooter' value='1'>
	<!-- END noHeaderNoFooter -->
	
	<!-- BEGIN modeAffichage -->
	<input type='hidden' name='modeAffichage' value='{modeAffichage.value}'>
	<!-- END modeAffichage -->
	
	
	<!-- BEGIN parametres -->
	<input type='hidden' name="{parametres.nom}" id="{parametres.id}" value="{parametres.value}">
	<!-- END parametres -->
	<input type="text" accesskey="F"  name="motcle" value="{motcle}" style='{motCleStyle}' placeholder="<?_("Indiquez une adresse, un nom de rue ou de bâtiment")?>" class="searchInput" />&nbsp;
		<input type="button"  name="submit" class="loupe" value="<?_("OK")?>" />
	
	<div class="rechercheBottomElements">
		<!-- BEGIN displayCheckBoxResultatsCarte -->
		<span><input type='checkbox' name='afficheResultatsSurCarte' id='afficheResultatsSurCarte' value='1' {checkBoxAfficheResultatsSurCarte}>&nbsp;<label for="afficheResultatsSurCarte"><?_("Afficher les résultats sur une carte")?></label></span>
		<!-- END displayCheckBoxResultatsCarte -->
		<!-- BEGIN displayRechercheAvancee -->
		<a class="lienRechercheAvancee" href='{urlRechercheAvancee}'><?_("Recherche avancée")?></a><br />
		<!-- END displayRechercheAvancee -->
	</div>
	</form>
</div>
