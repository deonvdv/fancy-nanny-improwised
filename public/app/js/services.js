angular.module('myApp')
    .factory('Authenticate', function($resource){
        return $resource("/api/v1/authenticate/")
    })
    .factory('Households', function($http) {
        return {
            getAll : function() {
                return $http.get('/api/v1/household');
            },
            get : function(id) {
                return $http.get('/api/v1/household/' + id);
            },
            getDocuments : function(id) {
                return $http.get('/api/v1/household/' + id + '/documents');
            },
            getMessages : function(id) {
                return $http.get('/api/v1/household/' + id + '/messages');
            },
            getTags : function(id) {
                return $http.get('/api/v1/household/' + id + '/tags');
            },
            getMembers : function(id) {
                return $http.get('/api/v1/household/' + id + '/members');
            },
            getMeals : function(id) {
                return $http.get('/api/v1/household/' + id + '/meals');
            },
            getRecipes : function(id) {
                return $http.get('/api/v1/household/' + id + '/recipes');
            },
            getTodayMeals : function(id) {
                return $http.get('/api/v1/household/' + id + '/todaymeals');
            },
            getEvents : function(id) {
                return $http.get('/api/v1/household/' + id + '/events');
            },
            getTodos : function(id) {
                return $http.get('/api/v1/household/' + id + '/todos');
            },
            getNotifications : function(id) {
                return $http.get('/api/v1/household/' + id + '/notifications');
            },
            show : function(id) {
                return $http.get('/api/v1/household/' + id);
            },
            save : function(householdData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/household',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(householdData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/household/' + id);
            }
        }
    })
    .factory('Users', function($http) {
        return {
            getUpcomingEvents : function(id) {
                return $http.get('/api/v1/user/' + id + '/upcoming_events');
            },
            getTags : function(id) {
                return $http.get('/api/v1/user/' + id + '/tags');
            },
            getPictures : function(id) {
                return $http.get('/api/v1/user/' + id + '/pictures');
            },
            getRecipes : function(id) {
                return $http.get('/api/v1/user/' + id + '/recipes');
            },
            getFavoriteRecipes : function(id) {
                return $http.get('/api/v1/user/' + id + '/favorite_recipes');
            },
            show : function(id) {
                return $http.get('/api/v1/user/' + id);
            },
            save : function(userData) {
                if('id' in userData){
                    return $http({
                        method: 'PUT',
                        url: '/api/v1/user/'+ userData.id,
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(userData)
                    });
                } else {
                    return $http({
                        method: 'POST',
                        url: '/api/v1/user',
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(userData)
                    });
                }
            },
            destroy : function(id) {
                return $http.delete('/api/v1/user/' + id);
            }
        }
    })
    .factory('Messages', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/message');
            },
            getUnread : function(id) {
                return $http.get('/api/v1/message/' + id + '/unread')
            },
            getReceived : function(id) {
                return $http.get('/api/v1/message/' + id + '/received')
            },
            getSent : function(id) {
                return $http.get('/api/v1/message/' + id + '/sent')
            },            
            show : function(id) {
                return $http.get('/api/v1/message/' + id);
            },
            save : function(messageData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/message',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(messageData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/message/' + id);
            }
        }
    })
    .factory('Categories', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/category');
            },
            show : function(id) {
                return $http.get('/api/v1/category/' + id);
            },
            save : function(categoryData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/category',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(categoryData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/category/' + id);
            }
        }
    })
    .factory('Tags', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/tag');
            },
            show : function(id) {
                return $http.get('/api/v1/tag/' + id);
            },
            save : function(tagData){
                if('id' in tagData) {
                     return $http({
                        method: 'PUT',
                        url: '/api/v1/tag/'+ tagData.id,
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(tagData)
                    });
                } else {
                    return $http({
                        method: 'POST',
                        url: '/api/v1/tag',
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(tagData)
                    });
                }
            },
            destroy : function(id) {
                return $http.delete('/api/v1/tag/' + id);
            }
        }
    })
    .factory('UnitOfMeasures', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/unit_of_measure');
            },
            show : function(id) {
                return $http.get('/api/v1/unit_of_measure/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/unit_of_measure',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/unit_of_measure/' + id);
            }
        }
    })
    .factory('Ingredients', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/ingredient');
            },
            show : function(id) {
                return $http.get('/api/v1/ingredient/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/ingredient',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/ingredient/' + id);
            }
        }
    })

    .factory('RecipeIngredients', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/recipe_ingredient');
            },
            show : function(id) {
                return $http.get('/api/v1/recipe_ingredient/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe_ingredient',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/recipe_ingredient/' + id);
            }
        }
    })
    
    .factory('Recipes', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/recipe');
            },
            getIngredients : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/recipe_ingredients');
            },
            getPictures : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/pictures');
            },
            getCategories : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/categories');
            },
            getTags : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/tags');
            },
            getReviews : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/reviews');
            },
            show : function(id) {
                return $http.get('/api/v1/recipe/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/recipe/' + id);
            }
        }
    })
    
    .factory('RecipeReviews', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/recipe_review');
            },
            show : function(id) {
                return $http.get('/api/v1/recipe_review/' + id);
            },
            save : function(recipeReviewData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe_review',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(recipeReviewData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/recipe_review/' + id);
            }
        }
    })
    .factory('Meals', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/meal');
            },
            show : function(id) {
                return $http.get('/api/v1/meal/' + id);
            },
            save : function(mealData) {
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
    })
    .factory('Events', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/event');
            },
            getAttendees : function(id) {
                return $http.get('/api/v1/event/' + id + '/attendees');
            },
            getTags : function(id) {
                return $http.get('/api/v1/event/' + id + '/tags');
            },
            show : function(id) {
                return $http.get('/api/v1/event/' + id);
            },
            save : function(eventData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/event',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(eventData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/event/' + id);
            }
        }
    })
    .factory('Todos', function($http) {
        return {
            get : function(id) {
                return $http.get('/api/v1/todo/' + id + '/assigned');
            },
            getAssignedTo : function(id) {
                return $http.get('/api/v1/todo/' + id + '/assignedto');
            },
            getCompleted : function(id) {
                return $http.get('/api/v1/todo/' + id + '/completed');
            },                     
            getTags : function(id) {
                return $http.get('/api/v1/todo/' + id + '/tags');
            },
            show : function(id) {
                return $http.get('/api/v1/todo/' + id);
            },
            save : function(todoData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/todo',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(todoData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/todo/' + id);
            }
        }
    })    
    .factory('Documents', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/document');
            },            
            show : function(id) {
                return $http.get('/api/v1/document/' + id);
            },
            save : function(documentData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/document',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(documentData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/document/' + id);
            }
        }
    })
    .factory('Pictures', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/picture');
            },            
            show : function(id) {
                return $http.get('/api/v1/picture/' + id);
            },
            save : function(pictureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/picture',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(pictureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/picture/' + id);
            }
        }
    })
    .factory('Notifications', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/notification');
            },            
            show : function(id) {
                return $http.get('/api/v1/notification/' + id);
            },
            save : function(notificationData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/notification',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(notificationData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/notification/' + id);
            }
        }
    })
    .factory('Flash', function($rootScope){
        return {
            show: function(message){
                $rootScope.flash = message
            },
            clear: function(){
                $rootScope.flash = ""
            }
        }
    });