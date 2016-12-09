function toggleNav() {
  var sideNav = document.getElementById("_side-panel");
  if(sideNav.offsetWidth > 0){
    document.getElementById("_side-panel").style.width = "0";
    document.body.style.marginLeft = "0";
  }else{
    document.getElementById("_side-panel").style.width = "250px";
    document.body.style.marginLeft = "250px";
  }
}
$(document).ready(function(){

  $("form").attr('autocomplete', 'off');
});
