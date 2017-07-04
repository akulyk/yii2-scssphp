<?php

namespace akulyk\yii2scssphp;


class ScssAssetConverter extends \lucidtaz\yii2scssphp\ScssAssetConverter
{

    /**
     * @var directory for compiled files
     */
    public $destDir;

    /**
     * Converts a given SCSS asset file into a CSS file.
     * @param string $asset the asset file path, relative to $basePath
     * @param string $basePath the directory the $asset is relative to.
     * @return string the converted asset file path, relative to $basePath.
     */
    public function convert($asset, $basePath)
    {
        $extension = $this->getExtension($asset);
        if ($extension !== 'scss') {
            return $asset;
        }
        $cssAsset = $this->replaceExtension($asset, 'css');

        $inFile = "$basePath/$asset";
        $outFile = "$basePath/$cssAsset";

        if (!$this->storage->exists($inFile)) {
            Yii::error("Input file $inFile not found.", __METHOD__);
            return $asset;
        }

        $this->convertAndSaveIfNeeded($inFile, $outFile);

        return $cssAsset;
    }/**/

    private function getExtension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }/**/

    private function replaceExtension(string $filename, string $newExtension): string
    {
        $extensionlessFilename = pathinfo($filename, PATHINFO_FILENAME);

        if(!$this->destDir){
            $fileDir = dirname($filename);
        } else{
            $fileDir = $this->destDir;
        }
      


        return "$fileDir/$extensionlessFilename.$newExtension";
    }/**/

    private function convertAndSaveIfNeeded(string $inFile, string $outFile)
    {
        if ($this->shouldConvert($inFile, $outFile)) {
            $css = $this->compiler->compile($this->storage->get($inFile), $inFile);
            $this->storage->put($outFile, $css);
        }
    }/**/

    private function shouldConvert(string $inFile, string $outFile): bool
    {
        if (!$this->storage->exists($outFile)) {
            return true;
        }
        if ($this->forceConvert) {
            return true;
        }
        try {
            return $this->isOlder($outFile, $inFile);
        } catch (RuntimeException $e) {
            Yii::warning('Encountered RuntimeException message "' . $e->getMessage() . '", going to convert.', __METHOD__);
            return true;
        }
    }/**/

    private function isOlder(string $fileA, string $fileB): bool
    {
        return $this->storage->getMtime($fileA) < $this->storage->getMtime($fileB);
    }/**/


}/* end of Class */
