<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('AppBundle:Default:login.html.twig', array(
                    'error_auth' => $error
        ));
    }

    public function roleCheckAction(Request $param) {
       $session = $param->getSession();
       
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_BECARIO')) {
          //  $session->set('I', $param->getIdusuario());
           // $session->set('nombre', $this->getIdpersona()->getNombre().' '.$this->getIdpersona()->getPrimerapellido().''.$this->getIdpersona()->getSegundoapellido());
            return $this->render('AppBundle:Default:index.html.twig', array());
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

//    public function indexAction(Request $request) {
//        $em = $this->getDoctrine()->getManager();
//        $usuario = new \BackendBundle\Entity\Usuario();
//        $usuarioForm = $this->createForm(\BackendBundle\Form\UsuarioType::class, $usuario);
//        $usuarioForm->handleRequest($request);
//
//
//        if ($usuarioForm->isSubmitted() && $usuarioForm->isValid()) {
//            $user = $usuario->getNombreusuario();
//            $pass = $usuario->getContrasena();
//
//            $userEntity = $em->getRepository('BackendBundle:Usuario')
//                    ->findOneBy(['nombreusuario' => $user, 'contrasena' => $pass]);
//
//            if ($userEntity != NULL) {
//                $role = $userEntity->getRol();
//                $iduser = $userEntity->getIdusuario();
//
//                $session = $request->getSession();
//                
//                $session->set('nombre', $userEntity->getIdpersona()->getNombre()." ".$userEntity->getIdpersona()->getPrimerapellido()." ".$userEntity->getIdpersona()->getSegundoapellido());
//
//                if ($role == "ROLE_ADMIN") {
//
//                    // $session->start();
//
//                    $admin = $em->getRepository('BackendBundle:Usuario')->find($iduser);
//                  //  $session->set('datos', $admin->getIdpersona()->getNombre() + " " + $admin->getIdpersona()->getPrimerapellido() + " " + $admin->getIdpersona()->getSegundoapellido());
//                    $session->set('rol', $admin->getRol());
//
//                    return $this->redirectToRoute('app_usuario');
//                } else if ($role == "ROLE_BECARIO") {
//
//                    //  $session->start();
//
//                    $becario = $em->getRepository('BackendBundle:Usuario')->find($iduser);
//                    
//                   // $nombre = $becario->getIdpersona()->getNombre() + " " + $becario->getIdpersona()->getPrimerapellido() + " " + $becario->getIdpersona()->getSegundoapellido();
//                  //  $session->set('nombre', $nombre );
//                    
//                    $session->set('rol', $becario->getRol());
//                    return $this->redirectToRoute('app_usuario');
//                }
//            } else {
//                $this->addFlash('error', 'Error en el usuario o contraseña');
//                return $this->redirectToRoute('app_login');
//            }
//        }
//
//        return $this->render('AppBundle:Default:login.html.twig', array(
//                    'usuarioList' => null,
//                    'usuarioForm' => $usuarioForm->createView()
//        ));
//    }
}
