<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class EquipoController extends Controller {

    public function equipoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $equipolist = $em->getRepository('BackendBundle:Equipos')->findAll();

        return $this->render('AppBundle:Default:equipos.html.twig', array
                    ('equipoList' => $equipolist,));
    }

    public function equipoRegistroAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $equipo = new \BackendBundle\Entity\Equipos();
        $equipoForm = $this->createForm(\BackendBundle\Form\EquiposType::class, $equipo);
        $equipoForm->handleRequest($request);

        if ($equipoForm->isSubmitted() && $equipoForm->isValid()) {
            $equipo->setEstadoequipo(1);
            $em->persist($equipo);
            $em->flush();

            $this->addFlash('reg', 'Se ha registrado correctamente el equipo.');
            return $this->redirectToRoute('app_equipos');
        }

        return $this->render('AppBundle:Default:registroEquipo.html.twig', array
                    ('equipoForm' => $equipoForm->createView()
        ));
    }

    public function equipoModificarAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $equipo = $em->getRepository('BackendBundle:Equipos')->find($id);

        $equipoForm = $this->createForm(\BackendBundle\Form\EquiposType::class, $equipo);
        $equipoForm->handleRequest($request);

        if ($equipoForm->isSubmitted() && $equipoForm->isValid()) {
            $em->persist($equipo);
            $em->flush();

            $this->addFlash('mod', 'Se ha modificado correctamente el equipo.');
            return $this->redirectToRoute('app_equipos');
        }

        return $this->render('AppBundle:Default:modificarEquipo.html.twig', array
                    ('equipoForm' => $equipoForm->createView()
        ));
    }

    public function equipoEliminarAction(Request $request, $id) {
        try {
            $em = $this->getDoctrine()->getManager();
            $equipo = $em->getRepository('BackendBundle:Equipos')->find($id);
            $equipo->setEstadoequipo(3);
            $em->persist($equipo);
            $flush = $em->flush();

            if ($flush == null) {
                $this->addFlash('elim', 'Se ha eliminado correctamente al equipo.');
                return $this->redirectToRoute('app_equipos');
            }
        } catch (ForeignKeyConstraintViolationException $ex) {
            $this->addFlash('error', 'No se ha podido eliminar, este equipo se encuentra en registros de prestamos y no podrá ser eliminado hasta eliminar esos registros.');
            return $this->redirectToRoute('app_equipos');
        }
    }

}
