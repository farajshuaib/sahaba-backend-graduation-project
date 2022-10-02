<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Collection;
use App\Models\Nft;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {

    }

    public function collection_report(Collection $collection, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $collection->reports()->create($data);
        return response()->noContent();
    }


    public function nft_report(Nft $nft, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $nft->reports()->create($data);
    }

    public function user_report(User $user, ReportRequest $request)
    {
        $data = $request->validated();
        $data['reporter_id'] = auth()->id();
        $user->reports()->create($data);
    }
}
