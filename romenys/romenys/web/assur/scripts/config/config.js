'use strict';

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'web/assur/templates/default.html',
            controller: 'DefaultController'
        })
        .when('/form', {
            templateUrl: 'web/assur/templates/form.html',
            controller: 'formController'
        })
        .when('/client/new', {
            templateUrl: 'web/assur/templates/new-user.html',
            controller: 'UserController'
        })
        .when('/clients', {
            templateUrl: 'web/assur/templates/users.html',
            controller: 'UserListController'
        })
        .when('/client/:id', {
            templateUrl: 'web/assur/templates/user-show.html',
            controller: 'UserShowController'
        })
        .when('/client/:id/modify', {
            templateUrl: 'web/assur/templates/modify.html',
            controller: 'modifyController'
        })
        .when('/client/:id/modify/assurances', {
            templateUrl: 'web/assur/templates/assurances.html',
            controller: 'assurancesController'
        })
        .when('/client/:clientid/car:carid/assurances', {
            templateUrl: 'web/assur/templates/carassurances.html',
            controller: 'carAssurShowController'
        })
    ;
});
