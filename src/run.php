<?php

use Symfony\Component\Yaml\Yaml;

require_once(dirname(__FILE__) . "/../vendor/autoload.php");

require_once "Keboola/GSCEx/GSC.php";

$arguments = getopt("d::", array("data::"));
if (!isset($arguments["data"])) {
    print "Data folder not set.";
    exit(1);
}

$config = Yaml::parse(file_get_contents($arguments["data"] . "/config.yml"));

try {
    $gsc = new GSC(
        $config['parameters'],
        $arguments["data"] . "/out/tables/"
    );

    $gsc->run();
} catch (Exception $e) {
    print $e->getMessage();
    exit(1);
}

exit(0);
