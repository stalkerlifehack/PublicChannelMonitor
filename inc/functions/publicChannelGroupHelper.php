<?php

/**********************************************

         Plik: publicChannelGroupHelper.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class publicChannelGroupHelper
{
    public function start($ts, $cldbid, $config, $client, $lang)
    {
        
        if(in_array($ts->channelInfo($client['cfid'])['data']['pid'], $config['publicParentChannels'])){
            $data = json_decode(file_get_contents('cache/saveClientChannel.json'), true);
            unset($data[$client['cfid']][$cldbid]);
            file_put_contents('cache/saveClientChannel.json', json_encode($data));
            $ts->setClientChannelGroup($config['defaultChannelGroup'], $client['cfid'], $cldbid);


            $channelList = $ts->channelClientList($client['cfid'])['data'];
            if(!empty($channelList)){
                foreach($channelList as $user){
                    $allUsers[$user['client_database_id']] = $user['clid'];
                }

                asort($data[$client['cfid']]);

                foreach(array_keys($data[$client['cfid']]) as $newUser){
                    if(array_key_exists($newUser, $allUsers)){  
                        if(!$ts->channelGroupClientList($client['cfid'], $newUser, $config['channelAdminGroup'])['success']){
                            $ts->setClientChannelGroup($config['channelAdminGroup'], $client['cfid'], $newUser);
                            $ts->sendMessage(1, $allUsers[$newUser], $lang['msg1']);
                        }
                        break;
                    }
                }
            }
        }
    }
}

?>