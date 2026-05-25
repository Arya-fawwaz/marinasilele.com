<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.reports.sales');
    }

    public function sales(Request $request)
    {
        // 1. Ambil data pesanan murni dari kolom 'status' yang bernilai sukses/completed
        $query = Order::with(['user', 'items'])
            ->whereIn('status', ['success', 'completed']);

        // 2. Jika Admin menggunakan filter pencarian tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $orders = $query->latest()->get();

        // 3. Menyiapkan Data untuk Grafik Real-time (Tren Pendapatan Harian)
        $chartData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('SUM((SELECT COALESCE(SUM(quantity), 1) FROM order_items WHERE order_items.order_id = orders.id)) as volume')
            )
            ->whereIn('status', ['success', 'completed'])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        $chartDates = $chartData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        });
        $chartTotals = $chartData->pluck('total');
        $chartVolumes = $chartData->pluck('volume');

        // 4. HITUNG RINGKASAN DATA KARTU ATAS SECARA REAL-TIME
        $totalRevenue = $orders->sum('total_amount'); 
        $totalTransactions = $orders->count();        
        
        // FIX KARTU ATAS: Mencegah angka 0 porsi pada ringkasan halaman web laporan
        $totalItemsSold = 0;
        foreach ($orders as $order) {
            $porsi = $order->items ? $order->items->sum('quantity') : 0;
            $totalItemsSold += ($porsi > 0 ? $porsi : 1);
        }

        return view('admin.reports.sales', compact(
            'orders', 
            'chartDates', 
            'chartTotals', 
            'chartVolumes', 
            'totalRevenue', 
            'totalTransactions', 
            'totalItemsSold'
        ));
    }

    public function stock()
    {
        $products = Product::orderBy('stock', 'asc')->get();
        return view('admin.reports.stock', compact('products'));
    }

    /**
     * Ekspor Laporan ke Excel Premium (Berwarna, Bergaris & Rapi)
     */
    public function exportExcel(Request $request)
    {
        $query = Order::with(['user', 'items'])->whereIn('status', ['success', 'completed']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $orders = $query->latest()->get(); 

        $filename = "Laporan_Penjualan_MarinasiLele_" . date('Ymd') . ".xls";

        $totalItemKeseluruhan = 0;
        $totalPendapatanKeseluruhan = 0;

        $html = '<table border="1" style="font-family: Arial, sans-serif; border-collapse: collapse; width: 100%;">';
        
        // --- BAGIAN HEADER ---
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th colspan="5" style="font-size: 16px; font-weight: bold; text-align: center; padding: 15px; background-color: #A81C1C; color: #ffffff;">LAPORAN PENJUALAN MARINASI LELE NUSANTARA</th>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<th style="background-color: #FFB800; color: #000; font-weight: bold; text-align: center; padding: 10px; width: 160px;">No. Order</th>';
        $html .= '<th style="background-color: #FFB800; color: #000; font-weight: bold; text-align: center; padding: 10px; width: 150px;">Tanggal</th>';
        $html .= '<th style="background-color: #FFB800; color: #000; font-weight: bold; text-align: center; padding: 10px; width: 250px;">Pelanggan</th>';
        $html .= '<th style="background-color: #FFB800; color: #000; font-weight: bold; text-align: center; padding: 10px; width: 120px;">Jumlah Item</th>';
        $html .= '<th style="background-color: #FFB800; color: #000; font-weight: bold; text-align: center; padding: 10px; width: 180px;">Total Pendapatan (Rp)</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        
        // --- BAGIAN BODY ---
        $html .= '<tbody>';

        foreach ($orders as $order) {
            $harga = $order->total_amount ?? $order->total_price ?? 0;
            
            // FIX EXCEL BARU: Koleksi objek kosong selalu lolos pengecekan truthy.
            // Kita hitung jumlahnya, jika hasilnya 0 atau kurang, paksa (fallback) agar bernilai 1 porsi.
            $jumlah = $order->items ? $order->items->sum('quantity') : 0;
            if ($jumlah <= 0) {
                $jumlah = 1;
            }
            
            $tanggal = $order->created_at ? $order->created_at->format('d M Y') : '-';

            $html .= '<tr>';
            $html .= '<td style="text-align: center; padding: 5px;">' . ($order->order_number ?? 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)) . '</td>';
            $html .= '<td style="text-align: center; padding: 5px;">' . $tanggal . '</td>';
            $html .= '<td style="padding: 5px;">' . ($order->user->name ?? 'Pelanggan Umum') . '</td>';
            $html .= '<td style="text-align: center; padding: 5px;">' . $jumlah . '</td>';
            $html .= '<td style="text-align: right; padding: 5px;">Rp ' . number_format($harga, 0, ',', '.') . '</td>';
            $html .= '</tr>';

            $totalItemKeseluruhan += $jumlah;
            $totalPendapatanKeseluruhan += $harga;
        }

        // --- BAGIAN FOOTER ---
        $html .= '<tr>';
        $html .= '<td colspan="3" style="text-align: right; font-weight: bold; background-color: #f8f9fa; padding: 10px;">TOTAL KESELURUHAN PENDAPATAN :</td>';
        $html .= '<td style="text-align: center; font-weight: bold; background-color: #f8f9fa; padding: 10px; color: #A81C1C;">' . $totalItemKeseluruhan . ' Porsi</td>';
        $html .= '<td style="text-align: right; font-weight: bold; background-color: #f8f9fa; padding: 10px; color: #A81C1C;">Rp ' . number_format($totalPendapatanKeseluruhan, 0, ',', '.') . '</td>';
        $html .= '</tr>';

        $html .= '</tbody></table>';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function clearData(Request $request)
    {
        $query = Order::whereIn('status', ['success', 'completed']);
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $orders = $query->get();

        foreach ($orders as $order) {
            DB::table('payments')->where('order_id', $order->id)->delete();
            $order->items()->delete(); 
            $order->delete(); 
        }

        return back()->with('success', 'Pembukuan ditutup! Data penjualan berhasil dibersihkan dari database.');
    }
}