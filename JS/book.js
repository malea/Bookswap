// Gathers information about a submit-entry request, then submits it
// Can't use automated sendRequestForm because IDs might be duplicate
function entryAddSubmit(event, isbn) {
  var form = event.target;
  sendRequest("publicEntryAdd", {
    isbn: isbn,
    title: form.getElementsByClassName("entry_title")[0].innerText,
    state: form.getElementsByClassName("entry_state")[0].value,
    action: form.getElementsByClassName("entry_action")[0].value,
    dollars: form.getElementsByClassName("num_dollars")[0].value,
    cents: form.getElementsByClassName("num_cents")[0].value
  }, function(result) { entryAddFinish(result, event.target); });
  
  // Mention it's working
  $(form).find("input[type=submit]").val("thinking...");
  console.log(window.d = form);
}

function entryAddFinish(result, form) {
  // Display the result in the HTML
  var displayer = form.getElementsByClassName("entry_results");
  displayer[0].innerHTML = result;
  $(form).find("input[type=submit]").val("Go!");
  
  // If it's a success, reload the page
  if(result == "Entry added successfully!")
    window.location.reload();
}