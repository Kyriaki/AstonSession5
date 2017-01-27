<?php
/**
 * Created by iKNSA.
 * Author: Khalid Sookia <khalidsookia@gmail.com>
 * Date: 04/12/16
 * Time: 00:08
 */

namespace Assur\Controller;

use Assur\Model\User;
use Romenys\Framework\Components\DB\DB;
use Romenys\Framework\Components\UrlGenerator;
use Romenys\Framework\Controller\Controller;
use Romenys\Http\Request\Request;
use Romenys\Http\Response\JsonResponse;

class AssurController extends Controller
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

        $user = $db->query("SELECT * FROM `clients` WHERE id = " . $id)->fetch($db::FETCH_ASSOC);

        $user = new User($user);

        return new JsonResponse([
            "user" => [
                "name" => $user->getName(),
                "email" => $user->getEmail()
            ]
        ]);
    }

    public function defaultAction(Request $request)
    {
        $urlGenerator = new UrlGenerator($request);

        return new JsonResponse(['form' => $urlGenerator->absolute("form")], [JSON_UNESCAPED_SLASHES]);
    }
}
