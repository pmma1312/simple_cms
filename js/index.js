var i = 0;
document.onload = getBlogPost(i);

function getBlogPost(page) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      displayEntries(xhttp);
    } else if (this.readyState == 4 && this.status == 204) {
      i -= 1;
      alert("Newest Blog Entry!");
    }
  }
  xhttp.open("GET", "php/api/query.php?page=" + page, true);
  xhttp.send();
}

function displayEntries(xhttp) {
  var data = JSON.parse(xhttp.responseText);
  var parent = document.querySelector(".main");
  parent.innerHTML = "";

  data.forEach(function(item, index) {
    var articleInfo = document.createElement("div");
    articleInfo.className = "articleInfo";


    var author = document.createElement("div");
    var title = document.createElement("div");
    var text = document.createElement("div");
    var entry_date = document.createElement("div");

    author.className = "author";
    title.className = "title";
    text.className = "text";
    entry_date.className = "entry_date";

    author.innerHTML = "Author: " + item['username'];
    title.innerHTML = item['title'];
    text.innerHTML = item['content'];
    entry_date.innerHTML = "Published: " + item['entry_date'];

    parent.appendChild(title);

    parent.appendChild(articleInfo);

    articleInfo.appendChild(author);
    articleInfo.appendChild(entry_date);

    parent.appendChild(text);
  });

  var control = document.createElement("div");
  control.className = "control";

  parent.appendChild(control);

  var prev = document.createElement("button");
  prev.innerHTML = "Previous";
  prev.className = "btn";
  prev.setAttribute("onclick", "javascript:newPost('prev');");

  var next = document.createElement("button");
  next.innerHTML = "Next";
  next.className = "btn";
  next.setAttribute("onclick", "javascript:newPost('next');");

  control.appendChild(prev);
  control.appendChild(next);

  var login = document.createElement("a");
  login.setAttribute("href", "login.php");
  login.innerHTML = "Admin Panel Login";
  parent.appendChild(login);

}

function newPost(type) {
  if (i == 0 && type == "prev") {
    alert("Newest post!");
  } else if (type == "next") {
    i += 1;
  } else {
    i -= 1;
  }
  getBlogPost(i);
  scrollToTop();
}

function scrollToTop() {
  window.scrollTo({
    top: 0
  });
}