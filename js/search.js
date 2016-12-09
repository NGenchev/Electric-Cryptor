$( document ).ready(function() {
	$( 'input[name=search_button]' ) . click(function(){
		var sTxt = $('input[name=search]').val();
		location.replace("search.php?sText="+sTxt);
	});
});