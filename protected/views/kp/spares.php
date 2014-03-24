<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <BASE href="v8config://eeaf5085-e783-4a57-9a05-1357ae55da33/mdobject/ide1ffff40-2647-407a-9655-20eb4c0de2b3/8eb4fad1-1fa6-403e-970f-2c12dbb43e23">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <META name=GENERATOR content="MSHTML 9.00.8112.16526">
    <title>КП по запасным частям</title>
</head>
<body>
    <table cellpadding="0" cellspacing="0" border="0" width="800" align="center">
        <tr>
            <td>
                <?php
                if($request[header]!='0')
                    echo '<div class="header">';
                        echo '<img src="http://www.lbr.ru/images/kp/spares/header.jpg" alt="Шапка ЛБР-Агромаркет">';
                    echo '</div>';

                if($title)
                    echo '<div class="title">'.$title.'</div>';

                if($table)
                    echo '<div class="content">'.$table.'</div>';

                if($request[footer]!='0')
                    echo '<div class="footer">'.$request[footer].'</div>';
                ?>
            </td>
        </tr>
    </table>
</body>
</html>