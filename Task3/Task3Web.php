<?php

namespace Task3;

include_once 'Task3/ApiService.php';
include_once 'Task3/AbstractTask3.php';

class Task3Web extends AbstractTask3
{
    public function handle(): string
    {
        if (isset($_POST['ico'])) {
            $ico = $_POST['ico'];

            if ((int) $ico === 0) {
                return $this->renderTemplate("Task3/templates/task3-web-form.tpl", [
                    'error' => 'Nesprávny formát IČO'
                ]);
            }

            $url = $this->baseUrl . $ico;
            $apiService = new ApiService();
            try {
                $result = $apiService->get($url);
            } catch (\Exception $exception) {
                echo $exception->getMessage();
                exit();
            }
            $data = json_decode($result, true);

            return $this->renderTemplate("Task3/templates/task3-web-results.tpl", [
                'data' => $data
            ]);
        }

        return $this->renderTemplate("Task3/templates/task3-web-form.tpl", [
            'error' => ''
        ]);
    }

    function renderTemplate(string $template, array $data = []): string
    {
        // Read the template file content
        $templateContent = file_get_contents($template);
        $renderedContent = '';

        foreach ($data as $valueName => $value) {
            if (is_string($value)) {
                $renderedContent = str_replace(
                    "{{ ".$valueName." }}",
                    $value,
                    $templateContent
                );
            }
        }
        if (empty($renderedContent)) {
            $renderedContent = $templateContent;
        }

        // Replace loop placeholders with content based on data
        // Return the final rendered template content
        return $this->replaceString($renderedContent, $data);
    }

    function replaceString(string $renderedContent, array $data): string
    {
        return preg_replace_callback(
            '/{% for ([\w-]+) in ([\w-]+) %}(.*?){% endfor %}/s',
            function ($matches) use ($data) {
                $loopVar = $matches[1];
                $dataVar = $matches[2];
                $loopContent = $matches[3];
                $output = "";
                if (isset($data[$dataVar])) {
                    foreach ($data[$dataVar] as $itemKey => $item) {
                        if (is_array($item)) {
                            $output .= str_replace("{{ $loopVar }}", $itemKey . ': ' . implode(',', $item), $loopContent);
                        } elseif (!empty($item)) {
                            $output .= str_replace("{{ $loopVar }}", $itemKey . ': ' . $item, $loopContent);
                        }
                    }
                }
                return $output;
            },
            $renderedContent
        );
    }
}