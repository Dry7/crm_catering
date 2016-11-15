<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Helpers\DocHelper;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use App\Repository\EventRepository;
use App\Repository\LogRepository;
use App\Repository\PlaceRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpWord\PhpWord;

/**
 * Class LogController
 * @package App\Http\Controllers
 */
class LogController extends Controller
{
    private $log;

    /**
     * Create a new controller instance.
     *
     * @param LogRepository $log
     */
    public function __construct(
        LogRepository $log
    )
    {
        $this->middleware('auth');

        $this->log = $log;
    }

    /**
     * Show all events
     *
     * @return string
     */
    public function index()
    {
        $logs = $this->log->with('user')->orderBy('created_at', 'DESC')->paginate(100);

        return view('log.index')
            ->with('logs', $logs);
    }
}