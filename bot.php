<?php

/**********************************************

              Plik: bot.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/
system('clear');
require_once('inc/configs/config.php');
require_once('lang/language.php');


# Deklaracja stałych
date_default_timezone_set('Europe/Warsaw');
define("version", "4.1");
define("author", "Stalker");
define("name", "qBot");
define("telegram", "@Stal_ker");
define("ts", "Jutuby.net");
define("SP", " ");
define("PREF", "\e[92m[->]\e[0m");
define("ERR", "\e[91m[ERROR] \e[0m");
define("WARN", "\e[94m[WARN] \e[0m");
define("ENDC", "\e[0m");
define("GREEN", "\e[92m");
define("RED", "\e[91m");
define("ORAN", "\e[33m");
define("MAG", "\e[95m");
define("BLUE", "\e[34m");
define("DARKRED", "\e[38;5;88m");


echo
"                             ".$lang['core']['author'][$config['lang']].":  ".author."                      ".PHP_EOL;
echo
"                             Telegram:  ".telegram."                 ".PHP_EOL;
echo
"                             TS:  ".ts."                      ".PHP_EOL;

echo "\n";


# Ładowanie potrzebnych plików
echo PREF.$lang['core']['loadingFiles'][$config['lang']].PHP_EOL;
require_once('inc/classes/teamspeak.class.php');
require_once('inc/functions/publicChannelGroup.php');
require_once('inc/functions/publicChannelGroupHelper.php');
require_once('inc/classes/bot.class.php');

# Checking cache files
echo PREF.$lang['core']['checkCache'][$config['lang']].PHP_EOL;
$new = 0;

  if(!file_exists('cache/saveClientChannel.json')){
    file_put_contents('cache/saveClientChannel.json', '[]');
    $new = 1;
  }

if($new != 0){
  echo PREF.$lang['core']['newCache'][$config['lang']].PHP_EOL;
}



# Logi
if ($config['logs']) {
  if(!is_dir('logs')){
    mkdir('logs', 0700);
  } 
  ini_set('error_log', 'logs/error_'.date('Y-m-d').'_log_'.$instance['i'].'.log');
}
error_reporting($config['errors']);



# Połczenie z ts3
$ts = new teamspeak($config['conn']['ip'], $config['conn']['queryPort'], "\e[91m[ERROR] \e[0m");
if ($ts->connect()) {
    echo PREF.$lang['core']['connSucc'][$config['lang']].PHP_EOL;
    if ($ts->login($config['conn']['login'], $config['conn']['passwd'])['success']) {
        echo PREF.$lang['core']['querySucc'][$config['lang']].PHP_EOL;
        if ($ts->selectServer($config['conn']['voicePort'])['success']) {
            echo PREF.$lang['core']['selectSucc'][$config['lang']].PHP_EOL;
        } else {
            exit(ERR.$lang['core']['selectErr'][$config['lang']].PHP_EOL);
        }
        switch($config['conn']['prefix']){
          case 1:
            $botName = "qBot".$config['conn']['botName'];
            break;
    
          case 2:
            $botName = "(qBot)".$config['conn']['botName'];
            break;
    
          case 3:
            $botName = "q-Bot".$config['conn']['botName'];
            break;
    
          case 4:
            $botName = "(q-Bot)".$config['conn']['botName'];
            break;
    
          case 5:
            $botName = $config['conn']['botName']."(qBot)";
            break;
    
          case 6:
            $botName = $config['conn']['botName']."(q-Bot)";
            break;

          case 7:
            $botName = "Stalkersapps.pl".$config['conn']['botName'];
            break;
             break;
    
          default:
            exit(ERR.$lang['core']['prefix'][$config['lang']].PHP_EOL);
        }
        if (strlen($botName) > 30) {
            exit(ERR.$lang['core']['tooLong'][$config['lang']].PHP_EOL);

        }
        if ($ts->setName($botName)) {
            echo PREF.$lang['core']['changeName'][$config['lang']].ORAN.$botName.ENDC.PHP_EOL;
        } else {
            echo WARN.$lang['core']['notName'][$config['lang']].PHP_EOL;
        }
        $cid = $ts->clientInfo($ts->whoAmI()['data']['client_id'])['data']['cid'];
        if ($cid != $config['conn']['channelId']) {
            if ($ts->clientMove($ts->whoAmI()['data']['client_id'], $config['conn']['channelId'])['success']) {
                echo PREF.$lang['core']['channelChanged'][$config['lang']].ORAN.$config['conn']['channelId'].ENDC.PHP_EOL;
            } else {
                echo WARN.$lang['core']['notChanged'][$config['lang']].PHP_EOL;
            }
        }
    } else {
        exit(ERR.$lang['core']['queryErr'][$config['lang']].PHP_EOL);
    }

    echo $lang['core']['preview'][$config['lang']].PHP_EOL;


    $publicChannelGroup = new publicChannelGroup();
    $publicChannelGroupHelper = new publicChannelGroupHelper();

    # get socket
    $socket = $ts->runtime['socket'];

 
        # When user change channel or admin send command or token used
        bot::sendCommand($socket, 'servernotifyregister event=channel id=0');


        # get client channels
        foreach($ts->clientList()['data'] as $client){
          if($client['client_type'] == 0){
            $channels[$client['clid']] = $client['cid'];
          }
        }

        $cldbid = [];

        # save database id
        foreach($ts->clientList()['data'] as $client){
          if($client['client_type'] == 0){
            $cldbid[$client['clid']] = $client['client_database_id'];
          }
        }

        # loop
        while(1){

          # get data from socket
          $client = bot::getData($socket);
          
          # if client join server
          if(array_key_exists('notifycliententerview', $client)){
            $channels[$client['clid']] = $client['ctid'];
            $cldbid[$client['clid']] = $client['client_database_id'];
           
          }

          # if client change channel
          if(array_key_exists('notifyclientmoved', $client)){
            $publicChannelGroup->start(
              $ts, 
              array_merge($ts->clientInfo($client['clid'])['data'], 
              ['clid' => $client['ctid'], 'clid' => $client['clid']]), 
              $config['function'], 
              $channels[$client['clid']], 
              $lang['publicChannelGroup'][$config['lang']]
            );
          }
          if(array_key_exists('clid', $client)){
            $channels[$client['clid']] = $client['ctid'];
          }

          # if client leave
          if(array_key_exists('notifyclientleftview', $client)){
            if(!empty($cldbid[$client['clid']])){
              $publicChannelGroupHelper->start($ts, $cldbid[$client['clid']], $config['function'], $client, $lang['publicChannelGroupHelper'][$config['lang']]);
            }
            unset($cldbid[$client['clid']]);
            unset($channels[$client['clid']]);
          }
          $ts->version($socket);      
    }

} else {
    echo ERR.$lang['core']['connectErr'][$config['lang']].PHP_EOL;
}
