'use strict';

var generator = angular.module('gApp', [
    'ngRoute',
    'ngAnimate',
    'gBody',
    'gFilters',
    'gService',
    'ngSanitize'
]);
generator.config(['$routeProvider',
    function ($routeProvider) {
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

gFilter.filter('checkmark', function () {
    return function (input) {
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

gFilter.filter('normalDate', function ($filter) {
    return function (text) {
        var date_r = new Date(text.replace(' ', 'T'));
        return $filter('date')(date_r, "dd.MM.yyyy hh:mm");
    };
});


/* Controllers */
var gController = angular.module('gBody', []);

//angular.module('css', [], function($cssProvider) {
//    $cssProvider.directive('css', function($css) {
//        return function(scope, element, attrs) {
//            scope.$watch(
//                function (scope) {
//                    return scope.$eval(attrs.link);
//                },
//                function (value) {
//                    console.log(value[attrs.key]);
//                    element.val(value[attrs.key]);
//
//                    $css(element.val())(scope);
//                }
//            );
//        };
//    })
//});

gController.controller('bodyStyleCtrl', ['$scope', 'Params',
    function ($scope, Params) {

        $scope.params = Params;

        $scope.bodyClass = 'light';

        $scope.userDisplay = false;

    }
]);

gController.controller('KpListCtrl', ['$scope', 'Kp',
    function ($scope, Kp) {

        $scope.rowList = $scope.params.rowList;

        $scope.kpList = Kp.query();

        $scope.orderProp = false;

        $scope.setOrder = function (field) {
            $scope.orderProp = field;
            $scope.reverse = $scope.reverse ? false : true;
        };
    }
]);

gController.controller('KpOneCtrl', ['$scope', '$routeParams', 'Kp', '$http', '$sce',
    function ($scope, $routeParams, Kp, $http, $sce) {
        $scope.kp = false;
        $scope.html = false;
        $http.get('/generator/one?id=' + $routeParams.id).success(function (data) {
            $scope.kp = data;
            $scope.kp.json = JSON.parse(data.json);
            angular.element('#eeditor').append($scope.parseFromJson($scope.kp.json, 'kp.json'));
//            console.log($scope.kp.json);
        });

        $scope.index = 0;

        $scope.activeTool = 0;
        $scope.activeCss = {};

        $scope.setActiveTool = function (key) {
            $scope.activeTool = key;
        };

        $scope.parseFromJson = function (data, root, parent) {
            var item, returned = parent;

            if (!parent)
                returned = angular.element('<div class="editor-wrapper"></div>');

            if (data === 'undefined')
                return false;

            if (typeof data !== "object")
                data = JSON.parse(data);

            for (item in data) {
                var elem, tag = '';
                switch (data[item].type) {
                    case "img":
                        tag = '<img >';
                        break;
                    case "string":
                        tag = '<elem></elem>';
                        break;
                    default:
                        tag = '<div elem class="elem ' + data[item].type + '" type="' + data[item].type + '"></div>';
                        break;
                }
                elem = angular.element(tag);
                elem.css(data[item].style);
                elem.attr('uid', data[item].id);
                elem.attr('ulink', root + '[' + item + ']');
                elem.attr("data-ng-model", root + '[' + item + ']');
                elem.attr("loool", '{{kp.json[0].content[0].style.background}}');
                if (typeof data[item].content === "object") {
                    elem = $scope.parseFromJson(data[item].content, root + '[' + item + '].content', elem);
                } else {
                    elem.html(data[item].content);
                }
                elem.click(function (e) {
                    $scope.onClickEvent(e);
                    return false;
                });
                returned.append(elem);
            }
            return returned;
        };
        $scope.moveElem = function (drop, drag, droplink, draglink) {

            var _self = this,
                parentId,
                childId = drag.elem.id;

            if(drop.elem)
                parentId = drop.elem.id;
            else
                parentId = drop.page.id;

            this.init = function(){
                var parent, child,
                    item, nItem = {},
                    dragIndex = draglink.slice( (draglink.lastIndexOf('[')+1), draglink.length-1),
                    dragParent = draglink.slice(0, draglink.lastIndexOf('['));

                console.log(dragIndex);
                console.log(dragParent);
                parent = $scope.$eval(droplink);
                child = $scope.$eval(draglink);


                for(item in child)
                {
                    nItem[item] = child[item];
                }
                var p = eval('$scope.'+dragParent);
                p.splice(dragIndex, 1);
//                eval('delete $scope.'+draglink);
                parent.content.push(nItem);
                $scope.$apply();
            }

            this.setElem = function()
            {

            }
            return _self.init();
        }
        $scope.onClickEvent = function (elem) {

            if (!elem)
                return false;

            var params = $scope.params.pwindow.items.data,
                activeTool = params[$scope.activeTool],
                target = elem.target,
                ulink = target.getAttribute('ulink'),
                // Стремная реализация, eval() нужно бы заменить
                activeCss = $scope.$eval(ulink);

            switch (activeTool.type) {
                case 'select':
                    $scope.activeCss = activeCss;
                    $scope.$apply();
                    break;
                case 'move':
                    if(activeCss.type!=='page'){
                        var drop = $(target);
                        drop.draggable({
                            stop: function(event, ui) {
                                drop.draggable("destroy");
                            }
                        });
                    }
                    break;
            }
            return false;
        };
    }
]);


gController.directive('page', function ($compile) {
    return {
        restrict: 'E',
        replace: true,
        transclude: true,
        scope: {
            content: '=',
            link: '@'
        },
        template: '<div class="pages" page="{{content.id}}" ulink="kp.json[{{link}}]">' +
            '<elem ng-repeat="(ind, elem) in content.content" content="elem" link="kp.json[{{link}}].content[{{ind}}]" ng-style="elem.style"></elem>' +
            '</div>',
        link: function (scope, element, attrs, controller) {
            var _scope = element.scope();
            element.on('click', function(e){
                _scope.onClickEvent(e);
            });
            element.droppable({
                greedy: true,
                tolerance: "pointer",
                hoverClass: "ui-hover-elem",
                drop: function(event, ui){
                    controller.eventDrop(event, ui, $(this));
                    return false;
                }
            });
        },
        controller: function($scope, $element, $attrs, $transclude){
            var _self = this,
                _scope = $element.scope();

            this.eventDrop = function(event, ui, e){
                var dropElem = e.inheritedData().$scope,
                    dragElem = ui.draggable.inheritedData().$scope,
                    dropLink = e.attr('ulink'),
                    dragLink = ui.draggable.attr('ulink');

                _scope.moveElem(dropElem, dragElem, dropLink, dragLink);

                return false;
            }
        }
    };
});

gController.directive('elem', function ($compile) {
    return {
        restrict: 'E',
        replace: true,
        transclude: true,
        scope: {
            content: '=',
            link: '@'
        },
        require: '^page',
        template: function (elem, attrs) {
            return '<span ulink="{{link}}" uid="{{content.id}}">{{content.content}}</span>';
        },
        link: function (scope, element, attrs, parentCtrl) {

            if(!scope.content)
                return false;

            switch (scope.content.type) {
                case 'string':
//                        element = angular.element('<span></span>');
//                    element.html(scope.content.content);
                    break;
                case 'img':
//                        element = angular.element('<img>');
                    break;
                default:
                    element.droppable({
                        greedy: true,
                        tolerance: "pointer",
                        hoverClass: "ui-hover-elem",
                        drop: function(event, ui){
                            parentCtrl.eventDrop(event, ui, $(this));
                            return false;
                        }
                    })
                    break;
            }
            element.addClass(scope.content.type);

            if (angular.isArray(scope.content.content)) {
                var ind = scope.content.id;
                element.html('<elem ng-repeat="(i, elem) in content.content" content="elem" link="{{link}}.content[{{i}}]" ng-style="elem.style"></elem>');
                $compile(element.contents())(scope);
            }
            return false;
        }
    };
});

gController.directive('pWindow', function () {
    return {
        restrict: 'EC',
        replace: true,
        transclude: true,
        scope: {
            pwtitle: '@'
        },
        templateUrl: "/tmpl?dir=default&f=pWindow",
        link: function (scope, element, attrs) {
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

gController.directive('pPanel', function () {
    return {
        restrict: 'C',
        replace: true,
        transclude: true,
        templateUrl: "/tmpl?dir=default&f=panel",
        scope: {
            position: '@'
        },
        link: function (scope, element, attrs) {
            var childrens = $(element.children()), item;
            for (item in childrens) {
                if (typeof childrens[item] === "object") {
                    var elem, position;
                    elem = $(childrens[item]);
                    position = elem.attr("position");
                    elem.addClass(position);
                }
            }
        }
    };
});

/* Services */
var gService = angular.module('gService', ['ngResource']);

gService.factory('Kp', ['$resource',
    function ($resource) {
        var returns = $resource('/generator/:kpid', {}, {
            query: {method: 'GET', params: {kpid: 'list'}, isArray: true}
        });
        return returns;
    }
]);
gService.factory('Params', ['$resource',
    function ($resource) {
        return $resource('/js/params.json', {}).get();
    }
]);

