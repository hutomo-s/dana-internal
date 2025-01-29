$(function () {
  bsCustomFileInput.init();
});

var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

$("input[name=request_due_date]").datepicker({
  uiLibrary: "bootstrap4",
  format: "yyyy-mm-dd",
  minDate: today
});

$(document).on("input", ".number-separator", function (e) {
  if (/^[0-9.,]+$/.test($(this).val())) {
    $(this).val(
      parseFloat($(this).val().replace(/,/g, "")).toLocaleString('en')
    );
  } else {
    $(this).val(
      $(this)
        .val()
        .substring(0, $(this).val().length - 1)
    );
  }
});

$("#request_cost_amount_input").on("change", function(e) {
  var value = e.target.value;

  var original_amount = value.replace(/,(?=\d{3})/g, '');

  $("input[name=request_cost_amount]").val(original_amount);
});

$("#add_impact_attachment").on("click", function(e) {
  e.preventDefault();

  var input_name = 'impact_file[]';

  var input_group = `<div class="input-group">
      <div class="custom-file mb-2">
          <input type="file" accept="*" class="custom-file-input" name="${input_name}">
          <label class="custom-file-label">Choose file</label>
      </div>
  </div>`;

  $("#impact_attachments").append(input_group);

  bsCustomFileInput.init();
});

$("#add_reason_attachment").on("click", function(e) {
  e.preventDefault();

  var input_name = 'reason_file[]';

  var input_group = `<div class="input-group">
      <div class="custom-file mb-2">
          <input type="file" accept="*" class="custom-file-input" name="${input_name}">
          <label class="custom-file-label">Choose file</label>
      </div>
  </div>`;

  $("#reason_attachments").append(input_group);

  bsCustomFileInput.init();
});

$("#ep-create-form").on("submit", function (e) {
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