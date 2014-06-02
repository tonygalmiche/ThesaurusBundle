<?php

namespace OVE\ThesaurusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;

use OVE\ThesaurusBundle\Entity\terme;
//use OVE\ThesaurusBundle\Form\termeType;


/**
 * webservice controller.
 *
 * @Route("/webservice")
 */
class webserviceController extends Controller
{

    /**
     * Retourne la liste des roots d'un Thésaurus
     *
     * @Route("/thesaurus", name="webservice_thesaurus", defaults={"id" = ""})
     * @Route("/thesaurus/{id}")
     * @Method("GET")
     * @Template()
     */
    public function thesaurusAction($id) {


        if($id=="") {
          $SQL="SELECT * FROM thesaurus ORDER BY nom";
          $em  = $this->getDoctrine()->getEntityManager();
          $req = $em->getConnection()->prepare($SQL);
          $req->execute();
          $rows=$req->fetchAll();
          $r=array();
          foreach ($rows as $row) {
            $parent=$row["id_terme_parent"];
            if($parent=="") $parent="#";
            $node=array("id"=>$row["id"], "nom"=>$row["nom"]);
            $r[]=$node;
          }
        } else {
          $id=$id/1;
          $SQL="SELECT * FROM terme where id_thesaurus=$id";
          $em  = $this->getDoctrine()->getEntityManager();
          $req = $em->getConnection()->prepare($SQL);
          $req->execute();
          $rows=$req->fetchAll();
          $r=array();
          foreach ($rows as $row) {
            $parent=$row["id_terme_parent"];
            if($parent=="") $parent="#";
            $description=$row["description"];
            //$description="toto\ntutu";
            $description = str_replace("\n","\\n",$description);


            //$node=array("id"=>$row["id"], "parent"=>$parent, "text"=>$row["terme"], "description"=>"Description ".$row["id"]." : ".$row["description"]);
            $node=array("id"=>$row["id"], "parent"=>$parent, "text"=>$row["terme"], "description"=>$description);
            $r[]=$node;
          }
        }

        $r = json_encode($r);
        return new Response($r);
    }


    /**
     * Set Terme
     *
     * @Route("/set_terme", name="webservice_set_terme")
     * @Method("GET")
     * @Template()
     */
    public function setTermeAction() {

      $id               = $this->getRequest()->query->get('id');
      $terme            = $this->getRequest()->query->get('terme');
      $webservice_token = $this->getRequest()->query->get('webservice_token');

      $webservice  = $this->container->getParameter('webservice');
      $token_write = $webservice["token_write"];
      $err="";
      if($token_write!=$webservice_token) $err="Accès non autorisé !";

      if($err=="") {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('OVEThesaurusBundle:terme')->findOneBy(array("id"=>$id));

        if(is_object($entity)) {
          $entity->setTerme($terme);
          $em = $this->getDoctrine()->getManager();
          $em->persist($entity);
          $em->flush();
        } else {
          $err="Impossible de renommer le terme $id !";
        }
      }

      $r=array("err"=>$err);
      $r = json_encode($r);        
      return new Response($r);
    }



    /**
     * Set Parent
     *
     * @Route("/set_parent", name="webservice_set_parent")
     * @Method("GET")
     * @Template()
     */
    public function setParentAction() {
      $id               = $this->getRequest()->query->get('id');
      $parent           = $this->getRequest()->query->get('parent');
      $webservice_token = $this->getRequest()->query->get('webservice_token');
      $webservice  = $this->container->getParameter('webservice');
      $token_write = $webservice["token_write"];

      $parent=$parent/1;
      if($parent==0) $parent=null;
      $err="";
      if($token_write!=$webservice_token) $err="Accès non autorisé !";

      if($err=="") {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('OVEThesaurusBundle:terme')->findOneBy(array("id"=>$id));
        if(is_object($entity)) {
          $entity->setIdTermeParent($parent);
          $em = $this->getDoctrine()->getManager();
          $em->persist($entity);
          $em->flush();
        } else {
          $err="Impossible de changer le parent de $id !";
        }
      }
      $r=array("err"=>$err);
      $r = json_encode($r);        
      return new Response($r);
    }













    /**
     * Set Description
     *
     * @Route("/set_description", name="webservice_set_description")
     * @Method("GET")
     * @Template()
     */
    public function setDescriptionAction() {
      $id          = $this->getRequest()->query->get('id');
      $description = $this->getRequest()->query->get('description');

      $webservice_token = $this->getRequest()->query->get('webservice_token');
      $webservice  = $this->container->getParameter('webservice');
      $token_write = $webservice["token_write"];
      $err="";
      if($token_write!=$webservice_token) $err="Accès non autorisé !";
      if($err=="") {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('OVEThesaurusBundle:terme')->findOneBy(array("id"=>$id));
        if(is_object($entity)) {
          $entity->setDescription($description);
          $em = $this->getDoctrine()->getManager();
          $em->persist($entity);
          $em->flush();
        } else {
          $err="Impossible de changer la description de l'id $id !";
        }
      }
      $r=array("err"=>$err);
      $r = json_encode($r);        
      return new Response($r);
    }



    /**
     * Get Description
     *
     * @Route("/get_description", name="webservice_get_description")
     * @Method("GET")
     * @Template()
     */
    public function getDescriptionAction() {
      $id          = $this->getRequest()->query->get('id');
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('OVEThesaurusBundle:terme')->findOneBy(array("id"=>$id));
      $err=""; $description="";
      if(is_object($entity)) {
        $description=$entity->getDescription();
      } else {
        $err="Impossible de trouver la description de l'id $id !";
      }
      $r=array("err"=>$err,"description"=>$description);
      $r = json_encode($r);        
      return new Response($r);
    }



    /**
     * Remove terme
     *
     * @Route("/remove_terme", name="webservice_remove_terme")
     * @Method("GET")
     * @Template()
     */
    public function removeTermeAction() {
      $id          = $this->getRequest()->query->get('id');

      $webservice_token = $this->getRequest()->query->get('webservice_token');
      $webservice  = $this->container->getParameter('webservice');
      $token_write = $webservice["token_write"];
      $err="";
      if($token_write!=$webservice_token) $err="Accès non autorisé !";
      if($err=="") {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('OVEThesaurusBundle:terme')->findOneBy(array("id"=>$id));
        if(is_object($entity)) {
          $em->remove($entity);
          $em->flush();
        } 
      }
      $r=array("err"=>$err);
      $r = json_encode($r);        
      return new Response($r);
    }


    /**
     * Create terme
     *
     * @Route("/create_terme", name="webservice_create_terme")
     * @Method("GET")
     * @Template()
     */
    public function createTermeAction() {
      $id_thesaurus = $this->getRequest()->query->get('id_thesaurus');
      $parent       = $this->getRequest()->query->get('parent');

      $webservice_token = $this->getRequest()->query->get('webservice_token');
      $webservice  = $this->container->getParameter('webservice');
      $token_write = $webservice["token_write"];
      $err=""; $id="";
      if($token_write!=$webservice_token) $err="Accès non autorisé !";
      if($err=="") {
        $em = $this->getDoctrine()->getManager();
        $err=""; $id="";
        $entity = new Terme;
        $entity->setTerme("Nouveau");
        if($parent>0) $entity->setIdTermeParent($parent);
        $entity->setIdThesaurus($id_thesaurus);
        $em->persist($entity);
        $em->flush();
        $id=$entity->getId();
      }
      $r=array("err"=>$err,"id"=>$id);
      $r = json_encode($r);        
      return new Response($r);
    }






}





