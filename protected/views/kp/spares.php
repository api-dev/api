<?php
if($request[header]!='0')
    echo '<div class="header">'.$request[header].'</div>';

if($title)
    echo '<div class="title">'.$title.'</div>';

if($table)
    echo '<div class="content">'.$table.'</div>';

if($request[footer]!='0')
    echo '<div class="footer">'.$request[footer].'</div>';