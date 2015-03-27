<div class="commentairesAccueil">
<h2>{commentaireSectionTitle}</h2>
<hr class="edgeFade" />
<!-- BEGIN commentaire -->
	<div class="singleComment">
		<a href="{commentaire.urlAdresse}"><div class="commentDate">{commentaire.date} par</div>
		<div class="commentAuthor">{commentaire.nom} {commentaire.prenom}</div>
		<div class="commentAdresse">sur {commentaire.adresse}</div>
		<div class="commentBody ellipsis"><div>{commentaire.commentaire}</div></div> 
		</a>
	</div>
<!-- END commentaire -->
	<a class="linkListCommentaire" href="{urlListCommentaire}">Tous les commentaires</a>
</div>