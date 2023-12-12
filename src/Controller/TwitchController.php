<?php

namespace App\Controller;

use App\Entity\Twitch;
use App\Form\TwitchType;
use App\Repository\TwitchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/twitch')]
class TwitchController extends AbstractController
{
    #[Route('/index', name: 'app_twitch_index', methods: ['GET'])]
    public function index(TwitchRepository $twitchRepository): Response
    {
        return $this->render('twitch/index.html.twig', [
            
        ]);
    }

    
}
