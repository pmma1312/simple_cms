document.onload = fetchEntries();
fetchVisitors();

// Allow tab in textarea
var textarea = document.querySelector('textarea');
textarea.onkeydown = function(e) {
  if (e.keyCode == 9 || e.which == 9) {
    e.preventDefault();
    var s = this.selectionStart;
    this.value = this.value.substring(0, this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
    this.selectionEnd = s + 1;
  }
}

function fetchVisitors() {
  var xhttp = new XMLHttpRequest();
  xhttp.withCredentials = true;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      displayVisitorStats(xhttp);
    }
  }
  xhttp.open("GET", "php/api/visitor.php", true);
  xhttp.send();
}

function displayVisitorStats(xhttp) {
  var visitors = xhttp.responseText;
  visitors = JSON.parse(visitors);
  var visit_t = document.getElementById('visit_t');
  var visit_u = document.getElementById('visit_u');
  visit_t.innerHTML = "Total Visits: " + visitors[0]['visits'];
  visit_u.innerHTML = "Unique Visitors: " + visitors[0]['visitors_unique'];
}

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
  var i = 0;
  data.forEach(function(item, index) {
    var child = document.createElement('div');
    child.className = "entry"
    parent.appendChild(child);
    var grandChild = document.createElement('div');
    grandChild.className = "entry-info"


    var username = document.createElement('div');
    var entry_date = document.createElement('div');
    var title = document.createElement('div');
    var text = document.createElement('div');
    var lastEdited = document.createElement('div');

    username.className = "username";
    entry_date.className = "entry_date";
    title.className = "text title";
    text.className = "text";
    lastEdited.className = "text";

    username.innerHTML = item['username'];
    entry_date.innerHTML = item['entry_date'];
    title.innerHTML = item['title'];
    text.innerHTML = item['content'];
    lastEdited.innerHTML = "Last edited: " + item['edited'];

    grandChild.appendChild(username);
    grandChild.appendChild(entry_date);

    title.setAttribute('id', item['cid'] + "_t");
    child.append(title);

    child.appendChild(grandChild);

    text.setAttribute('id', item['cid']);
    child.appendChild(text);

    child.appendChild(lastEdited);

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
    del.setAttribute('onclick', "javascript:deleteItem(" + item['cid'] + ")");
    del.className = "delete";
    grandChild.append(del);
    i += 1;
  });

  var total = document.getElementById('total');
  total.innerHTML = "Total Blog Posts: " + i;

}

function loadText(cid) {
  var form = document.getElementById('edit_form');
  form.setAttribute("action", "php/cms/update.php?cid=" + cid);
  var textarea = document.querySelector('textarea');
  var in_title = document.getElementById('title');
  var text = document.getElementById(cid);
  var title = document.getElementById(cid + "_t");
  textarea.value = text.innerHTML;
  in_title.value = title.innerHTML;
  textarea.setAttribute('id', cid);
  in_title.focus();
}

function newEntry() {
  var form = document.getElementById('edit_form');
  form.setAttribute("action", "php/cms/entry.php");
  var textarea = document.querySelector('textarea');
  var in_title = document.getElementById('title');
  textarea.removeAttribute('id');
  in_title.focus();
}

function clearInputFields() {
  var form = document.getElementById('edit_form');
  var textarea = document.querySelector('textarea');
  var in_title = document.getElementById('title');
  form.setAttribute("action", "php/cms/entry.php");
  textarea.removeAttribute('id');
  textarea.value = "";
  in_title.value = "";
}

function deleteItem(cid) {
  window.setTimeout(function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        location.href = "php/cms/delete.php?cid=" + cid + "";
      }
    })
    document.getElementById("swal2-content").style.color = "rgb(20, 20, 20)";
  }, 10);
}