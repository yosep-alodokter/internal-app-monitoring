<?php

namespace App\Helpers;

class ConfigurationHelper
{
    public function typeOfConfiguration()
    {
        $listTypeOfConfiguration = [
            "email_notification" => "Email Notification",
            "app_info" => "App Information",
        ];

        return $listTypeOfConfiguration;
    }
}