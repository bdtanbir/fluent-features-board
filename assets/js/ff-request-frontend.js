(function($) {
    'use strict';
    $(document).ready(function() {
        $(document).on('click', '.ff-requests-header .ff-addnewrequest', function() {
            $('.ff-requests-header .ff-requests-form-wrap').toggleClass('active');
        });

        // Show Logout Button
        $(document).on('click', '.ff-requests-list-home header .header-right ul .user-logout>a', function(e) {
            e.preventDefault();
            $(".ff-requests-list-home header .header-right ul .user-logout-dropdown").toggle();
        })


        // Searching Request
        $('.ff-requests-list-home').each(function(index, el) {
            var parent = $(this);
            var input = $('#search-request');
            var timeout;
            input.keyup(function(event) {
                clearTimeout(timeout);
                var t = $(this);
                timeout = setTimeout(function() {
                    var text = t.val().toLowerCase();
                    if (text == '') {
                        $('.ff-requests-list-box .ff-requests-list-body .ff-request-item').show()
                    } else {
                        $('.ff-requests-list-box .ff-requests-list-body .ff-request-item').hide();
                        $(".ff-requests-list-box .ff-requests-list-body .ff-request-item").each(function() {
                            var name = $(this).data("name").toLowerCase();
                            var reg = new RegExp(text, "g");
                            if (reg.test(name)) {
                                $(this).show()
                            }
                        })
                    }
                }, 100)
            })
        });

        // Submit Feature Request
        $('#ff-request-frontend-form').on('submit', function(e) {
            e.preventDefault();
            var title = $("#ff-request-frontend-form input[name='title']").val();
            var description = $("#ff-request-frontend-form textarea[name='description']").val();
            var parent_id = $("#ff-request-frontend-form #parent_board_id").val();
            var thankyou = $(".ff-requests-form .thankyou");
            var submit_btn = document.querySelector('#ff-request-frontend-form .ff-request-submit');
            const that = this;
            $(this).addClass('submitting');
            submit_btn.setAttribute("disabled", "");
            setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_url.ajaxurl,
                    data: {
                        action: 'addFeatureRequestFromFrontend',
                        title: title,
                        description: description,
                        parent_id: parent_id
                    },
                    success: function(data) {
                        console.log('Success ');
                        $("#ff-request-frontend-form input[name='title']").val('');
                        $("#ff-request-frontend-form textarea[name='description']").val('');
                        $(that).removeClass('submitting');
                        submit_btn.removeAttribute("disabled");
                        thankyou.show();
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    }
                });
            }, 2000);
        })
    })

})(jQuery);