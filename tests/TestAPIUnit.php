<?php

namespace Tests;

use GuzzleHttp\Client;
use TestAPI\TestAPI;

class TestAPIUnit
{

    public function it_work_auth()
    {
        $testAPI = new TestAPI(new Client());
        $test = $testAPI->auth();
        assert($test == true);
    }

    public function it_work_getUser()
    {
        $testAPI = new TestAPI(new Client());
        $result = $testAPI->getUser('ivanov');
        assert($result['status'] == 'OK');
    }

    public function it_work_setUser()
    {
        $testAPI = new TestAPI(new Client());
        $jsonFields = [
            "active" => "1",
            "blocked" => true,
            "name" => "Petr Petrovich",
            "permissions" => [
                "id" => 1,
                "permission" => "comment"
            ]
        ];

        $result = $testAPI->setUser('ivanov', $jsonFields);
        assert($result['status'] == 'OK');
    }

}