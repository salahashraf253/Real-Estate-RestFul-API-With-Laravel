<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUnitRequest;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\UnitCollection;
use App\Http\Resources\UnitResource;
use App\Http\Services\UnitService;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UnitController extends Controller
{
    public function index(SearchUnitRequest $request): UnitCollection
    {
        $limit = (int) $request->query('limit', '10');
        $units = UnitService::buildFilterQuery($request)->paginate($limit);

        return new UnitCollection($units);
    }

    public function show(int $unitId): UnitResource
    {
        return new UnitResource(Unit::findOrFail($unitId));
    }

    public function update(StoreUnitRequest $request, int $unitId): UnitResource
    {
        $unit = Unit::findOrFail($unitId);

        $unit->update($request->validated());

        return new UnitResource($unit);
    }

    public function edit(UpdateUnitRequest $request, int $unitId): UnitResource
    {
        $unit = Unit::findOrFail($unitId);

        $unit->update($request->validated());

        return new UnitResource($unit);
    }

    public function store(StoreUnitRequest $request): UnitResource
    {
        $unit = Unit::create($request->validated());

        if ($request->hasFile('image')) {
            $imageName = $unit->id.'.'.$request->image->getClientOriginalExtension();

            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            $unit->image = asset("storage/app/public/$imageName");
            $unit->save();
        }

        return new UnitResource($unit);
    }

    public function destroy(int $unitId): JsonResponse
    {
        $unit = Unit::findOrFail($unitId);

        $unit->delete();

        return response()->json(
            ['message' => 'Done'],
            HttpResponse::HTTP_OK
        );
    }
}
