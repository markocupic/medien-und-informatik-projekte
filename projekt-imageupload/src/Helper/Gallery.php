<?php
declare(strict_types=1);

namespace Helper;

/**
 * Class Gallery
 * @package Helper
 */
class Gallery
{
    protected $imageDir;

    protected $thumbDir;

    /**
     * Gallery constructor.
     * @param string $imageDir
     * @param string $thumbDir
     */
    public function __construct(string $imageDir, string $thumbDir)
    {
        $this->imageDir = $imageDir;
        $this->thumbDir = $thumbDir;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        $arrImages = [];
        $root = dirname(dirname(dirname(__FILE__)));
        $src = scandir($root.'/'.$this->imageDir);

        foreach ($src as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $arrImage = [
                'image'     => $this->imageDir.'/'.$file,
                'thumbnail' => $this->imageDir.'/'.$file,
            ];

            $thumb = $this->thumbDir.'/'.$file;
            if (is_file($thumb)) {
                $arrImage['thumbnail'] = $thumb;
            }

            $arrImages[] = $arrImage;

        }

        return $arrImages;
    }
}