<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Models\EntityRequest;
use App\Service\CbsService;

class EntityUriReqController extends Controller
{    
    protected $cbsApiService;
    public function __construct(CbsService $cbsApiService){
        $this->cbsApiService = $cbsApiService;
    }

    public function handle(Request $request){
        // Log xml response
        \Log::info('Webhook received', [$request->getContent()]);

        $requestParam = $request->getContent();
        
        try {
            $parsedXml = simplexml_load_string($requestParam); // xml to object parsing here
            $json = json_encode($parsedXml); // Convert XML to JSON
            $requestDtl = json_decode($json, true); // Convert JSON to associative array
            
            $apiAttribute = $requestDtl['@attributes'];
            $requestDocDtl = $requestDtl['DocDetails'];
            
            $dbInsertResult = $this->insertRequest($requestDocDtl, $apiAttribute);
            
            if($dbInsertResult['status'] == 'success' && !empty($dbInsertResult['erappId'])){
                
                $entityRquestDtl = EntityRequest::where('erapp_id', $dbInsertResult['erappId'])
                ->selectRaw('full_name')
                ->selectRaw('dob')
                ->selectRaw('doc_type')
                ->selectRaw('udf')
                ->selectRaw('uid')
                ->selectRaw('document_uri')
                ->selectRaw('api_version')
                ->selectRaw('api_timestamp')
                ->selectRaw('api_txn_id')
                ->first();
                $udfArray = json_decode($entityRquestDtl->udf,true);

                // validate request details
                $validationResult = $this->validateRequest($udfArray['UDF1'], $udfArray['UDF2'], $entityRquestDtl->full_name);
                if($validationResult['request_valid'] == true){
                        if($entityRquestDtl->doc_type == 'ASTMT' || $entityRquestDtl->doc_type == 'LSTMT'){
                            $accountStatmentResp = $this->cbsApiService->accountStatment($udfArray['UDF1'], $udfArray['UDF3'], $udfArray['UDF4']);
                            $accountStatmentRespArr = json_decode($accountStatmentResp->getContent(), true);
                            
                            if($accountStatmentRespArr['data']['responseMessage'] == 'SUCCESS'){
                                $data = [
                                    "PullURIResponse" => [
                                        "ResponseStatus" => [
                                            "@attributes" => ["Status" => "1","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                            "@value" => "1",
                                        ],
                                        "DocDetails" => [
                                            "DocType" => $entityRquestDtl->doc_type,
                                            "UID" => $entityRquestDtl->uid,
                                            "FullName" => $entityRquestDtl->full_name,
                                            "DOB" => $entityRquestDtl->dob,
                                            "UDF1" => $udfArray['UDF1'],
                                            "UDF2" => $udfArray['UDF2'],
                                            "UDF3" => $udfArray['UDF3'],
                                            "UDF4" => $udfArray['UDF4'],
                                            "URI" => $entityRquestDtl->document_uri,
                                            "DocContent" => $accountStatmentRespArr['data']['statmentPdf'],
                                        ],
                                    ],
                                ];
                                $rootElementName = array_key_first($data);
                                $rootElementData = $data[$rootElementName];
                                
                                // Create the root element
                                $xml = new \SimpleXMLElement('<?xml version="'.$entityRquestDtl->api_version.'" encoding="UTF-8" standalone="yes"?><'.$rootElementName.' xmlns:ns2="http://tempuri.org/" />');
                            
                                // Convert array to XML
                                $xmlResponse = arrayToXml($rootElementData, $xml);
                                
                                //update status of entity request
                                $updateStatus = EntityRequest::where('erapp_id', $dbInsertResult['erappId'])->update(['status' => 'success']);
                                // Return response with XML content
                                return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');
                            }else{
                                $data = [
                                    "PullURIResponse" => [
                                        "ResponseStatus" => [
                                            "@attributes" => ["Status" => "0","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                            "@value" => "0",
                                        ],
                                        "DocDetails" => [
                                            "DocType" => $entityRquestDtl->doc_type,
                                            "UID" => $entityRquestDtl->uid,
                                            "FullName" => $entityRquestDtl->full_name,
                                            "DOB" => $entityRquestDtl->dob,
                                            "UDF1" => $udfArray['UDF1'],
                                            "UDF2" => $udfArray['UDF2'],
                                            "UDF3" => $udfArray['UDF3'],
                                            "UDF4" => $udfArray['UDF4'],
                                            "URI" => $entityRquestDtl->document_uri,
                                            "DocContent" => "Somthing went wrong while document generate, please verify the request details and try again.",
                                        ],
                                    ],
                                ];
                                $rootElementName = array_key_first($data);
                                $rootElementData = $data[$rootElementName];
                                
                                // Create the root element
                                $xml = new \SimpleXMLElement('<?xml version="'.$entityRquestDtl->api_version.'" encoding="UTF-8" standalone="yes"?><'.$rootElementName.' xmlns:ns2="http://tempuri.org/" />');
                            
                                // Convert array to XML
                                $xmlResponse = arrayToXml($rootElementData, $xml);
                                //update status of entity request
                                $updateStatus = EntityRequest::where('erapp_id', $dbInsertResult['erappId'])->update(['status' => 'failed']);
                                // Return response with XML content
                                return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');
                            }
                        }else{
                            $data = [
                                "PullURIResponse" => [
                                    "ResponseStatus" => [
                                        "@attributes" => ["Status" => "0","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                        "@value" => "0",
                                    ],
                                    "DocDetails" => [
                                        "DocType" => $entityRquestDtl->doc_type,
                                        "UID" => $entityRquestDtl->uid,
                                        "FullName" => $entityRquestDtl->full_name,
                                        "DOB" => $entityRquestDtl->dob,
                                        "UDF1" => $udfArray['UDF1'],
                                        "UDF2" => $udfArray['UDF2'],
                                        "UDF3" => $udfArray['UDF3'],
                                        "UDF4" => $udfArray['UDF4'],
                                        "URI" => $entityRquestDtl->document_uri,
                                        "DocContent" => "Request Doc Type is not valid, please review the requested details and try again.",
                                    ],
                                ],
                            ];
                            $rootElementName = array_key_first($data);
                            $rootElementData = $data[$rootElementName];
                            
                            // Create the root element
                            $xml = new \SimpleXMLElement('<?xml version="'.$entityRquestDtl->api_version.'" encoding="UTF-8" standalone="yes"?><'.$rootElementName.' xmlns:ns2="http://tempuri.org/" />');
                        
                            // Convert array to XML
                            $xmlResponse = arrayToXml($rootElementData, $xml);
                            //update status of entity request
                            $updateStatus = EntityRequest::where('erapp_id', $dbInsertResult['erappId'])->update(['status' => 'failed']);
                            // Return response with XML content
                            return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');  
                        }
                }else{
                    //return response()->json(['status'=>$validationResult['status'],'message'=>$validationResult['message'],'status_code'=>$validationResult['status_code']],400);    
                    $data = [
                        "PullURIResponse" => [
                            "ResponseStatus" => [
                                "@attributes" => ["Status" => "0","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                "@value" => "0",
                            ],
                            "DocDetails" => [
                                "DocType" => $entityRquestDtl->doc_type,
                                "UID" => $entityRquestDtl->uid,
                                "FullName" => $entityRquestDtl->full_name,
                                "DOB" => $entityRquestDtl->dob,
                                "UDF1" => $udfArray['UDF1'],
                                "UDF2" => $udfArray['UDF2'],
                                "UDF3" => $udfArray['UDF3'],
                                "UDF4" => $udfArray['UDF4'],
                                "URI" => $entityRquestDtl->document_uri,
                                "DocContent" => $validationResult['message'],
                            ],
                        ],
                    ];
                    $rootElementName = array_key_first($data);
                    $rootElementData = $data[$rootElementName];
                    
                    // Create the root element
                    $xml = new \SimpleXMLElement('<?xml version="'.$entityRquestDtl->api_version.'" encoding="UTF-8" standalone="yes"?><'.$rootElementName.' xmlns:ns2="http://tempuri.org/" />');
                
                    // Convert array to XML
                    $xmlResponse = arrayToXml($rootElementData, $xml);
                    //update status of entity request
                    $updateStatus = EntityRequest::where('erapp_id', $dbInsertResult['erappId'])->update(['status' => 'failed']);
                    // Return response with XML content
                    return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');
                }
            }else{
                return response()->json(['status'=>'error','message'=>'Somthing went wrong while requesting document, Please try again later.','status_code'=>'400'],200);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthing went wrong, please review error >>>> '.$e->getMessage()], 400);
        }

        
    }

    public function insertRequest($requestDocDtl, $apiAttribute){
        
        $entityReq = new EntityRequest();

        $entityReq->api_version = $apiAttribute['ver'];
        $entityReq->api_timestamp = $apiAttribute['ts'];
        $entityReq->api_txn_id = $apiAttribute['txn'];
        $entityReq->org_id = $apiAttribute['orgId'];
        $entityReq->key_hash = $apiAttribute['keyhash'];
        $entityReq->doc_type = $requestDocDtl['DocType'];
        $entityReq->uid = $requestDocDtl['UID'];
        $entityReq->full_name = $requestDocDtl['FullName'];
        $entityReq->dob = $requestDocDtl['DOB'];

        // Filter array to get only keys starting with "UDF"
        $filteredData = array_filter($requestDocDtl, function ($key) {
            return str_starts_with($key, 'UDF');
        }, ARRAY_FILTER_USE_KEY);
        $udfJson = json_encode($filteredData);

        $entityReq->udf = $udfJson;
        $result = $entityReq->save();
        
        if($result == true){
            //Get ERAPP ID to update DOCUMENT URI
            $erappId = $entityReq->erapp_id;

            //Generate Document URI
            $documentUri = $apiAttribute['orgId'].'-'.$requestDocDtl['DocType'].'-'.$erappId;
            $uriRegister = $entityReq->where('erapp_id', $erappId)->update(['document_uri' => $documentUri]);
            
            return $ack = array('erappId'=>$erappId, 'status'=>'success', 'message'=>'Request Registered Successfully.','status_code'=>'200');
        }else{
            return $ack = array('status'=>'error', 'message'=>'Somthing went wrong while request registration, Please try after sometime.','status_code'=>'200');
        }
    }

    public function validateRequest($accountNumber, $mobileNumber, $fullName){
        $cifEnquiryResponse = $this->cbsApiService->cifEnquiry($accountNumber);
        $cifEnquiryRespArr = json_decode($cifEnquiryResponse->getContent(), true);
        
        if($cifEnquiryRespArr['data']['status'] == 'S' && $cifEnquiryRespArr['data']['responseCode'] == '00') {
            $cifEnquiryFullName = $cifEnquiryRespArr['data']['customerName'];
            $cifEnquiryMobileNumber = substr($cifEnquiryRespArr['data']['mobileNo'],-10);
            $mobileNumber = substr($mobileNumber,-10);
            
            if($cifEnquiryMobileNumber === $mobileNumber){
                $nameValidityResult = $this->validateName($fullName,$cifEnquiryFullName);
                $nameMatchPercentage = config('services.core_settings.name_match_percentage');
                if($nameValidityResult >= $nameMatchPercentage){
                    return array('status'=>'success', 'status_code'=>200, 'request_valid'=>true, 'message'=>'Request validate successfully.');
                }else{
                    return array('status'=>'error', 'status_code'=>400,'request_valid'=>false, 'message'=>'Entity full name is not valid, Please verify the details and try agin.');    
                }
            }else{
                return array('status'=>'error', 'status_code'=>400,'request_valid'=>false, 'message'=>'Entity mobile number is not valid, Please verify the details and try agin.');
            }
        }
        
    }

    public function validateName($name1, $name2){
        // Convert names to lowercase and split them into words
        $name1Words = explode(" ", strtolower($name1));
        $name2Words = explode(" ", strtolower($name2));
           
        // Sort the words to ignore the order
        sort($name1Words);
        sort($name2Words);
           
        $name1Words = implode(',', $name1Words);
        $name2Words = implode(',',$name2Words);
        
        // Initialize total similarity and match counts
        $totalSimilarity = 0;
        similar_text($name1Words, $name2Words, $totalSimilarity);
           
        // Calculate the percentage similarity
        return $totalSimilarity;
    }

}
