<?php

declare(strict_types=1);

namespace App\UsesCase\Student;

use App\Services\StudentService;

final class FindStudentsForLaboratoryUseCase
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function execute(String $labAccountName,String $labName)
    {
        $response = $this->studentService->obtainStudents($labAccountName,$labName);
        return $response;
    }
}
