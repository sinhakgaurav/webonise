<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dashboard Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link href="/admin_asset/css/bootstrap.min.css" rel="stylesheet">
        <link href="/admin_asset/css/bootstrap-datepicker.min.css" rel="stylesheet">
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
                        <li class="active"><a href="/admin/home/dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
                        <li><a href="/admin/home/showall"><i class="icon-user-md"></i><span>User View</span> </a> </li>

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
                            <div class="widget widget-nopad">
                                <div class="widget-header"> <i class="icon-list-alt"></i>
                                    <h3> 
                                        {% if currentStatDate==currentDate %}
                                        Today's Stats
                                        {% else %}
                                        {{currentStatDate}}  Stats
                                        {% endif %}
                                    </h3>
                                </div>
                                <!-- /widget-header -->
                                <div class="widget-content">
                                    <div class="widget big-stats-container">
                                        <div class="widget-content">

                                            <div id="big_stats" class="cf">
                                                <div class="stat" title="Total Employees"> <i class="icon-user"></i> <span class="value"> {% if totalEmp %}{{totalEmp}}{% else %} 0 {% endif %}</span> </div>


                                                <div class="stat" title="Absent"> <i class="icon-ban-circle"></i> <span class="value">{% if notPresent %} {{notPresent}} {% else %} 0 {% endif %}</span> </div>


                                                <div class="stat" title="Currently Present"> <i class="icon-check-sign"></i> <span class="value">{% if signedIn %} {{signedIn}}{% else %} 0 {% endif %}</span> </div>


                                                <div class="stat" title="Average In Time"> <i class="icon-time"></i> <span class="value">{% if averageInTime %} {{averageInTime}}{% else %} 00:00 {% endif %}</span> </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span12">
                            <div class="widget widget-table action-table">
                                <div class="widget-header"> <i class="icon-th-list"></i>
                                    <h3>List of family members</h3>
                                </div>
                                <div class="widget-header">
                                    <h3>Select View type</h3>
                                    <form style="display: inline-block" action="" method="post">
                                        <input value="{{currentStatDate}}" data-date-start-date="-365d" data-date-end-date="0d" class="datepicker" name="date" type="date" data-provide="datepicker"/>

                                        <button class="btn-success" type="submit">Get records</button>
                                    </form>
                                </div>
                                <!-- /widget-header -->
                                <div class="widget-content">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> Username </th>
                                                <th> Arrival Time</th>
                                                <th> Date</th>
                                                <!--<th class="td-actions"> </th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {% for type, items in totalEmps %}
                                            <tr>
                                                <td> {{items.user_name}} </td>
                                                <td>{% if items.punchin.0.time_entered and items.punchin.0.time_entered<"10:00" %}
                                                    {{items.punchin.0.time_entered}} 
                                                    {% elseif items.punchin.0.time_entered and items.punchin.0.time_entered>"10:00" %}
                                                    <span class="btn-danger">{{items.punchin.0.time_entered}}</span>
                                                    {% else %}
                                                    <span class="btn-warning">Absent</span>
                                                    {% endif %}
                                                </td>
                                                <td>
                                                    {% if items.punchin.0.created %}
                                                    {{items.punchin.0.created}} 
                                                    {% else %}
                                                    <span class="btn-warning">Absent</span>
                                                    {% endif %}

                                                </td>
                                                <!--<td class="td-actions"><a href="/admin/home/deleteUser/{{items.id}}" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>-->
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
                                    <a class="btn {% if currentPage==i %}btn-success {% else %}btn-primary {% endif %}" href="/admin/home/dashboard?pagenumber={{i}}">{{i}}</a>
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
        <script src="/admin_asset/js/excanvas.min.js"></script> 
        <script src="/admin_asset/js/chart.min.js" type="text/javascript"></script> 
        <script src="/admin_asset/js/bootstrap.js"></script>
        <script src="/admin_asset/js/bootstrap-datepicker.min.js"></script>

        <script src="/admin_asset/js/base.js"></script> 
        <script>
//$.fn.datepicker.defaults.format = "yyyy-mm-dd";
$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    daysOfWeekDisabled: ['0', '6'],
    autoclose: true
});

        </script>
    </body>
</html>