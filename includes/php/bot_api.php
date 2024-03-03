<?php
function bot_api($text, $buttons) {
    global $telegram;

    $query_string = http_build_query([
        'chat_id'      => $telegram['chat_id'], 
        'text'         => $text,
        'parse_mode'   => 'html',
        'reply_markup' => json_encode($buttons),
    ]);

    $url = 'https://api.telegram.org/bot' . $telegram['bot_token'] . '/sendMessage';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $query_string,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>