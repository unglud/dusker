<?php

namespace Tests;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\RootPackageInterface;
use Composer\Script\Event;
use Dusker\CopyFile;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

/**
 * Class CopyFileTest.
 */
class CopyFileTest extends TestCase
{
    /** @var vfsStreamDirectory */
    protected $root;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->root = $this->getFilesystem();
    }

    public function testFilesystem()
    {
        $root = $this->root;

        $this->assertTrue($root->hasChild('from/file1'));
        $this->assertTrue($root->hasChild('from/file2'));

        $this->assertTrue($root->hasChild('file3'));

        $this->assertTrue($root->hasChild('from_complex/file4'));
        $this->assertTrue($root->hasChild('from_complex/sub_dir/file5'));
    }

    public function testCopyDirToDir()
    {
        $root = $this->root;

        $this->assertFalse($root->hasChild('to/file1'));
        $this->assertFalse($root->hasChild('to/file2'));

        CopyFile::copy($this->getEventMock([
            vfsStream::url('root/from') => vfsStream::url('root/to')
        ]));

        $this->assertTrue($root->hasChild('to/file1'));
        $this->assertTrue($root->hasChild('to/file2'));
    }

    public function testCopyDirToNotExistsDir()
    {
        $root = $this->root;

        $this->assertFalse($root->hasChild('not_exists'));

        CopyFile::copy($this->getEventMock([
            vfsStream::url('root/from') => vfsStream::url('root/not_exists')
        ]));

        $this->assertTrue($root->hasChild('not_exists'));
        $this->assertTrue($root->hasChild('not_exists/file1'));
        $this->assertTrue($root->hasChild('not_exists/file2'));
    }

    public function testCopyFromNotExistsDir()
    {
        CopyFile::copy($this->getEventMock([
            vfsStream::url('root/fake') => vfsStream::url('root/to')
        ]));
    }

    public function testCopyDirToFile()
    {
        $this->expectException(\InvalidArgumentException::class);

        CopyFile::copy($this->getEventMock([
            vfsStream::url('root/from') => vfsStream::url('root/file3')
        ]));
    }

    public function testCopyFileToDir()
    {
        $root = $this->root;

        $this->assertFalse($root->hasChild('to/file3'));

        CopyFile::copy($this->getEventMock([
            vfsStream::url('root/file3') => vfsStream::url('root/to/')
        ]));

        $this->assertTrue($root->hasChild('to/file3'));
    }

    public function testCopyFileToFile()
    {
        $root = $this->root;

        $this->assertFalse($root->hasChild('to/file_new'));

        CopyFile::copy($this->getEventMock([
            vfsStream::url('root/file3') => vfsStream::url('root/to/file_new')
        ]));

        $this->assertTrue($root->hasChild('to/file_new'));
    }

    public function testCopyFromComplexDir()
    {
        $root = $this->root;

        $this->assertFalse($root->hasChild('to/file4'));
        $this->assertFalse($root->hasChild('to/sub_dir/file5'));

        CopyFile::copy($this->getEventMock([
            vfsStream::url('root/from_complex') => vfsStream::url('root/to')
        ]));

        $this->assertTrue($root->hasChild('to/file4'));
        $this->assertTrue($root->hasChild('to/sub_dir/file5'));
    }

    public function testConfigError()
    {
        $this->expectException(\InvalidArgumentException::class);

        CopyFile::copy($this->getEventMock([]));
        CopyFile::copy($this->getEventMock(['to', 'from', 'file3']));
        CopyFile::copy($this->getEventMock(null));
        CopyFile::copy($this->getEventMock('some string'));
    }

    /** @noinspection ReturnTypeCanBeDeclaredInspection */

    /**
     * @param $copyFileConfig
     *
     * @return \Composer\Script\Event
     */
    private function getEventMock($copyFileConfig)
    {
        $event = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->expects($this->once())
            ->method('getComposer')
            ->will($this->returnValue($this->getComposerMock($copyFileConfig)));

        $event
            ->method('getIO')
            ->will($this->returnValue($this->createMock(IOInterface::class)));

        /* @var \Composer\Script\Event $event */
        return $event;
    }

    /**
     * @param $copyFileConfig
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getComposerMock($copyFileConfig): \PHPUnit_Framework_MockObject_MockObject
    {
        $package = $this->getPackageMock($copyFileConfig);

        $composer = $this->getMockBuilder(Composer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $composer
            ->expects($this->once())
            ->method('getPackage')
            ->will($this->returnValue($package));

        return $composer;
    }

    /**
     * @param $copyFileConfig
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getPackageMock($copyFileConfig): \PHPUnit_Framework_MockObject_MockObject
    {
        $extra = null;

        if (null !== $copyFileConfig) {
            $extra = [
                'copy-file' => $copyFileConfig
            ];
        }

        $package = $this->getMockBuilder(RootPackageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $package
            ->expects($this->once())
            ->method('getExtra')
            ->will($this->returnValue($extra));

        return $package;
    }

    /**
     * @return vfsStreamDirectory
     */
    private function getFilesystem(): vfsStreamDirectory
    {
        $structure = [
            'from'         => [
                'file1' => 'Some content',
                'file2' => 'Some content'
            ],
            'to'           => [],
            'file3'        => 'Some content',
            'from_complex' => [
                'file4'   => 'Some content',
                'sub_dir' => [
                    'file5' => 'Some content'
                ]
            ]
        ];

        return vfsStream::setup('root', null, $structure);
    }
}
