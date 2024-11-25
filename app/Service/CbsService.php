<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CbsService
{
    protected $baseUrl;
    protected $apiEnv;
    protected $apiExecutionMode;
    public function __construct(){
        $this->baseUrl = config('services.cbs_api.local.baseurl');
        $this->apiEnv = config('services.cbs_api.local.api_env');
        $this->apiExecutionMode = config('services.cbs_api.local.api_exec_mode');

    }
    protected function post($endpoint, $data = []){
        // Log request details
        Log::info('Sending POST request to:', [
            'url' => $this->baseUrl . $endpoint,
            'data' => $data
        ]);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . $endpoint, $data);
        Log::info('Received response:', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);
        return $this->handleResponse($response);
    }
    public function cifEnquiry($account_number){   
        if($this->apiEnv == 'prod'){
            $endPoint = config('services.cbs_api.prod.cif_enquiry.endpoint');
            $vendor = config('services.cbs_api.prod.cif_enquiry.vendor');
            $client = config('services.cbs_api.prod.cif_enquiry.client');
        }elseif($this->apiEnv == 'uat'){
            $endPoint = config('services.cbs_api.uat.cif_enquiry.endpoint');
            $vendor = config('services.cbs_api.uat.cif_enquiry.vendor');
            $client = config('services.cbs_api.uat.cif_enquiry.client');
        }else{
            $endPoint = config('services.cbs_api.local.cif_enquiry.endpoint');
            $vendor = config('services.cbs_api.local.cif_enquiry.vendor');
            $client = config('services.cbs_api.local.cif_enquiry.client');
        }

        $requestId = 'req' . time();

        $arr = array(
            "data" => array(
                'requestId' => $requestId,
                'requestType' => 'CIFEnquiry',
                'accountNoCustNo' => $account_number
            ),
            "reqTimestamp" => time(),
            "vendor" => $vendor,
            "requestId" => $requestId,
            "client" => $client,
            "chksum" => "13456"
        );
        try {
            if($this->apiExecutionMode == 'uat' || $this->apiExecutionMode == 'prod'){
                $response = $this->post($endpoint, $arr);
            }
            if($this->apiExecutionMode == 'local'){
                $response = config('services.cbs_api.local.cif_enquiry.response');
            }
            $res = response()->json($response);
        } catch (\Exception $e) {
            $res = response()->json(['error' => $e->getMessage()], 500);
        }
        return $res;
    }
    public function accountStatment($account_number,$fromDate,$toDate){   
        if($this->apiEnv == 'prod'){
            $endPoint = config('services.cbs_api.prod.account_statment.endpoint');
            $vendor = config('services.cbs_api.prod.account_statment.vendor');
            $client = config('services.cbs_api.prod.account_statment.client');
        }elseif($this->apiEnv == 'uat'){
            $endPoint = config('services.cbs_api.uat.account_statment.endpoint');
            $vendor = config('services.cbs_api.uat.account_statment.vendor');
            $client = config('services.cbs_api.uat.account_statment.client');
        }else{
            $endPoint = config('services.cbs_api.local.account_statment.endpoint');
            $vendor = config('services.cbs_api.local.account_statment.vendor');
            $client = config('services.cbs_api.local.account_statment.client');
        }

        $requestId = 'req' . time();

        $arr = array(
            "data" => array(
                'requestId' => $requestId,
                'requestType' => 'AccountStatement',
                'referenceNo' => '2850',
                'accountNo' => $account_number,
                'fromDate'=> $fromDate,
                'toDate'=> $toDate,
                'isPasswordProtected' => 'N'
            ),
            "reqTimestamp" => time(),
            "vendor" => $vendor,
            "requestId" => $requestId,
            "client" => $client,
            "chksum" => "13456"
        );
        try {
            if($this->apiExecutionMode == 'uat' || $this->apiExecutionMode == 'prod'){
                $response = $this->post($endpoint, $arr);
            }
            if($this->apiExecutionMode == 'local'){
                $response = config('services.cbs_api.local.account_statment.response');
            }
            $res = response()->json($response);
        } catch (\Exception $e) {
            $res = response()->json(['error' => $e->getMessage()], 500);
        }
        return $res;
    }
    protected function handleResponse($response){
        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('API request failed with status ' . $response->status());
    }
}
