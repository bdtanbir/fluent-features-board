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
                        action: 'submit_feature_request',
                        title: title,
                        description: description,
                        id: parent_id
                    }
                });
                console.log('Success');
                $("#ff-request-frontend-form input[name='title']").val('');
                $("#ff-request-frontend-form textarea[name='description']").val('');
                $(that).removeClass('submitting');
                submit_btn.removeAttribute("disabled");
                thankyou.show();
                setTimeout(() => {
                    window.location.reload()
                }, 2000);
            }, 2000);
        });

        // Popup Login Form Toggle
        $(document).on('click', '.ff-request-board-login-register-nav button', function() {
            $(".ff-request-board-login-register-nav button").removeClass('active');
            $(this).addClass('active');
        })
        $(document).on('click', '.ff-request-board-login-register-nav button.btn-login', function() {
            $("#ff-request-board-login").show();
            $("#ff-request-board-register").hide();
            $('.ff-request-board-login-register-body form .ffrb-msg-status').hide();
            $(".ff-request-board-login-register-body form #username").val('');
            $(".ff-request-board-login-register-body form #password").val('');
        })
        $(document).on('click', '.ff-request-board-login-register-nav button.btn-register', function() {
            $("#ff-request-board-login").hide();
            $("#ff-request-board-register").show();
            $('.ff-request-board-login-register-body form .ffrb-msg-status').hide();
            $(".ff-request-board-login-register-body form #username").val('');
            $(".ff-request-board-login-register-body form #password").val('');
        })
        $(document).on('click', '#ffr-login-register-popup', function(e) {
            e.preventDefault();
            $(".ff-request-board-login-register-wrap").addClass('active');
        })
        $(document).on('click', '.ff-request-board-login-register-wrap .ff-request-board-login-register-overlay', function() {
            $(".ff-request-board-login-register-wrap").removeClass('active');
        });


        // Login / Register Form
        var loginicon = document.querySelector('#ffb-login-submit');
        var registericon = document.querySelector('#ffb-register-submit');
        jQuery('form#ff-request-board-login, form#ff-request-board-register').on('submit', function(e) {
            e.preventDefault();
            var curElement = "#" + jQuery(this).attr('id');
            jQuery(curElement + ' p.status', this).show().text(ajax_url.loadingmessage);
            if (jQuery(this).attr('id') === 'ff-request-board-register') {
                var action = 'fluent_features_board_ajaxregister';
                var username = jQuery('#reg-username').val();
                var password = jQuery('#reg-password').val();
                var password2 = jQuery('#reg-password2').val()
                var email = jQuery('#reg-email').val();
                var security = jQuery('#signonsecurity').val();
                var ctrl = jQuery(this);
                registericon.innerHTML = '<span class="loader"></span> Please Wait...';
                registericon.setAttribute('disabled', 'disabled');
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajax_url.ajaxurl,
                        data: {
                            'action': action,
                            'username': username,
                            'password': password,
                            'password2': password2,
                            'email': email,
                            'security': security,
                        },
                        success: function(data) {
                            jQuery(curElement + ' p.ffrb-msg-status').text(data.message);
                            if (data.loggedin == true) {
                                jQuery('.ffrb-msg-status').removeClass('loginerror');
                                jQuery('.ffrb-msg-status').addClass('loginsucess');
                                document.location.href = jQuery(ctrl).attr('id') == 'register' ? ajax_url.register_redirect : ajax_url.redirecturl;
                            } else {
                                jQuery('.ffrb-msg-status').addClass('loginerror');
                                registericon.innerHTML = 'Register Account';
                                registericon.removeAttribute('disabled');
                            }
                        }
                    })
                }, 2000)
            } else {
                var action = 'fluent_features_board_ajaxlogin';
                var username = jQuery('form#ff-request-board-login #username').val();
                var password = jQuery('form#ff-request-board-login #password').val();
                var security = jQuery('form#ff-request-board-login #security').val();
                var ctrl = jQuery(this);
                loginicon.innerHTML = '<span class="loader"></span> Please Wait...';
                loginicon.setAttribute('disabled', 'disabled');
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajax_url.ajaxurl,
                        data: {
                            'action': action,
                            'username': username,
                            'password': password,
                            'security': security,
                        },
                        success: function(data) {
                            jQuery(curElement + ' p.ffrb-msg-status').text(data.message);
                            jQuery('.ffrb-msg-status').show();
                            if (data.loggedin === true) {
                                jQuery('.ffrb-msg-status').removeClass('loginerror');
                                jQuery('.ffrb-msg-status').addClass('loginsucess');
                                loginicon.removeAttribute('disabled');
                                loginicon.innerHTML = 'Login';
                                document.location.href = jQuery(ctrl).attr('id') == 'register' ? ajax_url.register_redirect : ajax_url.redirecturl;
                            } else {
                                jQuery('.ffrb-msg-status').addClass('loginerror');
                                loginicon.innerHTML = 'Login';
                                loginicon.removeAttribute('disabled');
                            }

                        }
                    })
                }, 2000)
            }
        });


        // Submit Comment
        var submitbtn = document.querySelector(".submit-comment button");
        $("#ff-request-comment-form").on('submit', function(e) {
            e.preventDefault();
            var that = this;
            var comment = $('textarea[name="comment"]', that).val();
            var comment_post_id = $('input[name="comment_post_id"]', that).val();

            console.log('Submitted a New Comment');
            submitbtn.innerHTML = '<span class="loader"></span> Submitting';
            submitbtn.setAttribute('disabled', '');
            $(that).addClass('submitting');

            $.ajax({
                type: 'POST',
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: 'submit_new_comment_action',
                    comment_content: comment,
                    comment_post_id: comment_post_id
                }
            })


        });


        // Single Feature Request
        // $(document).on('click', '.ff-requests-list-box .ff-request-item .ff-request-content h3 a', function(e) {
        //     e.preventDefault();
        //     var request_id = parseInt(this.dataset.id);
        //     // alert('hello')
        //     // $.ajax({
        //     //     type: 'POST',
        //     //     dataType: 'json',
        //     //     url: ajax_url.ajaxurl,
        //     //     data: {
        //     //         action: 'ff_request_single_callback',
        //     //         id: request_id
        //     //     }
        //     // })
        // })

    })

})(jQuery);