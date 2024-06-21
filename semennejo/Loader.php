<?php

declare(strict_types=1);

namespace semennejo;

use DateTime;

class Loader
{

    public function __construct($data, tg_api $tgApi)
    {
        if ($tgApi->getCommand() === "ping") {
            $start_time = microtime(true);
            $tgApi->replyMessage("На месте и работаю! ответ: " . (number_format((microtime(true) - $start_time) * 1000, 4, ".", "")) . " мс!");
        } else {
            if (strpos($tgApi->getMessage(), "youtube") !== false) {
                if (($video = YouTube::getUrl($tgApi->getMessage())) !== false) {
                    $tgApi->replyMessage($video);
                }else{
                    $tgApi->replyMessage("Ошибка! Попробуйте ещё раз.");
                }
            } elseif (strpos($tgApi->getMessage(), "tiktok") !== false) {
                if (($video = TikTok::getUrl($tgApi->getMessage())) !== false) {
                    $tgApi->replyVideo($video);
                }else{
                    $tgApi->replyMessage("Ошибка! Попробуйте ещё раз.");
                }
            } else {
                $tgApi->replyMessage("Отправь ссылку на публикацию TikTok или YouTube, возможно, ссылка неполная.");
            }
        }
    }

}