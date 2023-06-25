<?php

// WordPress后台登录页面美化
function custom_login_style() {
    $bgimgj = get_template_directory_uri().'/style/img/th.jpeg';
    echo '
        <style>
            body{
                background-image:url('.$bgimgj.');
                background-position: 50%;
                background-size: cover;
            }
            .login form .input{
                border-radius:20px;
                padding:.1875rem 20px;
            }
            #login{
                width:400px;
                padding: 12% 0 0;
            }
            .login h1,.login .message, .login .success,.login #backtoblog{
                display:none;
            }
            .login form{
                margin-top:0;
                padding:26px 44px 34px;
                border:none;
                border-radius:10px;
                box-shadow: 0 0 18px 0 rgb(0 0 0 / 4%);
            }
            .login label{
                margin-bottom:10px;
            }
            .wp-core-ui .button-primary{
                background:#333;
                border-color:#333;
            }
            .login #login_error, .login .message, .login .success{
                border-left:none;
                border-radius:10px;
                box-shadow: 0 0 18px 0 rgb(0 0 0 / 4%);
            }
            .wp-core-ui p .button{
                width:100%;
                float:none;
                height:40px;
                line-height:40px;
                border-radius:20px;
            }
            .login #backtoblog a, .login #nav a{
                color:#fff;
            }
        </style>
    ';
}
add_action('login_head','custom_login_style');