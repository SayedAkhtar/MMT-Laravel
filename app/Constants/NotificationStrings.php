<?php

namespace App\Constants;

class NotificationStrings
{
    private $locale;
    private $strings = [
        'DOCTOR_RESPONSE' => [
            'en' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was revieed successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ru' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was revieed successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ar' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was revieed successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'bn' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was revieed successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
        ]
    ];

    public function __construct($locale = 'en')
    {
        $this->locale = $locale;
    }

    public function get($key): array
    {
        return $this->strings[$key][$this->locale];
    }
}
