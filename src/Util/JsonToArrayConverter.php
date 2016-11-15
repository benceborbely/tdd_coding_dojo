<?php

namespace Util;

/**
 * Class JsonToArrayConverter
 *
 * @author Bence Borbély
 */
class JsonToArrayConverter
{
    /**
     * @param string $json
     * @return array
     */
    public function convert($json)
    {
        return json_decode($json, true);
    }
}
