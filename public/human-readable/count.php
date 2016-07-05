<?php
$contents = file_get_contents('viewcount');
$lines_split = split("\n", $contents);


echo count($lines_split) . " views since 2016-06-27 21:24";
