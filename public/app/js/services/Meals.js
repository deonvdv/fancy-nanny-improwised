angular.module('myApp')
    
    .factory('Meals', function($http) {
        return {
            get : function() {

                var meals;

                var day_of_week = [];

                var day_of_week_1 = [];
                day_of_week_1.day = "Sunday";

                var day_of_week_2 = [];
                day_of_week_2.day = "Monday";

                var day_of_week_3 = [];
                day_of_week_3.day = "Tuesday";

                var day_of_week_4 = [];
                day_of_week_4.day = "Wednesday";

                var day_of_week_5 = [];
                day_of_week_5.day = "Thursday";

                var day_of_week_6 = [];
                day_of_week_6.day = "Friday";

                var day_of_week_7 = [];
                day_of_week_7.day = "Saturday";

                $http.get('/api/v1/meal').success(function(data){

                    meals = data.data;

                    // console.log(meals);

                    // console.log(meals.length);

                    for(i=0;i<meals.length;i++) {

                        if(meals[i].day_of_week === 1){
                            day_of_week_1.push(meals[i]);
                        }
                        else if(meals[i].day_of_week === 2){
                            day_of_week_2.push(meals[i]);
                        }
                        else if(meals[i].day_of_week === 3){
                            day_of_week_3.push(meals[i]);
                        }
                        else if(meals[i].day_of_week === 4){
                            day_of_week_4.push(meals[i]);
                        }
                        else if(meals[i].day_of_week === 5){
                            day_of_week_5.push(meals[i]);
                        }
                        else if(meals[i].day_of_week === 6){
                            day_of_week_6.push(meals[i]);
                        }
                        else if(meals[i].day_of_week === 7){
                            day_of_week_7.push(meals[i]);
                        }

                    }

                });

                day_of_week.push(day_of_week_1);
                day_of_week.push(day_of_week_2);
                day_of_week.push(day_of_week_3);
                day_of_week.push(day_of_week_4);
                day_of_week.push(day_of_week_5);
                day_of_week.push(day_of_week_6);
                day_of_week.push(day_of_week_7);

                return day_of_week;

            },
            show : function(id) {
                return $http.get('/api/v1/meal/' + id);
            },
            save : function(mealData) {
                console.log( mealData);
                return $http({
                        method: 'POST',
                        url: '/api/v1/meal',
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(mealData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/meal/' + id);
            }
        }
    });