﻿<form action='{ACTIONFORM}' method='post' enctype="multipart/form-data">
<!-- BEGIN noCompact -->
<br><br>
<div align='center'>
<div style='color:#000000;'>{etatConnexion}</div>
<table border="" align='center' class="authentification">
<tr><td class="enteteAuthentificationNoCompact borduresAuthentification">Login (mail) :</td><td class='borduresAuthentification'><input type='text' name='archiLogin' value='' /></td></tr>
<tr><td class="enteteAuthentificationNoCompact borduresAuthentification borduresFinAuthentification"><?_("Mot de passe :")?></td><td class='borduresAuthentification borduresFinAuthentification'><input type='password' name='archiMdp' value='' /></td></tr>
<tr><td colspan=2 align=center><input type='checkbox' name='cookie' id="cookie2" /><label for="cookie2"><?_("Rester connecté")?> (<?_("30 jours")?>)</label></td></tr>
<tr><td colspan=2 align=center><input type='submit' name='validAuthentification' value='<?_("Se connecter")?>' /></td></tr>
</table>
<br/>
{msg}
</div>
<!-- END noCompact -->


<!-- BEGIN compact -->
<div class="authFormInput">
	<label class="enteteAuthentificationCompact" for="archiLogin" style='color:#FFFFFF;'><?_("Login (mail) :")?></label> <input type='text' size="10" name='archiLogin' id="archiLogin" value='' />
	<label class="enteteAuthentificationCompact" for="archiMdp" style='color:#FFFFFF;'><?_("Mot de passe :")?></label> <input type='password' name='archiMdp' id="archiMdp" value='' size="10" />
		<input class="authFormSubmit" type='submit' name='validAuthentification' value='<?_("Connexion")?>' />
	<div class="stayConnectedWrapper">
		<div class="stayConnected">
			<input type='checkbox' name='cookie' id="cookie" /><label for="cookie" ><?_("Rester connecté")?></label>
		</div>
	</div>
</div>


<!-- END compact -->

</form>
<hr/>
