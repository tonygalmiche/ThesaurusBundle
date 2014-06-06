<?php

namespace OVE\ThesaurusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use OVE\ThesaurusBundle\Entity\thesaurus;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{


    /**
     * @Route("/", name="default_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $user  = $this->getUser();
        $roles = $user->getRoles();
        $id        = $this->getRequest()->query->get('id');
        $name      = $this->getRequest()->query->get('name');
        $rename    = $this->getRequest()->query->get('rename');
        $supprimer = $this->getRequest()->query->get('supprimer');
        $em = $this->getDoctrine()->getManager();
        $thesaurus="";


        //echo $webservice["token_read"];
        //echo uniqid ();


        $ROLE_PARAM=false;
        if(in_array("ROLE_ADMIN", $roles) or in_array("ROLE_PARAM",$roles)) $ROLE_PARAM=true;
        $bouton_supprimer=false; 
        $json="[]";
        if($id>0) {
          $thesaurus = $em->getRepository('OVEThesaurusBundle:thesaurus')->findOneBy(array("id"=>$id));
          $url = "https://".$_SERVER['HTTP_HOST']."/webservice/thesaurus/$id"; 
          $json=file_get_contents ($url);
          $json=str_replace("'","\'",$json);
          $json=str_replace('"','\"',$json);
          //echo $json;
        }
        if($ROLE_PARAM) {

          if(is_object($thesaurus)  and $id>0) {
            $entities = $em->getRepository('OVEThesaurusBundle:terme')->findBy(array("id_thesaurus"=>$id));
            if(count($entities)==0) $bouton_supprimer=true;
          }
          $repository = $em->getRepository('OVEThesaurusBundle:thesaurus');
          if($name<>"") {
            $entities = $repository->findBy(array('nom' => $name));
            if(count($entities)==0) {
              $thesaurus = new Thesaurus;
              $thesaurus->setNom($name);
              $em = $this->getDoctrine()->getManager();
              $em->persist($thesaurus);
              $em->flush();
            }
          }

          if($rename<>"" and $id>0 and is_object($thesaurus)) {
            $entities = $repository->findBy(array('nom' => $rename));
            if(count($entities)==0) {
              $thesaurus->setNom($rename);
              $em = $this->getDoctrine()->getManager();
              $em->persist($thesaurus);
              $em->flush();
            }
          }

          if($supprimer<>"" and $id>0 and is_object($thesaurus) and $bouton_supprimer==true) {
              $em = $this->getDoctrine()->getManager();
              $em->remove($thesaurus);
              $em->flush();
              $id=""; $thesaurus="";
          }

        }


        //** Accès au webservice ************************************
        $webservice=$this->container->getParameter('webservice');
        $token_read  = $webservice["token_read"];
        $token_write = $webservice["token_write"];
        $webservice_token=$token_read;
        if($ROLE_PARAM) $webservice_token=$token_write;
        //***********************************************************



        $nom=""; 
        if(is_object($thesaurus)  and $id>0) $nom=$thesaurus->getNom();

        $entities = $em->getRepository('OVEThesaurusBundle:thesaurus')->findBy(array(), array('nom' => 'ASC'));
        $t=array();
        foreach($entities as $entity) {
          $btn="btn-default";
          if($id==$entity->getId()) $btn="btn-disabled";
          $t[]=array(
            "id"   => $entity->getId(), 
            "nom"  => $entity->getNom(),
            "btn"  => $btn,
          );
        }

        //$json='[{"id":"1","parent":"#","text":"Terme 1"},{"id":"2","parent":"#","text":"Terme 2"},{"id":"3","parent":"#","text":"Terme 3"},{"id":"4","parent":"1","text":"Terme 1a"},{"id":"5","parent":"1","text":"Terme 1b"}]';


        return array(
          'entities'=>$t, 
          'id'=>$id, 
          'nom'=>$nom, 
          'bouton_supprimer'=>$bouton_supprimer, 
          'json'=>$json, 
          'ROLE_PARAM'=>$ROLE_PARAM,
          'webservice_token'=>$webservice_token
        );
    }





    /**
     * @Route("/thesaurus/", name="default_thesaurus", defaults={"id" = 1})
     * @Route("/thesaurus/{id}")

     * @Method("GET")
     * @Template()
     */ 
    /*
    public function thesaurusAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('OVEThesaurusBundle:thesaurus')->findAll();
        return array('entities' => $entities,'id' => $id);
        //return $this->render('OVEThesaurusBundle:Default:index.html.twig', array('entities' => $entities,'id' => $id));
    }
    */



    /**
     * @Route("/parametrage", name="default_parametrage")
     * @Method("GET")
     * @Template()
     */
    public function parametrageAction() 
    {
        return array();
        //return $this->render('OVEThesaurusBundle:Default:parametrage.html.twig', array());
    }


}
