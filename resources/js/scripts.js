const __WARN_EMPTY_FILEDS_SIGNIN     = 'Warning: please enter username and password!';
const __WARN_EMPTY_FILEDS            = 'Warning: please fill all the fields!';
const __WARN_PASS_NO_MATCHE          = "Warning: passwords are not matched together!";
const __WARN_PASS_MIN_LENGHT         = "Warning: your password must be at least 8 characters.";
const __WARN_USER_MIN_LENGHT         = "Warning: the username must be at least 6 characters.";
const __WARN_SIGN_UP_SUCCESS         = "Your account created successfully, right now you can sign in to your account!";
const __WARN_SIGN_IN_SUCCESS         = "You signed in successfully. redirecting to home...";
const __WARN_PROFILE_EMPTY_IMG       = "Warning: You've not chose 'Product image' for your auction!";
const __WARN_PROFILE_EMPTY_NAME      = "Warning: You've not entered 'Product name' for your auction!";
const __WARN_PROFILE_EMPTY_PRICE     = "Warning: You've not entered 'Product price' for your auction!";
const __WARN_PROFILE_CREATED_SUCCESS = "Your auction created successfully, you can manage that from 'Sales list'";
const __WARN_PROFILE_WRONG_PRICE     = "Warning: The entered 'Product price' is wrong!";
var __badges;


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

function showModal(modalId, header, body,warnId,onClickYes) {
    $(warnId).html('');
    $(modalId + ' #modal_header').html(header);
    $(modalId + ' #modal_body').html(body);

    const parent = $(modalId);
    const element = parent.find('#modal_button');
    element[0].onclick = function() {
        onClickYes();
    };

    $(modalId).modal('show');
}


function refreshBadges(ajaxPathNavbar,callback) {
    callPostAJAX(ajaxPathNavbar,null,function (data) {
        __badges = data;
        if(data.result){
            callback();
        }

    });
}

function flashElement(elemId) {
    $(function () {
        $(elemId).delay(150).animate({
            "background-color": "#ffe83b"
        }, 350, function () {
            $(elemId).animate({
                "background-color": "#fff"
            }, 200);
        });
    });
}