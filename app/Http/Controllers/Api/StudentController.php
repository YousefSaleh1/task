<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    use ApiResponseTrait;

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
        $students = Student::all();
        $data = StudentResource::collection($students);

        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $studentData = $request->validated();
            $user_id = auth()->guard('api')->user()->id;
            $student = $this->studentService->StoreSudent($studentData, $user_id);

            event(new \App\Events\StoreStudentEvent($student));

            $data = new StudentResource($student);
            return $this->customeResponse($data, 'Successfully Created', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => 'Failed To Create !'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $data = new StudentResource($student);
        return $this->customeResponse($data, 'Done!', 200);
    }

}
