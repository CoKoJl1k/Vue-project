<?php

$config = json_decode(file_get_contents(__DIR__ . '/config.json'));

if (empty($config->email)) {
    exit('Email не настроен');
}

$rate = json_decode(file_get_contents('https://api.nbrb.by/exrates/rates/431'));

if (!$rate) {
    exit('Ошибка получения курса');
}

$currentRate = $rate->Cur_OfficialRate;

if ($currentRate >= $config->threshold) {
    if ($config->lastSent === date('Y-m-d')) {
        exit('Уже отправлено сегодня');
    }

    $subject = 'Курс USD достиг порога';
    $message = "Курс USD: {$currentRate} BYN\nПорог: {$config->threshold} BYN\nДата: " . date('d-m-Y H:i');
    $headers = 'From: notification@super-it.local';

    mail($config->email, $subject, $message, $headers);

    $config->lastSent = date('Y-m-d');
    file_put_contents(__DIR__ . '/config.json', json_encode($config));

    echo "Уведомление отправлено на {$config->email}";
} else {
    echo "Курс {$currentRate} ниже порога {$config->threshold}";
}
