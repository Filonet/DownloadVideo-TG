<?php

declare(strict_types=1);

namespace semennejo;

class Loader
{

    public function __construct($data, tg_api $tgApi)
    {
        if ($tgApi->getCommand() === "ping") {
            $start_time = microtime(true);
            $tgApi->replyMessage("На месте и работаю! ответ: " . (number_format((microtime(true) - $start_time) * 1000, 4, ".", "")) . " мс!");
        } else {
            /*if (strpos($tgApi->getMessage(), "youtube") !== false) { //TODO: Ютуб временно закрыт!
                if (($video = YouTube::getUrl($tgApi->getMessage())) !== false) {
                    $tgApi->request("sendDocument", [
                        "chat_id" => $tgApi->getChatId(),
                        "document" => new CURLFile($video, 'video/mp4', 'video.mp4')
                    ]);
                    $tgApi->replyMessage($video);
                }else{
                    file_put_contents("text.txt", print_r($video, true));
                    $tgApi->replyMessage("Ошибка! Попробуйте ещё раз.");
                }
            } else*/if (strpos($tgApi->getMessage(), "tiktok") !== false) {
                if (($video = TikTok::getUrl($tgApi->getMessage())) !== false) {
                    $tgApi->replyVideo($video);
                }else{
                    $tgApi->replyMessage("Ошибка! Попробуйте ещё раз.");
                }
            } else {
                $tgApi->replyMessage("Отправь ссылку на публикацию TikTok, возможно, ссылка неполная.");
            }
        }
    }

}