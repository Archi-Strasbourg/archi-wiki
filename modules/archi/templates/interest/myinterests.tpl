<div class="myInterests">
	<h1>Mes centres d'intérêt</h1>
	Cette page vous permet de personnaliser les adresses qui s'affichent sur votre page d'accueil. Vous pouvez ajouter des villes, pays ou quartiers. Si vous n'indiquez rien, toutes les adresses modifiées s'afficheront sur l'accueil.
	<!-- BEGIN interestList -->
	<div class="{interestList.CSSclass}">
		<h2>{interestList.title}</h2>
		<ul>
		{interestList.vide}
		<!-- BEGIN interests -->
			<li>
			{interestList.interests.name}
			<a href="{interestList.interests.deleteUrl}" onclick="return confirm('Etes vous sur de vouloir supprimer cet intérêt ?');"> 
			<img alt="" src="images/delete-simple.png"></img>
			</a>
			</li>
		<!-- END interests -->
		</ul>
	</div>
	<!-- END interestList -->
	<div class="addInterest">
	<h1>Ajouter un intérêt</h1>
		<form action="{formActionUrl}" name="{nameForm}" method="post">
			<div id="choixAdresse">
				{formAddInterest}
			</div> 
			<input type="submit" value="Ajouter">
		</form>
	</div>
</div>	