<?php
namespace Plugin\ColorThumb\Controller\Admin;

use Eccube\Controller\AbstractController;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Repository\ClassNameRepository;
use Eccube\Repository\ProductClassRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Plugin\ColorThumb\Entity\ExtendClassCategory as ClassCategory;
use Plugin\ColorThumb\Form\Type\Admin\ExtendClassCategoryType as ClassCategoryType;
use Plugin\ColorThumb\Repository\ExtendClassCategoryRepository as classCategoryRepository;

class ColorThumbClassCategoryController extends AbstractController
{
    /**
     * @var ProductClassRepository
     */
    protected $productClassRepository;

    /**
     * @var ClassCategoryRepository
     */
    protected $classCategoryRepository;

    /**
     * @var ClassNameRepository
     */
    protected $classNameRepository;

    /**
     * ClassCategoryController constructor.
     *
     * @param ProductClassRepository $productClassRepository
     * @param ClassCategoryRepository $classCategoryRepository
     * @param ClassNameRepository $classNameRepository
     */
    public function __construct(
        ProductClassRepository $productClassRepository,
        ClassCategoryRepository $classCategoryRepository,
        ClassNameRepository $classNameRepository
    ) {
        $this->productClassRepository = $productClassRepository;
        $this->classCategoryRepository = $classCategoryRepository;
        $this->classNameRepository = $classNameRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/product/class_category/{class_name_id}", requirements={"class_name_id" = "\d+"}, name="admin_product_class_category")
     * @Route("/%eccube_admin_route%/product/class_category/{class_name_id}/{id}/edit", requirements={"class_name_id" = "\d+", "id" = "\d+"}, name="admin_product_class_category_edit")
     * @Template("@admin/Product/class_category.twig")
     */
    public function index(Request $request, $class_name_id, $id = null)
    {
        $ClassName = $this->classNameRepository->find($class_name_id);
        if (!$ClassName) {
            throw new NotFoundHttpException();
        }
        if ($id) {
            $TargetClassCategory = $this->classCategoryRepository->find($id);
            if (!$TargetClassCategory || $TargetClassCategory->getClassName() != $ClassName) {
                throw new NotFoundHttpException();
            }
        } else {
            $TargetClassCategory = new ClassCategory();
            $TargetClassCategory->setClassName($ClassName);
        }

        $builder = $this->formFactory
            ->createBuilder(ClassCategoryType::class, $TargetClassCategory);

        $event = new EventArgs(
            [
                'builder' => $builder,
                'ClassName' => $ClassName,
                'TargetClassCategory' => $TargetClassCategory,
            ],
            $request
        );
        $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_PRODUCT_CLASS_CATEGORY_INDEX_INITIALIZE, $event);

        $ClassCategories = $this->classCategoryRepository->getList($ClassName);

        $forms = [];
        foreach ($ClassCategories as $ClassCategory) {
            $id = $ClassCategory->getId();
            $forms[$id] = $this->formFactory->createNamed('class_category_'.$id, ClassCategoryType::class, $ClassCategory);
        }

        $form = $builder->getForm();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                log_info('規格分類登録開始', [$id]);

                $this->classCategoryRepository->save($TargetClassCategory);

                log_info('規格分類登録完了', [$id]);

                $event = new EventArgs(
                    [
                        'form' => $form,
                        'ClassName' => $ClassName,
                        'TargetClassCategory' => $TargetClassCategory,
                    ],
                    $request
                );
                $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_PRODUCT_CLASS_CATEGORY_INDEX_COMPLETE, $event);

                $this->addSuccess('admin.common.save_complete', 'admin');

                return $this->redirectToRoute('admin_product_class_category', ['class_name_id' => $ClassName->getId()]);
            }

            foreach ($forms as $editForm) {
                $editForm->handleRequest($request);
                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $this->classCategoryRepository->save($editForm->getData());
                    $this->addSuccess('admin.common.save_complete', 'admin');

                    return $this->redirectToRoute('admin_product_class_category', ['class_name_id' => $ClassName->getId()]);
                }
            }
        }

        $formViews = [];
        foreach ($forms as $key => $value) {
            $formViews[$key] = $value->createView();
        }

        return [
            'form' => $form->createView(),
            'ClassName' => $ClassName,
            'ClassCategories' => $ClassCategories,
            'TargetClassCategory' => $TargetClassCategory,
            'forms' => $formViews,
        ];
    }
}
