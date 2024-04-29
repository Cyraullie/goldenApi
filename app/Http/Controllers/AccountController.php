<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function show_all(Request $request)
    {
        $accounts = Account::all();
        return $accounts;
    }

    public function store(Request $request)
    {

        try {
            $firstname = strtolower(preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($request->input("firstname"))));
            $lastname = strtolower(preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($request->input("lastname"))));
            
            $username = $firstname . $lastname;
    
            $first = mt_rand(0, 9);
            $second = mt_rand(0, 9);
            $third = mt_rand(0, 9);
            $forth = mt_rand(0, 9);
    
            $lastname_temp = str_replace("i", "1", str_replace("o", "0", str_replace("e", "3", str_replace("a", "@", $lastname))));
            $firstname_temp = str_replace("i", "1", str_replace("o", "0", str_replace("e", "3", str_replace("a", "@", $firstname))));
    
            $password = $firstname_temp . $first . $second . $third . $forth . $lastname_temp;
    

            $account = new Account();
            $account->username = $username;
            $account->password = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);
            $account->save();

            return response($password, 200);
        } catch (\Exception $e) {
            return response('Bad request:' . $e->getMessage(), 400);
        }
    }
    
    public function verify(Request $request)
    {
        $account = Account::where("username", $request->input("username"))->first();

        if ($account) {
            // Le nom existe dans la table "accounts"

            $password = $request->input("password");
            $hashFromDatabase = $account->password;

            if (password_verify($password, $hashFromDatabase)) {
                return response($account->id, 200);
            } else {
                return response('Bad password', 400);
            }
        } else {
            // Le nom n'existe pas dans la table "accounts"
            return response("Le nom n'existe pas dans la table.", 400);
        }

        
    }
}
