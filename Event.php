<?php

namespace Plugin\ColorThumb;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\EccubeEvents;
use Eccube\Event\TemplateEvent;
use Eccube\Event\EventArgs;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Plugin\ColorThumb\Form\Type\Admin\ExtendClassCategoryType;
use Symfony\Component\Form\FormFactoryInterface;
use Plugin\ColorThumb\Repository\ExtendClassCategoryRepository;
use Plugin\ColorThumb\Entity\ExtendClassCategory;
use Eccube\Form\Type\Admin\ClassCategoryType;
use Symfony\Component\Validator\Constraints as Assert;

class Event implements EventSubscriberInterface
{
    public function __construct(FormFactoryInterface $formFactory, ExtendClassCategoryRepository $classCategoryRepository)
    {
        $this->formFactory = $formFactory;
        $this->classCategoryRepository = $classCategoryRepository;

    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            EccubeEvents::ADMIN_PRODUCT_CLASS_CATEGORY_INDEX_INITIALIZE => 'onShowColorPicker',
            '@admin/Product/class_category.twig' => 'onShowColorPickerRender',
            'Product/detail.twig' => 'onShowColorThumbnail',
        ];
    }

    public function onShowColorPicker(EventArgs $event)
    {
        $TargetClassCategory = $event['TargetClassCategory'];
        if ($TargetClassCategory->getId()) {
            $TargetClassCategory = $this->classCategoryRepository->find($event['TargetClassCategory']->getId());
        } else {
            $TargetClassCategory = new ExtendClassCategory();
            $TargetClassCategory->setClassName($event['ClassName']);
        }
        $event['TargetClassCategory'] = $TargetClassCategory;

        $event['builder']->add('color_thumb_hex', TextType::class, [
            'label' => 'classname.label.color_thumb_hex',
            'required' => false
        ]);
    }

    public function onShowColorPickerRender(TemplateEvent $event)
    {
        $event->addSnippet('@ColorThumb/admin/colorpicker.twig');
    }

    public function onShowColorThumbnail(TemplateEvent $event)
    {
        $event->addSnippet('@ColorThumb/default/color_thumbnail.twig');
    }
}
