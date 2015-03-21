<?php
$about = <<<EOC
/*
 *      geolocate.php
 *      
 *      A PHP command-line tool to get geolocation information about
 *      an IP address (or addresses).
 *
 *      Example usage:
 *
 *              $ php geolocate.php github.com
 *
 *              ip: 192.30.252.128
 *              country_code: US
 *              country_name: United States
 *              region_code: CA
 *              region_name: California
 *              city: San Francisco
 *              zip_code: 94107
 *              time_zone: America/Los_Angeles
 *              latitude: 37.77
 *              longitude: -122.394
 *              metro_code: 807
 *
 *      Author:
 *              Luke Kuzmish <luke@lukekuzmish.com>
 *
 *      Repository:
 *              https://github.com/lukeKuzmish/geolocate
 */ 

EOC;
if ((in_array("-h", $argv)) or (in_array("--help", $argv))) {
    die($about);
}

$url = 'https://freegeoip.net/json/';
for ($i = 1; $i < count($argv); $i++) {
    $json = file_get_contents($url . $argv[$i]);
    $response = json_decode($json, true);
    echo "\n-------------\n{$argv[$i]}\n-------------\n";
    foreach ($response as $k => $v) {
        $key = str_pad($k . ":", 15, " ", STR_PAD_LEFT);
        $val = "  $v";
        echo "\n$key$val";
    }
    echo "\n";
}
echo "\n";
