<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Admin Panel</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 

        <link href="/admin_asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/admin_asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

        <link href="/admin_asset/css/font-awesome.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

        <link href="/admin_asset/css/style.css" rel="stylesheet" type="text/css">
        <link href="/admin_asset/css/pages/signin.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <div class="navbar navbar-fixed-top">

            <div class="navbar-inner">

                <div class="container">

                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <a class="brand" href="index.html">
                        Admin Panel Login				
                    </a>		
                    <!--/.nav-collapse -->	

                </div> <!-- /container -->

            </div> <!-- /navbar-inner -->

        </div> <!-- /navbar -->



        <div class="account-container">

            <div class="content clearfix">

                <form action="/admin" method="post">

                    <h1>Welcome Leader</h1>	
                    {{message | raw}}
                    <div class="login-fields">

                        <p>Please provide your details</p>

                        <div class="field">
                            <label for="username">Username</label>
                            <input pattern='[a-zA-Z0-9-]+' required="required" type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
                        </div> <!-- /field -->

                        <div class="field">
                            <label for="password">Password:</label>
                            <input required="required" type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
                        </div> <!-- /password -->

                    </div> <!-- /login-fields -->

                    <div class="login-actions">



                        <button class="button btn btn-success btn-large">Sign In</button>

                    </div> <!-- .actions -->



                </form>

            </div> <!-- /content -->

        </div> <!-- /account-container -->


        <!-- /login-extra -->


        <script src="/admin_asset/js/jquery-1.7.2.min.js"></script>
        <script src="/admin_asset/js/bootstrap.js"></script>

        <script src="/admin_asset/js/signin.js"></script>

    </body>

</html>