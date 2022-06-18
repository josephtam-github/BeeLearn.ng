function toggleEye(x) {
  var y = x.parentNode.childNodes[1];
  if (y.type == "password") {
    y.type = "text";
    x.className = "fas fa-eye-slash btn";
  } else {
    y.type = "password";
    x.className = "fas fa-eye btn";
  }
}
  
function toggleForm(label) {
  var y = label.nextSibling.nextSibling;
  if (y.style.display == "none") { 
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
}
  