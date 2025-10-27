<?php
declare(strict_types=1);

namespace App\Http\Controllers\Hunting;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Hunting\GuideResource;
use App\Actions\Hunting\GetGuidesListAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class GuideController extends Controller
{
    /**
     * @var GetGuidesListAction
     */
    private GetGuidesListAction $getGuidesListAction;

    public function __construct(GetGuidesListAction $getGuidesListAction)
    {
        $this->getGuidesListAction = $getGuidesListAction;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $minExp = $request->integer('min_experience');
        $guides = $this->getGuidesListAction->execute($minExp);

        return GuideResource::collection($guides);
    }
}
