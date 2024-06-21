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
                $tgApi->replyMessage("request processing YouTube");
            } elseif (strpos($tgApi->getMessage(), "tiktok") !== false) {
                $tiktok = new TikTok();
                $url = trim($tgApi->getMessage());
                $resp = $tiktok->getContent($url);
                $check = explode('"downloadAddr":"', $resp);
                if (count($check) > 1) {
                    $contentURL = explode("\"", $check[1])[0];
                    $contentURL = $tiktok->escape_sequence_decode($contentURL);
                    $videoKey = $tiktok->getKey($contentURL);
                    $cleanVideo = "https://api2-16-h2.musical.ly/aweme/v1/play/?video_id=$videoKey&vr_type=0&is_play_url=1&source=PackSourceEnum_PUBLISH&media_type=4";
                    $cleanVideo = $tiktok->getContent($cleanVideo, true);

                    $video = $tiktok->downloadVideo($contentURL);
                    $tgApi->replyVideo("https://ankarian-mc.ru/bot/".$video); //TODO: вот так вот
                }

            } else {
                $tgApi->replyMessage("Отправь ссылку на публикацию TikTok или YouTube, возможно, ссылка неполная.");
            }
        }
    }

}