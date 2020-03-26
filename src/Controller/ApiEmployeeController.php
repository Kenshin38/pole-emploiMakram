<?php

namespace App\Controller;


use App\Entity\Employee;
use App\Entity\Job;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class ApiEmployeeController extends AbstractController
{
    public $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/api/employees", name="api_employee_index", methods={"GET"})
     */
    public function index()
    {

        $employees = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        $data = $this->serializer->normalize($employees, null, ['groups' => 'all_employees']);

        $jsonContent = $this->serializer->serialize($data, 'json');

         $response = new Response($jsonContent);
         
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/employees", name="api_employee_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        

        /**
         * On créée un restaurant en prenant les données de la requête
         */
        $employee = new Employee;
        $employee->setFirstname($request->request->get('firstname'));
        $employee->setLastname($request->request->get('lastname'));
        $date = new \DateTime($request->request->get('employement_date'));
        $employee->setEmployementDate($date);


        /**
         * On récupère les users 1 et city 1 (car l'objet Restaurant s'attend à des objets)
         */
        $job = $this->getDoctrine()->getRepository(Job::class)->find($request->request->get('job_id'));

        $employee->setJob($job);
     

        /**
         * On enregistre en base de données
         */

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($job);
        $entityManager->flush();
        return new Response(null, 201);
    }
    /**
     * @Route("api/employees/{id}", name="api_employee_patch", methods={"GET"})
     */
    public function show(Request $request, Employee $employee)
    {
        $id = $this->getDoctrine()->getRepository(Employee::class)->find('id');
        $employee->setId($id);
        
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();
        $data = $this->serializer->normalize($employee, null, ['groups' => 'all_jobs']);
        $jsonContent = $this->serializer->serialize($data, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content - Type', 'application / json');
        return $response;
        
    }
    /**
     * @Route("api/employees/{job}/edit", name="api_employee_patch", methods={"POST"})
     */
    public function update(Request $request, Employee $employee)
    {


        if (!empty($request->request->get('firstname'))) {
            $employee->setFirstname($request->request->get('firstname'));
        }
        if (!empty($request->request->get('lastname'))) {
            $employee->setLastname($request->request->get('lastname'));
        }
        if (!empty($date = new \DateTime($request->request->get('employement_date')))) {
            $employee->setEmployementDate($date);
        }
     
        if (!empty($request->request->get('job_id'))) {
            $employee->setJob($this->getDoctrine()->getRepository(Job::class)->find($request->request->get('job_id')));
        }
       


        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        return new Response(null, 202);
    }
    /**
     * @Route("api/employees/{employee}", name="api_employee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, employee $employee)
    {

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($employee);

        $manager->flush();

        return new Response(null, 200);
    }
}

