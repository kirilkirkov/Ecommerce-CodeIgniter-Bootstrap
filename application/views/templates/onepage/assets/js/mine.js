$(document).ready(function () {
	if($(window).scrollTop() != 0) {
		$( ".navbar-onepoge" ).addClass( "navbar-white" );
	}else {
		$( ".navbar-onepoge" ).removeClass( "navbar-white" );
	}
	 
});
$(window).scroll(function () { 
	if ($(this).scrollTop() != 0) {
		$( ".navbar-onepoge" ).addClass( "navbar-white" );
	} else {
		$( ".navbar-onepoge" ).removeClass( "navbar-white" );
	} 
	if($('.after-main').visible()) {
		 $( ".after-main" ).addClass( "animated flipInX" );
	}  
	if($('.page-second').visible()) {
		 $( ".page-second .page-info" ).addClass( "animated bounceInLeft" );
	}  
	if($('.page-third').visible()) {
		 $( ".page-third .page-info" ).addClass( "animated bounceInRight" );
	}  
	if($('#products').visible()) {
		 $( "#products" ).addClass( "animated flipInX" );
	}  
});