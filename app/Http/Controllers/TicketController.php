<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Services\AIService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $perPage = $request->per_page ?? 20;
        $orderBy = $request->order_by ?? 'DESC';
        $criteria = $request->criteria ?? false;
        $category = $request->category ?? false;
        $status = $request->status ?? false;
        $priority = $request->priority ?? false;

        $query = Ticket::when($orderBy, function ($q) use ($orderBy) {
            return $q->orderBy('id', $orderBy);
        });

        $query->when($criteria, function ($q) use ($criteria) {
            return $q->where('title', 'like', '%' . $criteria . '%')
                ->orWhere('description', 'like', '%' . $criteria . '%');
        });

        $query->when($category, function ($q) use ($category) {
            return $q->where('category', strtolower($category));
        });

        $query->when($status, function ($q) use ($status) {
            return $q->where('status', strtolower($status));
        });

        $query->when($priority, function ($q) use ($priority) {
            return $q->where('priority', strtolower($priority));
        });

        try {
            $tickets = $isPaginated
                ? $query->paginate($perPage)
                : $query->get();
            return TicketResource::collection(
                $tickets
            );
        } catch (Exception $e) {
            Log::info('Error occured during Tickets index method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $aiService = new AIService;
            $data["summary"] = $aiService->createTicketSummary($data);

            $ticket = Ticket::create($data);
            
            
            DB::commit();
            
            return (new TicketResource($ticket))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollback();
            Log::info('Error occured during Tickets store method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        try {
            return new TicketResource($ticket);
        } catch (Exception $e) {
            Log::info('Error occured during Tickets show method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $aiService = new AIService;
            $data["summary"] = $aiService->createTicketSummary($data);
            $ticket->update($data);
            
            DB::commit();
            
            return (new TicketResource($ticket))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollback();
            Log::info('Error occured during Tickets update method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        DB::beginTransaction();
        try {
            $ticket->delete();
            DB::commit();
            return response()->noContent();
        } catch (Exception $e) {
            DB::rollback();
            Log::info('Error occured during Tickets delete method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }
}
