<?php
namespace Plugin\ColorThumb\Entity;

use Eccube\Entity\Category;
use Eccube\Entity\ClassName;
use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Entity(repositoryClass="Plugin\ColorThumb\Repository\ExtendClassNameRepository")
 */
class ExtendClassName extends ClassName
{
    use ClassCateogoryTrait;
}