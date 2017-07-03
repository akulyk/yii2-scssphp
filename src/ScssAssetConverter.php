<?php

namespace akulyk\yii2scssphp;


class ScssAssetConverter extends \lucidtaz\yii2scssphp\ScssAssetConverter
{

    /**
     * @var directory for compiled files
     */
    public $destDir;



    private function replaceExtension(string $filename, string $newExtension): string
    {
        $extensionlessFilename = pathinfo($filename, PATHINFO_FILENAME);

        if(!$this->destDir){
            $fileDir = dirname($filename);
        } else{
            $fileDir = $this->destDir;
        }


        return "$fileDir/$extensionlessFilename.$newExtension";
    }


}/* end of Class */
