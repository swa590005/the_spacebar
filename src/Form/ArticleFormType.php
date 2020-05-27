<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // to add two fields to form
        $builder 
            ->add('title', TextType::class,[
                'help'=> 'Choose something catchy!'
            ])
            ->add('content')
            ->add('publishedAt',DateTimeType::class)
            
            ->add('author', EntityType::class,[
                'class'=>User::class,
                'choice_label'=>function(User $user){
                    return sprintf('(%d) %s',$user->getId(),$user->getEmail());
                },
                'placeholder'=>'Choose an Author',
            ] )
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        //This binds the form to that class.
        $resolver->setDefaults([
            'data_class'=> Article::class
        ]);
    }
}



