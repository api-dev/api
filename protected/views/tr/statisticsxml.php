<?php
$echo = '<?xml version="1.0" encoding="UTF-8" ?>';
$echo .= '<data count="'.  count($data).'">';
foreach ($data as $tr):
    $ratesCount = Rate::model()->countByAttributes(array(
        'transport_id'=> $tr[id]
    ));
    $users = Yii::app()->db->createCommand(array(
        'select'   => 'user_id',
        'distinct' => 'true',
        'from'     => 'rate',
        'where'    => 'transport_id = ' . $tr[id],
    ))->queryAll();
    $membersCount = count($users);
    
    $echo .= '<transport t_id="'.$tr[t_id].'">';
        $echo .= '<status>'.$tr[status].'</status>';
        $echo .= '<datepublished>'.$tr[date_published].'</datepublished>';
        $echo .= '<dateclose>'.$tr[date_close].'</dateclose>';
        $echo .= '<editstatus>'.$tr[edit_status].'</editstatus>';
        $echo .= '<startrate>'.$tr[start_rate].'</startrate>';
        $echo .= '<ratescount>'.$ratesCount.'</ratescount>';
        $echo .= '<memberscount>'.$membersCount.'</memberscount>';
        if($tr[status]=='0')
        {
            $rate = Rate::model()->findByPk($tr[rate_id]);
            $user = $parent = $rate->user;
            
            if($user->type_contact=='1')
                $parent = TrUser::model()->findByPk($user->parent);
            
            $echo .= '<win>';
                $echo .= '<inn>'.$parent->inn.'</inn>';
                $echo .= '<nds>'.$user->userFields[0]->with_nds.'</nds>';
                if($user->userFields[0]->with_nds=='1'){
                    $echo .= '<ndspercent>'.Yii::app()->params['nds'].'</ndspercent>';
                }
                $echo .= '<price>'.$rate->price.'</price>';
                $echo .= '<currency>'.$tr[currency].'</currency>';
                $echo .= '<date>'.$rate->date.'</date>';
            $echo .= '</win>';
        }
    $echo .= '</transport>';
endforeach;
$echo .= '</data>';
echo $echo;