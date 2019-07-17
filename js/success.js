checkSuccess();

function checkSuccess() {
  myCookie = replaceAll(getCookie("success"), "+", " ");
  if (myCookie != "") {
    Swal.fire({
      title: "Success!",
      text: myCookie,
      type: 'success',
      confirmButtonText: "Ok"
    });
    document.getElementById("swal2-content").style.color = "rgb(20, 20, 20)";
    eraseCookie("success");
  }
}