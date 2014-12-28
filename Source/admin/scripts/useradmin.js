UserAdmin = function() {
    var internal = {

    };

    var external = {
        validate: function() {
            internal.clearError('#username');
            internal.clearError('#email_address');
            internal.clearError('#name');
            internal.clearError('#password1');
            internal.clearError('#password2');

            internal.clearClientSideErrors();

            var username = $('#username').val();
            var email = $('#email_address').val();
            var name = $('#name').val();
            var password1 = $('#password1').val();
            var password2 = $('#password2').val();

            var validForm = true;

            var errors = [];

            if (username == '') {
                internal.invalidateField('#username');
                validForm = false;
                errors.push('Username is required');
            }

            var emailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            if (!emailRegex.test(email)) {
                internal.invalidateField('#email_address');
                validForm = false;
                errors.push('Email is required');
            }

            if (name == '') {
                internal.invalidateField('#name');
                validForm = false;
                errors.push('Name is required');
            }

            if (password1 =='') {
                internal.invalidateField('#password1');
                validForm = false;
                errors.push('Password is required');
            }

            if (password2 == '') {
                internal.invalidateField('#password2');
                validForm = false;
                errors.push('Re-Enter Password is required');
            }

            if (password1 != password2) {
                internal.invalidateField('#password1');
                internal.invalidateField('#password2');
                validForm = false;
                errors.push('Passwords do not match');
            }

            if (password1.length < 8 || password2.length < 8) {
                internal.invalidateField('#password1');
                internal.invalidateField('#password2');
                validForm = false;
                errors.push('Password must be at least 8 characters long');
            }

            if (errors.length > 0) {
                for (var i = 0; i < errors.length; i++) {
                    $('#client-side-errors').append("<li><span>" + errors[i] + "</span></li>");
                }
                $('#client-side-errors').show();
            }

            return validForm;
        },

        checkUsernameAvailability: function(username) {
            $.ajax({
                type: 'GET',
                url: '/admin/php/ajax.checkusername.php',
                data: { username: username },
                success: function (data) {
                    if (data.Result == "SUCCESS") {
                        if (data.Data.available) {
                            alert('available');
                        } else {
                            alert('not available');
                        }
                    } else {
                        Utilities.processAjaxError(data);
                    }
                },
                error: function(data) { Utilities.processAjaxError(data); }
            });
        }
    };

    var initialize = function() {
        $(document).ready(function() {
            $('#username').blur(function() {
                var username = $(this).val();
                external.checkUsernameAvailability(username);
            });
        });
    }();

    return external;
}();