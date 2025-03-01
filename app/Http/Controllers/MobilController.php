<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\MobilRepositoryInterface;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    protected $mobilRepository;

    public function __construct(MobilRepositoryInterface $mobilRepository)
    {
        $this->mobilRepository = $mobilRepository;
    }

    public function index()
    {
        $mobils = $this->mobilRepository->paginate(10);

        return view('mobils.index', compact('mobils'));
    }

    public function create()
    {
        return view('mobils.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa,perawatan',
        ]);

        $this->mobilRepository->create($request->all());

        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mobil = $this->mobilRepository->getById($id);
        if (! $mobil) {
            return redirect()->route('mobils.index')->with('error', 'Mobil tidak ditemukan.');
        }

        return view('mobils.show', compact('mobil'));
    }

    public function edit($id)
    {
        $mobil = $this->mobilRepository->getById($id);
        if (! $mobil) {
            return redirect()->route('mobils.index')->with('error', 'Mobil tidak ditemukan.');
        }

        return view('mobils.edit', compact('mobil'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa,perawatan',
        ]);

        $mobil = $this->mobilRepository->update($id, $request->all());

        if (! $mobil) {
            return redirect()->route('mobils.index')->with('error', 'Gagal memperbarui mobil.');
        }

        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $deleted = $this->mobilRepository->delete($id);

        if (! $deleted) {
            return redirect()->route('mobils.index')->with('error', 'Gagal menghapus mobil.');
        }

        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil dihapus.');
    }
}
