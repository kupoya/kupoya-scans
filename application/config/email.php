<?php

//$config['protocol'] = 'mail';
//$config['mailpath'] = '/usr/sbin/sendmail';

$config['protocol'] = 'smtp';
$config['useragent'] = 'smtp-server';
$config['smtp_host'] = 'out.bezeqint.net';
$config['smtp_user'] = 'lirantal1';
$config['smtp_pass'] = '***REMOVED***';
$config['smtp_port'] = 25;
$config['smtp_timeout'] = 5;

$config['mailtype'] = 'html';
//$config['charset'] = 'iso-8859-1';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;