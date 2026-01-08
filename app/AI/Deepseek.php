<?php

namespace App\AI;

use DeepSeek\DeepSeekClient;
use DeepSeek\Enums\Models;
use NewsViewsView;

class Deepseek
{
    private  $apiKey = 'sk-86b7daf668e14b65a4631b6606486832';
    private function connect($prompt)
    {
        // اطلاعات API
        $apiKey = 'sk-86b7daf668e14b65a4631b6606486832'; // کلید API خود را اینجا وارد کنید
        $apiUrl = 'https://api.deepseek.com/v1/endpoint'; // آدرس API DeepSeek

        // داده‌هایی که می‌خواهید به API ارسال کنید
        $data = [
            'prompt' => $prompt,
            'max_tokens' => 50,
            'temperature' => 0.7,
        ];
        // تنظیمات درخواست cURL
        $ch = curl_init($apiUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // دریافت پاسخ به عنوان رشته
        curl_setopt($ch, CURLOPT_POST, true); // ارسال درخواست POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // ارسال داده‌ها به صورت JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey, // افزودن کلید API به هدر
        ]);

        // اجرای درخواست و دریافت پاسخ
        $response = curl_exec($ch);

        // بررسی خطاها
        if (curl_errno($ch)) {
            $alert = 'خطا در ارسال درخواست: ' . curl_error($ch);
            curl_close($ch);
            return [
                'result' => false,
                'msg' => $alert
            ];
        }
        // دریافت کد وضعیت HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode == 200) {
            // پردازش پاسخ موفقیت‌آمیز
            $responseData = json_decode($response, true);
            return [
                'result' => true,
                'data' => $responseData
            ];
        } else {
            return [
                'result' => false,
                'msg' => "خطا در دریافت پاسخ. کد وضعیت: $httpCode <br> پاسخ: $response"
            ];
        }

    }
    public function chat($question)
    {


    }


}
