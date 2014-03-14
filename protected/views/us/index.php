<?php
if(is_array($text))
{
    foreach ($text as $e)
    {
        if(count($e)>1)
        {
            foreach ($e as $m)
                echo $m;
        }else{
            echo $e[0];
        }
    }
}elseif($text){
    echo $text.'; \n ';
}