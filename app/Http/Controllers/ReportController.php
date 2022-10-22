<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Collection;
use App\Models\Nft;
use App\Models\Report;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::withFilters();
        return response()->json([
            'data' => ReportResource::collection($reports),
            'meta' => PaginationMeta::getPaginationMeta($reports)
        ]);

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
