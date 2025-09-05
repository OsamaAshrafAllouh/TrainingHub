<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogController extends Controller
{

    function __construct(){
        $this->middleware('permission:admin-logfile-download', ['only' => ['showLogs']]);
    }

    public function showLogs(){
        $logFile = storage_path('logs/laravel.log');

        if (File::exists($logFile)) {
            return new BinaryFileResponse($logFile, 200, [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="laravel.log"',
            ]);
        } else {
            return response('Log file not found.', 404);
        }
    }
}
