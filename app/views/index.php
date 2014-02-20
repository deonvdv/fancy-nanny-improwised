<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Fancy-Nanny System</title>

	<!-- CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"> <!-- load bootstrap via cdn -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"> <!-- load fontawesome -->
	<style>
		body 		{ padding-top:30px; }
		form 		{ padding-bottom:20px; }
		.comment 	{ padding-bottom:20px; }
	</style>

	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script> <!-- load angular -->

	<!-- ANGULAR -->
	<!-- all angular resources will be loaded from the /public folder -->
		<script src="js/controllers/mainCtrl.js"></script> <!-- load our controller -->
		<script src="js/services/householdService.js"></script> <!-- load our service -->
		<script src="js/app.js"></script> <!-- load our application -->

</head>
<!-- declare our angular app and controller -->
<body class="container" ng-app="fancyNannyApp">
<div class="col-md-8 col-md-offset-2">

	<!-- PAGE TITLE -->
	<div class="page-header">
		<h4>Fancy-Nanny System</h4>
	</div>

	<div ng-controller="mainController">
		<form ng-submit="submitHousehold()">
			<!-- Name -->
			<div class="form-group">
				<input type="text" class="form-control input-sm" name="name" ng-model="householdData.name" placeholder="Name">
			</div>

			<!-- Emergency Contact -->
			<div class="form-group">
				<textarea type="text" class="form-control input-lg" name="emergency_contacts" 
				ng-model="householdData.emergency_contacts" placeholder="Emergency Contacts" >
				</textarea>
			</div>

			<!-- Critical Information -->
			<div class="form-group">
				<textarea type="text" class="form-control input-lg" name="critical_information" 
				ng-model="householdData.critical_information" placeholder="Critical Information">
				</textarea>
			</div>
			
			<!-- SUBMIT BUTTON -->
			<div class="form-group text-right">	
				<button type="submit" class="btn btn-primary btn-lg">Submit</button>
			</div>
		</form>

		<!-- LOADING ICON -->
		<!-- show loading icon if the loading variable is set to true -->
		<p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>

		<!-- THE COMMENTS -->
		<!-- hide these household if the loading variable is true -->
		<div class="household" ng-hide="loading" ng-repeat="household in households">
			<h3>Household #{{ household.id }} <small>by {{ household.name }}</h3>
			<p>{{ household.emergency_contacts }}</p>
			<p>{{ household.critical_information }}</p>
			<p><a href="#" ng-click="deleteHousehold(household.id)" class="text-muted">Delete</a></p>
		</div>

	</div>
	
	<div ng-controller="loginController">
		<!-- NEW LOGIN FORM -->
		<form ng-submit="submitComment()"> <!-- ng-submit will disable the default form action and use our function -->
			<h3> Login </h3>
			<!-- Email -->
			<div class="form-group">
				<input type="text" class="form-control input-sm" name="email" ng-model="user.email" placeholder="Email">
			</div>

			<!-- PASSWORD -->
			<div class="form-group">
				<input type="password" class="form-control input-lg" name="password" ng-model="user.password" placeholder="Password">
			</div>
			
			<!-- SUBMIT BUTTON -->
			<div class="form-group text-right">	
				<button type="submit" class="btn btn-primary btn-lg">Submit</button>
			</div>
		</form>
	</div>

</div>
</body>
</html>