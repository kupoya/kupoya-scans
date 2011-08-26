
/* === handle microsite loading process */
$(window).ready(function() {
	$('#page').hide();
	$('#loading').show();
});

/* when all resources have finished up loading present the page */
$(window).load(function() {
   show();
});


function show() {
    $('#loading').hide();
    $('#page').fadeIn();
};
/* === end */