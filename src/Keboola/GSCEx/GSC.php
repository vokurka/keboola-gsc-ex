<?php

class GSC
{
  private $api;
  private $config;
  private $destination;
  private $mandatoryConfigColumns = array(
    //'bucket', 
    'client_id', 
    'client_email',
    '#private_key',
    'site_url',
  );

  public function __construct($config, $destination)
  {
    date_default_timezone_set('UTC');
    $this->destination = $destination;

    foreach ($this->mandatoryConfigColumns as $c)
    {
      if (!isset($config[$c])) 
      {
        throw new Exception("Mandatory column '{$c}' not found or empty.");
      }

      $this->config[$c] = $config[$c];
    }
  }

  private function logMessage($message)
  {
    echo($message."\n");
  }

  public function run()
  {
    require_once 'vendor/autoload.php';

    $client = new Google_Client();

    $client->setAuthConfig(array(
      "type" => "service_account",
      "client_id" => $this->config['client_id'],
      "client_email" => $this->config['client_email'],
      "private_key" => $this->config['#private_key'],
      "signing_algorithm" => "HS256",
    ));

    $client->setApplicationName("GSC_Reports_Download");
    $client->setScopes(['https://www.googleapis.com/auth/webmasters.readonly']);

    $service = new Google_Service_Webmasters($client);

    $this->getCrawlErrorsCounts($service, $this->config['site_url']);
  }

  private function getCrawlErrorsCounts($service, $siteUrl)
  {
    $result = $service->urlcrawlerrorscounts->query($this->config['site_url'], array('latestCountsOnly' => false));

    $file = fopen($this->destination."urlcrawlerrorscounts","w");
    if ($file === false)
    {
      throw new Exception("Could not open local file for writing.");
    }

    fputcsv($file, array('type','category','date','error_count'));

    foreach ($result["countPerTypes"] as $row)
    {
      $category = $row->getCategory();
      $platform = $row->getPlatform();

      foreach ($row->getEntries() as $entry)
      {
        fputcsv($file, array($category, $platform, $entry['timestamp'], $entry['count']));
      }
    }

    fclose($file);
  }
}