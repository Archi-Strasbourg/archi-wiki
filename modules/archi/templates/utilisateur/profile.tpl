<div>
	
	<div class="boxVertArrondie">
		{userFormInfo}
	</div>
	<div class="boxVertArrondie">
		{userInformations}
		{userStatistics}
	</div>
	<div class="boxVertArrondie">
		{userContributions}
	</div>
	<div class="boxVertArrondie">
		{userFormMail}
	</div>



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