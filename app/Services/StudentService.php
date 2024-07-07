<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{

    public function StoreSudent($data, $user_id)
    {
        $student = Student::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'degree'     => $data['degree'],
            'user_id'    => $user_id
        ]);
        return $student;
    }
}
