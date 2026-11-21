<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Menampilkan daftar proyek.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = Project::with('client')
            ->withCount('bids');

        // Klien hanya melihat proyek miliknya
        if ($user->role === 'klien') {
            $query->where('client_id', $user->id);
        }

        // Developer hanya melihat proyek yang terbuka
        elseif ($user->role === 'developer') {
            $query->where('status', 'terbuka');
        }

        $projects = $query->latest()->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Menampilkan form tambah proyek.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Menyimpan proyek baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:50',
            'budget_min' => 'required|integer|min:0|lte:budget_max',
            'budget_max' => 'required|integer|min:1|gte:budget_min',
            'batas_lelang' => 'required|date|after_or_equal:today',
        ]);

        // ID klien diambil dari akun yang sedang login
        $request->user()->projects()->create($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyek berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail proyek.
     */
    public function show(Request $request, Project $project): View
    {
        $user = $request->user();

        // Klien hanya boleh melihat proyek miliknya
        if ($user->role === 'klien') {
            abort_unless(
                $project->client_id === $user->id,
                403
            );
        }

        // Developer hanya boleh melihat proyek terbuka
        elseif ($user->role === 'developer') {
            abort_unless(
                $project->status === 'terbuka',
                404
            );
        }

        $project->load(['client', 'bids.developer']);

        return view('projects.show', compact('project'));
    }

    /**
     * Menampilkan form edit proyek.
     */
    public function edit(Request $request, Project $project): View
    {
        $this->authorizeClientOwner($request, $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Memperbarui data proyek.
     */
    public function update(
        Request $request,
        Project $project
    ): RedirectResponse {

        $this->authorizeClientOwner($request, $project);

        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:50',
            'budget_min' => 'required|integer|min:0|lte:budget_max',
            'budget_max' => 'required|integer|min:1|gte:budget_min',
            'batas_lelang' => 'required|date',
            'status' => 'required|in:terbuka,ditutup',
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyek berhasil diperbarui!');
    }

    /**
     * Menghapus proyek.
     */
    public function destroy(
        Request $request,
        Project $project
    ): RedirectResponse {

        $this->authorizeClientOwner($request, $project);

        // Hapus penawaran terlebih dahulu agar relasi tetap aman
        DB::transaction(function () use ($project) {
            $project->bids()->delete();
            $project->delete();
        });

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyek berhasil dihapus!');
    }

    /**
     * Memastikan proyek hanya dapat dikelola oleh pemiliknya.
     */
    private function authorizeClientOwner(
        Request $request,
        Project $project
    ): void {
        abort_unless(
            $request->user()->role === 'klien'
            && $project->client_id === $request->user()->id,
            403
        );
    }
}
