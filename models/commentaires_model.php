<?php

function getComms($bdd)
{
    $requete = $bdd->query('SELECT * FROM commentaires');

    return $requete;
}

function getCommsById($id, $bdd)
{
    $comms = getComms($bdd); 
    foreach($comms as $comm)
    {
        if($id == $comm['idArticle'])
        {
            $result = $bdd->prepare('SELECT * FROM commentaires WHERE idArticle = ? ORDER BY dateAjout DESC');

            $result->execute(array($id));

            return $result;
        }
    }
}

function createCommentaireForArticle($bdd)
{
    $stmt = $bdd->prepare('INSERT INTO commentaires (pseudoAuteur, contenu, idArticle) VALUES (:pseudoAuteur, :contenu, :idArticle)');

    $stmt->bindParam(':pseudoAuteur', $_SESSION['username']);
    $stmt->bindParam(':contenu', $_POST['comment']);
    $stmt->bindParam(':idArticle', $_GET['id']);

    $stmt->execute();
}

function compteurComms($idArticle, $bdd)
{
    var_dump($idArticle);
    $stmt = $bdd->prepare('SELECT COUNT(*) FROM commentaires WHERE idArticle LIKE :idArticle');
    $stmt->bindParam(':idArticle', $idArticle);
    $stmt->execute();
    $resultat = $stmt->fetch();

    return $resultat['COUNT(*)'];
}