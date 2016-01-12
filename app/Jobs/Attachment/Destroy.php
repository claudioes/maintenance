<?php

namespace App\Jobs\Attachment;

use App\Models\Attachment;
use App\Jobs\Job;
use Illuminate\Contracts\Filesystem\Filesystem;

class Destroy extends Job
{
    /**
     * @var Attachment
     */
    protected $attachment;

    /**
     * Constructor.
     *
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * Deletes the current attachment as well as the file.
     *
     * @param Filesystem $filesystem
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function handle(Filesystem $filesystem)
    {
        if ($filesystem->delete($this->attachment->path)) {
            return $this->attachment->delete();
        }

        return false;
    }
}