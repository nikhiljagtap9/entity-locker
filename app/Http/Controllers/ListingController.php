<?php

namespace App\Http\Controllers;

use App\Models\EntityRequest;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function totalRequest()
    {
        $data = EntityRequest::select('erapp_id', 'document_uri', 'org_id', 'doc_type', 'full_name', 'status')
        ->get(); // Returns a collection

        return view('batch.listing', ['data' => $data]);
    }

    public function successRequest()
    {
        $data = EntityRequest::where('status', 'success')
        ->select('erapp_id', 'document_uri', 'org_id', 'doc_type', 'full_name', 'status')
        ->get(); // Returns a collection

    return view('batch.listing', ['data' => $data]);
    }

    public function failedRequest()
    {
        $data = EntityRequest::where('status', 'failed')
        ->select('erapp_id', 'document_uri', 'org_id', 'doc_type', 'full_name', 'status')
        ->get();
    //dd($data);

    return view('batch.listing', ['data' => $data]);
    }

    public function pendingRequest()
    {
        $data = EntityRequest::where('status', 'pending')
        ->select('erapp_id', 'document_uri', 'org_id', 'doc_type', 'full_name', 'status')
        ->get();
    //dd($data);

    return view('batch.listing', ['data' => $data]);
    }

}