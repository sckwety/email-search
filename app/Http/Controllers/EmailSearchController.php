<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailSearchPostRequest;

class EmailSearchController extends Controller
{
    public function searchForm()
    {
        return view('emails-search/form');
    }

    public function search(EmailSearchPostRequest $request)
    {
        $searchParameters = $request->validated();
        dd($searchParameters);
    }
}
