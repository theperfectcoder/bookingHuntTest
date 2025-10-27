<?php
declare(strict_types=1);

namespace App\Http\Controllers\Hunting;

use App\Http\Requests\Hunting\StoreBookingRequest;
use App\Http\Resources\Hunting\BookingResource;
use Symfony\Component\HttpFoundation\Response;
use App\Actions\Hunting\CreateBookingAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use RuntimeException;

final class BookingController extends Controller
{
    /**
     * @var CreateBookingAction
     */
    private CreateBookingAction $createBookingAction;

    public function __construct(CreateBookingAction $createBookingAction)
    {
        $this->createBookingAction = $createBookingAction;
    }

    /**
     * @param StoreBookingRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->createBookingAction->execute($request->validated());

            return (new BookingResource($booking))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (RuntimeException $e) {
            $message = $e->getMessage();
            $status = match ($message) {
                'Guide not found.' => Response::HTTP_BAD_REQUEST,
                'Guide is not active.' => Response::HTTP_BAD_REQUEST,
                'Guide already booked for this date.' => Response::HTTP_CONFLICT,
                default => Response::HTTP_INTERNAL_SERVER_ERROR,
            };

            return response()->json(['message' => $message], $status);
        }
    }
}
