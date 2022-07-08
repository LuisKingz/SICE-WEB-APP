<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('BackendBundle:Default:login.html.twig', array(
                    'error_auth' => $error
        ));
    }

    public function roleCheckAction(Request $param) {
        if ($this->isGranted('ROLE_ADM')) {
            return $this->render('BackendBundle:Default:index.html.twig');
        } else if ($this->isGranted('ROLE_EMP')) {
            return $this->render('BackendBundle:Default:index.html.twig');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

}
