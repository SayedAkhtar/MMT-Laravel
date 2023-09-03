<?php

namespace App\Constants;

class NotificationStrings
{
    private $locale;
    private $strings = [
        'DOCTOR_RESPONSE' => [
            'en' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ru' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ar' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'bn' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
        ],
        'PROCEED_TO_NEXT_STEP' => [
            'en' => [
                'title' => "Your documents have been reviewed.",
                'body' => "HCF has Successfully verified your Documents. Please proceed with your Query Form."
            ],
            'ru' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ar' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'bn' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
        ],
        'PAYMENT_REQUIRED' => [
            'en' => [
                'title' => "Payment Required",
                'body' => "Upon screening, we concluded that you will have to complete a security deposit to proceed. Please Open the query for further actions"
            ],
            'ru' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ar' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'bn' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
        ],
        'MEDICAL_QUERY' => [
            'en' => [
                'title' => "Your Request for Medical Visa Recieved",
                'body' => "You Query was revcied successfully an HCF will review your document. Please Open the query for further actions.",
                'action' => 'listQuery'
            ],
            'ru' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ar' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'bn' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
        ],
        'TICKETS_AND_VISA_VERIFIED' => [
            'en' => [
                'title' => "Your uploaded tickets and visa has been verified.",
                'body' => "Please move to confirmed Screen to view Details of your Assigned HCF"
            ],
            'ru' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'ar' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
            'bn' => [
                'title' => "You have recieved doctor's Response",
                'body' => "You Query was recieved successfully and the our doctor has provided a review for you. Please Open the query for further actions"
            ],
        ],
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
