<?php

namespace semennejo;

class YouTube
{

    public static function getUrl(string $link)
    {

        parse_str(parse_url($link, PHP_URL_QUERY), $params);
        $video_id = $params['v'] ?? exit;

        $arr = [
            'context' => [
                'client' => [
                    'hl' => 'en',
                    'clientName' => 'WEB',
                    'clientVersion' => '2.20210721.00.00',
                    'mainAppWebInfo' => [
                        'graftUrl' => '/watch?v=' . $video_id
                    ]
                ]
            ],
            'videoId' => $video_id
        ];


        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://www.youtube.com/youtubei/v1/player?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($arr));
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');

        $result = json_decode(curl_exec($curl), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        curl_close($curl);

        $video_details = $result['videoDetails'];
        $streaming_data = $result['streamingData'];
        $formats = $streaming_data['formats'];
        $video_name = $video_details['title'];

        $video = [];

        foreach ($formats as $key) {
            $data = $key;

            $mime_type = explode(';', $data['mimeType']);
            $data['mime'] = $mime_type[0];
            $data['format'] = ltrim(substr($mime_type[0], stripos($mime_type[0], '/')), '/');

            $video[] = $data;
        }

        $video_file_name = strtolower(str_replace(' ', '_', $video_name)) . '.' . $video[0]['format'];
        $download_url = $video[0]['url'];
        $file_name = preg_replace('/[^A-Za-z0-9.\_\-]/', '', basename($video_file_name));


        if ($download_url) {
            header('Cache-Control: public');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . $file_name);
            header('Content-Type: application/zip');
            header('Content-Transfer-Encoding: binary');

            readfile($download_url);
            return $download_url;
        }

        return false;
    }
}