<?php

namespace App\Services;

// use App\Constants\NotificationStrings;

use App\Constants\NotificationStrings;
use App\Models\QueryResponse;
use App\Notifications\FirebaseNotification;
use Google\Cloud\Storage\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;

class QueryResponseService
{
    private int $query_id;
    private int $step_no;
    private array $response;
    private bool $from_patient;

    public function __construct(int $query_id, int $step_no, array $response, bool $from_patient)
    {
        $this->query_id = $query_id;
        $this->step_no = $step_no;
        $this->response = $response;
        $this->from_patient = $from_patient;
    }

    public function execute()
    {
        switch ($this->step_no) {
            case 1:
                return $this->processStepOne();
            case 2:
                return $this->processStepTwo();
            case 3:
                return $this->processStepThree();
            case 4:
                return $this->processStepFour();
            case 5:
                return $this->processStepFive();
            default:
                return [];
        }
    }

    /**
     * @throws \Exception
     */
    private function processStepOne(): QueryResponse
    {
        $validated_input = Validator::validate($this->response, QueryResponse::stepOneFields);
        $query = QueryResponse::where(['query_id' => $this->query_id, 'step' => $this->step_no])->first();
        if ($query != null) {
            $query->response = json_encode($validated_input);
            if (!$query->save()) {
                throw (new \Exception("Database error"));
            }
            return $query;
        }
        if (empty($validated_input)) {
            throw (new \Exception("Response cannot be empty"));
        }
        return QueryResponse::create([
            'query_id' => $this->query_id,
            'step' => $this->step_no,
            'response' => json_encode($validated_input)
        ]);
    }

    /**
     * @throws \Exception
     */
    private function processStepTwo(): QueryResponse
    {
        if ($this->from_patient) {
            try {
                DB::beginTransaction();
                QueryResponse::where('query_id', $this->query_id)->where('step', $this->step_no)->delete();
                $insert = [];
                foreach ($this->response as $docResponse) {
                    $insert[] = [
                        'query_id' => $this->query_id,
                        'step' => $this->step_no,
                        'response' => json_encode($docResponse)
                    ];
                }
                $res = QueryResponse::create($insert);
                DB::commit();
                return $res;
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);
                throw $e;
            }
        }
        $folderPath = 'query_docs/';
        $url = "";
        $notify = !empty($this->response['notify']);
        if (!empty($this->response['proforma_invoice'])) {
            $file = $this->response['proforma_invoice'];
            if (!is_string($file)) {
                $fileName = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $storage = Firebase::storage();
                $storageClient = $storage->getStorageClient();
                $bucket = $storage->getBucket();
                $object = $bucket->upload(
                    fopen($file->getPathname(), 'r'),
                    ['name' => $folderPath . $fileName, 'predefinedAcl' => 'publicRead',], // Upload to the specified folder
                );
                $url = "https://storage.googleapis.com/{$bucket->name()}/{$folderPath}{$fileName}";
            } else {
                $url = $file;
            }
        }
        $validated_input = Validator::validate($this->response, QueryResponse::stepTwoFields);
        $validated_input['proforma_invoice'] = $url;
        $validated_input['document_required'] = $validated_input['document_required'] == "1";
        $query = QueryResponse::where(['query_id' => $this->query_id, 'step' => $this->step_no])->latest()->first();
        if ($query != null && !empty($validated_input['patient'])) {
            $query->response = json_encode($validated_input);
            if (!$query->save()) {
                throw (new \Exception("Database error"));
            }
            return $query;
        }
        if (empty($validated_input)) {
            throw (new \Exception("Response cannot be empty"));
        }
        $query = QueryResponse::create([
            'query_id' => $this->query_id,
            'step' => $this->step_no,
            'response' => json_encode($validated_input)
        ]);
        try {
            $ns = (new NotificationStrings('en'))->get('DOCTOR_RESPONSE');
            $query->parentQuery->notify(new FirebaseNotification($ns['title'], $ns['body']));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $query;
    }

    /**
     * @throws \Exception
     */
    private function processStepThree(): QueryResponse
    {
        $validated_input = Validator::validate($this->response, QueryResponse::stepThreeFields);
        $query = QueryResponse::where(['query_id' => $this->query_id, 'step' => $this->step_no])->first();
        if ($query != null) {
            $query->response = json_encode($validated_input);
            if (!$query->save()) {
                throw (new \Exception("Database error"));
            }
            return $query;
        }
        if (empty($validated_input)) {
            throw (new \Exception("Response cannot be empty"));
        }
        return QueryResponse::create([
            'query_id' => $this->query_id,
            'step' => $this->step_no,
            'response' => json_encode($validated_input)
        ]);
    }

    /**
     * @throws \Exception
     */
    private function processStepFour(): QueryResponse
    {
        $validated_input = Validator::validate($this->response, QueryResponse::stepFourFields);
        $query = QueryResponse::where(['query_id' => $this->query_id, 'step' => $this->step_no])->first();
        if ($query != null) {
            $query->response = json_encode($validated_input);
            if (!$query->save()) {
                throw (new \Exception("Database error"));
            }
            return $query;
        }
        if (empty($validated_input)) {
            throw (new \Exception("Response cannot be empty"));
        }
        return QueryResponse::create([
            'query_id' => $this->query_id,
            'step' => $this->step_no,
            'response' => json_encode($validated_input)
        ]);
    }

    /**
     * @throws \Exception
     */
    private function processStepFive(): QueryResponse
    {
        $validated_input = Validator::validate($this->response, QueryResponse::stepFiveFields);
        $query = QueryResponse::where(['query_id' => $this->query_id, 'step' => $this->step_no])->first();
        if ($query != null) {
            $tickets = [];
            $visa = [];
            if (!empty($validated_input['tickets'])) {
                $tickets = $validated_input['tickets'];
            }
            if (!empty($validated_input['visa'])) {
                $visa = $validated_input['visa'];
            }
            $validated_input = ['tickets' => $tickets, 'visa' => $visa];
            $query->response = json_encode($validated_input);
            if (!$query->save()) {
                throw (new \Exception("Database error"));
            }
            return $query;
        }

        if (empty($validated_input)) {
            throw (new \Exception("Response cannot be empty"));
        }
        return QueryResponse::create([
            'query_id' => $this->query_id,
            'step' => $this->step_no,
            'response' => json_encode($validated_input)
        ]);
    }
}
