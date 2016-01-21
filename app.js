var myApp = angular.module('myApp', ['ngRoute']);

myApp.config( function ($routeProvider){
    
    $routeProvider.when('/generate', {
        templateUrl: 'generate.php',
        controller: 'mainController'
    });
});


myApp.controller('mainController', ['$scope', '$location', '$log', '$routeParams', function($scope, $location, $log, $routeParams) {
    
    $scope.num = $routeParams.num;
    
    $scope.go = function ( hash ) {
        $location.path( hash );
    };
    
}]);
