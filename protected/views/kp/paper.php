<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" style="min-height: 100%">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <BASE href="v8config://eeaf5085-e783-4a57-9a05-1357ae55da33/mdobject/ide1ffff40-2647-407a-9655-20eb4c0de2b3/8eb4fad1-1fa6-403e-970f-2c12dbb43e23">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <META name=GENERATOR content="MSHTML 9.00.8112.16526">
    <title><? echo $template->title; ?></title>
</head>
<body>
<?php
function getMonthName($unixTimeStamp = false) {
	
	if (!$unixTimeStamp) {
		$mN = date('m');
	} else {
		$mN = date('m', (int)$unixTimeStamp);
	}
	$monthAr = array(
		1 => array('Январь', 'Января'),
		2 => array('Февраль', 'Февраля'),
		3 => array('Март', 'Марта'),
		4 => array('Апрель', 'Апреля'),
		5 => array('Май', 'Мая'),
		6 => array('Июнь', 'Июня'),
		7 => array('Июль', 'Июля'),
		8 => array('Август', 'Августа'),
		9 => array('Сентябрь', 'Сентября'),
		10=> array('Октябрь', 'Октября'),
		11=> array('Ноябрь', 'Ноября'),
		12=> array('Декабрь', 'Декабря')
	);
	return $monthAr[(int)$mN];
}

$test = $data;

if(empty($data['wrapper'])):
    $test = array();
    $test['title'] = 'Фронт продаж!';
    $test['epigraph'] = 'Они тоже Продавцы!';
    $test['wrapper'] = array();
    $test['wrapper']['1'] = array();
    $test['wrapper']['1']['header'] = 'Новости Филиальной сети';
    //$test['wrapper']['2']['header'] = 'Новости от ПЛей техника';
    //$test['wrapper']['3']['header'] = 'Новости от ПЛей запчасти';
    $test['wrapper']['1']['content'] = array();
    $test['wrapper']['1']['content']['collum'] = array();
    $test['wrapper']['1']['content']['row'] = array();
    $test['wrapper']['1']['content']['row']['1'] =
        $test['wrapper']['1']['content']['row']['2'] = array();
    $test['wrapper']['1']['content']['row']['1']['caption'] = 'РЕМОНТ ДВИГ А ТЕЛЯ ТРАКТОРА КЕЙС 305';
    $test['wrapper']['1']['content']['row']['2']['caption'] = '6 ЗАКАЗОВ НА 284 ДИСКА BELLOT A';
    $test['wrapper']['1']['content']['row']['1']['date'] = '29.01.2014';
    $test['wrapper']['1']['content']['row']['2']['date'] = '30.01.2014';
    $test['wrapper']['1']['content']['row']['1']['text'] = 'Инженер технолог Живаев Николай Викторович (Москва) при выезде к клиенту сумел продать 180 часов платного ремонта (ремонт двигателя трактора Кейс 305). Заказ на сервис полностью оплачен, клиент доволен. Данный ремонт был проведен в начале прошлого года. После него 15 заказов по запасным частям были поставлены клиенту на сумму свыше 2 млн рублей.';
    $test['wrapper']['1']['content']['row']['2']['text'] = 'Менеджер Смычков А. (Красноярск) за два месяца законтрактовал 6 заказов на 284 Диска Bellota на БДМ c доходностью 18-26%. Эта товарная позиция имеет очень много дешевых аналогов. Кроме того конкуренция среди продавцов Bellota большая, и тем значима доходность по заказам. В настоящий момент этим менеджром ведется работа по заказу на 200 дисков. Стаж работы менеджера в Компании всего три месяца.';
    $test['wrapper']['1']['content']['row']['1']['image'] = 'Якобы изображение';
    $test['wrapper']['1']['content']['row']['2']['image'] = 'Якобы изображение';
    $test['wrapper']['1']['content']['collum']['1'] =
        $test['wrapper']['1']['content']['collum']['2'] = array();

    $test['wrapper']['1']['content']['collum']['1']['1'] =
        $test['wrapper']['1']['content']['collum']['1']['2'] = array();
    $test['wrapper']['1']['content']['collum']['1']['1']['caption'] = 'РЕМОНТ ДВИГ А ТЕЛЯ ТРАКТОРА КЕЙС 305';
    $test['wrapper']['1']['content']['collum']['1']['1']['date'] = '29.01.2014';
    $test['wrapper']['1']['content']['collum']['1']['1']['text'] = 'Инженер технолог Живаев Николай Викторович (Москва) при выезде к клиенту сумел продать 180 часов платного ремонта (ремонт двигателя трактора Кейс 305). Заказ на сервис полностью оплачен, клиент доволен. Данный ремонт был проведен в начале прошлого года. После него 15 заказов по запасным частям были поставлены клиенту на сумму свыше 2 млн рублей.';
    $test['wrapper']['1']['content']['collum']['1']['1']['image'] = 'Якобы изображение';
    $test['wrapper']['1']['content']['collum']['1']['2']['caption'] = '6 ЗАКАЗОВ НА 284 ДИСКА BELLOT A';
    $test['wrapper']['1']['content']['collum']['1']['2']['date'] = '30.01.2014';
    $test['wrapper']['1']['content']['collum']['1']['2']['text'] = 'Менеджер Смычков А. (Красноярск) за два месяца законтрактовал 6 заказов на 284 Диска Bellota на БДМ c доходностью 18-26%. Эта товарная позиция имеет очень много дешевых аналогов. Кроме того конкуренция среди продавцов Bellota большая, и тем значима доходность по заказам. В настоящий момент этим менеджром ведется работа по заказу на 200 дисков. Стаж работы менеджера в Компании всего три месяца.';
    $test['wrapper']['1']['content']['collum']['1']['2']['image'] = 'Якобы изображение';
    $test['wrapper']['1']['content']['collum']['2']['1'] =
        $test['wrapper']['1']['content']['collum']['2']['2'] = array();
    $test['wrapper']['1']['content']['collum']['2']['1']['caption'] = 'РЕМОНТ ДВИГ А ТЕЛЯ ТРАКТОРА КЕЙС 305';
    $test['wrapper']['1']['content']['collum']['2']['1']['date'] = '29.01.2014';
    $test['wrapper']['1']['content']['collum']['2']['1']['text'] = 'Инженер технолог Живаев Николай Викторович (Москва) при выезде к клиенту сумел продать 180 часов платного ремонта (ремонт двигателя трактора Кейс 305). Заказ на сервис полностью оплачен, клиент доволен. Данный ремонт был проведен в начале прошлого года. После него 15 заказов по запасным частям были поставлены клиенту на сумму свыше 2 млн рублей.';
    $test['wrapper']['1']['content']['collum']['2']['1']['image'] = 'Якобы изображение';
    $test['wrapper']['1']['content']['collum']['2']['2']['caption'] = '6 ЗАКАЗОВ НА 284 ДИСКА BELLOT A';
    $test['wrapper']['1']['content']['collum']['2']['2']['date'] = '30.01.2014';
    $test['wrapper']['1']['content']['collum']['2']['2']['text'] = 'Менеджер Смычков А. (Красноярск) за два месяца законтрактовал 6 заказов на 284 Диска Bellota на БДМ c доходностью 18-26%. Эта товарная позиция имеет очень много дешевых аналогов. Кроме того конкуренция среди продавцов Bellota большая, и тем значима доходность по заказам. В настоящий момент этим менеджром ведется работа по заказу на 200 дисков. Стаж работы менеджера в Компании всего три месяца.';
    $test['wrapper']['1']['content']['collum']['2']['2']['image'] = 'Якобы изображение';
endif;
if(!empty($test)):?>
<div class="wrapper">
    <div class="header">
        <?php list($first, $second) = explode(' ', $test['title']);?>
        <div class="front"><?php echo $first.'<br>'.$second;?></div>
    </div>
    <div class="epigraph">
        <?php echo $test['epigraph']; ?>
        <span class="datetime">
        <?php
            $curTime = mktime();
            $monthNameAr = getMonthName ($curTime);
            echo date('d', $curTime).' '.$monthNameAr[1].' '.date('Y', $curTime);
        ?></span>
    </div>
    <?php if(!empty($test['wrapper'])): ?>
    <div class="w-wrapper">
        <?php for($i = 0; $i<=count($test['wrapper']); $i++): ?>
        <div class="w-w-header">
            <?php echo $test['wrapper'][$i]['header'];?>
        </div>
            <?php 
            if (isset($test['wrapper'][$i]['content']['collum']) && !empty($test['wrapper'][$i]['content']['collum']))
                echo getCollum ($test['wrapper'][$i]['content']['collum']);
            if (isset($test['wrapper'][$i]['content']['row']) && !empty($test['wrapper'][$i]['content']['row']))
                echo getRow ($test['wrapper'][$i]['content']['row']);
            ?>
        <?php endfor;?>
    </div>
    <?php endif; ?>
</div>
<?php
endif;

function getRow($array){
    $return = '<table class="row-table">';
    for($i = 1; $i<=count($array); $i++){
        $photo = false;
        if(isset($array[$i]['login']) && !empty($array[$i]['login']))
            $photo = User::model()->findByAttributes(array('login' => $array[$i]['login']))->photo;
        $return .= '<tr>';
            $return .= '<td class="t-r-image" rowspan="2">';
                if($photo && $photo!='1')
                    $return .= '<img src="http://api.lbr.ru'.$photo.'" alt="'.$array[$i]['login'].'">';
            $return .= '</td>';
            $return .= '<td class="t-r-header">';
                $return .= '<span class="t-r-date">'.$array[$i]['date'].'</span>';
                $return .= '<span>'.$array[$i]['caption'].'</span>';
            $return .= '</td>';
        $return .= '</tr>';
        $return .= '<tr>';
            $return .= '<td class="t-r-text">';
                $return .= $array[$i]['text'];
            $return .= '</td>';
        $return .= '</tr>';
    }
    $return .= '</table>';
    return $return;
}
function getCollum($array){
    $return = '<table class="collum-table">';
    for($i = 1; $i<=count($array); $i++){
        $return .= '<tr>';
        $c = count($array[$i]);
        if($c<=0)
            continue;
        $tdclass = floor(100/$c);
        for($k = 1; $k<=$c; $k++)
        {
            $return .= '<td class="width-'.$tdclass.'" valign="top">';
                $return .= '<div class="t-c-header"><span class="t-c-date">'.$array[$i][$k]['date'].'</span> '.$array[$i][$k]['caption'].'</div>';
                $return .= '<div class="t-c-image">'.$array[$i][$k]['image'].'</div>';
                $return .= '<div class="t-c-text">'.$array[$i][$k]['text'].'</div>';
            $return .= '</td>';
        }
        $return .= '</tr>';
    }
    $return .= '</table>';
    return $return;
}
?>
<style>
    
    body, html
    {
        margin: 0;
        padding: 0;
        font-family: Calibri;
    }
    .code
    {
        width: 50%;
        float: left;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
    .code h1
    {
        padding: 5px 15px;
        margin: 0;
        font-size: 16px;
        background: #ef7f1a;
    }
    .code > div
    {
        height: 300px;
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: scroll;
    }
    .code > div > pre
    {
        padding: 0 2%;
    }
    
    /*-------paper-style---------*/
    table, tr, td, th
    {
        padding: 0;
        margin: 0;
        border: 0;
    }
    .wrapper 
    {
        background: url('http://api.lbr.ru/images/paper/bg.jpg') repeat;
        padding: 20px 50px;
        margin: 0 auto;
        max-width: 1000px;
    }
    .header
    {
        background: url('http://api.lbr.ru/images/paper/billy.png') no-repeat bottom left;
        border-bottom: 3px solid rgb(102, 97, 71);
        padding: 20px 0px;
        font-family: Capitalist, Impact;
        margin: 0px 0 0 0;
        min-height: 160px;
    }
    .header .front
    {
        text-transform: uppercase;
        color: rgb(102, 97, 71);
        color: rgba(102, 97, 71, .9);
        font-size: 70px;
        line-height: 80px;
        text-align: right;
    }
    .epigraph
    {
        display: block;
        padding: 10px 15px;
        font-family: 'Times New Roman', sans-serif;
        font-size: 27px;
        font-style: italic;
        font-weight: bold;
        color: #666147;
        margin-bottom: 15px;
    }
    .epigraph .datetime
    {
        display: block;
        float: right;
        text-align: right;
    }
    .wrapper h3
    {
        font-family: Calibri;
        color: rgb(43,42,41);
        text-align: center;
        font-size: 16px;
    }
    .wrapper .w-wrapper .w-w-header
    {
        background: rgb(102, 97, 71);
        background: rgba(102, 97, 71, .8);
        color: white;
        font-family: Capitalist, Impact;
        font-size: 32px;
        padding: 0 25px;
        line-height: 44px;
    }
    .wrapper .collum-table
    {
        
    }
    .white
    {
        color: rgb(255,251,239);
    }
    .wrapper .collum-table .width-50
    {
        width: 48%;
        padding-left: 2%;
    }
    .wrapper .collum-table .width-50:first-child
    {
        padding-left: 0;
        padding-right: 2%;
    }
    .wrapper .collum-table .t-c-header
    {
        font-family: Calibri;
        font-size: 15px;
        color: rgb(43, 42, 41);
        font-weight: 900;
        margin-top: 15px;
    }
    .wrapper .collum-table .t-c-header .t-c-date
    {
        color: rgb(157,158,159);
        margin-right: 10px;
        padding-right: 10px;
        border-right: 2px solid rgb(43, 42, 41);
    }
    .wrapper .collum-table .t-c-image
    {
        margin: 10px 0;
    }
    .wrapper .collum-table .t-c-image
    {
        /*width: 95%;*/
    }
    .wrapper .collum-table .t-c-text
    {
        /*width: 95%;*/
        color: rgb(91,91,91);
        text-align: justify;
    }
    .wrapper .row-table
    {
        margin-top: 15px;
    }
    .wrapper .row-table .t-r-date
    {
        font-family: Calibri;
        font-size: 15px;
        color: rgb(43, 42, 41);
        font-weight: 900;
        color: rgb(157,158,159);
        padding-right: 10px;
        border-right: 2px solid rgb(43, 42, 41);
        margin-right: 10px;
    }
    .wrapper .row-table .t-r-image
    {
        
    }
    .wrapper .row-table .t-r-image img
    {
        width: 90px;
        margin-right: 10px;
        max-height: 250px;
    }
    .wrapper .row-table .t-r-header
    {
        font-family: Calibri;
        font-size: 15px;
        color: rgb(43, 42, 41);
        font-weight: 900;
    }
    .wrapper .row-table .t-r-text
    {
        padding: 5px 0px 15px;
        color: rgb(91,91,91);
        text-align: justify;
    }
    
</style>
</body>
</html>