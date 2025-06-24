<?php

namespace App\Http\Controllers;

use App\Services\Contracts\${CONTROLLER_NAME}ServiceInterface;
use App\Http\Requests\${CONTROLLER_NAME}\Store${CONTROLLER_NAME}Request;
use App\Http\Requests\${CONTROLLER_NAME}\Update${CONTROLLER_NAME}Request;
use App\Models\${CONTROLLER_NAME};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ${CONTROLLER_NAME}Controller extends Controller
{
    protected $${CONTROLLER_NAME,,}Service;

    public function __construct(${CONTROLLER_NAME}ServiceInterface $${CONTROLLER_NAME,,}Service)
    {
        $this->${CONTROLLER_NAME,,}Service = $${CONTROLLER_NAME,,}Service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', ${CONTROLLER_NAME}::class);
        $${CONTROLLER_NAME,,}s = $this->${CONTROLLER_NAME,,}Service->getAll();
        return response()->json($${CONTROLLER_NAME,,}s);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store${CONTROLLER_NAME}Request $request): JsonResponse
    {
        $this->authorize('create', ${CONTROLLER_NAME}::class);
        $${CONTROLLER_NAME,,} = $this->${CONTROLLER_NAME,,}Service->create($request->validated());
        return response()->json($${CONTROLLER_NAME,,}, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $${CONTROLLER_NAME,,} = $this->${CONTROLLER_NAME,,}Service->getById($id);
        if (!$${CONTROLLER_NAME,,}) {
            return response()->json(['message' => '${CONTROLLER_NAME} not found'], 404);
        }
        $this->authorize('view', $${CONTROLLER_NAME,,});
        return response()->json($${CONTROLLER_NAME,,});
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update${CONTROLLER_NAME}Request $request, int $id): JsonResponse
    {
        $${CONTROLLER_NAME,,} = $this->${CONTROLLER_NAME,,}Service->getById($id);
        if (!$${CONTROLLER_NAME,,}) {
            return response()->json(['message' => '${CONTROLLER_NAME} not found'], 404);
        }
        $this->authorize('update', $${CONTROLLER_NAME,,});

        $success = $this->${CONTROLLER_NAME,,}Service->update($id, $request->validated());
        if (!$success) {
            return response()->json(['message' => 'Failed to update ${CONTROLLER_NAME} or ${CONTROLLER_NAME} not found'], 404);
        }
        return response()->json(['message' => '${CONTROLLER_NAME} updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $${CONTROLLER_NAME,,} = $this->${CONTROLLER_NAME,,}Service->getById($id);
        if (!$${CONTROLLER_NAME,,}) {
            return response()->json(['message' => '${CONTROLLER_NAME} not found'], 404);
        }
        $this->authorize('delete', $${CONTROLLER_NAME,,});

        $success = $this->${CONTROLLER_NAME,,}Service->delete($id);
        if (!$success) {
            return response()->json(['message' => 'Failed to delete ${CONTROLLER_NAME} or ${CONTROLLER_NAME} not found'], 404);
        }
        return response()->json(['message' => '${CONTROLLER_NAME} deleted successfully'], 204);
    }
}
