'use strict';

/* App Module */

var generator = angular.module('gApp', [
    'ngRoute',
    'ngAnimate',
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
            case '2':
                ret = '\u25D4';
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

gController.controller('bodyStyleCtrl', ['$scope', 'Params',
    function($scope, Params) {
        
        $scope.params = Params;
        
        $scope.bodyClass = 'light';
        
        $scope.userDisplay = false;
        
    }
]);

gController.controller('KpListCtrl', ['$scope', 'Kp',
    function($scope, Kp) {
       
        $scope.rowList = $scope.params.rowList;
        
        $scope.kpList = Kp.query();

        $scope.orderProp = false;

        $scope.setOrder = function(field)
        {
            $scope.orderProp = field;
            $scope.reverse = $scope.reverse ? false : true;
        };
    }
]);

gController.controller('KpOneCtrl', ['$scope', '$routeParams', 'Kp',
    function($scope, $routeParams, Kp) {
        $scope.kp = Kp.get({kpid: 'one', id: $routeParams.id});
        
    }
]);

gController.directive('pWindow', function() {
    return {
        restrict: 'EC',
        replace: true,
        transclude: true,
        scope: 
        {
            pwtitle: '@'
        },
        templateUrl: "/tmpl?dir=default&f=pWindow",
        link: function(scope, element, attrs) 
        {
            var title = angular.element(element.children()[0]),
                opened = true;
                
            title.bind('click', toggle);

            function toggle() {
                opened = !opened;
                element.removeClass(opened ? 'closed' : 'opened');
                element.addClass(opened ? 'opened' : 'closed');
            }
        }
    };
});
gController.directive('pPanel', function() {
    return {
        restrict: 'C',
        replace: true,
        transclude: true,
        templateUrl: "/tmpl?dir=default&f=panel",
        scope: 
        {
            position: '@'
        },
        link: function(scope, element, attrs) 
        {
            var childrens = angular.element(element.children()),
                item;
            for(item in childrens)
            {
                console.log(item);
            }
//            var handle;
//            switch(scope.position)
//            {
//                case 'left':
//                    handle = 'e';
//                break;
//                case 'right':
//                    handle = 'w';
//                break;
//            }
//            if(scope.position!=='center'){
//                
//                $(function() {
//                    element.resizable({
//                           handles: handle,
//                           maxWidth: 450,
//                           minWidth: 200,
//                           distance: 10
//                    });
//                });
//            }
        }
    };
});

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
gService.factory('Params', ['$resource',
    function($resource) {
        return $resource('/js/params.json', {}).get();
    }
]);

