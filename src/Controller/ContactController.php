<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $mail = ( new TemplatedEmail())
            ->from( new Address($contact['adresseEmail'], $contact['prenom']. ' ' . $contact['nom']) )
            ->to( new Address('stephen.germain971@gmail.com'))
            ->subject($contact['objet'])
            ->htmlTemplate('contact/contactEmail.html.twig')
            ->context([
                'prenom' => $contact['prenom'],
                'nom' => $contact['nom'],
                'adresseEmail' => $contact['adresseEmail'],
                'objet' => $contact['objet'],
                'message' => $contact['message']
            ]);

            $mailer->send($mail);
            $this->addFlash(
                'success',
                'Votre email à bien été envoyé'
            );
        
            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
