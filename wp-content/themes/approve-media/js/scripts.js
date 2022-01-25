/* global approveMedia */
( function ($) {
    'use strict';

    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity()) {

                    const properties = {
                        action: approveMedia.name,
                        security: approveMedia.security,
                        title: $('#new-property-name').val(),
                        property_type: $('input[name="new-property-category"]:checked').val(),
                        desc: $('#new-property-desc').val(),
                        city: $('#new-property-city').val(),
                        address: $('#new-property-address').val(),
                        square: $('#new-property-square').val(),
                        living_square: $('#new-property-living-square').val(),
                        level: $('#new-property-level').val(),
                        price: $('#new-property-price').val(),
                    };

                    const alert = $('#new-property-message');
                    alert.removeClass('alert-danger').removeClass('alert-success');

                    $.ajax({
                        type: 'POST',
                        url: approveMedia.ajax_url,
                        data: properties,
                        dataType: 'json',
                        success: function(response) {
                            if (response.hasOwnProperty('success')) {
                                if ( response.success === false) {
                                    const msg = response.data[0].message;
                                    alert.addClass('alert-danger').show().text(msg)
                                } else {
                                    const msg = 'Багодарим Вас за добавленые этого объекта. Ваша заявка будет рассмотрена в кратчайшие сроки';
                                    alert.addClass('alert-success').show().text(msg)
                                }
                            }
                        }
                    })
                }

                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})( jQuery );