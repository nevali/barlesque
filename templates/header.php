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
echo '</head>';

echo '<body class="' . _e($page_type) . '">';

echo $blq->bodyfirst;
