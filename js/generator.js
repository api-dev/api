'use strict';

/* App Module */

var generator = angular.module('gApp', [
    'ngRoute',
    'gBody',
    'gFilters',
    'gService'
]);

generator.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
                when('/list', {
                    templateUrl: '/tmpl?dir=default&f=list',
                    controller: 'KpListCtrl'
                }).
                when('/list/:id', {
                    templateUrl: '/tmpl?dir=default&f=edit',
                    controller: 'KpOneCtrl'
                }).
                otherwise({
                    redirectTo: '/list/'
                });
    }]);

/* Filtres */
var gFilter = angular.module('gFilters', []);

gFilter.filter('checkmark', function() {
    return function(input) {
        var ret;
        switch (input) {
            case '1':
                ret = '\u2713';
                break;
            default :
                ret = '\u2715';
                break;
        }
        return ret;
    };
});

gFilter.filter('normalDate', function($filter) {
    return function(text) {
        var date_r = new Date(text.replace(' ', 'T'));
        return $filter('date')(date_r, "dd.MM.yyyy hh:mm");
    };
});


/* Controllers */
var gController = angular.module('gBody', []);

gController.controller('bodyStyleCtrl', ['$scope',
    function($scope) {
        $scope.bodyClass = 'light';
    }
]);

gController.controller('KpListCtrl', ['$scope', 'Kp',
    function($scope, Kp) {
        $scope.rowList = [
            {val: 'name', label: 'Название'},
            {val: 'status', label: 'Статус'},
            {val: 'date_status', label: 'Дата публикации'},
            {val: 'date_finish', label: 'Дата окончания'},
            {val: 'auditor_status', label: 'Согл.'},
            {val: 'auditor_date_status', label : 'Аудит'},
            {val: 'date_create', label: 'Дата создания'},
            {val: 'date_edit', label: 'Дата редактирования'}
        ];
        console.log($scope.rowList);
        $scope.kpList = Kp.query();
        
        $scope.orderProp = false;
        
        $scope.setOrder = function(field)
        {
            $scope.orderProp = field;
            $scope.reverse = $scope.reverse ? false : true;
        };
    }
]);

//gController.controller('KpOneCtrl', ['$scope', '$routeParams', '$http',
//    function($scope, $routeParams, $http) {
//        $http.get('/generator/one?id=' + $routeParams.id).success(function(data) {
//            $scope.kp = data;
//        });
//    }
//]);
gController.controller('KpOneCtrl', ['$scope', '$routeParams', 'Kp',
    function($scope, $routeParams, Kp) {
        $scope.kp = Kp.get({kpid: 'one', id: $routeParams.id});
    }
]);

/* Services */
var gService = angular.module('gService', ['ngResource']);

gService.factory('Kp', ['$resource',
    function($resource) {
        var returns = $resource('/generator/:kpid', {}, {
            query: {method: 'GET', params: {kpid: 'list'}, isArray: true}
        });
        return returns; 
    }
]);

