<?php include_once 'controller/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Pricing example · Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <link href="resources/bootstrap_4.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="resources/css/signin.css" rel="stylesheet">
    <link href="resources/css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="resources/js/scripts.js"></script>
</head>

<body class="text-center">

<div class="container">
    <div class="row">
        <div class="col-11 mx-auto col-md-8 col-lg-6 pl-0 pr-0 text-left" id="warnId"></div>
    </div>
    <div class="row">
        <div class="col-11 mx-auto col-md-8 col-lg-6 sign-in">
            <div class="row">
                <div class="col-12 d-md-none d-sm-block" style="position: relative;height: 220px;">
                    <div class="sign-in-left-image"></div>
                </div>
                <div class="col-12 col-md-5" style="position: relative;">
                    <div class="sign-in-left-image"></div>
                </div>
                <div class="col-12 col-md-7 pt-3 pb-4">
                    <form class="form-signin">
                        <h1 class="h3 mb-4 font-weight-normal">Sign in to your account</h1>
                        <input type="text" id="inputUsername" class="form-control mb-2" placeholder="Username">
                        <input type="password" id="inputPassword" class="form-control" placeholder="Password">
                        <button id="btnSubmit" class="btn btn-lg btn-block" style="background: var(--yellow-color);" type="button">Sign in</button>

                        <div class="col-12 mt-4">
                            <a class="text-dark font-weight-bold" href="signup.php">Create new Account</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div>
                <a href="index.php" class="text-dark">Back to website</a>
            </div>
        </div>
    </div>
</div>

</body>

<script src="resources/bootstrap_4.5/js/bootstrap.min.js"></script>
<script>
    const __redirect_where_after_login = 'index.php';
    const ajaxPath = '<?=$__CONTROLLERS.'login/controller.php';?>';
    const warnElement = $('#warnId');

    $(document).ready(function () {

        const btnSubmit = $('#btnSubmit');
        const btnSubmitDefaultHTML = btnSubmit.html();
        btnSubmit.click(function () {

            const usernameElem = $('#inputUsername');
            const passElem = $('#inputPassword');

            const username = usernameElem.val().trim();
            const pass = passElem.val().trim();

            if(username != "" && pass != ""){

                var params = {
                    'username':username,
                    'password':pass
                };
                btnSubmit.prop('disabled','disabled');
                btnSubmit.html(__LOADING_SPAN);
                callPostAJAX(ajaxPath,params,function (data) {
                    btnSubmit.html(btnSubmitDefaultHTML);
                    if(!data.result){
                        btnSubmit.prop('disabled','');
                        showWarnInside(warnElement, 'alert-danger',data.message);
                    }else{
                        showWarnInside(warnElement, 'alert-success',__WARN_SIGN_IN_SUCCESS);
                        window.location = __redirect_where_after_login;
                    }
                });

            }else{
                showWarnInside(warnElement, 'alert-danger',__WARN_EMPTY_FILEDS_SIGNIN);
            }

        }); // btnSubmit clicked event end #

    });
</script>

</html>
