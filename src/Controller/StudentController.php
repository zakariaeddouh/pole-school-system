<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('student/create', name: 'student_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $student = New Student();

        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($student);
            $em->flush();

            $this->addFlash('success', 'Étudiant créé avec succès');
            return $this->redirectToRoute('student_list');
        }

        return $this->render('student/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
