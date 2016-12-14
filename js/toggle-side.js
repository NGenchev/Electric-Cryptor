var device_width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
function toggleNav() {
  var sideNav = document.getElementById("_side-panel");
  if(sideNav.offsetWidth > 0){
    document.getElementById("_side-panel").style.width = "0";
    document.body.style.marginLeft = "0";
  }else{
    if(device_width <= 800)
    {
      document.getElementById("_side-panel").style.width = "100%";
      document.body.style.marginLeft = "0";
    }else
    {
      document.getElementById("_side-panel").style.width = "250px";
      document.body.style.marginLeft = "250px";
    }
  }
}
$(document).ready(function(){
  $("form").attr('autocomplete', 'off');
  if(device_width <= 800)
  {
    document.getElementById("_side-panel").style.width = "0";
    document.body.style.marginLeft = "0";
  }
});
