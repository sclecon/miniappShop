<?php

namespace App\Utils;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Upload\UploadedFile;
use Hyperf\Utils\Traits\StaticInstance;
use League\Flysystem\Filesystem;

class Image
{
    use StaticInstance;

    /**
     * @Inject()
     * @var Filesystem
     */
    protected $filesystem;

    public function upload(UploadedFile $file, string $type = 'default') : string {
        $stream = fopen($file->getRealPath(), 'r+');
        $filename = $this->getFilename($file, $type);
        $this->filesystem->writeStream($filename, $stream);
        fclose($stream);
        return '/'.$filename;
    }

    protected function getFilename(UploadedFile $file, string $type) : string {
        $filename = md5($file->getFilename()).'.'.$file->getMimeType();
        return $type.'/'.date('Ym', time()).'/'.date('d', time()).'/'.explode('.', $filename)[0].'.'.explode('/', $filename)[1];
    }
}