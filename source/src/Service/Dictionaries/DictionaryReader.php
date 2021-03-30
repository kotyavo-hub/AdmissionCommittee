<?php

namespace AC\Service\Dictionaries;

use AC\Config\Dictionaries\Enum\DictionaryEnum;
use SimpleXMLElement;

class DictionaryReader
{
    public function read(DictionaryEnum $dictionaryPath)
    {
        $dictionaryPath = $dictionaryPath->getValue();

        $xml = new SimpleXMLElement(file_get_contents($dictionaryPath));

        return json_decode(json_encode($xml),TRUE)['DictionaryItems']['DictionaryItem'];
    }
}