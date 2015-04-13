<!-- BEGIN commentaires -->
<div class="commentaire" id="{commentaires.htmlId}">
	<div class="commentHeader"><div class="profilePicWrapper">
		<img alt="" src="{commentaires.urlProfilPic}">
	</div> 
	<div class="commentNameAction"> 
		<p>{commentaires.prenom} {commentaires.nom} {commentaires.labelCommentAction} </p>
		
		<!-- BEGIN supprimer -->
		<p><a href="{commentaires.supprimer.urlSupprimer}">Supprimer ce commentaire</a></p>
		<!-- END supprimer -->
	</div> 
		<div class="commentDate">
		<p>{commentaires.date}</p>
		</div> 
	 </div>
	<div class="comment">
		{commentaires.commentaire}
	</div>
</div>
<!-- END commentaires -->
