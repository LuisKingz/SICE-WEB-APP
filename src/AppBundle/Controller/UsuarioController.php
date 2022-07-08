<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Services\Helpers;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class UsuarioController extends Controller {

    public function userAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        if ($this->isGranted('ROLE_ADMIN')) {


            $usuarioLista = $em->getRepository('BackendBundle:Usuario')->findAll();


            $personaLista = $qb->select('P')
                    ->from('BackendBundle:Persona', 'P')
                    ->leftjoin('BackendBundle:Usuario', 'U', 'WITH', 'P.idpersona = U.idpersona')
                    ->where($qb->expr()->isNull('U.idpersona'))
                    ->getQuery()
                    ->getResult();


            return $this->render('AppBundle:Default:Usuario.html.twig', array(
                        'usuarioList' => $usuarioLista,
                        'personaList' => $personaLista
            ));
        } else if ($this->isGranted('ROLE_BECARIO')) {

            $personaLista = $qb->select('P')
                    ->from('BackendBundle:Persona', 'P')
                    ->leftjoin('BackendBundle:Usuario', 'U', 'WITH', 'P.idpersona = U.idpersona')
                    ->where($qb->expr()->isNull('U.idpersona'))
                    ->getQuery()
                    ->getResult();
            return $this->render('AppBundle:Default:Usuario.html.twig', array(
                        'personaList' => $personaLista,
            ));
        }
    }

    public function addUserAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $error;
        if ($this->isGranted('ROLE_ADMIN')) {
            $user = new \BackendBundle\Entity\Persona();
            $user2 = new \BackendBundle\Entity\Usuario();

            $rol = 'ROLE_ADMIN';
            $userForm = $this->createForm(\BackendBundle\Form\PersonaType::class, $user);
            $userForm->handleRequest($request);


            $user2Form = $this->createForm(\BackendBundle\Form\Usuario2Type::class, $user2);
            $user2Form->handleRequest($request);

            if ($userForm->isSubmitted() && $userForm->isValid()) {


                $em->persist($user);
                $em->flush();

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user2);
                $password = $encoder->encodePassword($user2->getContrasena(), $user2->getSalt());
                $user2->setContrasena($password);

                if ($user2->getRol() == null && $user->getMatricula() == null) {
                    $user2->setRol('ROLE_ADMIN');
                }

                $user2->setIdpersona($user);
                $em->persist($user2);
                $em->flush();


                $this->addFlash('reg', 'Registro Exitoso');
                return $this->redirectToRoute('app_usuario');
            }
            return $this->render('AppBundle:Default:RegistrarUsuario.html.twig', array(
                        'usuarioForm' => $userForm->createView(),
                        'usuario2Form' => $user2Form->createView(),
                        'rol' => $rol,
                        'flag' => true
            ));
        } else if ($this->isGranted('ROLE_BECARIO')) {
            $user = new \BackendBundle\Entity\Persona();

            $rol = 'ROLE_BECARIO';
            $userForm = $this->createForm(\BackendBundle\Form\PersonaType::class, $user);
            $userForm->handleRequest($request);


            if ($userForm->isSubmitted() && $userForm->isValid()) {

                $em->persist($user);
                $em->flush();

                $this->addFlash('reg', 'Registro Exitoso');
                return $this->redirectToRoute('app_usuario');
            }
            return $this->render('AppBundle:Default:RegistrarUsuario.html.twig', array(
                        'usuarioForm' => $userForm->createView(),
                        'rol' => $rol,
                        'flag' => true
            ));
        } else if ($session == NULL) {
            return $this->redirectToRoute('app_logout');
        }
    }

    public function addUserAdminAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = new \BackendBundle\Entity\Persona();

        $rol = 'ROLE_ADMIN_P';
        $userForm = $this->createForm(\BackendBundle\Form\PersonaType::class, $user);
        $userForm->handleRequest($request);



        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash('reg', 'Registro Exitoso');
            return $this->redirectToRoute('app_usuario');
        }
        return $this->render('AppBundle:Default:RegistrarUsuario.html.twig', array(
                    'usuarioForm' => $userForm->createView(),
                    'rol' => $rol,
                    'flag' => false
        ));
    }

    public function updateUserAdminAction(Request $request, $id) {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BackendBundle:Persona')->find($id);
        $userForm = $this->createForm(\BackendBundle\Form\PersonaType::class, $user);
        $userForm->handleRequest($request);


        $rol = 'ROLE_ADMIN_P';

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $em->persist($user);
            $em->flush();

            $session->remove('valor');
            $this->addFlash('mod', 'Se ha modificado correctamente el equipo.');
            return $this->redirectToRoute('app_usuario');
        }

        return $this->render('AppBundle:Default:modificarUsuario.html.twig', array(
                    'usuarioForm' => $userForm->createView(),
                    'rol' => $rol,
        ));
    }

    public function updateUserAction(Request $request, $id) {
        $session = $request->getSession();
        $session->set('valor', $id);

        $em = $this->getDoctrine()->getManager();
        $flag = false;
        if ($this->isGranted('ROLE_ADMIN')) {
            $user = $em->getRepository('BackendBundle:Persona')->find($id);
            $user2 = $em->getRepository('BackendBundle:Usuario')->findOneBy(['idpersona' => $id]);

            $userForm = $this->createForm(\BackendBundle\Form\PersonaType::class, $user);
            $user2Form = $this->createForm(\BackendBundle\Form\Usuario2Type::class, $user2);
            $user2Form->remove('contrasena');



            $userForm->handleRequest($request);
            $user2Form->handleRequest($request);
            $rol = 'ROLE_ADMIN';

            if ($userForm->isSubmitted() && $userForm->isValid()) {


                $em->persist($user);
                $em->flush();

                $user2->setIdpersona($user);
                $em->persist($user2);
                $em->flush();
                $session->remove('valor');
                $this->addFlash('mod', 'Se ha modificado correctamente el equipo.');
                return $this->redirectToRoute('app_usuario');
            }

            return $this->render('AppBundle:Default:modificarUsuario.html.twig', array(
                        'usuarioForm' => $userForm->createView(),
                        'usuario2Form' => $user2Form->createView(),
                        'rol' => $rol,
                        'flag' => $flag
            ));
        } else if ($this->isGranted('ROLE_BECARIO')) {
            $user = $em->getRepository('BackendBundle:Persona')->find($id);
            $userForm = $this->createForm(\BackendBundle\Form\PersonaType::class, $user);
            $userForm->handleRequest($request);

            $rol = 'ROLE_BECARIO';

            if ($userForm->isSubmitted() && $userForm->isValid()) {
                $em->persist($user);
                $em->flush();
                $session->remove('valor');
                $this->addFlash('mod', 'Se ha modificado correctamente el equipo.');
                return $this->redirectToRoute('app_usuario');
            }

            return $this->render('AppBundle:Default:modificarUsuario.html.twig', array(
                        'usuarioForm' => $userForm->createView(),
                        'rol' => $rol,
            ));
        } else {
            return $this->redirectToRoute('app_logout');
        }
    }

    public function deleteUserAction(Request $request, $id) {
        try {
            $em = $this->getDoctrine()->getManager();
            $user2 = $em->getRepository('BackendBundle:Usuario')->findOneBy(['idpersona' => $id]);

            if ($user2 == NULL) {
                
            } else {
                $em->remove($user2);
                $em->flush();
            }
            $user = $em->getRepository('BackendBundle:Persona')->find($id);

            $em->remove($user);
            $em->flush();

            $this->addFlash('elim', 'Eliminado!');
            return $this->redirectToRoute('app_usuario', array());
        } catch (ForeignKeyConstraintViolationException $ex) {
            $this->addFlash('error', 'No se ha podido eliminar, esta persona se encuentra en registros de prestamos y no podrá ser eliminado hasta eliminar esos registros.');
            return $this->redirectToRoute('app_equipos');
        }
    }

    public function validationAction(Request $request, $id) {
        $session = $request->getSession();

        $val = $request->get('id');
        $response = false;
        $em = $this->getDoctrine()->getManager();
        $Person = $em->getRepository('BackendBundle:Persona')->findOneBy(['matricula' => $val]);

        $idP = $session->get('valor');
        if ($Person != null) {
//            if ($Person->getIdpersona() != $idP) {
//                $response = false;
//            } else {
//                $response = true;
//            }
            $response = true;
        } else if ($Person->getMatricula() == 'Docente') {
            $response = false;
        }

        return new JsonResponse($response);
    }

    public function validationUserAction(Request $request) {
        $val = $request->get('id');
        $response = false;
        $em = $this->getDoctrine()->getManager();
        $Person = $em->getRepository('BackendBundle:Usuario')->findOneBy(['nombreusuario' => $val]);
        if ($Person != null) {
            $response = true;
        }
        return new JsonResponse($response);
    }

}
