angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('addNewMealController',function($scope, $controller, $http, Recipes, Meals){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        $scope.meals = [];

        $scope.day_of_week = [];

        $scope.day_of_week_1 = [];
        $scope.day_of_week_1.day = "Sunday";

        $scope.day_of_week_2 = [];
        $scope.day_of_week_2.day = "Monday";

        $scope.day_of_week_3 = [];
        $scope.day_of_week_3.day = "Tuesday";

        $scope.day_of_week_4 = [];
        $scope.day_of_week_4.day = "Wednesday";

        $scope.day_of_week_5 = [];
        $scope.day_of_week_5.day = "Thursday";

        $scope.day_of_week_6 = [];
        $scope.day_of_week_6.day = "Friday";

        $scope.day_of_week_7 = [];
        $scope.day_of_week_7.day = "Saturday";

        loadmeals();

        function loadmeals(){

            //Fetch all Recipes for LoggedIn user's household.
            Meals.get()
                .success(function(data) {

                    $scope.meals = data.data;

                    for(i=0;i<$scope.meals.length;i++){

                            if($scope.meals[i].day_of_week === 1){

                                $scope.day_of_week_1.push($scope.meals[i]);

                            }

                            else if($scope.meals[i].day_of_week === 2){

                                $scope.day_of_week_2.push($scope.meals[i]);

                            }

                            else if($scope.meals[i].day_of_week === 3){

                                $scope.day_of_week_3.push($scope.meals[i]);

                            }

                            else if($scope.meals[i].day_of_week === 4){

                                $scope.day_of_week_4.push($scope.meals[i]);

                            }

                            else if($scope.meals[i].day_of_week === 5){

                                $scope.day_of_week_5.push($scope.meals[i]);

                            }

                            else if($scope.meals[i].day_of_week === 6){

                                $scope.day_of_week_6.push($scope.meals[i]);

                            }

                            else if($scope.meals[i].day_of_week === 7){

                                $scope.day_of_week_7.push($scope.meals[i]);

                            }

                    }

                $scope.day_of_week.push($scope.day_of_week_1);
                $scope.day_of_week.push($scope.day_of_week_2);
                $scope.day_of_week.push($scope.day_of_week_3);
                $scope.day_of_week.push($scope.day_of_week_4);
                $scope.day_of_week.push($scope.day_of_week_5);
                $scope.day_of_week.push($scope.day_of_week_6);
                $scope.day_of_week.push($scope.day_of_week_7);

                console.log($scope.day_of_week);

            });

        }

        // ==============================================================================


        // object to hold all the data for the recipes

        $scope.recipes = {};

        loadrecipes();

        function loadrecipes(){

            //Fetch all Recipes for LoggedIn user's household.
            Recipes.get()
                .success(function(data) {
                    $scope.recipes = data.data;
            });
        }

        // ==============================================================================

        $scope.Slotes = ["Breakfast","Lunch","Dinner"];

        $scope.Days = [ 

                        {id:"1",name:"Sunday"},
                        {id:"2",name:"Monday"},
                        {id:"3",name:"Tuesday"},
                        {id:"4",name:"Wednesday"},
                        {id:"5",name:"Thursday"},
                        {id:"6",name:"Friday"},
                        {id:"7",name:"Saturday"}

                      ];  

        // ==============================================================================

        function loadMeal(){

             $scope.meal_array = [];

             $scope.meal_array.day_of_week = '';

             $scope.meal_array.slot = '';

             $scope.meal_array.recipe_id = [];

        }

        loadMeal();
       
        // ==============================================================================

        function new_recipe(){

            var new_Recipe = {};

            new_Recipe.recipe_id = '';

            return new_Recipe;

        }

        // ==============================================================================

        $scope.init = function() {

            for(i=0;i<1;i++){

                $scope.meal_array.recipe_id.push(new_recipe());

            }

        };

        $scope.init();

        // ==============================================================================

        $scope.addNewMealRecipe = function(){

            $scope.meal_array.recipe_id.push(new_recipe());

        };

        // ==============================================================================

        $scope.removeMealRecipe = function(recipe){

            $scope.meal_array.recipe_id.pop(recipe);

        };

        // ==============================================================================

        // add Recipe to database

        $scope.addMeal = function (form){

            $scope.submitted = true;

            if(form.$valid && $scope.meal_array.recipe_id.length !== 0) {

                console.log("done");

                console.log($scope.meal_array);

                // Meals.save($scope.meal_array)
                //     .success(function(response){                     
                //        loadMeal();
                //        $scope.init();
                //        $scope.submitted = false;
                // });

            }

            else if($scope.meal_array.recipe_id.length === 0){
                $scope.error_msg = true;
            }

        };

        // ==============================================================================



        // $scope.today = function() {
        //     $scope.dt = new Date();
        // };
        // $scope.today();

        // ==============================================================================

        // $scope.toggleMin = function() {
        //     $scope.minDate = new Date();
        // };
        // $scope.toggleMin();

        // ==============================================================================

        // $scope.open = function($event) {
        //     $event.preventDefault();
        //     $event.stopPropagation();

        //     $scope.opened = true;
        // };

    });