<?php
$result = '<?xml version="1.0" encoding="UTF-8" ?>';
$result .= '<data count="'.count($data).'">';
foreach ($data as $info):
    $result .= '<info id="'.$info[id].'">';
        $result .= '<customer_id>'.$info[customer_id].'</customer_id>';
        $result .= '<subscription_id>'.$info[subscription_id].'</subscription_id>';
        $result .= '<link_id>'.$info[link_id].'</link_id>';
        $result .= '<date>'.date('Y.m.d H:i', strtotime($info[date_created])).'</date>';
        $result .= '<time>'.$this->getTime($info[time]).'</time>';
        $result .= '<url>'.$info[url].'</url>';
        $result .= '<title>'.$info[title].'</title>';
    $result .= '</info>';
endforeach;
$result .= '</data>';
echo $result;