<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('AppBundle:Contact')->findAll();

        return $this->render('contact/index.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * Creates a new contact entity.
     *
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm('AppBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice', 'Le nouveau contact a été ajouté avec succès');
            return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
        }

        return $this->render('contact/new.html.twig', array(
            'contact' => $contact,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contact entity.
     *
     */
    public function showAction(Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);

        return $this->render('contact/show.html.twig', array(
            'contact' => $contact,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contact entity.
     *
     */
    public function editAction(Request $request, Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);
        $editForm = $this->createForm('AppBundle\Form\ContactType', $contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add(
                'notice', 'Le contact a été mis à jour avec succès');
            return $this->redirectToRoute('contact_edit', array('id' => $contact->getId()));
        }

        return $this->render('contact/edit.html.twig', array(
            'contact' => $contact,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contact entity.
     *
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'alert', 'Le contact a été supprimé!');
        }

        return $this->redirectToRoute('contact_index');
    }

    /**
     * Creates a form to delete a contact entity.
     *
     * @param Contact $contact The contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * ajax pagination : à tester si on veut utiliser le chargement age par page
     */
    /*public function paginateAction(Request $request)
    {
        $length = $request->get('length');
        $length = $length && ($length!=-1)?$length:0;

        $start = $request->get('start');
        $start = $length?($start && ($start!=-1)?$start:0)/$length:0;

        $search = $request->get('search');
        $filters = [
            'query' => @$search['value']
        ];

        $contacts = $this->getDoctrine()->getRepository('AppBundle:Contact')->search(
            $filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($this->getDoctrine()->getRepository('AppBundle:Contact')->search($filters, 0, false)),
            'recordsTotal' => count($this->getDoctrine()->getRepository('AppBundle:Contact')->search(array(), 0, false))
        );

        foreach ($contacts as $contact) {
            $links = '<ul>
                        <li>
                            <a href="'. $this->generateUrl('contact_show', array('id' => $contact->getId())).'" title="voir la fiche" class="btn btn-info"> <span class="glyphicon glyphicon-search"></span></a>
                        </li>
                        <li>
                            &nbsp;
                        </li>
                        <li>
                            <a href="'. $this->generateUrl('contact_show', array('id' => $contact->getId())).'"title="modifier" class="btn btn-warning"> <span class="glyphicon glyphicon-pencil"></span></a>
                        </li>
                    </ul>';
            $output['data'][] = [
                'id' => $contact->getId(),
                'firstname' => $contact->getFirstName(),
                'lastname' => $contact->getLastName(),
                'phone' => $contact->getPhone(),
                'portable' => $contact->getPortable(),
                'departement' => $contact->getDepartement()->getName(),
                'actions' => $links,

            ];
        }

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }*/
}
