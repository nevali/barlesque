<?php

if(!isset($blq))
{
	require_once(MODULES_ROOT . 'barlesque/client.php');
	$blq = new Barlesque();
}
$blq->fetch();

$page_type = 'blq ' . @$page_type;

echo '<!DOCTYPE html>';
echo '<html>';

echo '<head>';
$this->title();
echo $blq->head;
$this->links();
if(isset($headExtra))
{
	echo $headExtra;
}
echo '<script>bbccookies._showPrompt = function() { return false; }</script>';
if(defined('EREGANSU_DEBUG'))
{
	echo '<style type="text/css">#eregansu-debug-info { position: relative; bottom: 0; left: 0; right: 0; margin: 0; padding: 0; border-top: solid #888 1px; background: #eee; color: #444; text-align: center;}</style>';
}
echo '</head>';

echo '<body class="' . _e($page_type) . '">';

echo $blq->bodyfirst;
