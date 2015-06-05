<h1>{titre}</h1>
{messageInfo}
{nbReponses}

<!-- BEGIN urlBackPagination -->
	<a href="{urlBackPagination.urlPrecedent}" onclick="{urlBackPagination.urlPrecedentOnClick}">&lt;</a>
<!-- END urlBackPagination -->
<!-- BEGIN nav -->
	<!-- BEGIN courant -->
		<strong>
	<!-- END courant -->
	<a href="{nav.urlNb}" onclick="{nav.urlNbOnClick}">{nav.nb}</a>
	<!-- BEGIN courant -->
		</strong>
	<!-- END courant -->
<!-- END nav -->
<!-- BEGIN urlNextPagination -->	
	<a href="{urlNextPagination.urlSuivant}" onclick="{urlNextPagination.urlSuivantOnClick}">&gt;</a>
<!-- END urlNextPagination -->

<div class="results">
	<div>
	<!-- BEGIN liens -->
			<a href="{liens.url}" onclick="{liens.urlOnClick}">{liens.titre}</a> 
			<a href="{liens.urlDesc}" onclick="{liens.urlDescOnClick}"><img src="images/Advisa/balisebas.png" alt="&darr;" /></a> 
			<a href="{liens.urlAsc}" onclick="{liens.urlAscOnClick}"><img src="images/Advisa/balisehaut.png" alt="&uarr;" /></a>
	<!-- END liens -->
	</div>
	
	<!-- BEGIN adresses -->
	<div class="listAddressItem">
        	<a href="{adresses.urlDetailHref}">
        		<div class="addrListImageWrapper miniatureWrapper">
        			<img src='{adresses.urlImageIllustration}' border=0 alt="{adresses.alt}" title="{adresses.alt}">
        		</div>
        	</a> 
        	<span>
        	<br/>
	        	<a href="{adresses.urlDetailHref}" onclick="{adresses.urlDetailOnClick}">
	        		<b>{adresses.nom} </b> {adresses.adresseComplete}
	        	</a>
        	</span>
        	<br/>
        	<span style='font-size:11px;'>
        		{adresses.titresEvenements}
        	</span>
	</div>
	<!-- END adresses -->
</div>
<br />

{nbReponses}
<!-- BEGIN urlBackPagination -->
	<a href="{urlBackPagination.urlPrecedent}" onclick="{urlBackPagination.urlPrecedentOnClick}">&lt;</a>
<!-- END urlBackPagination -->
<!-- BEGIN nav -->
	<!-- BEGIN courant -->
		<strong>
	<!-- END courant -->
	<a href="{nav.urlNb}" onclick="{nav.urlNbOnClick}">{nav.nb}</a>
	<!-- BEGIN courant -->
		</strong>
	<!-- END courant -->
<!-- END nav -->
<!-- BEGIN urlNextPagination -->	
	<a href="{urlNextPagination.urlSuivant}" onclick="{urlNextPagination.urlSuivantOnClick}">&gt;</a>
<!-- END urlNextPagination -->
		
