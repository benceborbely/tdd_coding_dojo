<?php

namespace Util;

/**
 * Class Curl
 *
 * @author Bence Borbély
 */
class Curl
{
    /**
     * @param string $url
     * @return string
     */
    public function get($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
