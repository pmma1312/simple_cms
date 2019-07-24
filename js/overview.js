getOverview();

function getOverview() {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      displayOverview(xhttp);
    }
  }

  xhttp.open("GET", "php/api/query.php?no_limit", true);
  xhttp.send();
}

function displayOverview(xhttp) {
  var i = 0;

  var data = JSON.parse(xhttp.responseText);
  var parent = document.querySelector(".main");

  var home = document.createElement("a");

  home.className = "link";
  home.setAttribute("href", "index.html");
  home.innerHTML = "Back to Home";

  parent.appendChild(home);

  data.forEach(function(item, index) {
    var listEntry = document.createElement("div");
    var entryInfo = document.createElement("div");

    listEntry.className = "listEntry";
    listEntry.setAttribute("onclick", "window.location = 'index.html?page=" + i + "';");

    entryInfo.className = "entryInfo";

    parent.appendChild(listEntry);

    var articleTitle = document.createElement("div");
    var articleAuthor = document.createElement("div");
    var articleDate = document.createElement("div");

    articleTitle.className = "articleTitle";
    articleAuthor.className = "articleAuthor";
    articleDate.className = "articleDate";

    articleTitle.innerHTML = item["title"];
    articleAuthor.innerHTML = "By: " + item["username"];
    articleDate.innerHTML = "On: " + item["entry_date"];

    listEntry.appendChild(articleTitle);
    listEntry.appendChild(entryInfo);

    entryInfo.appendChild(articleAuthor);
    entryInfo.appendChild(articleDate);

    i++;

  });

}