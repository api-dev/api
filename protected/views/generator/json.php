<?php
$labels = array('u_id_create', 'u_id_edit', 'auditor_id');
if($data && !empty($data))
{
    foreach ($data as &$kp)
    {
        if(is_object($kp) || is_array($kp))
        {
            foreach ($kp as $label=>$val)
            {
                if(in_array($label, $labels))
                {
                    $temp = User::model()->find('id=:id', array(':id'=>$kp->$label));
                    $kp->$label = $temp;
                }
            }
        }
    }
    echo CJavaScript::jsonEncode($data);
}