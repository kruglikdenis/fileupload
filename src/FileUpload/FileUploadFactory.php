<?php

namespace FileUpload;

use FileUpload\FileNameGenerator;
use FileUpload\FileSystem\FileSystem;
use FileUpload\PathResolver\PathResolver;
use FileUpload\Validator\Validator;

class FileUploadFactory
{
    /**
     * Validator to be used in the factory
     * @var Validator[]
     */
    protected $validators;

    /**
     * PathResolver to be used in the factory
     * @var PathResolver
     */
    protected $pathresolver;

    /**
     * FileSystem to be used in the factory
     * @var FileSystem
     */
    protected $filesystem;

    /**
     * FileNameGenerator to be used in the factory
     * @var FileNameGenerator\FileNameGenerator
     */
    protected $fileNameGenerator;

    /**
     * Construct new factory with the given modules
     * @param PathResolver $pathresolver
     * @param FileSystem   $filesystem
     * @param array        $validators
     */
    public function __construct(
        PathResolver $pathresolver,
        FileSystem $filesystem,
        $validators = []
    ) {
        $this->pathresolver = $pathresolver;
        $this->filesystem = $filesystem;
        $this->validators = $validators;
        $this->fileNameGenerator = new FileNameGenerator\Simple();
    }

    /**
     * Create new instance of FileUpload with the preset modules
     * @param  array $upload
     * @param  array $server
     * @return FileUpload
     */
    public function create($upload, $server)
    {
        $fileupload = new FileUpload($upload, $server);
        $fileupload->setPathResolver($this->pathresolver);
        $fileupload->setFileSystem($this->filesystem);
        $fileupload->setFileNameGenerator($this->fileNameGenerator);

        foreach ($this->validators as $validator) {
            $fileupload->addValidator($validator);
        }

        return $fileupload;
    }

    /**
     * FileNameGenerator will be used in the factory
     *
     * @param FileNameGenerator\FileNameGenerator $generator
     */
    public function withFileNameGenerator(FileNameGenerator\FileNameGenerator $generator)
    {
        $this->fileNameGenerator = $generator;
    }
}
