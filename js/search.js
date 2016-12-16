$( document ).ready(function() {
	$( 'input[name=search_button]' ) . click(function(){
		var sTxt = $('input[name=search]').val();
		location.replace("search.php?sText="+sTxt);
	});
	
	$('#searchId').bind("enterKey",function(e){
		var sTxt = $('input[name=search]').val();
		location.replace("search.php?sText="+sTxt);
	});
	$('#searchId').keyup(function(e){
	if(e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});
});