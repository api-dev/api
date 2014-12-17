<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<title>1c API</title>
</head>
<body>
<div class="header">
    <ul class="menu">
        <li><img src="/images/lbrlogo.png" title="white logo LBR"/></li>
        <li><a href="/">Главная</a></li>
        <li><a href="/?view=kp">КП</a></li>
        <li><a href="/generator/">Генератор КП</a></li>
        <li><a href="/?view=user">Пользователи</a></li>
        <li><a href="/?view=transport">Биржа</a></li>
        <li><a href="/?view=shop">Магазин</a></li>
        <li><a href="http://www.lbr.ru/users/login/">Вход на сайт ЛБР</a></li>
        <li class="login"><?php
    $app = Yii::app();
    if(!$app->user->isGuest)
        echo CHtml::link('Выход из Api', 'http://auth.lbr.ru/logout/', array('class'=>'logout'));
    else
        echo CHtml::link('Вход в Api', 'http://auth.lbr.ru/', array('class'=>'login'));
    ?></li>
    </ul>
</div>
<div class="wrapper">
<?php echo $content; ?>
</div>
<div class="footer">
    
</div>
</body>
</html>
