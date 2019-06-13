<?php
namespace Plugin\ColorThumb\Entity;

use Eccube\Entity\Category;
use Eccube\Entity\ClassCategory;
use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Entity(repositoryClass="Plugin\ColorThumb\Repository\ExtendExtendClassCategoryRepository")
 */
class ExtendClassCategory extends ClassCategory
{
    use ClassCateogoryTrait;
}