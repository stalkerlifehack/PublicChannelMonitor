<?php

/**********************************************

         Plik: language.php
              Autor: Angel. & Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

$lang = [

     /*
          Core
     */
     'core' => [
          'author' => [
               'PL' => 'Autor',
               'EN' => 'Author',
          ],
          'version' => [
               'PL' => 'Wersja',
               'EN' => 'Version'
          ],
          'loadingFiles' => [
               'PL' => 'Ładowanie potrzebnych plików...',
               'EN' => 'Loading necessary files...',
          ],
          'checkCache' => [
               'PL' => "Sprawdzanie plików cache...",
               'EN' => "Checking cache files...",
          ],
          'newCache' => [
               'PL' => "Utworzono brakujące pliki cache!",
               'EN' => "Cache files created!",
          ],

          'connSucc' => [
               'PL' => "Pomyślnie połączono z serwerem!",
               'EN' => "Successfully connected to server!",
          ],
          'querySucc' => [
               'PL' => "Pomyślnie zalogowano na query!",
               'EN' => "Successfully logged to query!",
          ],
          'selectSucc' => [
               'PL' => "Pomyślnie wybrano serwer!",
               'EN' => "Successfully selected server!",
          ],
          'selectErr' => [
               'PL' => "Bot nie mógł wybrać serwera!",
               'EN' => "Bot couldnt select server!",
          ],
          'prefix' => [
               'PL' => "Musisz wybrać prefix bota!",
               'EN' => "You have to select bot prefix",
          ],
          'tooLong' => [
               'PL' => "Nazwa bota jest za długa!",
               'EN' => "The bot name i too long!",
          ],
          'changeName' => [
               'PL' => "Bot zmienił nazwę na ",
               'EN' => "Bot changed his name to ",
          ],
          'notName' => [
               'PL' => "Bot nie mógł zmienić nazwy!",
               'EN' => "Bot couldnt change his name!",
          ],
          'channelChanged' => [
               'PL' => "Bot zmienił kanał na ",
               'EN' => "Bot changed channel to ",
          ],
          'notChanged' => [
               'PL' => "Bot nie mógł zmienić kanału!",
               'EN' => "Bot couldnt change the channel!",
          ],
          'queryErr' => [
               'PL' => "Bot nie mógł się zalogować na query!",
               'EN' => "Bot couldnt login to query!",
          ],
          'preview' => [
               'PL' => "Podgląd:",
               'EN' => "Preview:",
          ],
          'connectErr' => [
               'PL' => "Bot nie mógł się połączyć z serwerem!",
               'EN' => "Bot couldnt connect to server!",
          ],
          'loop' => [
               'PL' => "    Pętla wykonała sie w ",
               'EN' => "    Loop executed in ",
          ],

     ],



     /*
          Functions
     */

     'publicChannelGroup' =>[
          'PL' => [
               'msg1' => 'Wszedłeś/aś jako pierwszy/a na ten kanał, więc otrzymujesz channel admina!',
               'msg2' => 'Obecny channel admin opuścił kanał, teraz ty przemujesz dowodzenie!',
          ],
          'EN' => [
               'msg1' => 'You enter this channel first, so you got channel admin!',
               'msg2' => 'The current channel admin has left the channel, now you are the commander!',
          ]
     ],
     'publicChannelGroupHelper' => [
          'PL' => [
               'msg1' => 'Obecny channel admin opuścił kanał, teraz ty przemujesz dowodzenie!',
          ],
          'EN' => [
               'msg1' => 'The current channel admin has left the channel, now you are the commander!',
          ]
     ]   
];
?>