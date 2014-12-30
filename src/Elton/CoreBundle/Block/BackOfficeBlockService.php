<?php
/**
 * Created by PhpStorm.
 * User: rarity
 * Date: 03/12/14
 * Time: 14:05
 */

namespace Elton\CoreBundle\Block;

use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

/**
 * BackOffice block service
 *
 */
class BackOfficeBlockService extends BaseBlockService
{
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'url'      => true,
            'title'    => 'Special',
            'template' => 'EltonCoreBundle:BackOffice:index.html.twig',
        ));
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('url', 'url', array('required' => false)),
                array('title', 'text', array('required' => false)),
            )
        ));
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        $errorElement
            ->with('settings.url')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->end()
            ->with('settings.title')
            ->assertNotNull(array())
            ->assertNotBlank()
            ->assertMaxLength(array('limit' => 200))
            ->end();
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        if ($settings['url']) {
            $options = array(
                'http' => array(
                    'user_agent' => 'Elton/Back Office',
                    'timeout' => 2,
                )
            );
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ), $response);
    }
} 