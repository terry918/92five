<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>92five App - {{trans('92five.fp.title')}}</title>
<!-- Bootstrap -->
{{ HTML::style('assets/css/bootstrap/bootstrap.css') }}
{{ HTML::style('assets/css/bootstrap/bootstrap-responsive.css') }}
{{ HTML::style('assets/css/simplelogin/style.css') }}
{{ HTML::style('assets/css/simplelogin/custom.css') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}      
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/ie.css" />
        <![endif]-->
        
        <!--[if lt IE 9]>
            <script src="js/html5.js"></script>
            <script src="js/respond.min.js"></script>
            <script src="js/excanvas.min.js"></script>
        <![endif]-->
        
<!--script strt here-->
{{ HTML::script('assets/js/jquery/jquery-1.9.1.min.js') }}
{{ HTML::script('assets/js/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
</head>
<body>
<div class="login_detail">
     <div class="error_detail_1"><img src="{{asset('assets/images/errorpages/logo12.png')}}" alt=""/></div>
	<h2>{{trans('92five.fp.title')}}</h2>
    <div class="login_form">
        <div class="row-fluid">
            <form method="post" id="newpassform" name="newpassform" action="auth/forgotpassword"  data-validate="parsley">
                <input type="text" name="recoverEmail" id="recoverEmail" class="span12" placeholder="Email" data-trigger="change" data-required="true" data-type="email">
                <div class="sign_button_main forgot">
                	<button class="sign_in_button">{{trans('92five.fp.button')}}</button>
                </div>
                <div class="forgot_link">{{trans('92five.fp.text1')}} {{trans('92five.to')}} <a href="login">{{trans('92five.fp.loginlink')}}</a> {{trans('92five.fp.text2')}}</div>
            </form>              
        </div>
    </div>
</div>
<div class="footer">&copy; 2014 92five app </div>
</body>
</html>
