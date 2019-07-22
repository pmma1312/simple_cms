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
  var data = JSON.parse(xhttp.responseText);
  var parent = document.querySelector(".main");

  data.forEach(function(item, index) {
    var listEntry = document.createElement("div");

    listEntry.className = "listEntry";
    listEntry.setAttribute("onclick", "javascript:window.location('index.html?page=" + item['cid'] + "')");
    listEntry.style = "cursor: pointer";

    parent.appendChild(listEntry);

    var articleTitle = document.createElement("div");
    var articleAuthor = document.createElement("div");
    var articleDate = document.createElement("div");

    articleTitle.className = "articleTitle";
    articleAuthor.className = "articleAuthor";
    articleDate.className = "articleDate";

    articleTitle.innerHTML = item["title"];
    articleAuthor.innerHTML = item["username"];
    articleDate.innerHTML = item["entry_date"];

    listEntry.appendChild(articleTitle);
    listEntry.appendChild(articleAuthor);
    listEntry.appendChild(articleDate);

  });

}