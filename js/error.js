checkError();

function checkError() {
  myCookie = replaceAll(getCookie("error"), "+", " ");
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