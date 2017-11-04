<?php

namespace Dusker;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class ScriptHandler is modified version of https://github.com/slowprog/CopyFile.
 */
class CopyFile
{
    /**
     * @param Event $event
     *
     * @throws \InvalidArgumentException
     */
    public static function copy(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();

        if (!isset($extras['copy-file'])) {
            throw new \InvalidArgumentException(
                'The dirs or files needs to be configured through the extra.copy-file setting.'
            );
        }

        /** @var array $files */
        $files = $extras['copy-file'];

        if ($files === array_values($files)) {
            throw new \InvalidArgumentException(
                'The extra.copy-file must be hash like "{<dir_or_file_from>: <dir_to>}".'
            );
        }

        $fs = new Filesystem();
        $io = $event->getIO();

        foreach ($files as $from => $to) {
            // if path doesn't exists, we in root package, do not do anything
            if (false === file_exists($from)) {
                return;
            }

            // Check the renaming of file for direct moving (file-to-file)
            $isRenameFile = '/' !== substr($to, -1) && !is_dir($from);

            if (!$isRenameFile && file_exists($to) && !is_dir($to)) {
                throw new \InvalidArgumentException('Destination directory is not a directory.');
            }

            try {
                if ($isRenameFile) {
                    $fs->mkdir(dirname($to));
                } else {
                    $fs->mkdir($to);
                }
            } catch (IOException $e) {
                $io->write(sprintf('%s. It is ok, if you develop this package.', $e->getMessage()));

                return;
            }

            if (is_dir($from)) {
                $finder = new Finder();
                $finder->files()->in($from);

                foreach ($finder as $file) {
                    $dest = sprintf('%s/%s', $to, $file->getRelativePathname());

                    try {
                        $fs->copy($file, $dest, true);
                    } catch (IOException $e) {
                        throw new \InvalidArgumentException(
                            sprintf('<error>Could not copy %s</error> %s', $file->getBasename(), $e->getMessage())
                        );
                    }
                }
            } else {
                try {
                    if ($isRenameFile) {
                        $fs->copy($from, $to, true);
                    } else {
                        $fs->copy($from, $to . '/' . basename($from), true);
                    }
                } catch (IOException $e) {
                    throw new \InvalidArgumentException(
                        sprintf('<error>Could not copy %s</error> %s', $from, $e->getMessage())
                    );
                }
            }

            $io->write(sprintf('Copied file(s) from <comment>%s</comment> to <comment>%s</comment>.', $from, $to));
        }
    }
}
