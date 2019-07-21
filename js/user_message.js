checkMessage();

function checkMessage() {
  var types = ["error", "success"];
  var titles = ["Error!", "Success!"]

  for (var i = 0; i < types.length; i++) {
    myCookie = replaceAll(getCookie(types[i]), "+", " ");
    if (myCookie != "") {
      Swal.fire({
        title: titles[i],
        text: myCookie,
        type: types[i],
        confirmButtonText: "Ok"
      });

      if (types[i] == "error") {
        document.querySelector(".swal2-modal").style.backgroundColor = "rgb(20, 20, 20)";
      }

      eraseCookie(types[i]);
    }
  }
}


/*
 * Those are the helper functions
 */

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

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function escapeRegExp(str) {
  return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}