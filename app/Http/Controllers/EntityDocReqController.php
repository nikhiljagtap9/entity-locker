<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Models\EntityRequest;
use App\Service\CbsService;

class EntityDocReqController extends Controller
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

            $entityRquestDtl = EntityRequest::where('document_uri', $requestDocDtl['URI'])
                ->selectRaw('full_name')
                ->selectRaw('dob')
                ->selectRaw('doc_type')
                ->selectRaw('udf')
                ->selectRaw('uid')
                ->selectRaw('erapp_id')
                ->selectRaw('api_version')
                ->selectRaw('api_timestamp')
                ->selectRaw('api_txn_id')
                ->selectRaw('status')
                ->first();
                $udfArray = json_decode($entityRquestDtl->udf,true);

                if($entityRquestDtl->status == 'success'){
                    if($entityRquestDtl->doc_type == 'ASTMT' || $entityRquestDtl->doc_type == 'LSTMT'){
                        $accountStatmentResp = $this->cbsApiService->accountStatment($udfArray['UDF1'], $udfArray['UDF3'], $udfArray['UDF4']);
                        $accountStatmentRespArr = json_decode($accountStatmentResp->getContent(), true);
                        
                        if($accountStatmentRespArr['data']['responseMessage'] == 'SUCCESS'){
                            $data = [
                                "PullDocResponse" => [
                                    "ResponseStatus" => [
                                        "@attributes" => ["Status" => "1","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                        "@value" => "1",
                                    ],
                                    "DocDetails" => [
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
                            
                            // Return response with XML content
                            return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');
                        }else{
                            $data = [
                                "PullDocResponse" => [
                                    "ResponseStatus" => [
                                        "@attributes" => ["Status" => "0","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                        "@value" => "0",
                                    ],
                                    "DocDetails" => [
                                        "DocContent" => "Request Doc URI is not valid, please review request and try agin later.",
                                    ],
                                ],
                            ];
                            $rootElementName = array_key_first($data);
                            $rootElementData = $data[$rootElementName];
                            
                            // Create the root element
                            $xml = new \SimpleXMLElement('<?xml version="'.$entityRquestDtl->api_version.'" encoding="UTF-8" standalone="yes"?><'.$rootElementName.' xmlns:ns2="http://tempuri.org/" />');
                        
                            // Convert array to XML
                            $xmlResponse = arrayToXml($rootElementData, $xml);
                            
                            // Return response with XML content
                            return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');
                        }
                    }else{
                        $data = [
                            "PullDocResponse" => [
                                "ResponseStatus" => [
                                    "@attributes" => ["Status" => "0","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                    "@value" => "0",
                                ],
                                "DocDetails" => [
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
                        
                        // Return response with XML content
                        return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');
                    }
                }else{
                    $data = [
                        "PullDocResponse" => [
                            "ResponseStatus" => [
                                "@attributes" => ["Status" => "0","ts" => $entityRquestDtl->api_timestamp,"txn" => $entityRquestDtl->api_txn_id],
                                "@value" => "0",
                            ],
                            "DocDetails" => [
                                "DocContent" => "Request Doc URI is not valid, please review the requested details and try again.",
                            ],
                        ],
                    ];
                    $rootElementName = array_key_first($data);
                    $rootElementData = $data[$rootElementName];
                    
                    // Create the root element
                    $xml = new \SimpleXMLElement('<?xml version="'.$entityRquestDtl->api_version.'" encoding="UTF-8" standalone="yes"?><'.$rootElementName.' xmlns:ns2="http://tempuri.org/" />');
                
                    // Convert array to XML
                    $xmlResponse = arrayToXml($rootElementData, $xml);
                    
                    // Return response with XML content
                    return response($xmlResponse->asXML(), 200)->header('Content-Type', 'application/xml');
                }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthing went wrong, please review error >>>> '.$e->getMessage()], 400);
        }
    }

    
}
