<?php

namespace Task3;

class ApiService
{
    /**
     * @throws \Exception
     */
    public function get($url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        curl_close($ch);

        if ($output === false) {
            throw new \Exception(curl_error($ch));
        }

        return $output;
    }
}