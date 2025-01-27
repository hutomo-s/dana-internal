$("#login-form").on("submit", function(e) {
    // stop form from submitting normally
    e.preventDefault();

    // reset modal body content
    $("#modal-default-body").html("");

    var $form = $(this);

    var url = $form.attr("action");

    // get some values from user input
    var form_data = {
        email: $form.find("input[name='email']").val(),
    };

    // send the data using post
    var posting = $.post( url, form_data );

    posting.done(function(result) {
        
        if(result.redirect_url) {
            window.location = result.redirect_url;
        } 
        else {
            var container = $("<div />");
            var message = `<p>${result.message}</p>`;
            container.append(message);
            $("#modal-default-body").html(container);
            $("#modal-default").modal("show");
        }
    });

    posting.fail(function(response) {
        
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
})