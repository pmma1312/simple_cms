var i = 0;

var $_GET = {};
if (document.location.toString().indexOf('?') !== -1) {
  var query = document.location
    .toString()
    // get the query string
    .replace(/^.*?\?/, '')
    // and remove any existing hash string (thanks, @vrijdenker)
    .replace(/#.*$/, '')
    .split('&');

  for (var i = 0, l = query.length; i < l; i++) {
    var aux = decodeURIComponent(query[i]).split('=');
    $_GET[aux[0]] = aux[1];
  }
}

if ($_GET['page'] != null) {
  document.onload = getBlogPost($_GET['page']);
} else {
  document.onload = getBlogPost(i);
}

window.onload = updateVisitor;
document.onkeydown = checkKey;

function getBlogPost(page) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      displayEntries(xhttp);
    } else if (this.readyState == 4 && this.status == 204) {
      i -= 1;
      alert("Oldest entry!");
    }
  }
  xhttp.open("GET", "php/api/query.php?page=" + page, true);
  xhttp.send();
}

function updateVisitor() {
  var xhttp = new XMLHttpRequest();
  xhttp.open("PUT", "php/api/visitor.php", true);
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
    var pp = document.createElement("img");
    var title = document.createElement("div");
    var text = document.createElement("div");
    var entry_date = document.createElement("div");


    author.className = "author";
    pp.className = "profile_pic";
    title.className = "title";
    text.className = "text";
    entry_date.className = "entry_date";

    pp.src = item['profile_pic'];
    pp.alt = "author picture"

    author.innerHTML = "Author: " + item['username'];
    title.innerHTML = item['title'];
    text.innerHTML = item['content'];
    entry_date.innerHTML = "Published: " + item['entry_date'];

    parent.appendChild(title);
    parent.appendChild(pp);

    parent.appendChild(articleInfo);

    articleInfo.appendChild(author);
    articleInfo.appendChild(entry_date);

    parent.appendChild(text);
    document.title = item['title'];
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
  login.className = "link";
  login.innerHTML = "Admin Panel Login";
  parent.appendChild(login);

}

function newPost(type) {
  if (i == 0 && type == "prev") {
    alert("Newest entry!");
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

function checkKey(e) {
  e = e || window.event;

  if (e.keyCode == "37") {
    // Left arrow => Previous Entry
    newPost("prev");
  } else if (e.keyCode == "39") {
    // Right arrow => Next Entry
    newPost("next");
  }
}