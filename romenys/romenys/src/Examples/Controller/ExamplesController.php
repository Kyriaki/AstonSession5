<?php
/**
 * Created by iKNSA.
 * Author: Khalid Sookia <khalidsookia@gmail.com>
 * Date: 04/12/16
 * Time: 00:08
 */

namespace Examples\Controller;

use Examples\Entity\User;
use Examples\Entity\Car;
use Romenys\Framework\Components\DB\DB;
use Romenys\Framework\Components\UrlGenerator;
use Romenys\Framework\Controller\Controller;
use Romenys\Http\Request\Request;
use Romenys\Http\Response\JsonResponse;

class ExamplesController extends Controller
{
    public function listAction()
    {
        $db = new DB();
        $db = $db->connect();

        $query = $db->query("SELECT * FROM `clients`");
        $clients = $query->fetchAll($db::FETCH_ASSOC);

        return new JsonResponse(["clients" => $clients]);
    }

    public function newAction(Request $request)
    {
        
        $client = new User($request->getPost()["client"]);

        /*
         * Registering the file path on the system
         * You could also choose to save the original name and corresponding info so as to display it on the frontend
         */

        $db = new DB();
        $db = $db->connect();

        $query = $db->prepare("INSERT INTO `clients` (`name`, `email`) VALUES (:name, :email)");

        $query->bindValue(":name", $client->getName());
        $query->bindValue(":email", $client->getEmail());
        $query->execute();

        return new JsonResponse([
            "client" => [
                "name" => $client->getName(),
                "email" => $client->getEmail()
            ]
        ]);
    }

    public function showAction(Request $request)
    {
        $params = $request->getGet();
        $id = $params["id"];

        $db = new DB();
        $db = $db->connect();

        $db2 = new DB();
        $db2 = $db2->connect();

        $db3 = new DB();
        $db3 = $db3->connect();

        $client = $db->query("SELECT * FROM `clients` WHERE id = " . $id)->fetch($db::FETCH_ASSOC);
        $clientCar = $db2->query("SELECT `id`, `brand` FROM `car` WHERE user_id ="  . $id)->fetch($db2::FETCH_ASSOC);
        $clientAssur = $db3->query("SELECT `name` FROM `assurance` WHERE user_id =" . $id)->fetch($db3::FETCH_ASSOC);

        $client = new User($client);
        $clientCar = new Car($clientCar);

        return new JsonResponse([
            "client" => [
                "id" => $client->getId(),
                "name" => $client->getName(),
                "email" => $client->getEmail(),
            ],
            "clientCar" =>[
                "id" => $clientCar->getId(),
                "brand" => $clientCar->getBrand()
            ],
            "clientAssur" =>[
                "name" => $clientAssur["name"]
            ]
        ]);
    }

    public function formAction(Request $request)
    {
        $request->uploadFiles();

        return new JsonResponse([
            'uploadedFiles' => $request->getUploadedFiles(),
            'post' => $request->getPost(),
            'get' => $request->getGet(),
            'file' => $request->getOneFile('user', 'avatar'),
            'files' => $request->getFiles(),
            'session' => $request->getSession()
        ]);
    }

    public function modifyAction(Request $request)
    {
        $params = $request->getGet();
        $id = $params["id"];

        $db = new DB();
        $db = $db->connect();

        $db2 = new DB();
        $db2 = $db2->connect();

        $client = $db->query("SELECT * FROM `clients` WHERE id =" . $id)->fetch($db::FETCH_ASSOC);
        $clientAssur = $db2->query("SELECT * FROM `assurance`")->fetchAll($db2::FETCH_ASSOC);

        $client = new User($client);

        if(!empty($request->getPost())){

            print_r($request->getPost());
            $postParams = $request->getPost();
            $newValues = new User($postParams);

            $query = $db->prepare("UPDATE `clients` SET `name`=:name, `email`=:email WHERE `id`=:id" );

            $query->bindValue(":id", $id);
            $query->bindValue(":name", $newValues->getName());
            $query->bindValue(":email", $newValues->getEmail());

            $query->execute();

           
        }
        return new JsonResponse([
            "client" => [
                "name" => $client->getName(),
                "email" => $client->getEmail(),
            ],
            "clientAssur" => $clientAssur
        ]);

    }

    public function modifyAssurAction(Request $request)
    {
        $params = $request->getGet();
        $id = $params["id"];

        $db = new DB();
        $db = $db->connect();

        $client = $db->query("SELECT * FROM `clients` WHERE id =" . $id)->fetch($db::FETCH_ASSOC);
        $client = new User($client);



        return new JsonResponse([
                "client" => [
                    "name" => $client->getName()
                ]
            ]);

    }

    public function getAssursAction(Request $request)
    {
        $params = $request->getGet();
        $id = $params["id"];

        $db = new DB();
        $db = $db->connect();

        $assurs = $db->query("SELECT * FROM `assurance`")->fetchAll($db::FETCH_ASSOC);

        if(!empty($request->getPost())){
            
            $postParams = $request->getPost();
            print_r($postParams);

            $query = $db->prepare("UPDATE `assurance` SET `user_id`=:userid WHERE `id`=:assurid");

            $query->bindValue(":userid", $id);
            $query->bindValue(":assurid", $postParams["id"]);
            print_r($query);
            $query->execute();
           
        }

        return new JsonResponse([ "assurs" => $assurs ]);

    }

    public function getAssursFromClientAction(Request $request)
    {
        $params = $request->getGet();
        $id = $params["id"];

        $db = new DB();
        $db = $db->connect();
        $clientAssurs = $db->query("SELECT * FROM `assurance` WHERE user_id =" . $id)->fetchAll($db::FETCH_ASSOC);

        return new JsonResponse([ "clientAssurs" => $clientAssurs ]);

    }



    public function carAssurShowAction(Request $request)
    {
        $params = $request->getGet();
        $id = $params["carid"];

        $db = new DB();
        $db = $db->connect();

        $assur = $db->query("SELECT `name` FROM `assurance` WHERE car_id =" . $id)->fetch($db::FETCH_ASSOC);
        

        return new JsonResponse([
            "assur" => [
                "name" => $assur["name"]
            ]
        ]);
    }

    public function clientAssurShowAction(Request $request)
    {
        $params = $request->getGet();
        $id = $params["id"];

        $db = new DB();
        $db = $db->connect();

        $assur = $db->query("SELECT `name` FROM `assurance` WHERE user_id =" . $id)->fetch($db::FETCH_ASSOC);
        

        return new JsonResponse([
            "assur" => [
                "name" => $assur["name"]
            ]
        ]);
    }

    public function defaultAction(Request $request)
    {
        $urlGenerator = new UrlGenerator($request);

        return new JsonResponse(['form' => $urlGenerator->absolute("form")], [JSON_UNESCAPED_SLASHES]);
    }
}
