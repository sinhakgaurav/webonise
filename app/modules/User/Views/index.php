<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Employee PunchIn </title>

        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">


        <!-- Custom styles for this template -->
        <link href="/css/style.css" rel="stylesheet">

    </head>

    <body>

        <div class="container">
            <div class="back col-lg-10">&nbsp;</div>
            <form class="form-signin" action="/user/home/" method="post">
                <h2 class="form-signin-heading">Welcome to your second home...</h2>
                {{message | raw}}
                
                <input pattern='[a-zA-Z0-9-]+' required="required" name="username" type="text" id="inputEmail" class="form-control" placeholder="Write in your username" required autofocus>
                <p class="row">&nbsp;</p>
                <div class="col-lg-12 row">
                    <button class="btn btn-lg btn-primary col-lg-4" type="submit">Sign in</button>
                    <div class="col-md-1">&nbsp;</div>
                    <a href="/user/home/register" class="btn btn-lg btn-success col-lg-6">Click here to register</a>
                </div>
                <div class="row">&nbsp;</div>
            </form>

        </div> <!-- /container -->


    </body>
</html>
