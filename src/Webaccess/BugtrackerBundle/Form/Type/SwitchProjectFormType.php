<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SwitchProjectFormType extends AbstractType {

	protected $userManager;

    public function __construct($userManager) {
        $this->userManager = $userManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
    	$userManager = $this->userManager;

		$builder->add('project', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:Project',
			'empty_value' => 'All projects',
			'data' => $userManager->getProjectInSession(),
            'property' => 'name',
            'required' => false,
            'query_builder' => function($er) use ($userManager) {
                return $er->getByUser($userManager->getUserInSession()->getId(), $userManager->isAdmin());
            })
        );
    }

    public function getName() {
        return 'webaccess_bugtracker_switch_project';
    }
}
