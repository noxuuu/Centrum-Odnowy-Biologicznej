(function($) {
    "use strict";
    $("#contactForm").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            formError();
            submitMSG(false, "Czy wypełniłeś formularz poprawnie?");
        }
    });
}(jQuery));
