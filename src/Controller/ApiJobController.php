<?php

namespace App\Controller;

use App\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class ApiJobController extends AbstractController
{
    public $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }
    /**
     * @Route("/jobs", name="api_job_index", methods={"GET"})
     */
    public function index()
    {

        $jobs = $this->getDoctrine()->getRepository(Job::class)->findAll();

        $data = $this->serializer->normalize($jobs, null, ['groups' => 'all_jobs']);

        $jsonContent = $this->serializer->serialize($data, 'json');

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/jobs/{id}", name="api_job_patch", methods={"GET"})
     */
    public function show(Request $request, Job $job)
    {
        $this->getDoctrine()->getRepository(Job::class)->find('id');
       


        $manager = $this->getDoctrine()->getManager();
        $data = $this->serializer->normalize($job, null, ['groups' => 'all_jobs']);
        $jsonContent = $this->serializer->serialize($data, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content - Type', 'application / json');
        return $response;
        $manager->flush();

        return new Response(null, 202);
    }


    /**
     * @Route("/jobs", name="api_job_create", methods={"POST"})
     */
    public function create(Request $request)
    {

        /**
         * On créée un restaurant en prenant les données de la requête
         */
        $job = new Job;
        $job->setTitle($request->request->get('title'));

        
    


        /**
         * On enregistre en base de données
         */

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($job);
        $entityManager->flush();
        return new Response(null, 201);
    }



    /**
     * @Route("/jobs/{job}", name="api_job_patch", methods={"POST"})
     */
    public function update(Request $request, Job $job)
    {


        if (!empty($request->request->get('title'))) {
            $job->setTitle($request->request->get('title'));
        }


        $manager = $this->getDoctrine()->getManager();
        $manager->flush();
        

        return new Response(null, 202);
    }
    /**
     * @Route("/jobs/{job}", name="api_job_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Job $job)
    {

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($job);

        $manager->flush();

        return new Response(null, 200);
    }
}
