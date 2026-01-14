<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use App\Entity\Course;
use App\Entity\Profile;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1) Créer quelques classes (Classroom)
        $classroom1 = new Classroom();
        $classroom1->setName('Classe A');
        $classroom1->setLevel('Licence 1');
        $manager->persist($classroom1);

        $classroom2 = new Classroom();
        $classroom2->setName('Classe B');
        $classroom2->setLevel('Licence 2');
        $manager->persist($classroom2);

        // 2) Créer quelques cours (Course)
        $courseMath = new Course();
        $courseMath->setTitle('Mathématiques');
        $courseMath->setDescription('Cours de mathématiques avancées.');
        $manager->persist($courseMath);

        $courseWeb = new Course();
        $courseWeb->setTitle('Développement Web');
        $courseWeb->setDescription('HTML, CSS, JavaScript, Symfony.');
        $manager->persist($courseWeb);

        $courseEnglish = new Course();
        $courseEnglish->setTitle('Anglais');
        $courseEnglish->setDescription('Cours d’anglais niveau intermédiaire.');
        $manager->persist($courseEnglish);

        // 3) Créer quelques étudiants (Student) avec profils (Profile)
        // Student 1
        $student1 = new Student();
        $student1->setFirstName('Alice');
        $student1->setLastName('Durand');
        $student1->setEmail('alice.durand@example.com');
        $student1->setClassroom($classroom1); // ManyToOne

        $profile1 = new Profile();
        $profile1->setPhone('0600000001');
        $profile1->setAddress('10 rue de Paris, 75000 Paris');
        $profile1->setBio('Étudiante sérieuse, passionnée de web.');
        $profile1->setStudent($student1);     // OneToOne (owning side)

        // ManyToMany : cours suivis par Alice
        $student1->addCourse($courseMath);
        $student1->addCourse($courseWeb);

        $manager->persist($student1);
        $manager->persist($profile1);

        // Student 2
        $student2 = new Student();
        $student2->setFirstName('Bob');
        $student2->setLastName('Martin');
        $student2->setEmail('bob.martin@example.com');
        $student2->setClassroom($classroom1);

        $profile2 = new Profile();
        $profile2->setPhone('0600000002');
        $profile2->setAddress('20 avenue de Lyon, 69000 Lyon');
        $profile2->setBio('Étudiant qui aime la programmation.');
        $profile2->setStudent($student2);

        // Bob suit Math + Anglais
        $student2->addCourse($courseMath);
        $student2->addCourse($courseEnglish);

        $manager->persist($student2);
        $manager->persist($profile2);

        // Student 3
        $student3 = new Student();
        $student3->setFirstName('Claire');
        $student3->setLastName('Dupont');
        $student3->setEmail('claire.dupont@example.com');
        $student3->setClassroom($classroom2);

        $profile3 = new Profile();
        $profile3->setPhone('0600000003');
        $profile3->setAddress('5 boulevard Victor Hugo, 34000 Montpellier');
        $profile3->setBio('Étudiante intéressée par les langues.');
        $profile3->setStudent($student3);

        // Claire suit Web + Anglais
        $student3->addCourse($courseWeb);
        $student3->addCourse($courseEnglish);

        $manager->persist($student3);
        $manager->persist($profile3);

        // 4) Envoyer toutes les données en base
        $manager->flush();
    }
}
