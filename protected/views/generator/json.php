<?php
$labels = array('u_id_create', 'u_id_edit', 'auditor_id');
if($data && !empty($data) && is_array($data))
{
    foreach ($data as &$kp)
    {
        if(is_object($kp) || is_array($kp))
        {
            $kp = setUser($kp);
        }
    }
    echo CJSON::encode($data);
}else if(is_object($data))
{
    echo CJSON::encode(setUser($data));
}

function setUser($obj)
{
    $labels = array('u_id_create', 'u_id_edit', 'auditor_id');
    
    foreach ($obj as $label=>$val)
    {
        if(in_array($label, $labels))
        {
            $temp = User::model()->find('id=:id', array(':id'=>$val));
            $obj->$label = $temp;
        }
        
    }
    return $obj;
}