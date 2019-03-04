<?php



namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\FormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;






class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, FormAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**********************************************************************/

           echo "<pre>";
           var_dump( $_FILES); die;

           imagecreatefromjpeg($file);

            //retrive the file send in the request
            $file = $request->files->get('registration_form')['photo'];

            //put the path to the folder that will stock our files in a var
            $uploads_user_directory = $this->getParameter('uploads_user_directory');

            //create a var to change the name of the file
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            
            //move the file into the folder
            $file->move(
                $uploads_user_directory,
                $filename
            );

            //set the user photo's attribut
            $user->setPhoto($filename);

        /**********************************************************************/  
            
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
