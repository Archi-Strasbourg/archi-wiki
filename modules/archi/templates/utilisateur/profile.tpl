<div>
<h1>Profil - {nom} {prenom}</h1>
<!-- Formulaire accessible sur mon profile -->



{userInformations}
{userStatistics}
{userContributions}
{userFormMail}





<!-- Liste des droits -->
<!-- BEGIN userRights -->
<div>
	<ul>
	<!-- BEGIN right -->
	<li>
		{userRights.right.content}
	</li>
	<!-- END right -->
	
	<!-- BEGIN linkRight -->
	<li>
		<a href="{userRights.linkRight.url}">{userRights.linkRight.content}</a>
	</li>
	<!-- END linkRight -->
	</ul>
</div>
<!-- END userRights -->



</div>