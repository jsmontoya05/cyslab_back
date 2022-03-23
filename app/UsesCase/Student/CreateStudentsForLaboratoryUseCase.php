<?php

declare(strict_types=1);

namespace App\UsesCase\Student;

use App\Services\StudentService;


final class CreateStudentsForLaboratoryUseCase
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function execute(
        String $labAccountName,
        String $labName,
        Array $emails)
    {
        $response = $this->studentService->createStudents($labAccountName,$labName,$emails);
        return $response;
    }
}
