<?php

namespace App\Services;

use App\Models\QueryResponse;
use Illuminate\Support\Facades\Validator;

class QueryResponseService
{
    private int $query_id;
    private int $step_no;
    private array $response;

    public function __construct(int $query_id, int $step_no, array $response)
    {
        $this->query_id = $query_id;
        $this->step_no = $step_no;
        $this->response = $response;
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
        $validated_input = Validator::validate($this->response, QueryResponse::stepTwoFields);
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
