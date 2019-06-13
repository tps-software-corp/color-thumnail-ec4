<?php
namespace Plugin\ColorThumb;

use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Eccube\Service\Composer\ComposerServiceFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Eccube\Entity\ClassName;
use Plugin\ColorThumb\Entity\ExtendClassName;

/**
 * Class PluginManager.
 */
class PluginManager extends AbstractPluginManager
{
    const VERSION = '1.0.0';
    const CLASS_NAME_CODE = 'color_thumb_code';
    const CLASS_NAME_NAME = 'Màu sắc';

    /**
     * Install the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function install(array $meta, ContainerInterface $container)
    {
        $configRepository = $container->get('Plugin\ColorThumb\Repository\ConfigRepository');
        $classNameRepository = $container->get('Eccube\Repository\ClassNameRepository');
        $classCategoryRepository = $container->get('Plugin\ColorThumb\Repository\ExtendClassCategoryRepository');
        $className = new ExtendClassName();
        $className->setName(self::CLASS_NAME_NAME);
        $className->setBackendName(self::CLASS_NAME_CODE);
        $classNameRepository->save($className);
        $colors = ['Ametit' => '9966CC', 'Anh đào' => 'DE3163', 'Be' => 'F5F5DC', 'Bạc' => 'C0C0C0', 'Cam cháy' => 'CC5500', 'Chàm' => '4B0082', 'Cá hồi' => 'FF8C69', 'Cẩm quỳ' => '993366', 'Da bò' => 'F0DC82', 'Da cam' => 'FF7F00', 'Dừa cạn' => 'CCCCFF', 'Hoa cà' => 'c8a2c8', 'Hạt dẻ' => '800000', 'Hồng' => 'FFC0CB', 'Hồng sẫm' => 'FF00FF', 'Hồng y' => 'C41E3A', 'Hồng đất' => 'CC8899', 'Hổ phách' => 'FFBF00', 'Kaki' => 'C3B091', 'Kem' => 'FFFDD0', 'Lam sẫm' => '000080', 'Lan tím' => 'DA70D6', 'Lòng đào' => 'FFE5B4', 'Lục bảo' => '50C878', 'Men ngọc' => 'ACE1AF', 'Mòng két' => '008080', 'Mận' => '660066', 'Ngọc thạch' => '00A86B', 'Nâu' => '964B00', 'Nâu sẫm' => '3D2B1F', 'Nâu tanin' => 'D2B48C', 'Nâu đen' => '704214', 'Oải hương' => 'E6E6FA', 'San hô' => 'FF7F50', 'Thổ hoàng' => 'CC7722', 'Trắng' => 'FFFFFF', 'Tía' => '660099', 'Tím' => 'BF00BF', 'Vàng' => 'FFFF00', 'Vàng chanh' => 'CCFF00', 'Vàng kim loại' => 'FFD700', 'Vòi voi' => 'DF73FF', 'Xanh berin' => '7FFFD4', 'Xanh crôm' => '40826D', 'Xanh cô ban' => '0047AB', 'Xanh da trời' => '007FFF', 'Xanh hoàng hôn ' => '007BA7', 'Xanh lam' => '0000FF', 'Xanh lá cây' => '00FF00', 'Xanh lơ' => '00FFFF', 'Xanh nõn chuối' => '7FFF00', 'Xanh Thổ' => '30D5C8', 'Xanh thủy tinh' => '003399', 'Xám' => '808080', 'Ô liu' => '808000', 'Đen' => '000000', 'Đỏ' => 'FF0000', 'Đỏ son' => 'FF4D00', 'Đỏ thắm' => 'DC143C', 'Đỏ tươi' => 'FF2400', 'Đỏ yên chi' => '960018', 'Đồng' => 'B87333'];
        foreach($colors as $name => $code) {
            $classCategory = new \Plugin\ColorThumb\Entity\ExtendClassCategory();
            $classCategory->setClassName($className);
            $classCategory->setBackendName($name);
            $classCategory->setName($name);
            $classCategory->setSortNo(0);
            $classCategory->setVisible(1);
            $classCategory->setColorThumbHex($code);
            $classCategoryRepository->save($classCategory);
        }
    }

    /**
     * Update the plugin.
     *q
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function update(array $meta, ContainerInterface $container)
    {
    }
    /**
     * Enable the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function enable(array $meta, ContainerInterface $container)
    {
    }

    /**
     * Disable the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function disable(array $meta, ContainerInterface $container)
    {
    }

    /**
     * Uninstall the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function uninstall(array $meta, ContainerInterface $container)
    {
        // $classNameRepository = $container->get('Eccube\Repository\ClassNameRepository');
        // $classCategoryRepository = $container->get('Plugin\ColorThumb\Repository\ExtendClassCategoryRepository');
        // $classNames = $classNameRepository->findBy(['backend_name' => self::CLASS_NAME_CODE]);
        // foreach($classNames as $className) {
        //     foreach($className->getClassCategories() as $cat) {
        //         try {
        //             $classCategoryRepository->delete($cat);
        //         } catch (\Exception $ex) {
        //             dump($ex->getMessage());
        //         }
        //     }
        //     try {
        //         $classNameRepository->delete($className);
        //     } catch (\Exception $ex) {
        //         dump($ex->getMessage());
        //     }
        // }
    }
}
