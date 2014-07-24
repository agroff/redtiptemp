<?php

require_once __DIR__.'/src/init.php';

$results = $easy->search(post("query"));

fullView("find", array("results" => $results));