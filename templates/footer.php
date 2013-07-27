<?php

echo $blq->bodylast;

global $EREGANSU_START_TIME;

if(defined('EREGANSU_DEBUG') && EREGANSU_DEBUG && isset($EREGANSU_START_TIME))
{
	$now = microtime(true);
	echo '<div id="eregansu-debug-info">';
	echo '<p class="eregansu-debug-info">Page generated in ' . sprintf("%.5f", $now - $EREGANSU_START_TIME) . 's</p>';
	echo '</div>';
}

echo '</body>';
echo '</html>';
