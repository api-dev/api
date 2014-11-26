<?php
if(is_array($text))
{
    foreach ($text as $e)
    {
        if(count($e)>1)
        {
            foreach ($e as $m):
                Yii::log($m, 'info');
                echo $m;
            endforeach;
        } else {
            Yii::log($e[0], 'info');
            echo $e[0];
        }
    }
} elseif($text) {
    Yii::log($text, 'info');
    echo $text;
}

