<?php
declare(strict_types=1);

namespace Helper;

/**
 * Class Fileupload
 * @package Helper
 */
class Fileupload
{
    protected string $key;
    protected string $targetImageDir;
    protected string $targetThumbDir;

    /**
     * Fileupload constructor.
     * @param string $key
     * @param string $targetImageDir
     * @param string $targetThumbDir
     */
    public function __construct(string $key, string $targetImageDir, string $targetThumbDir)
    {
        $this->key = $key;
        $this->targetImageDir = $targetImageDir;
        $this->targetThumbDir = $targetThumbDir;
    }

    /**
     * @return bool
     */
    private function hasUpload(): bool
    {
        //die(print_r($_FILES,true));
        return isset($_FILES[$this->key]["tmp_name"]);

    }

    /**
     * @return bool
     */
    public function hasImageUpload(): bool
    {
        if ($this->hasUpload()) {
            $check = getimagesize($_FILES[$this->key]["tmp_name"]);
            if ($check !== false) {
                return true;
            }
        }

        return false;

    }

    /**
     * @return array
     */
    public function uploadImage(): array
    {
        $arrFile = [];
        if ($this->hasImageUpload()) {
            $targetDir = dirname(dirname(dirname(__FILE__))).'/'.$this->targetImageDir;
            $thumbDir = dirname(dirname(dirname(__FILE__))).'/'.$this->targetThumbDir;
            $extension = strtolower(pathinfo($_FILES[$this->key]["name"], PATHINFO_EXTENSION));
            $filename = md5(microtime());
            $targetImage = sprintf('%s/%s.%s', $targetDir, $filename, $extension);
            $targetThumb = sprintf('%s/%s.%s', $thumbDir, $filename, $extension);

            if (move_uploaded_file($_FILES[$this->key]["tmp_name"], $targetImage)) {
                $arrFile['basename'] = basename($targetImage);
                $arrFile['path'] = $targetImage;
                $arrFile['extension'] = $extension;
                if ($this->generateSquareImage($targetImage, $targetThumb)) {
                    $arrFile['thumb'] = $targetThumb;
                }

                return $arrFile;
            }
        }

        return $arrFile;
    }

    /**
     * @param string $imgSrc
     * @param string $targetPath
     * @return bool
     */
    function generateSquareImage(string $imgSrc, string $targetPath): bool
    {

        //getting the image dimensions
        [$width, $height] = getimagesize($imgSrc);

        //saving the image into memory (for manipulation with GD Library)
        $myImage = imagecreatefromjpeg($imgSrc);

        // calculating the part of the image to use for thumbnail
        if ($width > $height) {
            $y = 0;
            $x = ($width - $height) / 2;
            $smallestSide = $height;
        } else {
            $x = 0;
            $y = ($height - $width) / 2;
            $smallestSide = $width;
        }

        // copying the part into thumbnail
        $thumbSize = min($width, $height);
        $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
        imagecopyresampled($thumb, $myImage, 0, 0, (int)floor($x), (int)floor($y), $thumbSize, $thumbSize, $smallestSide, $smallestSide);

        @imagedestroy($myImage);

        if (imagejpeg($thumb, $targetPath)) {
            @imagedestroy($thumb);
            return true;
        }

        @imagedestroy($thumb);
        return false;
    }

    /**
     * reload page
     */
    public function reload()
    {

        header("Refresh:0");
    }

}