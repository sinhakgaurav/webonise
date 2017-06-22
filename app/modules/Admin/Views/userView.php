<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Home Members Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link href="/admin_asset/css/bootstrap.min.css" rel="stylesheet">
        <link href="/admin_asset/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
              rel="stylesheet">
        <link href="/admin_asset/css/font-awesome.css" rel="stylesheet">
        <link href="/admin_asset/css/style.css" rel="stylesheet">
        <link href="/admin_asset/css/pages/dashboard.css" rel="stylesheet">
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
              <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                            class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.html">EMS Admin  </a>
                    <div class="nav-collapse">
                        <ul class="nav pull-right">

                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                        class="icon-user"></i> Welcome Admin, <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/admin/home/logout">Logout</a></li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="subnavbar">
            <div class="subnavbar-inner">
                <div class="container">
                    <ul class="mainnav">
                        <li ><a href="/admin/home/dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
                        <li class="active"><a href="/admin/home/showall"><i class="icon-user-md"></i><span>User View</span> </a> </li>

                    </ul>
                </div>

            </div>

        </div>
        
        <div class="main">
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        <div class="span8">{{message | raw}}</div>
                        <div class="span12">
                            <div class="widget widget-table action-table">
                                <div class="widget-header"> <i class="icon-th-list"></i>
                                    <h3>List of family members</h3>
                                </div>
                                <div class="widget-header">
                                    <h3>Sort By</h3>
                                    <form style="display: inline-block" action="" method="get">
                                        <select id="sort_type" name="sort_by" required="required" >
                                            <option value="">Select option to sort</option>
                                            <option value="userByLateCount">By high to low latecount</option>
                                            <option value="userByAlphabeticalOrder">by username alphabetically</option>
                                            <option value="userByAverageTime">By highest average time</option>
                                        </select>

                                        <button class="btn-success" id="getSortType">Get records</button>
                                    </form>
                                </div>
                                <!-- /widget-header -->
                                <div class="widget-content">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> Username </th>
                                                <th>Average Arrival Time</th>
                                                <th> Late Count</th>
                                                <th class="td-actions"> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {% for type, items in totalEmp %}
                                            <tr>
                                                <td><a href='/admin/home/viewDetail/{{items.id}}'> {{items.user_name}} </a></td>
                                                <td>{% if items.average_arrival and items.average_arrival < "10:00" %}
                                                    {{items.average_arrival}} 
                                                    {% elseif items.average_arrival and items.average_arrival>"10:00" %}
                                                    <span class="btn-danger">{{items.average_arrival}}</span>
                                                    {% else %}
                                                    <span class="btn-warning">Please check the status</span>
                                                    {% endif %}
                                                </td>
                                                <td>
                                                    {% if items.late_count==0 %}
                                                    {{items.late_count}} 
                                                    {% else %}
                                                    <span class="btn-warning">{{items.late_count}}</span>
                                                    {% endif %}

                                                </td>
                                                <td class="td-actions"><a href="/admin/home/deleteUser/{{items.id}}" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
                                            </tr>
                                            {% else %}
                                            <tr>
                                                <td colspan="4">No users have been found.</td>
                                            </tr>
                                            {% endfor %}

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /widget-content --> 
                            </div>
                            <div class="pagination-right widget ">
                                    {% set k=pageCount%}
                                    {% for i in range(1, k) %}
                                    <a class="btn {% if currentPage==i %}btn-success {% else %}btn-primary {% endif %}" href="{{currentUrl}}&pagenumber={{i}}">{{i}}</a>
                                    {% endfor %}
                                </div>
                        </div>

                    </div>
                </div> 
            </div> 
        </div>
        <div class="footer">
            <div class="footer-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-12"> &copy; <?php echo date('Y'); ?> <a href="#">Webonise </a>. </div>

                    </div> 
                </div>
            </div>
        </div>
        <!--  javascript
        ================================================== --> 
        <!-- Placed at the end of the document so the pages load faster --> 
        <script src="/admin_asset/js/jquery-1.7.2.min.js"></script> 
        <script src="/admin_asset/js/bootstrap.js"></script>
        <script src="/admin_asset/js/base.js"></script> 
        <script>
$(function () {

    $('#sort_type option[value="{{selected}}"]').attr('selected', 'selected');
});
        </script>
    </body>
</html>