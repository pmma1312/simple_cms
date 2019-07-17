checkError();

function checkError() {
  myCookie = getCookie("error").replace("+", " ");
  if (myCookie != "") {
    Swal.fire({
      title: "Error!",
      text: myCookie,
      type: 'error',
      confirmButtonText: "Ok"
    });
    document.querySelector(".swal2-modal").style.backgroundColor = "rgb(20, 20, 20)";
    eraseCookie("error");
  }
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function eraseCookie(name) {
  document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}