<?php

namespace App\AppBundle\Controller\api;

use App\AppBundle\Entity\Post;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Router;
use App\AppBundle;
use App\AppBundle\Controller\api;
class PostController extends AbstractController
{
    /**
     * @Route("/api/posts/{id}", name="show_post")
     * @param $id
     * @return JsonResponse
     */
    public function showPost($id)
    {
        $post=$this->getDoctrine()->getRepository('AppBundle::Post')->find($id);

        if (empty($post)){
            $response=array(
                'code'=>1,
                'message'=>'post not found',
                'error'=>null,
                'result'=>null
            );

            return new JsonResponse( Response::HTTP_NOT_FOUND, $response,  'false');

        }
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data=$serializer-> serialize($post, 'json');

        $response=array(
            'code'=>0,
            'message'=>'success',
            'error'=>null,
            'result'=>json_decode($data)
        );
        return new JsonResponse($response, 200);
    }
}
?>