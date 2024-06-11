<?php

namespace Task3;

include_once 'Task3/ApiService.php';
include_once 'Task3/AbstractTask3.php';

class Task3Cli extends AbstractTask3
{
    public function handle(): string
    {
        echo "Zadajte ICO: ";
        $input = rtrim(fgets(STDIN));

        if ((int) $input === 0) {
            echo 'Nesprávny formát IČO';
            exit();
        }

        $url = $this->baseUrl . $input;

        $apiService = new ApiService();
        try {
            $result = $apiService->get($url);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            exit();
        }

        $result = json_decode($result, true);
        $return = '';

        foreach ($result as $name => $value) {
            if (is_array($value)) {
                $return .= $name . " : " . PHP_EOL;
                foreach ($value as $subName => $subValue) {
                    $return .= PHP_TAB . $subName . " : " . $subValue . PHP_EOL;
                }
            } else {
                $return .= $name . " : " . $value . PHP_EOL;
            }
        }

        return $return;
    }
}