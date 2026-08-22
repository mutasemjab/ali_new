<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Qr;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index()
    {
        $qrs = Qr::latest()->paginate(15);

        return view('store.qrs.index', compact('qrs'));
    }

    public function create()
    {
        return view('store.qrs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url|max:255',
        ]);

        Qr::create([
            'link' => $request->link,
            'photo' => $this->generateQrImage($request->link),
        ]);

        return redirect()->route('store.qrs.index')->with('success', 'QR code generated successfully');
    }

    public function destroy(Qr $qr)
    {
        $qr->delete();

        return back()->with('success', 'QR code deleted');
    }

    /**
     * Generates a QR code image (SVG, no Imagick required) for the given
     * link and saves it under assets/uploads/qrs. Returns the relative path.
     */
    private function generateQrImage(string $link): string
    {
        $folder = 'assets/uploads/qrs';

        if (! is_dir(base_path($folder))) {
            mkdir(base_path($folder), 0777, true);
        }

        $filename = uniqid() . '_' . time() . '.svg';

        QrCode::size(300)->generate($link, base_path($folder . '/' . $filename));

        return $folder . '/' . $filename;
    }
}
