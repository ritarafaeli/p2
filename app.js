var myApp = angular.module('myApp', ['ngRoute']);


myApp.config( function ($routeProvider){
    
    $routeProvider.when('/generate', {
        templateUrl: 'generate.php',
        controller: 'mainController'
    });
});


myApp.controller('mainController', ['$scope', '$location', '$log', '$routeParams', '$http', function($scope, $location, $log, $routeParams, $http) {
    
    $scope.num = $routeParams.num;
    
    $scope.go = function ( hash ) {
        $location.path( hash );
    };
    
    $scope.formData = {
        case: 'default',
        breakage: 'spaces',
        num: 3,
        words: {}
    };
    $scope.status = '';
    $scope.data;
    $scope.words;
    
    $scope.showErrorOnNumberInput = function() {
        return  $scope.formData.num>9 || $scope.formData.num<3;
    }
    
    $scope.scrapeWords = function() {
        console.log('scraping words');
        
        $http.post('scrape.php','')
        .success(function(data, status, headers, config) {
            $scope.formData.words = data;          
            console.log('success: ' + $scope.formData.words);
        }).error(function(data, status, headers, config) {
            $scope.status = status;
            console.log('failure: ' + status);
        });
    }
    
    
    $scope.GeneratePassword = function() {
        console.log('generating');
        
        $http.post('generate.php',$scope.formData)
        .success(function(data, status, headers, config) {
            $scope.data = data;            
            console.log('success: ' + $scope.data);
        }).error(function(data, status, headers, config) {
            $scope.status = status;
            console.log('failure: ' + status);
        });
    }
    
}]);
