(function () {

//Start ContactForm
    $('#contact-form').submit(function (event) {
        event.preventDefault(); // Prevent direct form submission
        $('#alert').text('Відправляємо...').fadeIn(0); // Display "Processing..." to let the user know that the form is being submitted

        grecaptcha.ready(function () {
            grecaptcha.execute('YOUR_recaptcha3_PUBLIC_KEY', {action: 'sendform'}).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token; //action form URL
                // Make Ajax Here
                $.ajax({
                    url: '/sendform', //Document URL in Evo
                    type: 'post',
                    data: $('#contact-form').serialize(),
                    dataType: 'json',
                    success: function (_response) {
                        // The Ajax request is a success. _response is a JSON object
                        var error = _response.error;
                        var success = _response.success;
                        if (error != "") {
                            // In case of error, display it to user
                            $('#alert').html(error);
                        } else {
                            // In case of success, display it to user and remove the submit button
                            $('#alert').html(success).fadeOut(4000);
                            $('#contact-form').trigger('reset');
                            //$('#submit-button').remove();
                        }
                    },
                    error: function (jqXhr, json, errorThrown) {
                        // In case of Ajax error too, display the result
                        var error = jqXhr.responseText;
                        $('#alert').html(error);
                    }
                });
            });
        });
    });
//End ContactForm
})();