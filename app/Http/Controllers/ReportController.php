<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationMeta;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Collection;
use App\Models\Nft;
use App\Models\Report;
use App\Models\User;
use Exception;

class ReportController extends Controller
{
    public function index()
    {
        try {
            $reports = Report::withFilters();
            return response()->json([
                'data' => ReportResource::collection($reports),
                'meta' => PaginationMeta::getPaginationMeta($reports)
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function collection_report(Collection $collection, ReportRequest $request)
    {
        try {
            $data = $request->validated();
            $data['reporter_id'] = auth()->id();
            $collection->reports()->create($data);
            return response()->noContent();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function nft_report(Nft $nft, ReportRequest $request)
    {
        try {
            $data = $request->validated();
            $data['reporter_id'] = auth()->id();
            $nft->reports()->create($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function user_report(User $user, ReportRequest $request)
    {
        try {
            $data = $request->validated();
            $data['reporter_id'] = auth()->id();
            $user->reports()->create($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
