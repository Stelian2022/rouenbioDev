<?php

namespace App\Controller;

use App\Form\JobApplicationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobApplicationController extends AbstractController
{
    #[Route('/job/application', name: 'app_job_application')]
    public function index(Request $request): Response
    {
        $currentPage = 'Postuler';
        $form = $this->createForm(JobApplicationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // Gestion du fichier CV
            $cvFile = $form['cvFile']->getData();

            // Generate a unique name for the file and move it to the directory
            $cvFileName = md5(uniqid()) . '.' . $cvFile->guessExtension();
            $cvFile->move($this->getParameter('cv_directory'), $cvFileName);

            // Envoi des données par e-mail
            $to = 'contact@rouenbiomonde.fr';
            $subject = 'Nouvelle candidature pour l\'offre d\'emploi';
            $message = "Nom: {$formData['nom']}\n";
            $message .= "Prénom: {$formData['prenom']}\n";
            $message .= "Email: {$formData['email']}\n";
            $message .= "Message: {$formData['message']}\n";

            // Create boundary for multipart email
            $boundary = md5(uniqid());

            // Headers for HTML email with attachments
            $headers = "From: {$formData['email']}\r\n";
            $headers .= "Reply-To: {$formData['email']}\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

            // Message body
            $body = "--$boundary\r\n";
            $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $body .= "Nom: {$formData['nom']}\n";
            $body .= "Prénom: {$formData['prenom']}\n";
            $body .= "Email: {$formData['email']}\n";
            $body .= "Message: {$formData['message']}\n";
            $body .= "\r\n--$boundary\r\n";

            // Attachment
            $body .= "Content-Type: application/pdf; name=\"$cvFileName\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$cvFileName\"\r\n\r\n";
            $body .= chunk_split(base64_encode(file_get_contents($this->getParameter('cv_directory').'/'.$cvFileName))) . "\r\n";
            $body .= "--$boundary--";

            // Send the email
            mail($to, $subject, $body, $headers);

            return $this->redirectToRoute('accueil');
        }

        return $this->render('job_application/index.html.twig', [
            'currentPage' => $currentPage,
            'form' => $form->createView(),
        ]);
    }
}
