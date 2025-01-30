$("#ep-submit-approval").on("submit", function (e) {
    // stop form from submitting normally
    e.preventDefault();
  
    // reset modal body content
    $("#modal-default-body").html("");
  
    var $form = $(this);
  
    var url = $form.attr("action");
  
    var form_data = new FormData(this);
  
    // send the data using post
    $.ajax({
      url: url,
      type: "POST",
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
  
        if (result.redirect_url) {
          alert(result.message);
          window.location = result.redirect_url;
        }
        else {
          var container = $("<div />");
          var message = `<p>${result.message}</p>`;
          container.append(message);
          $("#modal-default-body").html(container);
          $("#modal-default").modal("show");
        }
      },
      error: function (response) {
  
        var result = response.responseJSON;
  
        var container = $("<div />");
  
        var message = `<p>${result.message}</p>`;
  
        container.append(message);
  
        if (result.error_messages) {
  
          var ul = $("<ul />");
  
          result.error_messages.forEach(em => {
            var em = `<li>${em}</li>`;
            ul.append(em);
          });
  
          container.append(ul);
        }
  
        $("#modal-default-body").html(container);
  
        $("#modal-default").modal("show");
  
      }
    });
  })