<?php

if(!isset($blq))
{
	require_once(MODULES_ROOT . 'barlesque/client.php');
	$blq = new Barlesque();
}
$blq->fetch();

echo '<!DOCTYPE html>';
echo '<html>';

echo '<head>';
$this->title();
echo $blq->head;
$this->links();
echo '<script>bbccookies._showPrompt = function() { return false; }</script>';
echo '</head>';

echo '<body>';

echo $blq->bodyfirst;
