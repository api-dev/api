<!DOCTYPE html>
<?php
$app = Yii::app();
?>
<html ng-app="gApp">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="ru"/>

    <title>Генератор Коммерческих предложений</title>

    <link rel="stylesheet" type="text/css" href="<?php echo $app->request->baseUrl; ?>/css/generator/main.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>

    <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular.js"></script>
    <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular-route.js"></script>
    <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular-resource.js"></script>
    <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular-animate.js"></script>
    <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular-sanitize.min.js"></script>
    <script src="<?php echo $app->request->baseUrl; ?>/js/angularjs/angular-1.2.9/angular-date.js"></script>

    <script src="<?php echo $app->request->baseUrl; ?>/js/generator.js"></script>
</head>
<body class="{{bodyClass}}" ng-controller="bodyStyleCtrl">
<div class="panel">
    <div style="float: left"></div>
    <div class="logout"><a href="http://auth.<?php echo $app->params['host'] ?>/logout/">Выход</a></div>
    <div class="bodyClassBut">
        <label for="bodyClass-light" id="label-bodyClass-light">
            <input type="radio" id="bodyClass-light" ng-model="bodyClass" value="light">Светлая
        </label>
        <label for="bodyClass-dark" id="label-bodyClass-dark">
            <input type="radio" id="bodyClass-dark" ng-model="bodyClass" value="dark">Темная
        </label>
    </div>
    <div class="user-info">
        <?php $user = User::model()->findByPk($app->user->_id); ?>
        <span
            ng-click="userDisplay = !userDisplay"><?php echo $user->surname . ' ' . substr($user->name, 0, 2) . '.' . substr($user->secondname, 0, 2) . '.'; ?></span>

        <div class="user-drop" ng-if="userDisplay">
            <?php
            $phone = implode('; ', array_diff(array($user->phone_mb, $user->phone_mr), array('-', '', ' ', '0', null)));
            $photo = '/images/default.jpg';
            if ($user->photo != '1' && !empty($user->photo)) {
                $photo = $user->photo;
            }
            ?>
            <div class="photo"><img src="http://api.lbr.ru<?php echo $photo; ?>"/></div>
            <div class="u-field"><label>Имя</label><?php echo $user->name; ?></div>
            <div class="u-field"><label>Фамилия</label><?php echo $user->surname; ?></div>
            <div class="u-field"><label>Отчество</label><?php echo $user->secondname; ?></div>
            <div class="u-field"><label>E-mail</label><?php echo $user->email; ?></div>
            <div class="u-field"><label>Skype</label><?php echo $user->skype; ?></div>
            <div class="u-field"><label>Телефон</label><?php echo $phone; ?></div>
        </div>
    </div>
</div>
<div class="view" ng-view></div>
</body>
</html>