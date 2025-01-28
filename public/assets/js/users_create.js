function get_line_manager() {

    disable_select_line_manager();
    
    var role_id = $("select[name=role_id]").val();
    var department_id = $("select[name=department_id]").val();

    var api_base_url = $("#api_get_line_managers").attr("data-value");

    if(role_id && department_id) {
        var url = `${api_base_url}/${role_id}/${department_id}`;

        var get = $.get(url, function() {});

        get.done(function(result) {

            if(result.result && result.result.length > 0) {

                var select_line_manager = $('select[name=line_manager_id]');

                result.result.forEach(lm => {
                    var option = `<option value="${lm.id}">${lm.display_name}</option>`;
                    select_line_manager.append(option);
                })
            }
            
            if(result.enable_select_line_manager === true) {
                
                enable_select_line_manager();

                var container = $("<div />");
                var message = `<p>${result.message}</p>`;
                container.append(message);
                $("#modal-default-body").html(container);
                $("#modal-default").modal("show");
            }
        });

        get.fail(function(response) {

            var result = response.responseJSON;

            var container = $("<div />");

            var message = `<p>${result.message}</p>`;

            container.append(message);

            if(result.error_messages) {

                var ul = $("<ul />");

                result.error_messages.forEach(em => {
                    var em = `<li>${em}</li>`;
                    ul.append(em);
                });

                container.append(ul);
            }

            $("#modal-default-body").html(container);
            
            $("#modal-default").modal("show");
        });
    }
}

function disable_select_line_manager() {
    $("select[name=line_manager_id]").attr("disabled", "disabled");
    $("select[name=line_manager_id]").html("");
}

disable_select_line_manager();

function enable_select_line_manager() {
    $('select[name=line_manager_id]').removeAttr('disabled');
}

$("select[name=role_id]").on("change", function() {
    get_line_manager();
});

$("select[name=department_id]").on("change", function() {
    get_line_manager();
});

$("#user-create-form").on("submit", function(e) {
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
        success: function(result) {
            
            if(result.redirect_url) {
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
        error: function(response) {

            var result = response.responseJSON;

            var container = $("<div />");

            var message = `<p>${result.message}</p>`;

            container.append(message);

            if(result.error_messages) {

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