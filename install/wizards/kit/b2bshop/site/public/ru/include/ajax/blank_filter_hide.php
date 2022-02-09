<?php
session_start();
if($_POST['hide'] == 'Y')
{
	$_SESSION['BLANK_HIDE_FILTER'] = 'Y';
}
elseif($_POST['hide'] == 'N')
{
	$_SESSION['BLANK_HIDE_FILTER'] = 'N';
}