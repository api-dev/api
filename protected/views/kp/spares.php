<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name=GENERATOR content="MSHTML 9.00.8112.16526">
    <title>КП по запасным частям</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/kp/spares/print.css" />
</head>
<body>
    <div class="wrapper">
        <?php
        if($request[header]!='0'):
            echo '<div class="header">';
                echo '<img src="http://www.lbr.ru/images/kp/spares/header.jpg" alt="Шапка ЛБР-Агромаркет">';
            echo '</div>';
        endif;
        if($title):
            echo '<div class="title">'.$title.'</div>';
        endif;
        if($table):
            echo '<div class="content">'.$table.'</div>';
        endif;
        if($request[footer]!='0'):
            echo '<div class="footer">'.$request[footer].'</div>';
        endif;
        ?>
    </div>
</body>
</html>