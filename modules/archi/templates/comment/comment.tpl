<div>
<a href="" class="addCommentButton">Ajouter un commentaire</a>
	<form class="formComment" method="POST" action="{urlRedirect}">
		<textarea rows="5" cols="50" name ="commentaire" required></textarea>
		<input type="submit" name="valider" value="Envoyer">
		<!-- BEGIN input -->
		<input id="{input.id}" type="{input.type}" value="{input.value}" name="{input.id}">
		<!-- END input -->
	</form>
</div>