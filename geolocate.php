<?php

$about = <<<EOC

       geolocate.php
       
       A PHP command-line tool to get geolocation information about
       an IP address (or addresses).
 
       Example usage:
 
               $ php geolocate.php 172.56.1.65 github.com

                -------------
                172.56.1.65
                -------------

                           ip:  172.56.1.65
                 country_code:  US
                 country_name:  United States
                  region_code:  GA
                  region_name:  Georgia
                         city:  Forest Park
                     zip_code:  30050
                    time_zone:  America/New_York
                     latitude:  33.622
                    longitude:  -84.37
                   metro_code:  524

                -------------
                github.com
                -------------

                           ip:  192.30.252.128
                 country_code:  US
                 country_name:  United States
                  region_code:  CA
                  region_name:  California
                         city:  San Francisco
                     zip_code:  94107
                    time_zone:  America/Los_Angeles
                     latitude:  37.77
                    longitude:  -122.394
                   metro_code:  807



       Author:
               Luke Kuzmish <luke@lukekuzmish.com>
 
       Repository:
               https://github.com/lukeKuzmish/geolocate
  

EOC;

// CONFIG
$DEFAULT_GOOGLE_MAPS_LEVEL = '15';   // @int between 3 and 15


if ((in_array("-h", $argv)) or (in_array("--help", $argv))) {
    echo $about;
    exit();
    //die($about);
}

$url = 'https://freegeoip.net/json/';
for ($i = 1; $i < count($argv); $i++) {
    $json = file_get_contents($url . $argv[$i]);
    $response = json_decode($json, true);

    if ( (isset($response['latitude'])) and (!empty($response['latitude'])) and (isset($response['longitude'])) and (!empty($response['longitude'])) ) {
        $latitude = $response['latitude'];
        $longitude = $response['longitude'];
        $googleMapsUrl = "https://www.google.com/maps/preview/@{$latitude},{$longitude},{$DEFAULT_GOOGLE_MAPS_LEVEL}z"; 
        $response['maps_url'] = $googleMapsUrl;
    }

    echo "\n-------------\n{$argv[$i]}\n-------------\n";
    foreach ($response as $k => $v) {
        $key = str_pad($k . ":", 15, " ", STR_PAD_LEFT);
        $val = "  $v";
        echo "\n$key$val";
    }
    echo "\n";
}
echo "\n";
