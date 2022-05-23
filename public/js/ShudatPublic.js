(function ( $ ) {
    'use strict';
    $(window).load(
        function () {
            $('td a').on(
                'click',
                function (e) {
                    e.preventDefault();
                    let showUserDetailsId = $('#shut_user_details');
                    if (showUserDetailsId.hasClass('loader') ) {
                        return; // No need to continue if there is already a request ongoing.
                    } else {
                        $('#shut_user_details').html('');
                        showUserDetailsId.addClass('loader')
                    }

                    let userId = $(this).closest('tr').attr('data-userid');
                    $.post(
                        shutData.ajaxUrl,
                        {
                            action: 'get-user-details',
                            userId,
                            security : shutData.shut_ajax_security
                        },
                        function (data) {
                            if (true !== data.success) {
                                console.log(data);
                                return;
                            }
                            $('#shut_user_details').html(data.data);
                        }
                    )
                    .fail(
                        function (data) {
                            console.log(data);
                        }
                    ).always(
                        function () {
                            $('#shut_user_details').removeClass('loader');
                        }
                    );
                }
            )
        }
    )
})(jQuery);
