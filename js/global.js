// Navbar show/hide
function showmenu() {
  if (nav.style.display == 'none') {
    nav.style.display = 'block';
  } else {
    nav.style.display = 'none';
  }
}

// Allow tab in textarea
var textarea = document.querySelector('textarea');
textarea.onkeydown = function(e) {
  if (e.keyCode == 9 || e.which == 9) {
    e.preventDefault();
    var s = this.selectionStart;
    this.value = this.value.substring(0, this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
    this.selectionEnd = s + 1;
  }
}