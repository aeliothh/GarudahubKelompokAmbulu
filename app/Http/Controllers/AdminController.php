<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    public function index(): View
    {
        $stats = [
            'totalUsers' => User::count(),

            'totalClients' => User::where(
                'role',
                'klien'
            )->count(),

            'totalDevelopers' => User::where(
                'role',
                'developer'
            )->count(),

            'totalProjects' => Project::count(),

            'openProjects' => Project::where(
                'status',
                'terbuka'
            )->count(),

            'closedProjects' => Project::where(
                'status',
                'ditutup'
            )->count(),

            'totalBids' => Bid::count(),

            'completedProjects' => Project::whereHas(
                'bids',
                function ($query) {
                    $query->where('is_winner', true);
                }
            )->count(),
        ];

        $latestProjects = Project::with('client')
            ->latest()
            ->take(5)
            ->get();

        $latestBids = Bid::with([
            'project',
            'developer'
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestProjects',
            'latestBids'
        ));
    }

    /**
     * Menampilkan daftar seluruh pengguna.
     */
    public function users(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', compact('users'));
    }

    /**
     * Menampilkan dan memfilter seluruh proyek.
     */
    public function projects(Request $request): View
    {
        $query = Project::with('client')
            ->withCount('bids');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $projects = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Project::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.projects', compact(
            'projects',
            'categories'
        ));
    }

    /**
     * Menampilkan dan memfilter seluruh penawaran.
     */
    public function bids(Request $request): View
    {
        $query = Bid::with([
            'project',
            'developer'
        ]);

        // Pencarian berdasarkan proyek atau developer
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('project', function ($projectQuery) use ($search) {
                    $projectQuery->where(
                        'judul',
                        'like',
                        "%{$search}%"
                    );
                })

                ->orWhereHas('developer', function ($developerQuery) use ($search) {
                    $developerQuery->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });

            });
        }

        // Filter berdasarkan status penawaran
        if ($request->result === 'winner') {
            $query->where('is_winner', true);
        } elseif ($request->result === 'pending') {
            $query->where('is_winner', false);
        }

        $bids = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.bids', compact('bids'));
    }
}
