<div class="commentFormWrapper">
	<div class="addCommentButtonWrapper"><a href="" class="addCommentButton">+ Ajouter un commentaire</a></div>
	<div class="formComment">
		<div class="profilePicWrapper">
			<img alt="{profileAlt}" src="{urlProfilePic}">
		</div>
		<form class="" method="POST" action="{urlRedirect}">
			<textarea name ="commentaire" required></textarea>
			<input class="commentSubmitButton" type="submit" name="valider" value="Publier">
			<!-- BEGIN input -->
			<input id="{input.id}" type="{input.type}" value="{input.value}" name="{input.id}">
			<!-- END input -->
		</form>
	</div>
</div>