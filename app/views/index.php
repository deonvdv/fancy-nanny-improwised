<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/icon.png">

  	<title>Fancy Nanny Systems</title>
  	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
  	<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

  	<link rel="stylesheet" href="app/css/font-awesome.min.css">

  	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  	<!--[if lt IE 9]>
    <script src="../../assets/js/html5shiv.js"></script>
    <script src="../../assets/js/respond.min.js"></script>
  <![endif]-->
  
    <link href="app/css/bootstrap.css" rel="stylesheet">
    <link href="app/css/app.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="app/css/nanoscroller.css" />  
  	<link rel="stylesheet" type="text/css" href="app/css/style.css">
    <!-- Custom styles for this login -->
    <link href="app/css/login.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="app/css/index.css">
    
</head>
<body class="animated" ng-app="myApp">

<div id="cl-wrapper" ng-view></div>

<script src="app/lib/angular/angular.min.js"></script>
<script src="app/lib/angular/angular-resource.min.js"></script>
<script src="app/lib/angular/angular-sanitize.min.js"></script>
<script src="app/js/app.js"></script>
<script src="app/js/controllers.js"></script>
<script src="app/js/directives.js"></script>
<script src="app/js/filters.js"></script>
<script src="app/js/services.js"></script>

<script src="app/lib/jquery.js"></script>
<script src="app/lib/jPushMenu.js"></script>
<script type="text/javascript" src="app/lib/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="app/lib/jquery-ui.js" ></script>
<script type="text/javascript" src="app/lib/core.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
  <script src="app/lib/bootstrap.min.js"></script>

<script>
    angular.module("myApp").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
</script>
</body>
</html>