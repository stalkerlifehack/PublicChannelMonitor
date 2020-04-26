<?php 
/**********************************************

         Plik: bot.class.php.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/
    class bot{
        public static function getData($socket)
            {
                $data = fgets($socket, 4096);
                if (!empty($data)) {
                    $datasets = explode(' ', $data);
                    $output = array();
                    foreach ($datasets as $dataset) {
                        $dataset = explode('=', $dataset);
                        if (count($dataset) > 2) {
                            for ($i = 2; $i < count($dataset); $i++) {
                                $dataset[1] .= '='.$dataset[$i];
                            }
                            $output[self::unEscapeText($dataset[0])] = self::unEscapeText($dataset[1]);
                        } elseif (count($dataset) == 1) {
                            $output[self::unEscapeText($dataset[0])] = '';
                        } else {
                            $output[self::unEscapeText($dataset[0])] = self::unEscapeText($dataset[1]);
                        }
                    }
                    return $output;
                }
            }

            private static function unEscapeText($text)
            {
                $escapedChars = array("\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/");
                $unEscapedChars = array('', '', '', '', '', ' ', '|', '/');
                $text = str_replace($escapedChars, $unEscapedChars, $text);
                return $text;
            }

            public static function sendCommand($socket, $command)
            {
                $splittedCommand = str_split($command, 1024);
                $splittedCommand[(count($splittedCommand) - 1)] .= "\n";
                foreach ($splittedCommand as $commandPart) {
                    fputs($socket, $commandPart);
                }

                return fgets($socket, 4096);
            }
    }
?>
    