<?php
$echo = '<?xml version="1.0" encoding="UTF-8" ?>';
$echo .= '<data count="'.  count($data).'">';
foreach ($data as $tr):
    $ratesCount = Rate::model()->countByAttributes(array(
        'transport_id'=> $tr[id]
    ));
    $users = Yii::app()->db_exch->createCommand()
        ->selectDistinct('user_id')
        ->from('rate')
        ->where('transport_id = ' . $tr[id])
        ->queryAll()
    ;
    $membersCount = count($users);
    
    $echo .= '<transport t_id="'.$tr[t_id].'">';
        $echo .= '<status>'.$tr[status].'</status>';
        $echo .= '<deletereason>'.$tr[del_reason].'</deletereason>';
        $echo .= '<datepublished>'.$tr[date_published].'</datepublished>';
        $echo .= '<dateclose>'.$tr[date_close].'</dateclose>';
        $echo .= '<editstatus>'.$tr[edit_status].'</editstatus>';
        $echo .= '<startprice>'.$tr[start_rate].'</startprice>';
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
                if($tr[type]=='1') { // for local transport
                    $echo .= '<nds>'.$user->userFields[0]->with_nds.'</nds>';
                } else $echo .= '<nds>0</nds>';
                $echo .= '<ndspercent>'.Yii::app()->params['nds'].'</ndspercent>';
                $echo .= '<price>'.$rate->price.'</price>';
                $echo .= '<currency>'.$tr[currency].'</currency>';
                $echo .= '<date>'.$rate->date.'</date>';
            $echo .= '</win>';
        }
    $echo .= '</transport>';
endforeach;
$echo .= '</data>';
echo $echo;