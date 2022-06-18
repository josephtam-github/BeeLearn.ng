function toggleSideBar() {
  var x = document.getElementById("smSideBar");
  var y = document.getElementById("iconchange1");
  if (x.style.display == "flex") { 
    x.style.display = "none";
    y.className = "fas fa-bars eAnimateZoom";
  } else {
    x.style.display = "flex";
    x.style.flexDirection = "column";
    y.className = "fas fa-times eAnimateZoom";

  }
}

var smSideBar = document.getElementById("smSideBar");
var smh = window.innerHeight;
var smw = window.innerWidth * 0.7;
smSideBar.style.height = smh + "px";
smSideBar.style.width = smw + "px";


var editSideBar = document.getElementById("edit-sidebar");
var h = window.innerHeight;
editSideBar.style.height = h + "px";
