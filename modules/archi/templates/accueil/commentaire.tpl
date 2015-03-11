<div class="commentairesAccueil">
<h2>{commentaireSectionTitle}</h2>
<!-- BEGIN commentaire -->
	<div class="singleComment">
		<div class="commentDate">{commentaire.date} par</div>
		<div class="commentAuthor"><a href="{commentaire.urlPersonne}">{commentaire.nom} {commentaire.prenom}</a></div>
		<div class="commentAdresse">sur <a href="{commentaire.urlAdresse}">{commentaire.adresse}</a></div>
		<div class="commentBody">{commentaire.commentaire}</div> 
	</div>
<!-- END commentaire -->
	<a class="linkListCommentaire" href="{urlListCommentaire}">Tous les commentaires</a>
</div>