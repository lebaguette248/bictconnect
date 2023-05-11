<?php

namespace App\Tests;


use App\DTO\CreateUpdateUser;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;

class UserControllerTest extends TestCase
{
    private static $client;

    private int $tempid;
    public static function setUpBeforeClass(): void
    {
        self::$client = new Client([
            "base_uri" => "http://localhost:8000"
        ]);

        //$client = self::createClient();
        //self::$application = new Application($client->getKernel());
        //self::$application->setAutoExit(false);

        //self::$application->run(new StringInput(()))
    }

    public function testPost() {
        $dto = new CreateUpdateUser();
        $dto->name = "test";
        $dto->username = "testusername";
        $dto->password = "testpassword";

        $request = self::$client->request("POST", "/api/user",
            [
                "body" => json_encode($dto)
            ]
        );



        $response = json_decode($request->getBody());

        $this->tempid = $response->id;

        $this->assertTrue($request->getStatusCode() == 200);
        $this->assertFalse($response == "Post hat funktioniert");


    }

    public function testDelete()    {

        $id = $this->tempid;

        $entityToDelete = $this->repository->find($id);
        $this->repository->remove($entityToDelete, true);


        $request = self::$client->request("PUT", "/api/user/{$id}",
            [
            ]
        );
        $this->expectException(ClientException::class);
    }





    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
}
