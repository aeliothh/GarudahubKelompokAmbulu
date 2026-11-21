<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BidController extends Controller
{
    /**
     * Menampilkan daftar penawaran milik developer.
     */
    public function index(Request $request): View
    {
        $bids = $request->user()
            ->bids()
            ->with('project')
            ->latest()
            ->paginate(10);

        return view('bids.index', compact('bids'));
    }

    /**
     * Memproses pengajuan penawaran oleh developer.
     */
    public function store(
        Request $request,
        Project $project
    ): RedirectResponse {

        abort_unless(
            $request->user()->role === 'developer',
            403
        );

        $validated = $request->validate([
            'harga' => 'required|integer|min:1',
            'durasi' => 'required|integer|min:1',
            'proposal' => 'required|string|max:5000',
        ]);

        return DB::transaction(function () use (
            $request,
            $project,
            $validated
        ) {

            // Mengunci proyek selama proses pengajuan
            $lockedProject = Project::whereKey($project->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Memeriksa status dan batas lelang
            if (
                $lockedProject->status !== 'terbuka'
                || $lockedProject->batas_lelang->lt(today())
            ) {
                return back()->withErrors([
                    'project' => 'Proyek sudah ditutup dan tidak menerima penawaran.',
                ]);
            }

            // Memeriksa penawaran yang sudah pernah diajukan
            $alreadyBid = $lockedProject->bids()
                ->where('developer_id', $request->user()->id)
                ->exists();

            if ($alreadyBid) {
                return back()->withErrors([
                    'bid' => 'Kamu sudah pernah mengajukan penawaran pada proyek ini.',
                ]);
            }

            // Menyimpan penawaran
            $request->user()->bids()->create([
                'project_id' => $lockedProject->id,
                'harga' => $validated['harga'],
                'durasi' => $validated['durasi'],
                'proposal' => $validated['proposal'],
            ]);

            return redirect()
                ->route('projects.show', $lockedProject)
                ->with('success', 'Penawaran berhasil diajukan!');
        });
    }

    /**
     * Memproses pemilihan developer sebagai pemenang.
     */
    public function selectWinner(
        Request $request,
        Project $project,
        Bid $bid
    ): RedirectResponse {

        // Memastikan pengguna merupakan klien pemilik proyek
        abort_unless(
            $request->user()->role === 'klien'
            && (int) $project->client_id === (int) $request->user()->id,
            403
        );

        return DB::transaction(function () use ($project, $bid) {

            // Mengunci proyek agar pemilihan pemenang tidak bersamaan
            $lockedProject = Project::whereKey($project->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Memeriksa apakah proyek masih terbuka
            if (
                $lockedProject->status !== 'terbuka'
                || $lockedProject->batas_lelang->lt(today())
            ) {
                return back()->withErrors([
                    'winner' => 'Proyek sudah ditutup atau batas lelang telah berakhir.',
                ]);
            }

            // Memastikan penawaran berasal dari proyek tersebut
            $selectedBid = $lockedProject->bids()
                ->whereKey($bid->id)
                ->firstOrFail();

            // Memastikan penawaran dibuat oleh developer
            abort_unless(
                $selectedBid->developer()->where('role', 'developer')->exists(),
                403
            );

            // Memastikan proyek belum mempunyai pemenang
            $hasWinner = $lockedProject->bids()
                ->where('is_winner', true)
                ->exists();

            if ($hasWinner) {
                return back()->withErrors([
                    'winner' => 'Pemenang proyek ini sudah ditentukan.',
                ]);
            }

            // Memperbarui status penawaran dan proyek
            $lockedProject->bids()->update([
                'is_winner' => false,
            ]);

            $selectedBid->update([
                'is_winner' => true,
            ]);

            $lockedProject->update([
                'status' => 'ditutup',
            ]);

            return redirect()
                ->route('projects.show', $lockedProject)
                ->with('success', 'Developer berhasil dipilih sebagai pemenang!');
        });
    }
}
