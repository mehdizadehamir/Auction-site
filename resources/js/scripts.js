const __WARN_EMPTY_FILEDS_SIGNIN = 'Warning: please enter username and password!';
const __WARN_EMPTY_FILEDS = 'Warning: please fill all the fields!';
const __WARN_PASS_NO_MATCHE = "Warning: passwords are not matched together!";
const __WARN_PASS_MIN_LENGHT = "Warning: your password must be at least 8 characters.";
const __WARN_USER_MIN_LENGHT = "Warning: the username must be at least 6 characters.";
const __WARN_SIGN_UP_SUCCESS = "Your account created successfully, right now you can sign in to your account!";
const __WARN_SIGN_IN_SUCCESS = "You signed in successfully. redirecting to home...";

const __LOADING_SPAN = '<span class="fa fa-spinner fa-spin"></span>';

function showWarnInside(jqElem, className, txt) {

    var htm = '';
    htm += '<div class="alert '+ className +'">';
    htm += txt;
    htm += '</div>';

    jqElem.html(htm);
}

function callPostAJAX(url,params, onCallback) {
    $.post(url, params,function (result) {
        onCallback(result);
    });
}