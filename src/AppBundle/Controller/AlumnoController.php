<?php
//Este script fue generado automaticamente con el comando php bin/console doctrine:generate:crud
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Alumno;
use AppBundle\Form\AlumnoType;
use AppBundle\Entity\Curso;

/**
 * Alumno controller.
 *
 * @Route("/alumno")
 */
class AlumnoController extends Controller
{
    /**
     * Lists all Alumno entities.
     *
     * @Route("/", name="alumno_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $alumnos = $em->getRepository('AppBundle:Alumno')->findAll();

        return $this->render('alumno/index.html.twig', array(
            'alumnos' => $alumnos,
        ));
    }

    /**
     * Creates a new Alumno entity.
     *
     * @Route("/new", name="alumno_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		//Este metodo fue modificado para que cree un usuario al alumno
        $alumno = new Alumno();
        $form = $this->createForm('AppBundle\Form\AlumnoType', $alumno);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			/*Aqui se setean valores necesarios para generar el usuario.
			Esto se hace para no tener que ingresar estos datos tambien en el formulario, sino 
			que se realice automaticamente cada vez que se crea un alumno
			*/
			//Se establece como nombre de usuario el DNI del alumno (como sucede en el SIU)
			$alumno->setUsername($alumno->getDni());
			//La contraseña tambien sera el DNI. Se llama al metodo contrasña plana porque luego se codificara
			//con el metodo de encriptacion elegido en el archivo app/security.yml
			$alumno->setPlainPassword($alumno->getDni());
			//Se establece que la cuenta estara habilitada
			$alumno->setEnabled(true);
			//Se aclara que el rol es ROLE_ALUMNO; sus permisos estan limitados
			$alumno->addRole('ROLE_ALUMNO');
			//Se accede al servicio 'fos_user.user_manager', encargado de crear usuarios de FOSUserBundle
			//y se lo apunta con $userManager
			$userManager = $this->get('fos_user.user_manager');
			//Se actualiza el alumno. Esto crea un usuario alumno con todos sus atributos, y codifica la contraseña entre otras cosas
			//El parametro true se pasa para que guarde los datos en la base de datos
			$userManager->updateUser($alumno,true);
            return $this->redirectToRoute('alumno_show', array('id' => $alumno->getId()));
        }

        return $this->render('alumno/new.html.twig', array(
            'alumno' => $alumno,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{id}", name="alumno_show")
     * @Method("GET")
     */
    public function showAction(Alumno $alumno)
    {
        $deleteForm = $this->createDeleteForm($alumno);

        return $this->render('alumno/show.html.twig', array(
            'alumno' => $alumno,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{id}/edit", name="alumno_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Alumno $alumno)
    {
        $deleteForm = $this->createDeleteForm($alumno);
        $editForm = $this->createForm('AppBundle\Form\AlumnoType', $alumno);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
			//Como todos los datos ya estan en el alumno, simplemente se actualiza
			//con el servicio
			$userManager = $this->get('fos_user.user_manager');
			$userManager->updateUser($alumno,true);


            return $this->redirectToRoute('alumno_show', array('id' => $alumno->getId()));
        }

        return $this->render('alumno/edit.html.twig', array(
            'alumno' => $alumno,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Alumno entity.
     *
     * @Route("/{id}", name="alumno_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Alumno $alumno)
    {
        $form = $this->createDeleteForm($alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($alumno);
            $em->flush();
        }

        return $this->redirectToRoute('alumno_index');
    }

    /**
     * Creates a form to delete a Alumno entity.
     *
     * @param Alumno $alumno The Alumno entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Alumno $alumno)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alumno_delete', array('id' => $alumno->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
	
	/**
     * Muestra el curso del usuario (en caso de que el usuario sea un alumno)
     *
     * @Route("/curso/{id}", name="alumno_curso_show")
     * @Method("GET")
     */
    public function showCursoAction(Curso $curso)
    {	
        return $this->render('curso/showAlumno.html.twig', array(
            'curso' => $curso,
        ));
    }
}
