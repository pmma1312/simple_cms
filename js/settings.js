function comparePasswords() {
  // Check if passwords match
  var pw1 = document.getElementById('pw1');
  var pw2 = document.getElementById('pw2');

  var pwinfo = document.getElementById('pwinfo');

  var form = document.getElementById('fr');

  if (pw1.value != pw2.value || pw1.value.length < 1 || pw2.value.length < 1) {
    pwinfo.innerHTML = "Passwords do not match";
    pwinfo.style.color = "rgba(254, 88, 88, 0.4)";
  } else {
    pwinfo.innerHTML = "Passwords match";
    pwinfo.style.color = "rgba(126, 254, 131, 0.4)";
  }

}

function validateForm() {
  var pw1 = document.getElementById('pw1');
  var pw2 = document.getElementById('pw2');
  var form = document.getElementById('fr');

  if (pw1.value != pw2.value) {
    alert("Passwords have to match in order to submit the form!");
  } else {
    form.submit();
  }

}

var loadFile = function(event) {
  var output = document.getElementById('output');
  output.src = URL.createObjectURL(event.target.files[0]);
};