'use strict';

var generator = angular.module('gApp', [
    'ngRoute',
    'ngAnimate',
    'gBody',
    'gFilters',
    'gService',
    'ngSanitize',
    'ui.date'
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
//                ret = '\u25D4';
                ret = '\u2298';
                break;
            default :
                ret = '\u2298';
                break;
        }
        return ret;
    };
});

gFilter.filter('normalDate', function($filter) {
    return function(text) {
        if (text)
        {
           var date_r = new Date(text.replace(' ', 'T'));
           return $filter('date')(date_r, "dd.MM.yyyy HH:mm");
        } else {
            return 'Нет даты';
        }

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

gController.controller('KpListCtrl', ['$scope', '$location', 'Kp',
    function($scope, $location, Kp) {


        $scope.rowList = $scope.params.rowList;

        $scope.kpList = Kp.findAll();

        $scope.orderProp = false;

        $scope.create = function()
        {
            Kp.createKp();
        }
        $scope.delete = function(id)
        {
            Kp.deleteKp(id);
        }

        $scope.trash = function(id, index)
        {
            if (Kp.trashKp(id))
            {
                $scope.kpList.splice(index, 1);
            }
        }

        $scope.setOrder = function(field) {
            $scope.orderProp = field;
            $scope.reverse = $scope.reverse ? false : true;
        };
    }
]);

gController.controller('KpOneCtrl', ['$scope', '$routeParams', 'Kp', '$http', '$sce', '$location',
    function($scope, $routeParams, Kp, $http, $sce, $location) {

        $scope.dateOptions = {
            changeYear: true,
            changeMonth: true,
            dateFormat: 'yy-mm-dd'
        };

        $scope.print = true;
        
        $scope.edit=false;
        
        $scope.cl=false;
        
        $scope.style_p="active";
        
        $scope.style_e="";
        
        $scope.showPopUpSave = false;
        $scope.showPopUpClose = false;
        $scope.showPopUpDel=false;
        
        $scope.openPopUpSave = function() {
            $scope.showPopUpSave = true;
        }
        
        $scope.openPopUpClose = function() {
            $scope.showPopUpClose = true;
            
        }
        
        $scope.kp = Kp.findById($routeParams.id);

        $scope.save = function()
        {
            var save_success=false;
            save_success=Kp.saveKp($scope.kp, $routeParams.id);
            if (save_success){
                $scope.edit=false;
                $scope.openPopUpSave();  
            }
            
        }

        $scope.close = function()
        {
            //if($scope.edit){
                $scope.openPopUpClose();
            //}
            //$location.path('/list');
        }

        $scope.switch = function(key)
        {
            var html_code = "";
            if ($scope.print) {
                if (key === 'e') {
                    html_code = jsonToHTML($scope.kp.json);
                    $scope.kp.email = html_code;
                    $scope.codehtml = $sce.trustAsHtml($scope.kp.email);
                    console.log("html_code:" + html_code);
                    $scope.print = !$scope.print;
                }
            }
            else{
                if (key==='p'){
                  $scope.print = !$scope.print;  
                }
            }

        };

        $scope.cursorClass = 'default';
        $scope.index = 0;
        
        $scope.activeTool = 0;
        $scope.activeCss = {};
        $scope.index=0;
        
        
        $scope.findIndex=function(obj){
            if (obj.id>$scope.index){
                $scope.index=obj.id;
            }
            if ((Object.prototype.toString.call([obj.content]) === '[object Array]') && (typeof obj.content !== 'string') && (obj.content.length > 0)) {
                for (var i = 0; i < obj.content.length; i++) {
                    $scope.findIndex(obj.content[i]);
                }
            }
        };
        
        $scope.activeContentUrl = function() {
            var file = $scope.activeCss.type;

            if (file)
                return file + '.html';
            else
                return '/tmpl?dir=default&f=empty';
        };

        $scope.setActiveTool = function(key) {
            $scope.cursorClass = $scope.params.pwindow.tools.data[key].type;
            $scope.activeTool = key;
        };

        $scope.moveElem = function(drop, drag, droplink, draglink)
        {
            var _self = this;

            this.init = function()
            {
                var nItem = angular.copy($scope.$eval(draglink));

                if ($scope.addElem(nItem, droplink)) {
                    if ($scope.deleteElem(draglink)){
                        $scope.$apply();
                    }
                }
            }
            return _self.init();
        };
        
        $scope.deleteElem = function(link)
        {
            var elemIndex = link.slice((link.lastIndexOf('[') + 1), link.length - 1),
                    elemParent = link.slice(0, link.lastIndexOf('[')),
                    parent = $scope.$eval(elemParent);
                    $scope.edit=true;
            if (parent.splice(elemIndex, 1))
            {
                return true;
            }
            return false;
        };

        $scope.addElem = function(elem, parentLink)
        {
            var parent = $scope.$eval(parentLink);

            if (!parent || !parent.content || !elem) {
                console.log("Add FALED");
                return false;
            }

            if (parent.content.push(elem)) {
                
                $scope.$apply();
                return true;
            }
        };

        $scope.createElem = function(type, parentLink)
        {
            var target = $scope.getParentBlock(parentLink),
                    elem, json, params = $scope.params.pwindow.templates.data[type];

            if (!target)
                return false;

            elem = angular.copy(params);
            console.log($scope.kp.json);
            
            json=$scope.kp.json;
            for (var i = 0; i < json.length; i++) {
                $scope.findIndex(json[i]);
            }
            $scope.index++;
            elem.id = $scope.index;
            elem.title += elem.id;
            elem.link = target.link + '.content[' + target.content.length + ']';

            if (angular.isArray(elem.content)){
                $scope.setRecId(elem)
            };

            if (target.style.width && type === "block")
            {
                elem.style.width = (parseInt(target.style.width) - 20) + 'px';
            }
 
            if(type==="page") {
                $scope.kp.json.push(elem);
                $scope.$apply();
            } else if(target.content.push(elem)){
                $scope.$apply();
            }
            $scope.edit=true;
        }

        $scope.setRecId = function(elem)
        {
            var e;
            for (e in elem.content)
            {
                $scope.index++;
                elem.content[e].id = $scope.index;
                if (angular.isArray(elem.content[e].content))
                    $scope.setRecId(elem.content[e]);
            }
        }

        $scope.getParentBlock = function(link)
        {
            var target = $scope.$eval(link);

            if (target.type !== "block" && target.type !== "page")
                target = $scope.getParentBlock(link.slice(0, link.lastIndexOf('.')));

            return target;
        }

        $scope.activeLink = '';
        $scope.activeTarget = '';
        $scope.onClickEvent = function (elem)

        {
            if (!elem)
                return false;

            var params = $scope.params.pwindow.tools.data,
                    activeTool = params[$scope.activeTool],
                    target = elem.target,
                    ulink = target.getAttribute('ulink'),
                    // Стремная реализация, eval() нужно бы заменить
                    activeCss = $scope.$eval(ulink);

            
            switch (activeTool.type) {
                case 'select':
                    $scope.activeCss = activeCss;
                    $scope.activeLink = ulink;
                    $scope.$apply();
                    break;
                case 'move':
                    $('.ui-draggable').draggable("destroy");
                    if (activeCss.type !== 'page') {
                        var drag = $(target);
                        drag.draggable({
                            stop: function(event, ui) {
                                drag.draggable("destroy");
                            }
                        });
                    }
                    break;
                case 'delete':
                    if(activeCss.type !== "page"){
                        $scope.activeLink = ulink;
                        $scope.activeTarget = target;
                        if(activeCss.type !== "image"){
                            $(target).addClass('ui-delete-elem');
                        } else{
                            $(target).parent().addClass('ui-delete-elem');
                        }
                        $scope.$apply(function() {
                            $scope.showPopUpDel = true;
                        });
                    }
                    break;
                default:
                    $scope.createElem(activeTool.type, ulink);
                    break;
            }
            return false;
        };
    }
]);


gController.directive('page', function($compile) {
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
        link: function(scope, element, attrs, controller) {
            var _scope = element.scope();
            element.on('click', function(e) {
                _scope.onClickEvent(e);
            });
            element.droppable({
                greedy: true,
                tolerance: "pointer",
                hoverClass: "ui-hover-elem",
                drop: function(event, ui) {
                    controller.eventDrop(event, ui, $(this));
                    return false;
                }
            });
        },
        controller: function($scope, $element, $attrs, $transclude) {
            var _self = this,
                    _scope = $element.scope();

            this.eventDrop = function(event, ui, e) {
                var dropElem = e.inheritedData().$scope,
                        dragElem = ui.draggable.inheritedData().$scope,
                        dropLink = e.attr('ulink'),
                        dragLink = ui.draggable.attr('ulink');

                _scope.moveElem(dropElem, dragElem, dropLink, dragLink);
                $scope.edit=true;
                return false;
            }
        }
    };
});

gController.directive('elem', function($compile) {
    return {
        restrict: 'E',
        replace: true,
        transclude: true,
        scope: {
            content: '=',
            link: '@'
        },
        require: '^page',
        template: function(elem, attrs) {
            return '<span ulink="{{link}}" uid="{{content.id}}">{{content.content}}</span>';
        },
        link: function(scope, element, attrs, parentCtrl) {
          
            switch (scope.content.type) {
                case 'string':
                    element.html(angular.element('<span ulink="{{link}}" uid="{{content.id}}">{{content.content}}</span>'));
                    $compile(element.contents())(scope);
                    break;
                case 'image':
                    element.html(angular.element('<img ng-src="{{content.content.src}}" ' +
                            'alt="{{content.content.alt}}" title="{{content.content.title}}" ulink="{{link}}" uid="{{content.id}}"' +
                            'width="100%" height="100%" border="0">'));
                    $compile(element.contents())(scope);
                    break;
                case 'varible':

                    break;
                case 'page':
                    
                    break;
                default:
                    element.droppable({
                        greedy: true,
                        tolerance: "pointer",
                        hoverClass: "ui-hover-elem",
                        drop: function(event, ui) {
                            parentCtrl.eventDrop(event, ui, $(this));
                            return false;
                        }
                    })
                    break;
            }
            element.addClass(scope.content.type);

            if (angular.isArray(scope.content.content)) {
                element.html('<elem ng-repeat="(i, elem) in content.content" content="elem" link="{{link}}.content[{{i}}]" ng-style="elem.style"></elem>');
                $compile(element.contents())(scope);
            }
            
            return false;
        }
    };
});


gController.directive('treeitem', function($compile) {
    return {
        restrict: 'E',
        replace: true,
        transclude: true,
        scope: {
            content: '=',
            link: '@ulink',
            onDel: '&',
            level: '=',
            parent: '=',
            index: '=',
            edit:'@'
        },

        template: function (elem, attrs) {
            return  '<li ng-class="{active: activeLink == link}" link="{{link}}">' +
                        '<span class="icon"></span>'+
                        '<input ng-model="content.title" type="text">'+
                        '<span class="delete" title="Удалить элемент" ng-if="(index!==\'0\' && content.type!==\'page\')" ng-click="delete(parent, index);"></span>'+
                        '<span class="up" title="Переместить вверх" ng-click="moveUp(parent, index)" ng-if="showUp(parent, index)"></span>'+
                        '<span class="down" title="Переместить вниз" ng-click="moveDown(parent, index)" ng-if="showDown(parent, index)"></span>'+

                    '</li>';
        },
        link: function(scope, element, attrs, parentCtrl) {

            var input = angular.element(element.children()[1]);

            input.bind('focus', function() {
                input.addClass('focused');
            });
            input.bind('blur', function() {
                input.removeClass('focused')
            });

            if (angular.isArray(scope.content.content)) {
                element.append('<ul class="child">' +
                        '<treeitem ng-repeat="elem in content.content" parent="content" level="level+1" class="tree-item level-{{level}} type-{{elem.type}}" content="elem" ulink="{{link}}.content[{{$index}}]" index="$index"></treeitem>' +
                        '</ul>');
                $compile(element.contents())(scope);
            }
            return false;
        },
        controller: function($scope, $element)
        {
            $scope.showUp = function(parent, index)
            {
                if (!angular.isArray(parent))
                {
                    if (parent.content.length > 1 && index > 0)
                        return true;
                }
                
                return false
            }

            $scope.showDown = function(parent, index)
            {
                if (!angular.isArray(parent))
                {
                    if (parent.content.length > 1 && index < (parent.content.length - 1)){
                        $scope.edit=true;
                        return true;
                    }
                        
                }
                
                return false

            }

            $scope.delete = function(parent, index)
            {
                if (parent.content)
                    parent.content.splice(index, 1);   
            }

            $scope.moveUp = function(parent, index)
            {
                $scope.move(parent, index, -1)
            }
            $scope.moveDown = function(parent, index)
            {
                $scope.move(parent, index, 1);
            }

            $scope.move = function(parent, index, dif)
            {
                var e_move = parent.content.splice(index, 1);
                parent.content.splice(index + dif, 0, e_move[0]);
            }
        }
    }
});

gController.directive('pWindow', function() {
    return {
        restrict: 'EC',
        replace: true,
        transclude: true,
        scope: {
            pwtitle: '@'
        },
        templateUrl: "/tmpl?dir=default&f=pWindow",
        link: function(scope, element, attrs) {
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
        scope: {
            position: '@'
        },
        link: function(scope, element, attrs) {
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

gController.directive('popUpSave', function(){
    return{
        restrict:'E',
        scope:false,
        replace:true,
        template: '<div id="popUpMsg-bg" ng-show="showPopUpSave">'+
        '<div id="popUpMsg"><div class="close" ng-click="closePopUpSave()">x</div>'+
        '<div class="content">КП успешно сохранено</div><button ng-click="closePopUpSave();">Ok</button></div></div>',
         controller: function($scope,$location) {
            $scope.closePopUpSave = function(){
                $scope.showPopUpSave = false;
                console.log($scope.cl);
                if($scope.cl){
                    $location.path('/list');
                }
            }
         }                                                                                                    
    }; 
});

gController.directive('popUpClose', function(){
    return{
        restrict:'E',
        scope:false,
        replace:true,
        template: '<div id="popUpMsg-bg" ng-show="showPopUpClose">'+
        '<div id="popUpMsg"><div class="close" ng-click="closePopUpClose()">x</div>'+
        '<div class="content">Сохранить изменения?</div><button class="btn_save" ng-click="closePopUpS();">Ok</button>'+
        '<button class="btn_close" ng-click="closePopUpClose()">Cansel</button></div></div>',
         controller: function($scope,$location) {
            $scope.closePopUpClose = function(){
                $scope.showPopUpClose = false;
                $location.path('/list');
            }
            
            $scope.closePopUpS=function(){
              $scope.showPopUpClose = false;
              $scope.cl=true;
              $scope.save();
              
               
            }
         }                                                                                                    
    };
});

gController.directive('popUpDel', function(){
    return{
        restrict:'E',
        scope:false,
        replace:true,
        template: '<div id="popUpDelMsg-bg" ng-show="showPopUpDel">'+
        '<div id="popUpMsg"><div class="close" ng-click="closePopUpDel()">x</div>'+
        '<div class="content">Удалить выделенный элемент?</div><button class="btn_save" ng-click="deleteElement();">Ok</button>'+
        '<button class="btn_close" ng-click="closePopUpDel()">Cansel</button></div></div>',
         controller: function($scope,$location) {
            $scope.closePopUpDel = function(){
                $scope.showPopUpDel = false;
                $($scope.activeTarget).removeClass('ui-delete-elem');
                $($scope.activeTarget).parent().removeClass('ui-delete-elem');
                $scope.activeTarget='';
            }
            
            $scope.deleteElement=function(){
                if ($scope.deleteElem($scope.activeLink)) {
                    $scope.$apply();
                    $scope.activeLink="";
                    $scope.showPopUpDel = false;
                }
              
               
            }
         }                                                                                                    
    };
});
/* Services */
var gService = angular.module('gService', ['ngResource']);

gService.factory('Kp', ['$resource', '$location',
    function($resource, $location) {
        var kp = $resource('/generator/:kpid', {kpid: 'list'}, {});
        kp.createKp = function() {
            var k = kp.get({
                kpid: 'one',
                id: 'new'
            }, function(res) {
                $location.path('/list/' + res.id);
            });

            return k;
        }

        kp.trashKp = function(id)
        {
            var k = kp.get({
                kpid: 'trash',
                id: id
            });
            if (k)
                return true;

            return false;
        }

        kp.deleteKp = function(id)
        {

        }

        kp.findAll = function() {
            return kp.query();
        };

        kp.findById = function(id) {
            var k = kp.get({
                kpid: 'one',
                id: id
            }, function() {
                k.json = JSON.parse(k.json);
            });

            return k;
        };

        kp.saveKp = function(k) {
            return kp.save({
                kpid: 'one',
                id: k.id
            }, k, function() {
                console.log('Complete!');
            }, function() {
                console.log('Error!')
            });
        }

        return kp;

    }
]);
gService.factory('Params', ['$resource',
    function($resource) {
        return $resource('/js/params.json', {}).get();
    }
]);

