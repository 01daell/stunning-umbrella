<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDO;

class InstallController extends Controller
{
    public function index()
    {
        return view('install.index', [
            'checks' => $this->extensionChecks(),
            'vendorReady' => file_exists(base_path('vendor/autoload.php')),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_url' => ['required', 'url'],
            'db_host' => ['required', 'string'],
            'db_database' => ['required', 'string'],
            'db_username' => ['required', 'string'],
            'db_password' => ['nullable', 'string'],
            'db_create' => ['nullable', 'boolean'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255'],
            'admin_password' => ['required', 'min:8'],
            'workspace_name' => ['required', 'string', 'max:120'],
        ]);

        if (!file_exists(base_path('vendor/autoload.php'))) {
            return back()->withErrors(['vendor' => 'Upload the prebuilt bundle (including vendor/) before installing.']);
        }

        if (!empty($validated['db_create'])) {
            $this->createDatabase($validated['db_host'], $validated['db_database'], $validated['db_username'], $validated['db_password'] ?? '');
        }

        $env = [
            'APP_NAME' => 'StudioKit',
            'APP_ENV' => 'production',
            'APP_KEY' => 'base64:'.base64_encode(Str::random(32)),
            'APP_DEBUG' => 'false',
            'APP_URL' => $validated['app_url'],
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $validated['db_host'],
            'DB_PORT' => '3306',
            'DB_DATABASE' => $validated['db_database'],
            'DB_USERNAME' => $validated['db_username'],
            'DB_PASSWORD' => $validated['db_password'] ?? '',
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => 'localhost',
            'MAIL_PORT' => '587',
            'MAIL_ENCRYPTION' => 'tls',
            'MAIL_FROM_ADDRESS' => 'hello@studiokit.local',
            'MAIL_FROM_NAME' => 'StudioKit',
        ];

        $contents = collect($env)->map(fn ($value, $key) => $key.'='.$value)->implode("\n");
        file_put_contents(base_path('.env'), $contents."\n");

        config([
            'database.connections.mysql.host' => $validated['db_host'],
            'database.connections.mysql.database' => $validated['db_database'],
            'database.connections.mysql.username' => $validated['db_username'],
            'database.connections.mysql.password' => $validated['db_password'] ?? '',
        ]);
        DB::purge('mysql');

        Artisan::call('migrate', ['--force' => true]);

        $user = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
        ]);

        $workspace = Workspace::create([
            'name' => $validated['workspace_name'],
            'created_by' => $user->id,
        ]);

        $workspace->members()->attach($user->id, ['role' => 'OWNER']);

        return redirect()->route('login')->with('status', 'Installation complete. Please log in.');
    }

    protected function createDatabase(string $host, string $database, string $username, string $password): void
    {
        $dsn = "mysql:host={$host};charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    protected function extensionChecks(): array
    {
        $extensions = ['pdo_mysql', 'openssl', 'mbstring', 'gd', 'imagick', 'zip'];

        return collect($extensions)->mapWithKeys(function ($ext) {
            return [$ext => extension_loaded($ext)];
        })->toArray();
    }
}
