<?php


use OCA\FullNextSearch\Api\v1\NextSearch;
use OCP\Util;

NextSearch::addJavascriptAPI();
Util::addScript(NextSearch::appName(), 'example');

?>

Full Next Search



<input id="search_input" value="" >
<input id="search_submit" type="submit" value="go">



<div id="search_result"></div>
