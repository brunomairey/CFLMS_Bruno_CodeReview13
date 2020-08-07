<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use  Symfony\Component\HttpFoundation\Response;
use  Symfony\Component\HttpFoundation\Request;
use App\Entity\Events ;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class EventsController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function show()
    {
        
    	$repo =$this->getDoctrine()->getRepository(Events::class);
    	$events= $repo->findAll();
        return $this->render('events/index.html.twig', [
            'controller_name' => 'EventsController',
            'events' => $events]);

    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {

    	// Here we create an object from the class that we made
       $events = new Events;
/* Here we will build a form using createFormBuilder and inside this function we will put our object and then we write add then we select the input type then an array to add an attribute that we want in our input field */
       $form = $this->createFormBuilder($events)->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('datetime', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px;')))
       ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('image', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('capacity', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
        ->add('contactmail', EmailType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('contactphone', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
      	->add('address', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('url', UrlType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('type', ChoiceType::class, array('choices'=>array('Cinema'=>'Cinema', 'Heuriger'=>'Heuriger', 'Music'=>'Music', 'Sport'=>'Sport'),'attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       
       
       
   ->add('save', SubmitType::class, array('label'=> 'Create Event', 'attr' => array('class'=> 'btn-info btn-lg', 'style'=>'margin-bottom:15px')))
       ->getForm();
       $form->handleRequest($request);
       

       /* Here we have an if statement, if we click submit and if  the form is valid we will take the values from the form and we will save them in the new variables */
       if($form->isSubmitted() && $form->isValid()){
           //fetching data

           // taking the data from the inputs by the name of the inputs then getData() function
           $name = $form['name']->getData();
            $datetime = $form['datetime']->getData();
           $description = $form['description']->getData();
            $image = $form['image']->getData();
           $capacity = $form['capacity']->getData();
            $contactmail = $form['contactmail']->getData();
             $contactphone = $form['contactphone']->getData();
              $address = $form['address']->getData();
              $url = $form['url']->getData();
            $type = $form['type']->getData();
                    
 
/* these functions we bring from our entities, every column have a set function and we put the value that we get from the form */
           $events->setName($name);
           $events->setDatetime($datetime);
           $events->setDescription($description);
           $events->setImage($image);
           $events->setCapacity($capacity);
           $events->setContactmail($contactmail);
           $events->setContactphone($contactphone);
           $events->setAddress($address);
           $events->setUrl($url);
           $events->setType($type);
           $em = $this->getDoctrine()->getManager();
           $em->persist($events);
           $em->flush();
           $this->addFlash(
                   'notice',
                   'events Added'
                   );
           return $this->redirectToRoute('home');
       }
/* now to make the form we will add this line form->createView() and now you can see the form in create.html.twig file  */
       return $this->render('events/create.html.twig', array('form' => $form->createView()));

    }

     /**
     * @Route("/edit/{id}", name="edit")
     */
 
 public function edit($id, Request $request){
/* Here we have a variable todo and it will save the result of this search and it will be one result because we search based on a specific id */
   $events = $this->getDoctrine()->getRepository('App:Events')->find($id);

   			$events->setName($events->getName());
           $events->setDatetime($events->getDatetime());
           $events->setDescription($events->getDescription());
           $events->setImage($events->getImage());
           $events->setCapacity($events->getCapacity());
           $events->setContactmail($events->getContactmail());
           $events->setContactphone($events->getContactphone());
           $events->setAddress($events->getAddress());
           $events->setUrl($events->getUrl());
           $events->setType($events->getType());


/* Now when you type createFormBuilder and you will put the variable todo the form will be filled of the data that you already set it */
          $form = $this->createFormBuilder($events)->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('datetime', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px;')))
       ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('image', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('capacity', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
        ->add('contactmail', EmailType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('contactphone', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
      	->add('address', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('url', UrlType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('type', ChoiceType::class, array('choices'=>array('Cinema'=>'Cinema', 'Heuriger'=>'Heuriger', 'Music'=>'Music', 'Sport'=>'Sport'),'attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
         ->add('save', SubmitType::class, array('label'=> 'Edit Event', 'attr' => array('class'=> 'btn-info btn-lg', 'style'=>'margin-bottom:15px')))
       ->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           //fetching data
       
            $name = $form['name']->getData();
            $datetime = $form['datetime']->getData();
           $description = $form['description']->getData();
            $image = $form['image']->getData();
           $capacity = $form['capacity']->getData();
            $contactmail = $form['contactmail']->getData();
             $contactphone = $form['contactphone']->getData();
              $address = $form['address']->getData();
              $url = $form['url']->getData();
            $type = $form['type']->getData();

           $em = $this->getDoctrine()->getManager();
           $events = $em->getRepository('App:Events')->find($id);
            $events->setName($name);
           $events->setDatetime($datetime);
           $events->setDescription($description);
           $events->setImage($image);
           $events->setCapacity($capacity);
           $events->setContactmail($contactmail);
           $events->setContactphone($contactphone);
           $events->setAddress($address);
           $events->setUrl($url);
           $events->setType($type);
       
           $em->flush();
           $this->addFlash(
                   'notice',
                   'Events Updated'
                   );
           return $this->redirectToRoute('home');
       }
       return $this->render('events/edit.html.twig', array('events' => $events, 'form' => $form->createView()));
   }



     /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id, Request $request)
    {
    		$em = $this->getDoctrine()->getManager();
           $events = $em->getRepository('App:Events')->find($id);
            $form = $this->createFormBuilder($events)
            ->add('save', SubmitType::class, array('label'=> 'Delete Event', 'attr' => array('class'=> 'btn-danger btn-lg', 'style'=>'margin-bottom:15px')))
       ->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em->remove($events);
            $em->flush();
           $this->addFlash(
                   'notice',
                   'Events Removed'
                   );
            return $this->redirectToRoute('home');
        }
        return $this->render('events/delete.html.twig', array('form' => $form->createView()));
    }

     /**
     * @Route("/details/{id}", name="details")
     */
    public function details($id)
    {

    	$repo =$this->getDoctrine()->getRepository(Events::class);
    	$event= $repo->find($id);
        return $this->render('events/details.html.twig', [
                   'event' => $event
        ]);
        
    }
   /**
     * @Route("/type/{type}", name="type")
     */
    public function type($type)
    {

    	$repo =$this->getDoctrine()->getRepository(Events::class);
    	$events= $repo->findByType($type);
        return $this->render('events/type.html.twig', [
                   'events' => $events
        ]);
        
    }


}

