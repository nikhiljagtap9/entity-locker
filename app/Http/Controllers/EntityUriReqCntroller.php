<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\EntityRequest;

class EntityUriReqCntroller extends Controller
{
    public function handle(Request $request)
    {
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
            
            if($dbInsertResult == true){
                // validate request details
                
                return response()->json(['status' => 'success'], 200);
            }else{
                return response()->json(['status'=>'error','message'=>'Somthing went wrong while requesting document, Please try again later.','status_code'=>'400'],400);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Somthing went wrong, please review error >>>> '.$e->getMessage()], 400);
        }

        
    }

    public function insertRequest($requestDocDtl, $apiAttribute){
        
        $entityReq = new EntityRequest();

        $entityReq->api_version = $apiAttribute['ver'];
        $entityReq->api_timestamp = $apiAttribute['ts'];
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
            $documentUri = $apiAttribute['orgId'].'-'.$requestDocDtl['DocType'].'-'.'statment_'.$erappId;
            $entityReq->where('erapp_id', $erappId)->update(['document_uri' => $documentUri]);
            return true;
        }else{
            return false;
        }
    }


}
