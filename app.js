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
    
    $scope.formData = {};
    $scope.status = '';
    $scope.data = {};
    $scope.answer = '';
    
    $scope.GeneratePassword = function() {
        console.log('generating');
        
        $http.post('generate.php',$scope.formData)
        .success(function(data, status, headers, config) {
            $scope.data = data;
            $scope.answer = data.answer;
            console.log('success: ' + data);
        }).error(function(data, status, headers, config) {
            $scope.status = status;
            console.log('failure: ' + status);
        });
       //$scope.go('/generate');
    }
    
}]);

    /*$http({
        url: "generate.php",
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: $.param({num:app.num, breakage:app.breakage, case:app.case, number:app.number, specialSymbol:app.specialsymbol})
            // data: {'num':$scope.formData.num, 'breakage':$scope.formData.breakage, 'case':$scope.formData.case, 'number':$scope.formData.number, 'specialSymbol':$scope.formData.specialsymbol}        
    }).success(function(data, status, headers, config) {
        $scope.data = data;
    }).error(function(data, status, headers, config) {
        $scope.status = status;
    });*/
