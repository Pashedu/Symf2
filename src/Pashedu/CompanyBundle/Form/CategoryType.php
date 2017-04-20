<?php

namespace Pashedu\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('categoryname')->add('parent');
        $builder->add('children', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
            'class' => 'PasheduCompanyBundle:Category',
            'query_builder' => function (EntityRepository $er) use ($options) {
                return $er->createQueryBuilder('c')
                    ->where('c.parent is NULL')
                    ->andWhere('c.id <> :treeroot' )
                    ->orWhere('c.parent = :id')
                    ->setParameter('treeroot',($options['data']->getTreeroot()) ? $options['data']->getTreeroot() : "null")
                    ->setParameter('id',$options['data']->getId())
                    ->orderBy('c.categoryname','ASC');
            },
            'choice_label' => 'categoryname',
            'multiple' => 'true',
            'placeholder' => 'true',
            'expanded' => 'true',
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pashedu\CompanyBundle\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pashedu_companybundle_category';
    }


}
