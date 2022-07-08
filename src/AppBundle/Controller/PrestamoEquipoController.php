<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Helpers;
use DOMDocument;
use mPDF;

class PrestamoEquipoController extends Controller {

    public function prestamoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $prestamosList = $em->getRepository('BackendBundle:PrestamosEquipo')->findBy(array(),
                 array('fechaentrega' => 'ASC') );

        return $this->render('AppBundle:Default:prestamosEquipos.html.twig', array
                    ('prestamosList' => $prestamosList,
            ));
    }

    public function prestamoFormAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $equipolist = $em->getRepository('BackendBundle:Equipos')->findAll();
        $usuarioList = $em->getRepository('BackendBundle:Persona')->findAll();

        return $this->render('AppBundle:Default:prestamoEquipo.html.twig', array(
                    'equipoList' => $equipolist,
                    'usuarioList' => $usuarioList,
        ));
    }

    public function prestamoRegistroAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        //  Registro del prestamo:
        $prestamo = new \BackendBundle\Entity\PrestamosEquipo();

        $equipo = $em->getRepository('BackendBundle:Equipos')->find($request->get('_idequipo'));
        $prestante = $em->getRepository('BackendBundle:Usuario')->find($request->get('_idprestante'));
        $solicitante = $em->getRepository('BackendBundle:Persona')->find($request->get('_idpersona'));

        $prestamo->setIdequipo($equipo);
        $prestamo->setIdprestador($prestante);
        $prestamo->setIdsolicitante($solicitante);

        // Settear la hora:
        date_default_timezone_set('Mexico/General');
        $format = 'Y-m-d H:i:s';
        $fecha = date('Y-m-d H:i:s');
        $date = \DateTime::createFromFormat($format, $fecha);

        $prestamo->setFechaprestamo($date);

        $em->persist($prestamo);
        $em->flush();

        //Modificación del estado del equipo:
        $equipo->setEstadoequipo(2);
        $em->persist($equipo);
        $em->flush();

        $this->addFlash('reg', 'Se ha registrado correctamente el prestamo.');
        return $this->redirectToRoute('app_prestamo_registrar');
    }

    public function prestamoEliminarAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $equipo = $em->getRepository('BackendBundle:PrestamosEquipo')->find($id);

        $em->remove($equipo);
        $flush = $em->flush();

        if ($flush == null) {
            $this->addFlash('elim', 'Se ha eliminado correctamente el prestamo.');
            return $this->redirectToRoute('app_prestamos');
        }
    }

    public function prestamoEntregadoAction(Request $request, $idprestamo) {
        $em = $this->getDoctrine()->getManager();
        // Settear la hora:
        $prestamo = $em->getRepository('BackendBundle:PrestamosEquipo')->find($idprestamo);
        date_default_timezone_set('Mexico/General');
        $format = 'Y-m-d H:i:s';
        $fecha = date('Y-m-d H:i:s');
        $date = \DateTime::createFromFormat($format, $fecha);
        $prestamo->setFechaentrega($date);
        $idEquipo = $prestamo->getIdequipo()->getIdequipos();
        $em->persist($prestamo);
        $em->flush();

        $equipo = $em->getRepository('BackendBundle:Equipos')->find($idEquipo);

        $equipo->setEstadoequipo(1);
        $em->persist($equipo);
        $em->flush();

        $this->addFlash('entre', 'Se ha entregado correctamente el prestamo.');
        return $this->redirectToRoute('app_prestamos');
    }

    public function chartAction() {
        $helpers = $this->get(Helpers::class);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('E.tipoequipo, COUNT(PE.idequipo) CO')
                ->from('BackendBundle:PrestamosEquipo', 'PE')
                ->innerJoin('BackendBundle:Equipos', 'E')
                ->groupBy('E.tipoequipo')
                ->Where('PE.idequipo = E.idequipos');

        $list = $qb->getQuery();
        $EquipoLista = $list->getResult();


        $data = array(
            'status' => 'success',
            'code' => 200,
            'msg' => 'success'
        );

        return $this->render('AppBundle:Default:ChartsGeneral.html.twig', array(
                    'data' => $helpers->json($data),
                    'charts' => $EquipoLista
        ));
    }

    public function chartAlumnoAction(Request $request, $id) {
        $helpers = $this->get(Helpers::class);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('E.tipoequipo, COUNT(PE.idequipo) CO')
                ->from('BackendBundle:PrestamosEquipo', 'PE')
                ->innerJoin('BackendBundle:Equipos', 'E', 'WITH', 'PE.idequipo = E.idequipos')
                ->innerJoin('BackendBundle:Persona', 'P', 'WITH', 'P.idpersona = PE.idsolicitante')
                ->groupBy('E.tipoequipo')
                ->Where('P.idpersona = :personaId')
                ->setParameter('personaId', $id);

        $list = $qb->getQuery();
        $EquipoLista = $list->getResult();
        $personaNombre = $em->getRepository('BackendBundle:Persona')->find($id);

        $data = array(
            'status' => 'success',
            'code' => 200,
            'msg' => 'success'
        );

        return $this->render('AppBundle:Default:ChartsUsuario.html.twig', array(
                    'data' => $helpers->json($data),
                    'charts' => $EquipoLista,
                    'idp' => $id,
                    'per' => $personaNombre
        ));
    }

    public function pdfAction() {
        if (isset($_POST["hidden_div_html"]) && $_POST["hidden_div_html"] != '') {
            $html = $_POST["hidden_div_html"];
            $doc = new DOMDocument();
            @$doc->loadHTML($html);
            $tags = $doc->getElementsByTagName('img');
            $i = 1;
            $result = '';
            foreach ($tags as $tag) {
                $file_name = 'public/img/google_chart' . $i . '.png';
                $img_Src = $tag->getAttribute('src');
                file_put_contents($file_name, file_get_contents($img_Src));
                $res = '<img src="public/img/google_chart' . $i . '.png">';
                $result .= $res;
                $i++;
            }

            $style = '<html>
                                <head>
                                     <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                                 </head>
                               <body>';
            $cierre = '</body>
                        </html>';
            $put = '
                <table style="text-align: center">
                <tbody>
                    <tr>
                        <td rowspan="2" colspan="2">
                            <img align="left" src="public/img/LOGO_UTEZ.png" width="134" height="85">
                        </td>
                        <td colspan="4"><br>
                            <strong><p style="font-weight: bold">Universidad Tecnológica Emiliano Zapata</p></strong>
                            <p>Reporte General: EstadÍsticas tipos de equipos más solicitados.</p>
                        </td>
                        <td rowspan="2" colspan="2">
                            <img align="right" src="public/img/academia.png" width="130" height="30 ">
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>';

            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $qb->select('E.tipoequipo, COUNT(PE.idequipo) CO')
                    ->from('BackendBundle:PrestamosEquipo', 'PE')
                    ->innerJoin('BackendBundle:Equipos', 'E')
                    ->groupBy('E.tipoequipo')
                    ->Where('PE.idequipo = E.idequipos');

            $list = $qb->getQuery();
            $EquipoLista = $list->getResult();

            $ht = '<div class="w3-container">
                <table class="w3-table-all w3-small">
                            <tr>
                                <th>Tipo Equipo</th>
                                <th>No. Préstamos</th>
                            </tr>
                <tbody>';
            foreach ($EquipoLista as $valor) {
                $ht .= '<tr><td>' . $valor['tipoequipo'] . '</td><td>' . $valor['CO'] . '</td></tr>';
            }

            $ht .= '</tbody>
                                </table>
                                </div>';
            //include make_pdf
            $mpdf = new mPDF();

            $mpdf->allow_charset_conversion = true;
            $mpdf->SetDisplayMode('fullpage');

            $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
            $mpdf->WriteHTML($style);
            $mpdf->WriteHTML($put);
            $mpdf->WriteHTML($ht);
            $mpdf->WriteHTML($result);
            $mpdf->WriteHTML($cierre);
            $mpdf->setFooter('{PAGENO}');
            $mpdf->Output();
        }
    }

    public function pdfUsuarioAction(Request $request) {
        if (isset($_POST["hidden_div_html"]) && $_POST["hidden_div_html"] != '') {
            $html = $_POST["hidden_div_html"];
            $doc = new DOMDocument();
            @$doc->loadHTML($html);
            $tags = $doc->getElementsByTagName('img');
            $i = 1;
            $result = '';
            foreach ($tags as $tag) {
                $file_name = 'public/img/google_chart' . $i . '.png';
                $img_Src = $tag->getAttribute('src');
                file_put_contents($file_name, file_get_contents($img_Src));
                $res = '<img src="public/img/google_chart' . $i . '.png">';
                $result .= $res;
                $i++;
            }

            $style = '<html>
                                <head>
                                     <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                                 </head>
                               <body>';
            $cierre = '</body>
                        </html>';
            $put = '
                <table style="text-align: center">
                <tbody>
                    <tr>
                        <td rowspan="2" colspan="2">
                            <img align="left" src="public/img/LOGO_UTEZ.png" width="134" height="85">
                        </td>
                        <td colspan="4"><br>
                            <strong><p style="font-weight: bold">Universidad Tecnológica Emiliano Zapata</p></strong>
                            <p>Reporte Usuario: EstadÍsticas tipos de equipos más solicitados por una persona..</p>
                        </td>
                        <td rowspan="2" colspan="2">
                            <img align="right" src="public/img/academia.png" width="130" height="30 ">
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>';

            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $qb->select('E.tipoequipo, COUNT(PE.idequipo) CO')
                    ->from('BackendBundle:PrestamosEquipo', 'PE')
                    ->innerJoin('BackendBundle:Equipos', 'E', 'WITH', 'PE.idequipo = E.idequipos')
                    ->innerJoin('BackendBundle:Persona', 'P', 'WITH', 'P.idpersona = PE.idsolicitante')
                    ->groupBy('E.tipoequipo')
                    ->Where('P.idpersona = :personaId')
                    ->setParameter('personaId', $request->get('_idp'));

            $list = $qb->getQuery();
            $EquipoLista = $list->getResult();
            $personaNombre = $em->getRepository('BackendBundle:Persona')->find($request->get('_idp'));

            $ht = '<div class="w3-container">
                <table class="w3-table-all w3-small">
                            <tr>
                                <th colspan="2">' . $personaNombre->getNombre() . ' ' . $personaNombre->getPrimerapellido() . ' ' . $personaNombre->getSegundoapellido() . ' - ' . $personaNombre->getMatricula() . '</th>
                            </tr>
                            <tr>
                                <th>Tipo Equipo</th>
                                <th>No. Préstamos</th>
                            </tr>
                <tbody>';
            foreach ($EquipoLista as $valor) {
                $ht .= '<tr><td>' . $valor['tipoequipo'] . '</td><td>' . $valor['CO'] . '</td></tr>';
            }

            $ht .= '</tbody>
                                </table>
                                </div>';
            //include make_pdf
            $mpdf = new mPDF();

            $mpdf->allow_charset_conversion = true;
            $mpdf->SetDisplayMode('fullpage');

            $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
            $mpdf->WriteHTML($style);
            $mpdf->WriteHTML($put);
            $mpdf->WriteHTML($ht);
            $mpdf->WriteHTML($result);
            $mpdf->WriteHTML($cierre);
            $mpdf->setFooter('{PAGENO}');
            $mpdf->Output();
        }
    }

}
