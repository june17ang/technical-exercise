<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->getApi('test12')->assertStatus(400);

        $this->getApiWithInvalidParam('key', 'test')->assertStatus(400);

        $this->getApiWithParam('key', ['timestamp' => 1440568980])->assertStatus(400);

        $this->postData(['name' => 'salley'])->assertStatus(200);

    }

    protected function getApi($key)
    {
        return $this->get('/api/object/{key}', ['key' => $key]);
    }

    protected function getApiWithInvalidParam($key, $param)
    {
        return $this->get('/api/object/{key}?{$value}', ['key' => $key, 'value' => $param]);
    }

    protected function getApiWithParam($key, $param = [])
    {
        return $this->get('/api/object/{key}?{$value}', ['key' => $key, 'value' => http_build_query($param)]);
    }

    protected function postData($value = [])
    {
        return $this->postJson('/api/object', $value);
    }
}
