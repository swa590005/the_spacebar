<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // to add two fields to form
        $builder 
            ->add('title', TextType::class,[
                'help'=> 'Choose something catchy!'
            ])
            ->add('content')
            ->add('publishedAt',DateTimeType::class)
            
            ->add('author', UserSelectTextType::class)
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



