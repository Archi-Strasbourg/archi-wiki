/**
 * utils.js
 * 
 * Bunch of functions used here and there
 * 
 * @author Antoine Rota Graziosi - InPeople 2014
 * 
 */


/**
 * add VueSur elt on photo
 */

(function($) {
	$(document).ready(function() { 
		newMenuAction();
	});
	$(function(){
		$('.addCommentButton').on('click',function(e){
			e.preventDefault();
			$(e.target).parent().parent('div').toggleClass('active');
		});
	});
})(jQuery);

function addVueSur(idEvenementGroupeAdresse , idAdresse , nom){
	
	/*
	 * Adding remove link to the div
	 */
	identifiantRetour = parent.document.getElementById('identifiantRetour').value;
	idTargetDiv = "listeVueSurDiv"+identifiantRetour;
	param1 = idAdresse+"_"+idEvenementGroupeAdresse;
	param2 = identifiantRetour;
	
	retirerVueParam = param1 +","+ param2;
	contentToAdd = "<p>" +nom + "<a style='cursor:pointer;' onclick='retirerVueSur("+idAdresse+","+ identifiantRetour +");' > (-)</a></p>";
	
	var div = document.createElement('div');
	div.innerHTML = contentToAdd;
	
	parent.document.getElementById(idTargetDiv).appendChild(div) ;
	
	/*
	 * Adding correct id to the option input
	 */
	
	optionToAdd = "<option value=\'"+param1+"\' SELECTED>"+nom+"</option>";
	idTargetDiv = "vueSur"+identifiantRetour;
	parent.document.getElementById(idTargetDiv).innerHTML += optionToAdd;
}	


function addPrisDepuis(idEvenementGroupeAdresse , idAdresse , nom){
	identifiantRetour = parent.document.getElementById('identifiantRetour').value;
	idTargetDiv = "listePrisDepuisDiv"+identifiantRetour;
	
	param1 = idAdresse+"_"+idEvenementGroupeAdresse;
	param2 = identifiantRetour;
	
	retirerPrisDepuis = param1 +","+ param2;
	contentToAdd = "<p>" +nom + "<a style='cursor:pointer;' onclick='retirerPrisDepuis("+idAdresse+","+identifiantRetour+");' > (-)</a></p>";

	var div = document.createElement('div');
	div.innerHTML = contentToAdd;
	
	parent.document.getElementById(idTargetDiv).appendChild(div) ;
	
	
	/*
	 * Add option to the select form input
	 */
	optionToAdd = "<option value=\'"+param1+"\' SELECTED>"+nom+"</option>";
	idTargetDiv = "prisDepuis"+identifiantRetour;
	parent.document.getElementById(idTargetDiv).innerHTML += optionToAdd;
}


/*
 * Menu function
 */
function newMenuAction(){
    var body = document.body,
        mask = document.createElement("div"),
//        toggleSlideLeft = document.querySelector( ".toggle-slide-left" ),
//        toggleSlideRight = document.querySelector( ".toggle-slide-right" ),
//        toggleSlideTop = document.querySelector( ".toggle-slide-top" ),
//        toggleSlideBottom = document.querySelector( ".toggle-slide-bottom" ),
        togglePushLeft = document.querySelector(".toggle-push-left"),
//        togglePushRight = document.querySelector( ".toggle-push-right" ),
//        togglePushTop = document.querySelector( ".toggle-push-top" ),
//        togglePushBottom = document.querySelector( ".toggle-push-bottom" ),
//        slideMenuLeft = document.querySelector( ".slide-menu-left" ),
//        slideMenuRight = document.querySelector( ".slide-menu-right" ),
//        slideMenuTop = document.querySelector( ".slide-menu-top" ),
//        slideMenuBottom = document.querySelector( ".slide-menu-bottom" ),

        pushMenuLeft = document.querySelector( ".push-menu-left" ),

//        pushMenuRight = document.querySelector( ".push-menu-right" ),
//        pushMenuTop = document.querySelector( ".push-menu-top" ),
//        pushMenuBottom = document.querySelector( ".push-menu-bottom" ),

        activeNav
    ;
    mask.className = "mask";

//    /* slide menu left */
//    toggleSlideLeft.addEventListener( "click", function(){
//        classie.add( body, "sml-open" );
//        document.body.appendChild(mask);
//        activeNav = "sml-open";
//    } );
//
//    /* slide menu right */
//    toggleSlideRight.addEventListener( "click", function(){
//        classie.add( body, "smr-open" );
//        document.body.appendChild(mask);
//        activeNav = "smr-open";
//    } );
//
//    /* slide menu top */
//    toggleSlideTop.addEventListener( "click", function(){
//        classie.add( body, "smt-open" );
//        document.body.appendChild(mask);
//        activeNav = "smt-open";
//    } );
//
//    /* slide menu bottom */
//    toggleSlideBottom.addEventListener( "click", function(){
//        classie.add( body, "smb-open" );
//        document.body.appendChild(mask);
//        activeNav = "smb-open";
//    } );

    /* push menu left */
    /*
    togglePushLeft.addEventListener( "click", function(){
      //  classie.add( body, "pml-open" );
        document.getElementsByTagName('body')[0].classList.add("pml-open");
//    	document.getElementById("primaryContentContainer").classList.add("pml-open");
        document.body.appendChild(mask);
        activeNav = "pml-open";
        
        
        
    } );
    */

    $('#menu-button').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        $('body').removeClass('pmt-open-search pmt-open-connexion').toggleClass('pml-open');
        //Add event listener on click on body (so, on all the page)
        $('body').on('click', function(e){
        	//If the zone clicked is not the menu
        	if (!$(e.target).closest('.push-menu-left').length) {
        	    // Hide the menus.
                $('body').removeClass('pml-open');
        	  }
        });
    });
    
    $('#searchButton').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        $('body').removeClass('pmt-open-connexion pml-open').toggleClass('pmt-open-search');

        //Add event listener on click on body (so, on all the page)
        $('body').on('click', function(e){
        	//If the zone clicked is not the menu
        	if (!$(e.target).closest('.push-menu-top-search').length) {
        	    // Hide the menus.
                $('body').removeClass('pmt-open-search');
        	  }
        });
        
    });
    
    $('#connexionButton').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        $('body').removeClass('pml-open pmt-open-search').toggleClass('pmt-open-connexion');

        //Add event listener on click on body (so, on all the page)
        $('body').on('click', function(e){
        	//If the zone clicked is not the menu
        	if (!$(e.target).closest('.push-menu-top-connexion').length) {
        	    // Hide the menus.
                $('body').removeClass('pmt-open-connexion');
        	  }
        });
        
    });
//    /* push menu right */
//    togglePushRight.addEventListener( "click", function(){
//        classie.add( body, "pmr-open" );
//        document.body.appendChild(mask);
//        activeNav = "pmr-open";
//    } );
//
//    /* push menu top */
//    togglePushTop.addEventListener( "click", function(){
//        classie.add( body, "pmt-open" );
//        document.body.appendChild(mask);
//        activeNav = "pmt-open";
//    } );
//
//    /* push menu bottom */
//    togglePushBottom.addEventListener( "click", function(){
//        classie.add( body, "pmb-open" );
//        document.body.appendChild(mask);
//        activeNav = "pmb-open";
//    } );

    /* hide active menu if mask is clicked */
    mask.addEventListener( "click", function(){
        //classie.remove( body, activeNav );
        document.getElementsByTagName('body')[0].classList.remove(activeNav);
        activeNav = "";
//        document.body.removeChild(mask);
    } );

    /* hide active menu if close menu button is clicked */
    [].slice.call(document.querySelectorAll(".close-menu")).forEach(function(el,i){
        el.addEventListener( "click", function(){
            classie.remove( body, activeNav );
            activeNav = "";
            document.body.removeChild(mask);
        } );
    });

}
