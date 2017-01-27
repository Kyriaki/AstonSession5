'use script';

var app = angular.module('app',
    ['ngRoute', 'ngSanitize', 'ngFileUpload'],
    function($httpProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    }
);

app.controller('DefaultController', ['$http', '$scope', '$location', function ($http, $scope, $location) {
    console.log('DefaultController');

    this.default = $http({
        method: 'GET',
        url: '/app.php?route=default'
    });

    $scope.client = {
        name: ''
    };

    $scope.modify = function (client){
            $location.path("/client/" + $scope.client.name + "/modify");
    }
}]);

app.controller('UserShowController', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {
    console.log('UserShowController');
    console.log($routeParams);

    $http.get('/app.php?route=user_show&id=' + $routeParams.id)
        .then(function (response) {
            $scope.client = response.data.client;
            $scope.car = response.data.clientCar;
        }, function (response) {
            console.log(response.status);
        });

    $http.get('/app.php?route=user_show2&id=' + $routeParams.id)
        .then(function (response) {
            $scope.clientAssurs = response.data.clientAssurs;
            console.log($scope.clientAssurs);
        }, function (response) {
            console.log(response.status);
        });
}]);

app.controller('UserController', ['$scope', '$http', 'Upload', function ($scope, $http, Upload) {
    console.log('UserController');

    $scope.client = {
        name: 'test Test',
        email: 'test@mail.com'
    };

    $scope.submit = function (client) {

            Upload.upload({
                url: '/app.php?route=user_new',
                data: {client: client}
            })
                .then(function (response) {
                    console.log(response);
                }, function (response) {
                    console.log('Error status: ' + response.status);
                }, function (evt) {
                    console.log(evt);
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                });
    };
}]);

app.controller('UserListController', ['$scope', '$http', function ($scope, $http) {
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    console.log('UserListController');

    $scope.clients = {};

    $http.get('/app.php?route=user_list')
        .then(function (response) {
            $scope.clients = response.data.clients;
        }, function (response) {
            console.log(response.status);
        });
}]);

app.controller('modifyController', ['$scope', '$http', '$routeParams',function ($scope, $http, $routeParams) {
    console.log('modifyController');
    console.log($routeParams);
        
    $http.get('/app.php?route=modify&id=' + $routeParams.id)
        .then(function (response) {
            $scope.id = $routeParams.id;
            $scope.client = response.data.client;
            $scope.assur = response.data.clientAssur;
            console.log($scope.assur);
        }, function (response) {
            console.log(response.status);
        });

    $scope.submit = function (client){
        $http.post('app.php?route=modify&id=' + $routeParams.id, client)
        .then(function (response) {
            console.log($scope.client);
        }, function (response) {
            console.log(response.status);
        });
    }
}]);

app.controller('assurancesController', ['$scope', '$http', '$routeParams',function ($scope, $http, $routeParams) {
    console.log('assurancesController');
    console.log($routeParams);
    $scope.assurs= {};
    $scope.assurAdded = {};
        
    $http.get('/app.php?route=modify_assur&id=' + $routeParams.id)

        .then(function (response) {
            $scope.id = $routeParams.id;
            $scope.client = response.data.client;
        }, function (response) {
            console.log(response.status);
        });

    $http.get('/app.php?route=modify_assur2&id=' + $routeParams.id)

        .then(function (response) {
            $scope.assurs = response.data.assurs;
        }, function (response) {
            console.log(response.status);
        });

    $http.get('/app.php?route=modify_assur3&id=' + $routeParams.id)

        .then(function (response) {
            $scope.clientAssurs = response.data.clientAssurs;
        }, function (response) {
            console.log(response.status);
        });

    $scope.submit = function (assurAdded){
        $http.post('app.php?route=modify_assur2&id=' + $routeParams.id, assurAdded)
        .then(function (response) {
            console.log($scope.assurAdded);
        }, function (response) {
            console.log(response.status);
        });
    }         
}]);

app.controller('carAssurShowController', ['$scope', '$http', '$routeParams',function ($scope, $http, $routeParams) {
    console.log('carAssurShowController');
    console.log($routeParams);
        
    $http.get('/app.php?route=assur_show&clientid=' + $routeParams.clientid + '&carid=' + $routeParams.carid)
        .then(function (response) {
            $scope.assur = response.data.assur;
        }, function (response) {
            console.log(response.status);
        });
}]);

app.controller('formController', ['$scope', '$http', 'Upload', function ($scope, $http, Upload) {
    console.log('formController');

    $scope.client = {
        name: 'test',
        email: 'test'
    };

    // upload on file select or drop
    $scope.submit = function (client){
        Upload.upload({
            url: '/app.php?route=form',
            data: {file: client.file, client: client}
        })
        .then(function (response){
            console.log(response);
            console.log('Success ' + response.config.data.client.name + 'uploaded. Response: ' + response.data);
        }, function (response) {
            console.log('Error status: ' + response.status);
        });
    };

 



}]);
