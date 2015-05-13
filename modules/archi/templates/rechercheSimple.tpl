<div class="rechercheBlock">
	<!-- BEGIN titreEtLiens -->
	<h1><?_("Recherche")?></h1>
	<!-- END titreEtLiens -->
	
	
	<div class="switchSearch">
		<b>Texte</b> &ndash; 
		<a href="index.php?query={motcle}&archiAffichage=imageSearch&licence_1=on&licence_2=on&licence_3=on">Images</a>
	</div>
	
	<form action="{formAction}" method="get">

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
	<input type="text" accesskey="F"  name="motcle" value="{motcle}" style='{motCleStyle}' placeholder="<?_("Indiquez une adresse, un nom de rue ou de bâtiment")?>" class="searchInput" required/>&nbsp;
	<input type="submit"  name="submit" class="loupe" value="<?_("OK")?>" />
	
	<div class="rechercheBottomElements">
	<div>
		<!-- BEGIN displayCheckBoxResultatsCarte -->
		<div class="inline-block"><input type='checkbox' name='afficheResultatsSurCarte' id='afficheResultatsSurCarte' value='1' {checkBoxAfficheResultatsSurCarte}>&nbsp;<label for="afficheResultatsSurCarte"><?_("Afficher les résultats sur une carte")?></label></div>
		<!-- END displayCheckBoxResultatsCarte -->
		<!-- BEGIN displayRechercheAvancee -->
		<div class="inline-block lienRechercheAvancee"><a class="lienRechercheAvancee" href='{urlRechercheAvancee}'><?_("Recherche avancée")?></a><br /></div>
		<!-- END displayRechercheAvancee -->
		</div>
	</div>
	</form>
</div>
