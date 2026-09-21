<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        $purchaseRequests = PurchaseRequest::where('requested_by', Auth::id())
            ->latest()
            ->get();

        return Inertia::render('Staff/PurchaseRequests/Index', [
            'purchaseRequests' => $purchaseRequests,
        ]);
    }

    public function create()
    {
        return Inertia::render('Staff/PurchaseRequests/Create', [
            'items' => Item::select('id', 'name', 'unit')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'exists:items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.note' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $pr = PurchaseRequest::create([
                'pr_number' => 'PR-'.now()->format('Ymd').'-'.Str::upper(Str::random(4)),
                'requested_by' => Auth::id(),
                'unit_kerja' => Auth::user()->unit_kerja,
                'reason' => $validated['reason'],
                'status' => 'menunggu_persetujuan',
            ]);

            foreach ($validated['items'] as $item) {
                $pr->items()->create($item);
            }
        });

        return redirect()->route('staff.purchase-requests.index')
            ->with('success', 'Purchase Request berhasil diajukan.');
    }

    public function show(PurchaseRequest $purchaseRequest)
    {
        abort_unless($purchaseRequest->requested_by === Auth::id(), 403);

        return Inertia::render('Staff/PurchaseRequests/Show', [
            'purchaseRequest' => $purchaseRequest->load('items.item', 'approver'),
        ]);
    }

    public function destroy(PurchaseRequest $purchaseRequest)
    {
        abort_unless($purchaseRequest->requested_by === Auth::id(), 403);
        abort_unless($purchaseRequest->isPending(), 403, 'PR yang sudah diproses tidak bisa dihapus.');

        $purchaseRequest->delete();

        return redirect()->route('staff.purchase-requests.index')
            ->with('success', 'Purchase Request dibatalkan.');
    }
}