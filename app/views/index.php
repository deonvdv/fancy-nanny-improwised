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
    <link rel="stylesheet" type="text/css" href="app/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="app/css/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="app/css/select2.css" />
    <link rel="stylesheet" type="text/css" href="app/css/bootstrap-multiselect.css"/>
    <link rel="stylesheet" type="text/css" href="app/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app/css/component.css" />
    <link rel="stylesheet" type="text/css" href="app/css/colorpicker.css">
    <link rel='stylesheet' type='text/css' href='app/css/fullcalendar.css' />
    <link rel='stylesheet' type='text/css' href='app/css/fullcalendar.print.css'  media='print' />
    <!-- Custom styles for this login -->
    <link href="app/css/login.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="app/css/style.css">
  	<link rel="stylesheet" type="text/css" href="app/css/index.css">

</head>
<body class="animated" ng-app="myApp">

<div id="cl-wrapper" ng-view></div>


  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->

  <script type="text/javascript" src="app/lib/jquery.js"></script>
  <script type="text/javascript" src="app/lib/jPushMenu.js"></script>
  <script type="text/javascript" src="app/lib/jquery.nanoscroller.js"></script>
  <script type="text/javascript" src="app/lib/jquery-ui.js" ></script>
  <script type="text/javascript" src="app/lib/core.js"></script>
  <script type="text/javascript" src="app/lib/bootstrap.min.js"></script>
  <script type="text/javascript" src="app/lib/moment.min.js"></script>
  <script type="text/javascript" src="app/lib/daterangepicker.js"></script>
  <script type="text/javascript" src="app/lib/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript" src="app/lib/select2.min.js" ></script>
  <script type="text/javascript" src="app/lib/parsley.js"></script>
  <script type="text/javascript" src="app/lib/bootstrap-multiselect.js"></script>
  <script type="text/javascript" src="app/lib/jasny-bootstrap.min.js"></script>
  <script type="text/javascript" src="app/lib/modalEffects.js"></script>
  <script type='text/javascript' src='app/lib/fullcalendar.js'></script>

  <script type="text/javascript" src="app/lib/angular/angular.min.js"></script>
  <script type="text/javascript" src="app/lib/angular/angular-route.js"></script>
  <script type="text/javascript" src="app/lib/angular/angular-resource.min.js"></script>
  <script type="text/javascript" src="app/lib/angular/angular-sanitize.min.js"></script>
  <script type="text/javascript" src="app/lib/ui-bootstrap-tpls.js"></script>

  <script type="text/javascript" src="app/js/app.js"></script>

  <script type="text/javascript" src="app/js/routes.js"></script>

  <script type="text/javascript" src="app/lib/select2.js"></script>

  <!-- controllers -->
  <script type="text/javascript" src="app/js/controllers/LoginController.js"></script>
  <script type="text/javascript" src="app/js/controllers/HomeController.js"></script>
  <script type="text/javascript" src="app/js/controllers/TodoController.js"></script>
  <script type="text/javascript" src="app/js/controllers/MessageController.js"></script>
  <script type="text/javascript" src="app/js/controllers/RecipesController.js"></script>
  <script type="text/javascript" src="app/js/controllers/TagsController.js"></script>
  <script type="text/javascript" src="app/js/controllers/DocumentsController.js"></script>
  <script type="text/javascript" src="app/js/controllers/ShoppingController.js"></script>
  <script type="text/javascript" src="app/js/controllers/UserController.js"></script>
  <script type="text/javascript" src="app/js/controllers/EditUserController.js"></script>
  <script type="text/javascript" src="app/js/controllers/CalenderController.js"></script>
  <script type="text/javascript" src="app/js/controllers/EventsController.js"></script>
  <!-- //controllers -->

  <script type="text/javascript" src="app/js/directives.js"></script>
  <script type="text/javascript" src="app/js/filters.js"></script>

  <!-- services -->
  <script type="text/javascript" src="app/js/services/Authenticate.js"></script>
  <script type="text/javascript" src="app/js/services/Categories.js"></script>
  <script type="text/javascript" src="app/js/services/Documents.js"></script>
  <script type="text/javascript" src="app/js/services/Events.js"></script>
  <script type="text/javascript" src="app/js/services/Flash.js"></script>
  <script type="text/javascript" src="app/js/services/Households.js"></script>
  <script type="text/javascript" src="app/js/services/Ingredients.js"></script>
  <script type="text/javascript" src="app/js/services/Meals.js"></script>
  <script type="text/javascript" src="app/js/services/Messages.js"></script>
  <script type="text/javascript" src="app/js/services/Notifications.js"></script>
  <script type="text/javascript" src="app/js/services/Pictures.js"></script>
  <script type="text/javascript" src="app/js/services/RecipeIngredients.js"></script>
  <script type="text/javascript" src="app/js/services/RecipeReviews.js"></script>
  <script type="text/javascript" src="app/js/services/Recipes.js"></script>
  <script type="text/javascript" src="app/js/services/Tags.js"></script>
  <script type="text/javascript" src="app/js/services/Todos.js"></script>
  <script type="text/javascript" src="app/js/services/UnitOfMeasures.js"></script>
  <script type="text/javascript" src="app/js/services/Users.js"></script>
  <!-- //services -->

  <script>
      angular.module("myApp").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
  </script>

  <script type="text/javascript" src="app/lib/bootstrap-colorpicker-module.js"></script>

</body>
</html>