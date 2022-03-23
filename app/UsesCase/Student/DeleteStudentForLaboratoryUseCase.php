<?php

declare(strict_types=1);

namespace App\UsesCase\Student;

use App\Services\StudentService;


final class DeleteStudentForLaboratoryUseCase
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function execute(
        String $labAccountName,
        String $labName,
        String $userName)
    {
        $response = $this->studentService->deleteStudent($labAccountName,$labName,$userName);
        return $response;
    }
}
