<?php

$connect_error = 'Je nám líto, máme problémy s připojením.';

mysql_connect('localhost', 'root', '') or die ($connect_error);
mysql_select_db('mycet') or die ($connect_error);

unset($connect_error);
