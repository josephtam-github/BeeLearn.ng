function toggleNavHide() {
    var y = document.getElementById("iconchange1");
    var x = document.getElementById("eToggleObject1");
    if (x.style.display == "block") { 
      y.className = "fas fa-bars animate-zoom-4";
      x.style.display = "none";
    } else {
      x.style.display = "block";
      y.className = "fas fa-times animate-zoom-4";
    }
  }
  
  function toggleSearchHide() {
    var x = document.getElementById("eToggleObject2");
    if (x.style.display == "block") { 
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
  