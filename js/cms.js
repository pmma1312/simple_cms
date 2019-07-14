document.onload = fetchEntries();

function fetchEntries() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      displayEntries(xhttp);
    }
  }
  xhttp.open("GET", "php/api/query.php?no_limit", true);
  xhttp.send();
}

function displayEntries(xhttp) {
  var data = JSON.parse(xhttp.responseText);
  var parent = document.querySelector(".entry-list");
  data.forEach(function(item, index) {
    var child = document.createElement('div');
    child.className = "entry"
    parent.appendChild(child);
    var grandChild = document.createElement('div');
    grandChild.className = "entry-info"
    child.appendChild(grandChild);
    var username = document.createElement('div');
    var text = document.createElement('div');
    var entry_date = document.createElement('div');
    username.className = "username";
    text.className = "text";
    entry_date.className = "entry_date";
    username.innerHTML = item['username'];
    text.innerHTML = item['content'];
    entry_date.innerHTML = item['entry_date']
    grandChild.appendChild(username);
    grandChild.appendChild(entry_date);
    text.setAttribute('id', item['cid'])
    child.appendChild(text);
    var edit = document.createElement('button');
    edit.innerHTML = "Edit";
    edit.setAttribute('onclick', "javascript:loadText(" + item['cid'] + ")");
    child.append(edit);
  });
}

function loadText(cid) {
  var textarea = document.getElementById('myTextarea');
  var text = document.getElementById(cid);
  textarea.value = text.innerHTML;
}