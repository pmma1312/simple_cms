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
    var grandChild = document.createElement('div');
    grandChild.className = "buttons";
    child.append(grandChild);
    var edit = document.createElement('button');
    edit.innerHTML = "Edit";
    edit.className = "edit_b";
    edit.setAttribute('onclick', "javascript:loadText(" + item['cid'] + ")");
    grandChild.append(edit);
    var del = document.createElement('button');
    del.innerHTML = "Delete";
    del.setAttribute('onclick', "location.href='php/cms/delete.php?cid=" + item['cid'] + "'");
    del.className = "delete";
    grandChild.append(del);
  });
}

function loadText(cid) {
  var form = document.getElementById('edit_form');
  form.setAttribute("action", "php/cms/update.php?cid=" + cid);
  var textarea = document.querySelector('textarea');
  var text = document.getElementById(cid);
  textarea.value = text.innerHTML;
  textarea.setAttribute('id', cid);
  textarea.focus();
}

function newEntry() {
  var form = document.getElementById('edit_form');
  form.setAttribute("action", "php/cms/entry.php");
  var textarea = document.querySelector('textarea');
  textarea.removeAttribute('id');
  textarea.focus();
}