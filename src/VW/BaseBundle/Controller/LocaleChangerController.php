<?php



namespace VW\BaseBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;



/**

 * Class LocaleChangerController

 * Controlleur conceptuel

 */

class LocaleChangerController extends Controller

{

    public function indexAction(Request $request)

    {

        try {

            $router = $this->get('router');



            $ref = str_replace("app_dev.php/", "", parse_url($request->headers->get('referer'), PHP_URL_PATH));

            $ref = str_replace("app.php/", "", $ref);

            $route = $router->match($ref)['_route'];



            //On récupère les paramètres de l'url

            $params = $this->get('router')->match($ref);



            //On enlève les paramètres inutiles

            unset($params['_locale']);

            unset($params['_route']);



            //Si le nom de la route se termine par _en, on est en anglais

            //Ici, on est sur une page qui possède un slug en anglais

            if ($this->stringEndsWith($route, "_en")) {



                //On cherche si une route en français existe

                $route_fr = $router->getRouteCollection()->get(substr($route, 0, -3));

                if ($route_fr != null) {

                    $request->setLocale("fr");

                    $params['_locale'] = "fr";



                    //On prend le nom de la route en anglais et on enlève "_en"

                    return $this->redirectToRoute(substr($route, 0, -3), $params);

                } else {

                    //aucune page en français trouvé, redirige sur la dernière page

                    //peut-être que c'est la même url pour les deux langues

                    $request->setLocale("fr");

                    $params['_locale'] = "fr";

                    return $this->redirectToRoute($route, $params);

                }



            } else { //ici la route peut être français ou anglais (même slug)



                //On cherche si une route en anglais existe

                $route_en = $router->getRouteCollection()->get($route . '_en');

                if ($route_en != null) {

                    $request->setLocale("en");

                    $params['_locale'] = "en";

                    return $this->redirectToRoute($route . '_en', $params);

                } else {

                    //aucune page en anglais trouvé, redirige sur la dernière page

                    //peut-être que c'est la même url pour les deux langues

                    if ($request->getLocale() == "fr") {

                        $request->setLocale("en");

                        $params['_locale'] = "en";

                    } else {

                        $request->setLocale("fr");

                        $params['_locale'] = "fr";

                    }

                    return $this->redirectToRoute($route, $params);

                }



            }

        } catch (ResourceNotFoundException $e) {



            if ($request->headers->get('referer') != "") {

                return $this->redirect($request->headers->get('referer'));

            } else {

                return $this->redirectToRoute("vw_base_homepage");

            }



        }

    }



    function stringEndsWith($text, $value)

    {

        return (strpos($text, $value, strlen($text) - strlen($value)) !== false);

    }
    
    public function passchangeAction() {
            $user = $this->getUser();
    $newPasswordPlain = 'newpassword';
    $currentPasswordForValidation = 'fhoiG$HTsd-mlfk45h';

    $encoder_service = $this->get('security.encoder_factory');
    $encoder = $encoder_service->getEncoder($user);
    
    $encodedPassword = $encoder->encodePassword($currentPasswordForValidation, "xIeae1o4NfdT26V0rq3Mv.68pQfe5dKUv2cnsSEOoQA");
    
    var_dump( $encodedPassword);
    //var_dump( $user->getPassword());
        return $this->render('VWBaseBundle:Pages:gallerie.html.twig');
        
    }

}

