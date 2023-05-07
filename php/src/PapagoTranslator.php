<?php
class PapagoTranslator
{
    private $client_id;
    private $client_secret;
    private $url = "https://openapi.naver.com/v1/papago/n2mt";

    function __construct($client_id, $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    public function translate($text, $source, $target)
    {
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
        $headers[] = "X-Naver-Client-Id: " . $this->client_id;
        $headers[] = "X-Naver-Client-Secret: " . $this->client_secret;

        $postData = array(
            'source' => $source,
            'target' => $target,
            'text' => $text
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

        $result = curl_exec($ch);

        if ($result === false) {
            throw new Exception(curl_error($ch));
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new Exception('HTTP Error');
        }

        curl_close($ch);

        $json = json_decode($result, true);

        if (!$json) {
            throw new Exception('JSON decode error');
        }

        if (isset($json['errorMessage'])) {
            throw new Exception('API error');
        }

        if (!isset($json['message']['result']['translatedText'])) {
            throw new Exception('Unexpected response format');
        }

        return $json['message']['result']['translatedText'];
    }
}
