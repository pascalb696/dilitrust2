<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends AbstractController
{
    public function new()
    {
        // ...

        $form = $this->createFormBuilder($task)
            ->setAction($this->generateUrl('target_route'))
            ->setMethod('GET')
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        // ...
    }
}
