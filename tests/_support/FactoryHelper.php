<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FactoryHelper extends \Codeception\Module
{
    /**
     * @var \League\FactoryMuffin\Factory
     */
    protected $factory;
    
    public function _initialize()
    {
        $this->factory = new \League\FactoryMuffin\Factory;
        $this->factory->setCustomSetter(function($entity, $name, $value) {
            call_user_func([$entity, "set".ucfirst($name)], $value);
        });

        $this->factory->define('Acme\DemoBundle\Entity\Page', array(
            'title'    => 'sentence|5',
            'body'   => 'text',
        ));
    }

    public function _before(\Codeception\TestCase $test)
    {
        $em = $this->getModule('Symfony2')->container->get('doctrine.orm.entity_manager');

        $this->factory->setCustomSaver(function($entity) use ($em) {
            $em->persist($entity);
            $em->flush();
            return true;
        });

        $this->factory->setCustomDeleter(function($entity) use ($em) {

            // entity may already be deleted if Doctrine transaction is closed
            if (!$em->contains($entity)) {
                return true;
            }

            $em->remove($entity);
            $em->flush($entity);
            return true;
        });
    }

    public function havePages($num)
    {
        return $this->factory->seed($num, 'Acme\DemoBundle\Entity\Page');
    }

    public function produce($model, $attributes = array())
    {
        return $this->factory->create($model, $attributes);
    }

    public function _after(\Codeception\TestCase $test)
    {
        $this->factory->deleteSaved();
    }

}