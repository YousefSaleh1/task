<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
        /**
     * @var BookService
     */
    protected $studentService;

    /**
     * BookController constructor.
     *
     * @param BookService $bookService
     */
    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students= Student::with('user')->latest()->paginate(5);
        return view('index' , compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $studentData = $request->validated();
            $user_id = auth()->user()->id;
            $student = $this->studentService->StoreSudent($studentData, $user_id);

            event(new \App\Events\StoreStudentEvent($student));

            return redirect()->route('student.create')
            ->with('success','Student created successfully.');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->route('student.create')
            ->with('error','Failed To Create !');
        }
    }
}
