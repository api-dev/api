<!DOCTYPE html>
<?php
    $app = Yii::app();
?>
<html ng-app="gApp">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
        
	<link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/generator/main.css" />
	<title>Генератор Коммерческих предложений</title>
        
        <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular.js"></script>
        <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular-route.js"></script>
        <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular-resource.js"></script>
        
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        
        <script src="<?php echo $app->request->baseUrl; ?>/js/generator.js"></script>
    </head>
    <body class="{{bodyClass}}" ng-controller="bodyStyleCtrl">
        <div class="panel">
            <div class="user-info">
                <?php echo $app->user->_id;?>
            </div>
            <div class="bodyClassBut">
                <label for="bodyClass-light" id="label-bodyClass-light">
                    <input type="radio" id="bodyClass-light" ng-model="bodyClass" value="light">Светлая
                </label>
                <label for="bodyClass-dark" id="label-bodyClass-dark">
                    <input type="radio" id="bodyClass-dark" ng-model="bodyClass" value="dark">Темная
                </label>
            </div>
            <div class="logout"><a href="http://auth.<?php echo $app->params['host'] ?>/logout/">Выход</a></div>
        </div>
        <div class="view" ng-view></div>
    </body>
</html>