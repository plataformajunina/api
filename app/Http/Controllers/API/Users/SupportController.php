<?php

namespace App\Http\Controllers\API\Users;

use App\Actions\Users\Support\CreateSupport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Support\StoreSupportRequest;
use App\Http\Resources\Users\SupportResource;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupportController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreSupportRequest $request): Response
    {
        $supportCreated = app(CreateSupport::class)->execute(
            role: $request->role,
            name: $request->name,
            email: $request->email
        );

        return response(
            content: new SupportResource($supportCreated),
            status: Response::HTTP_CREATED
        );
    }

    public function show(Support $support): Response
    {
        $this->authorize('view', $support);

        return response(
            content: new SupportResource($support),
            status: Response::HTTP_OK
        );
    }

    public function update(Request $request, Support $support)
    {
        //
    }

    public function destroy(Support $support)
    {
        //
    }
}
