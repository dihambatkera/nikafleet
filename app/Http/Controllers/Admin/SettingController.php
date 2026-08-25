<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Exports\AllDataExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Facades\Excel;

class SettingController extends Controller
{
    /**
     * Show settings panel with tabs.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        $currentUser = auth()->user();

        return view('admin.settings.index', compact('admins', 'currentUser'));
    }

    /**
     * Unified update method for POST /admin/tetapan.
     */
    public function update(Request $request)
    {
        if ($request->has('company_name')) {
            return $this->saveCompany($request);
        }
        if ($request->has('booking_min_days')) {
            return $this->saveBooking($request);
        }
        if ($request->has('currency')) {
            return $this->saveFinance($request);
        }
        if ($request->has('current_password')) {
            return $this->updatePassword($request);
        }
        return back()->with('error', 'Tetapan tidak dikenali.');
    }

    /**
     * Save Tab 1: Company Profile.
     */
    public function saveCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'required|string|max:50',
            'address' => 'required|string',
            'tiktok' => 'required|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'google_maps_embed' => 'nullable|string',
            'about_us' => 'required|string',
        ]);

        Setting::set('company_name', $request->company_name);
        Setting::set('tagline', $request->tagline);
        Setting::set('phone', $request->phone);
        Setting::set('whatsapp', $request->whatsapp);
        Setting::set('address', $request->address);
        Setting::set('tiktok', $request->tiktok);
        Setting::set('instagram', $request->instagram ?? '');
        Setting::set('facebook', $request->facebook ?? '');
        Setting::set('google_maps_embed', $request->google_maps_embed ?? '');
        Setting::set('about_us', $request->about_us);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $file->move(public_path(), 'logo.jpeg');
            Setting::set('logo', 'logo.jpeg');
        }

        return redirect()->route('admin.settings.index', ['tab' => 'maklumat-syarikat'])
            ->with('success', 'Maklumat Syarikat berjaya dikemas kini!');
    }

    /**
     * Save Tab 2: Booking Settings.
     */
    public function saveBooking(Request $request)
    {
        $request->validate([
            'booking_min_days' => 'required|integer|min:1',
            'booking_max_advance_days' => 'required|integer|min:1',
            'booking_require_deposit' => 'nullable|boolean',
            'booking_deposit_type' => 'required|in:percentage,fixed',
            'booking_deposit_value' => 'required|numeric|min:0',
            'booking_auto_cancel_hours' => 'required|integer|min:1',
            'booking_confirmation_message' => 'required|string',
            'booking_whatsapp_template' => 'required|string',
        ]);

        Setting::set('booking_min_days', $request->booking_min_days);
        Setting::set('booking_max_advance_days', $request->booking_max_advance_days);
        Setting::set('booking_require_deposit', $request->has('booking_require_deposit') ? '1' : '0');
        Setting::set('booking_deposit_type', $request->booking_deposit_type);
        Setting::set('booking_deposit_value', $request->booking_deposit_value);
        Setting::set('booking_auto_cancel_hours', $request->booking_auto_cancel_hours);
        Setting::set('booking_confirmation_message', $request->booking_confirmation_message);
        Setting::set('booking_whatsapp_template', $request->booking_whatsapp_template);

        return redirect()->route('admin.settings.index', ['tab' => 'tempahan'])
            ->with('success', 'Tetapan Tempahan berjaya dikemas kini!');
    }

    /**
     * Save Tab 3: Financial Settings.
     */
    public function saveFinance(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|max:10',
            'finance_fy_start_month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'finance_late_penalty_per_hour' => 'required|numeric|min:0',
            'finance_tax_applicable' => 'nullable|boolean',
            'finance_tax_rate' => 'required_if:finance_tax_applicable,1|nullable|numeric|min:0|max:100',
            'finance_overhead_expenses' => 'required|numeric|min:0',
        ]);

        Setting::set('currency', $request->currency);
        Setting::set('finance_fy_start_month', $request->finance_fy_start_month);
        Setting::set('finance_late_penalty_per_hour', $request->finance_late_penalty_per_hour);
        Setting::set('finance_tax_applicable', $request->has('finance_tax_applicable') ? '1' : '0');
        Setting::set('finance_tax_rate', $request->finance_tax_rate ?? '0');
        Setting::set('finance_overhead_expenses', $request->finance_overhead_expenses);

        return redirect()->route('admin.settings.index', ['tab' => 'kewangan'])
            ->with('success', 'Tetapan Kewangan berjaya dikemas kini!');
    }

    /**
     * Add new Admin (Tab 4).
     */
    public function storeAdmin(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses dinafikan. Hanya super-admin boleh menambah admin baru.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $user->assignRole('admin');

        return redirect()->route('admin.settings.index', ['tab' => 'admin-pengguna'])
            ->with('success', 'Admin baru berjaya didaftarkan!');
    }

    /**
     * Delete Admin (Tab 4).
     */
    public function destroyAdmin(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses dinafikan. Hanya super-admin boleh memadam admin.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.settings.index', ['tab' => 'admin-pengguna'])
                ->with('error', 'Anda tidak boleh memadam akaun anda sendiri!');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.settings.index', ['tab' => 'admin-pengguna'])
                ->with('error', 'Akaun Super Admin utama tidak boleh dipadam!');
        }

        $user->delete();

        return redirect()->route('admin.settings.index', ['tab' => 'admin-pengguna'])
            ->with('success', 'Pengguna Admin telah berjaya dipadam.');
    }

    /**
     * Change Password (Tab 4).
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('admin.settings.index', ['tab' => 'admin-pengguna'])
                ->with('error', 'Kata laluan semasa tidak betul!');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.settings.index', ['tab' => 'admin-pengguna'])
            ->with('success', 'Kata laluan berjaya dikemas kini!');
    }

    /**
     * Export all data (Tab 5).
     */
    public function exportExcel()
    {
        return Excel::download(new AllDataExport, 'nikafleet_all_data_' . date('Y_m_d_His') . '.xlsx');
    }

    /**
     * Backup DB (Tab 5).
     */
    public function downloadBackup()
    {
        $connection = DB::connection();
        $tables = [];

        if ($connection->getDriverName() === 'mysql') {
            $tablesResult = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $key = "Tables_in_" . $dbName;
            foreach ($tablesResult as $row) {
                $tables[] = $row->$key;
            }
        }

        $sql = "-- NikaFleet Database Backup\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";

        if ($connection->getDriverName() === 'mysql') {
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
        }

        foreach ($tables as $table) {
            // Ignore migrations and password_reset_tokens from backup if desired, but let's backup everything
            $createTable = DB::select("SHOW CREATE TABLE `$table`")[0];
            $key = 'Create Table';
            $sql .= "DROP TABLE IF EXISTS `$table`;\n";
            $sql .= $createTable->$key . ";\n\n";

            $rows = DB::table($table)->get();
            if ($rows->count() > 0) {
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $keys = array_map(fn($k) => "`$k`", array_keys($rowArray));
                    $values = array_map(function($v) use ($connection) {
                        if (is_null($v)) return 'NULL';
                        return $connection->getPdo()->quote($v);
                    }, array_values($rowArray));

                    $sql .= "INSERT INTO `$table` (" . implode(', ', $keys) . ") VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }

        if ($connection->getDriverName() === 'mysql') {
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        }

        $filename = 'nikafleet_backup_' . date('Y_m_d_His') . '.sql';

        return response($sql, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Reset Demo Data (Tab 5).
     */
    public function resetDemoData()
    {
        if (config('app.env') !== 'local') {
            abort(403, 'Aksi ini hanya dibenarkan pada persekitaran local (APP_ENV=local).');
        }

        Artisan::call('migrate:fresh', ['--seed' => true]);

        return redirect()->route('admin.settings.index', ['tab' => 'data-backup'])
            ->with('success', 'Data demo sistem telah berjaya diset semula ke tetapan asal!');
    }
}
