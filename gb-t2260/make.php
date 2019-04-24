<?php

$lines = file('data.txt');
if (file_exists('patch.txt')) {
    $patch = file('patch.txt');
    $lines = array_merge($lines, $patch);
}
foreach ($lines as $line) {
    list($code, $name) = explode("\t", trim($line));
    $code = intval($code);
    if ($code % 10000 == 0) {
        $states[$code] = $name;
    } else if ($code % 100 == 0) {
        $cities[$code] = $name;
    } else {
        $districts[$code] = $name;
    }
}
ksort($states);
ksort($cities);
ksort($districts);

$content = '<?php'.PHP_EOL;
$content.= '$states = '.var_export($states, true).';'.PHP_EOL;
$content.= '$cities = '.var_export($cities, true).';'.PHP_EOL;
$content.= '$districts = '.var_export($districts, true).';'.PHP_EOL;
file_put_contents('gb-t2260.php', $content);

file_put_contents('gb-t2260.json', json_encode([
    'states' => $states,
    'cities' => $cities,
    'districts' => $districts,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));