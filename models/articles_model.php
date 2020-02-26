<?php

function getArticles($bdd)
{
    $requete = $bdd->query('SELECT * , (SELECT COUNT(*) FROM commentaires WHERE idArticle = articles.id) AS nbComms FROM articles ORDER BY dateRedaction DESC');

    return $requete;
}

function getArticleById($id, $bdd)
{
    $articles = getArticles($bdd); 
    foreach($articles as $article)
    {
        if($id == $article['id'])
        {
            $resultat = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
            $resultat->bindParam(':id', $id);
            $resultat->execute();
            $result = $resultat->fetch();

            return $result;
        }
    }
}

function createArticle($dataArticle, $bdd)
{
    // insert a row
    $img = $dataArticle["img"];
    $titre = $dataArticle["titre"];
    $contenu = $dataArticle["contenu"];
    $idRedacteur = $_SESSION['id'];

    $stmt = $bdd->prepare("INSERT INTO articles (img, titre, contenu, idRedacteur) VALUES (:img, :titre, :contenu, :idRedacteur)");

    $stmt->bindParam(':img', $img);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':contenu', $contenu);
    $stmt->bindParam(':idRedacteur', $idRedacteur);

    $stmt->execute();
}