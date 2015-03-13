<div style='display: table;'>
	<!--
<div class="pub">
    <strong><a href="http://m.archi-strasbourg.org/"><?_("Découvrez la version smartphone de notre site sur ")?><i>m.archi-strasbourg.org</i></a></strong><br/><br/>
    <a href="https://itunes.apple.com/fr/app/id557893157?mt=8&affId=1578782"><img src="images/Advisa/AR_appstore.jpg" alt="<?_("Disponible sur l'App Store")?>" /></a> <a href="https://play.google.com/store/apps/details?id=archi.strasbourg.dev&feature=search_result#?t=W251bGwsMSwyLDEsImFyY2hpLnN0cmFzYm91cmcuZGV2Il0."><img src="images/Advisa/AR_googleplay.jpg" alt="<?_("Disponible sur Google Play")?>" /></a>
</div>
-->
<script src="js/homeSearch.js"></script>
<script src="js/jquery-ui/js/jquery-1.7.2.min.js"type="text/javascript"></script>
<script type="js/utils.js"></script>


</div>



<div class="divAccueil">
	{news}
	{commentaires}
	{dernieresModifs}
	{favoris}
	{lastVisits}
</div>




<!-- BEGIN homeCategory -->
<div class="content_item">
	{homeCategory.category}	
</div>
<!-- END homeCategory -->

<!-- BEGIN afficheEncarts -->
<div style='display:table;'>

<div class="homeTable">
{encart1}
{encart2}
{encart3}
{encart4}
{encart5}
{encart6}

</tr></table>
</div>
<!-- END afficheEncarts -->



<!-- BEGIN afficheProfil -->
<div class="monProfil">
<table><tr>
<td>
{htmlProfil}
</td>
</tr></table>
</div>
<!-- END afficheProfil -->


<!-- BEGIN afficheMonArchi -->
<div class="monArchi">
<table><tr>
<td>
{htmlMonArchi}
</td></tr>
<tr>
<td>
{historiqueUtilisateur}
</td>
</tr>
</table>
</div>
<!-- END afficheMonArchi -->


</div>


{calqueHelp}


