<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StudentController extends AbstractController
{
    #[Route('/students', name: 'student_list')]
    public function list(StudentRepository $studentRepository): Response
    {
        $students = $studentRepository->findAllStudents();
        return $this->render('student/list.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/student/edit/{id}', name: 'student_edit')]
    public function edit(int $id): Response
    {
        return new Response("Modifier étudiant ID : $id");
    }

    #[Route('/student/delete/{id}', name: 'student_delete')]
    public function delete(int $id): Response
    {
        return new Response("Supprimer étudiant ID : $id");
    }

}
