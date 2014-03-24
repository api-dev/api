<?php

class Table {
    
    public static function generateTable($table, $class)
    {
        $return = '<table class="'.$class.'" cellspacing="0" cellpadding="0">';
        if(!empty($table[head])){
            $return .= '<thead>';
                $return .= self::generateTh($table[head][0]);
            $return .= '</thead>';
        }
        $return .= '<tbody>';
        foreach ($table[body] as $col)
        {
            if(is_array($col))
                $return .= self::generateTr($col);
        }
        $return .= '</tbody>';
        $return .= '</table>';
        return $return;
    }

    private function generateTr($tr)
    {
        if(!is_array($tr) || empty($tr))
            return false;

        $return = '<tr>';
        foreach ($tr as $td)
        {
                if(is_array($td))
                    $return .= '<td class="parent">'.self::generateTable($td, 'children');
                else
                    $return .= '<td class="text">'.$td;
            $return .= '</td>';
        }
        $return .= '</tr>';

        return $return;
    }
    private function generateTh($tr)
    {
        if(!is_array($tr) || empty($tr))
            return false;

        $return = '<tr>';
        
        foreach ($tr as $i=>$th)
            $return .= '<th class="text th-'.$i.'">'.$th.'</td>';
        
        $return .= '</tr>';

        return $return;
    }
}
