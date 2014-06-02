<?php

namespace OVE\ThesaurusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use OVE\ThesaurusBundle\Entity\terme;
use OVE\ThesaurusBundle\Form\termeType;

/**
 * terme controller.
 *
 * @Route("/terme")
 */
class termeController extends Controller
{

    /**
     * Lists all terme entities.
     *
     * @Route("/", name="terme")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OVEThesaurusBundle:terme')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new terme entity.
     *
     * @Route("/", name="terme_create")
     * @Method("POST")
     * @Template("OVEThesaurusBundle:terme:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new terme();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('terme_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('terme'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a terme entity.
    *
    * @param terme $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(terme $entity)
    {
        $form = $this->createForm(new termeType(), $entity, array(
            'action' => $this->generateUrl('terme_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new terme entity.
     *
     * @Route("/new", name="terme_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new terme();
        //$form   = $this->createCreateForm($entity);
        $form   = $this->createForm(new termeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a terme entity.
     *
     * @Route("/{id}", name="terme_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEThesaurusBundle:terme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find terme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing terme entity.
     *
     * @Route("/{id}/edit", name="terme_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEThesaurusBundle:terme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find terme entity.');
        }

        //$editForm   = $this->createEditForm($entity);
        $editForm   = $this->createForm(new termeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a terme entity.
    *
    * @param terme $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(terme $entity)
    {
        $form = $this->createForm(new termeType(), $entity, array(
            'action' => $this->generateUrl('terme_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing terme entity.
     *
     * @Route("/{id}", name="terme_update")
     * @Method("PUT")
     * @Template("OVEThesaurusBundle:terme:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEThesaurusBundle:terme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find terme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            //return $this->redirect($this->generateUrl('terme_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('terme'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a terme entity.
     *
     * @Route("/{id}", name="terme_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OVEThesaurusBundle:terme')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find terme entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('terme'));
    }

    /**
     * Creates a form to delete a terme entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('terme_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
