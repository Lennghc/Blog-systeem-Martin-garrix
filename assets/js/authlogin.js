$(document).ready(function () {

    $('.modal').on('shown.bs.modal', function () {
        $("body").css("overflow",'hidden');
    });

    $('.modal').on('hidden.bs.modal', function () {
        $("body").css("overflow",'unset');
    });

    $('#login_button').on('click', function () {
        var email = $('#email_log').val();
        var password = $('#password_log').val();

        // check if values are set and not empty
        if (email != "" && password != "") {

            $("#login_button").attr("disabled", "disabled");

            $.ajax({
                url: "auth/login",
                type: "POST",
                data: {
                    email: email,
                    password: password
                },
                beforeSend: function (xhr) {
                    doAuthLoading('#login_button');
                },
                cache: false,
                success: function (data, textStatus, xhr)  {
                    stopLoading('#login_button', 'Login');
                    toast(`Welcome back, ${data.username}`, 'success', 'toast-top-right');

                    setTimeout(() => {
                        window.location.reload()
                    }, 2000);
                },
                error: function (data) {
                    stopLoading('#login_button', 'Login');
                    $("#login_button").removeAttr("disabled");

                    if(data.responseJSON && data.responseJSON.errors) {
                        let errors = data.responseJSON.errors.map(error => {
                            return `${error} <br>`;
                        });

                        toast(errors, 'error', 'toast-top-right');
                    }
                }
            });
        }
        else {
            // fields are incomplete
            toast("Please fill all the fields!", 'error', 'toast-top-right');
        }
    });

    $('#signup_button').on('click', function () {
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#enter').val();
        var passwordConfirm = $('#retype').val();

        // check all the values are set and not empty
        if (username != "" && email != "" && password != "" && passwordConfirm != "") {

            $("#signup_button").attr("disabled", "disabled");

            $.ajax({
                url: "auth/register",
                type: "POST",
                data: {
                    username: username,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirm
                },
                beforeSend: function (xhr) {
                    doAuthLoading('#signup_button');
                },
                cache: false,
                success: function (data, textStatus, xhr) {
                    stopLoading('#signup_button', 'Register');

                    if(xhr.status == 201) {
                        // if status is (201 created), set de input fields to empty and give one message back of success
                        $('#signup-form')[0].reset();
                        $('.modal').modal('hide');
                        toast('Registration successful!', 'success', 'toast-top-right');
                    }

                },
                error: function (data) {
                    stopLoading('#signup_button', 'Register');
                    $("#signup_button").removeAttr("disabled");

                    if(data.responseJSON && data.responseJSON.errors) {
                        let errors = data.responseJSON.errors.map(error => {
                            return `${error} <br>`;
                        });

                        toast(errors, 'error', 'toast-top-right');
                    }
                }
            });
        }
        else {
            // check if alle fields are set
            toast("Please fill all the fields!", 'error', 'toast-top-right');
        }
    });

    $('#passwordreset_button').on('click', function () {
        var email = $('#reset_email');
        var password = $('#reset_password');
        var passwordConfirm = $('#reset_password_confirmation')

        // check all the values are set and not empty
        if (email.length && email.val() != "" || password.length && password.val() != "" && passwordConfirm.length && passwordConfirm.val() != "") {

            $("#passwordreset_button").attr("disabled", "disabled");

            let obj = {};

            email.length ? (obj.email = email.val()) : null;
            password.length ? (obj.password = password.val()) : null;
            passwordConfirm.length ? (obj.password_confirmation = passwordConfirm.val()) : null;

            $.ajax({
                url: "auth/passwordreset",
                type: "POST",
                data: obj,
                beforeSend: function (xhr) {
                    doAuthLoading('#passwordreset_button');
                },
                cache: false,
                success: function (data, textStatus, xhr) {
                    stopLoading('#passwordreset_button', 'Submit');

                    if(xhr.status == 201) {
                        // if status is (201 created), set de input fields to empty and give one message back of success
                        $('#reset-form')[0].reset();
                        $('.modal').modal('hide');
                        toast('Email has been sent', 'success', 'toast-top-right');
                    }

                    if(xhr.status == 204) {
                        $('#reset-form')[0].reset();
                        $('.modal').modal('hide');
                        toast('Password reset successful!', 'success', 'toast-top-right');
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);

                },
                error: function (data) {
                    stopLoading('#passwordreset_button', 'Submit');
                    $("#passwordreset_button").removeAttr("disabled");

                    if(data.responseJSON && data.responseJSON.errors) {
                        let errors = data.responseJSON.errors.map(error => {
                            return `${error} <br>`;
                        });

                        toast(errors, 'error', 'toast-top-right');
                    }
                }
            });
        }
        else {
            // check if alle fields are set
            toast("Please fill all the fields!", 'error', 'toast-top-right');
        }
    });
});

const stopLoading = function (selector, value) {
    if ($("#loading")) {
        $("#loading").remove();
        $(selector).html(value);
    }
}

const doAuthLoading = function (selector) {
    document.querySelector(selector).innerHTML = `
        <div id="loading" class="spinner-border text-dark" style="width: 1.5rem; height: 1.5rem; border-width: 0.2em;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    `;
}

function showPassword() {
    var enter = document.getElementById("enter");
    var retype = document.getElementById("retype")
    // set the input field from password to a text field to show the password
    if (retype.type === "password") {
        retype.type = "text";
    } else {
        retype.type = "password";
    }

    if (enter.type === "password") {
        enter.type = "text";
    } else {
        enter.type = "password";
    }
}