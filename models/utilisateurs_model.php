<?php

function getUsers($bdd)
{
    $resultat = $bdd->query('SELECT * FROM users');
    $result = $resultat->fetchAll();
    return $result;
}

function getUserByUsername($username, $bdd)
{
    $users = getUsers($bdd); 
    foreach($users as $user)
    {
        if($username == $user['username'])
        {
            $resultat = $bdd->query('SELECT * FROM users WHERE username = '.$username.'');

            $result = $resultat->fetch();

            return $result;
        }
    }
}

function createUser($dataUser, $bdd)
{
    // insert a row
    $username = $dataUser["username"];
    $prenom = $dataUser["prenom"];
    $nom = $dataUser["nom"];
    $passwd = $dataUser["passwd"];

    $stmt = $bdd->prepare("INSERT INTO users (username, prenom, nom, passwd) VALUES (:username, :prenom, :nom, :passwd)");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':passwd', $passwd);

    $stmt->execute();
}

function connect($data, $bdd)
{
    $stmt = $bdd->prepare('SELECT * FROM users WHERE username = :username AND passwd = :passwd');

    $stmt->bindParam(':username', $data['username']);
    $stmt->bindParam(':passwd', $data['passwd']);

    $stmt->execute();

    $result = $stmt->fetch();

    return $result;
}