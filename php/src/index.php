<?php
require_once 'PapagoTranslator.php';
require_once 'config.php';

function main()
{
    // POST 데이터가 없을 경우 처리ï
    if (empty($_POST)) {
        echo ('Request does not have values');
        return;
    }

    $post_data = json_decode($_POST['payload'], true);

    // POST 데이터가 JSON 형식이 아닐 경우 처리
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo ('Request data is not a valid JSON');
        return;
    }


    $text = $post_data['message']['text'];
    $response_url = $post_data['response_url'];

    // 번역 결과가 없을 경우 처리
    try {
        $translator = new PapagoTranslator(CLIENT_ID, CLIENT_SECRET);

        $translated_text = $translator->translate($text, 'ja', 'ko');

        if (!$translated_text) {
            echo ('Translation failed');
            return;
        }

        $send_data = json_encode(array(
            "text" => $translated_text
        ));

        $ch = curl_init($response_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        // curl 에러시 처리
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
    } catch (Exception $e) {
        echo 'An error occurred';
    } finally {
        if (!empty($ch)) {
            curl_close($ch);
        }
    }
}

main();
