<h1>Главная</h1>
<p>
    Добро пожаловать на сайт документации по обмену данными с сайтом.
    <?php
    $app = Yii::app();
    if(!$app->user->isGuest){
        echo CHtml::link('Выход', 'http://auth.lbr.ru/logout/', array('class'=>'logout'));
        if($app->user->checkAccess('readUser'))
            echo CHtml::link('Администрирование', 'http://auth.lbr.ru/admin/', array('class'=>'admin'));
    }
    ?>
</p>

