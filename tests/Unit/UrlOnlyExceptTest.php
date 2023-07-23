<?php
namespace Yormy\ApiIoTracker\Tests\Unit;

use GuzzleLogMiddleware\LogMiddleware;
use Yormy\ApiIoTracker\Domain\HttpLogger\Services\UrlOnlyExcept;
use Yormy\ApiIoTracker\Services\SimpleHandler;
use Yormy\ApiIoTracker\Tests\TestCase;

class UrlOnlyExceptTest extends TestCase
{
    /**
     * @test
     * @group xxx
     */
    public function IncludeExceptUrlMethodFilter(): void
    {
        $config = [
            'only' => [
                'include_url_all' => ['*'],
                'include_url_post' => ['delete', 'post']
            ],
            'except' => [
                'except_url_all' => ['*'],
                'except_url_post' => ['delete','post']
            ]
        ];

        $shouldInclude = [
            'include_url_all' => ['post', 'gEt'],
            'include_url_post' => ['post'],
        ];

        $shouldExcept = [
            'except_url_all' => ['pOst'],
            'except_url_post' => ['post'],
        ];

        $this->assertIncludes($shouldInclude, $config);
        $this->assertExcept($shouldExcept, $config);
    }

    /**
     * @test
     * @group xxx
     */
    public function IncludeUrlMethodFilter(): void
    {
        $config = [
            'only' => [
                'include_url_all' => ['*'],
                'include_url_post' => ['delete', 'post']
            ],
            'except' => []
        ];

        $shouldInclude = [
            'include_url_all' => ['post', 'gEt'],
            'include_url_post' => ['post'],
            'except_url_all' => ['pOst'],
            'except_url_post' => ['post'],
        ];

        $this->assertIncludes($shouldInclude, $config);

    }

    private function assertIncludes(array $shouldInclude, array $config)
    {
        foreach ($shouldInclude as $url => $methods) {

            foreach ($methods as $method) {
                $included = UrlOnlyExcept::shouldInclude($url, $method, $config);
            }

            $message ="$method to $url should be included";
            $this->assertTrue($included, $message);
        }
    }

    private function assertExcept(array $shouldExcept, array $config)
    {
        foreach ($shouldExcept as $url => $methods) {

            foreach ($methods as $method) {
                $included = UrlOnlyExcept::shouldInclude($url, $method, $config);
            }

            $message ="$method to $url should be excepted";
            $this->assertFalse($included, $message);
        }
    }

}
