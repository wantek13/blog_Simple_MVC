<?php

require 'bdd.php';

function homeAction($bdd)
{
   require 'models/articles_model.php';
   $articles = getArticles($bdd);
   require 'views/home.phtml';
}

function articleAction($bdd)
{
   $articleId = $_GET['id'];
   require 'models/articles_model.php';
   require 'models/commentaires_model.php';
   $article = getArticleById($articleId, $bdd);
   $comms = getCommsbyId($articleId, $bdd);
   $nbComms = compteurComms($articleId, $bdd);
   require 'views/article.phtml';
   // var_dump($_POST);
   // exit;
   
}

function createAction($bdd)
{
   if($_SERVER['REQUEST_METHOD'] === 'POST')
   {
      require 'models/articles_model.php';
      createArticle($_POST, $bdd);

      header('Location: home');
   }
   require 'views/create.phtml';
}

function commentaireAction($bdd)
{
   if($_SERVER['REQUEST_METHOD'] === 'POST')
   {
      require 'models/commentaires_model.php';
      createCommentaireForArticle($bdd);
      header('Location: article?id=' . $_POST['postId']);
   }
}

function loginAction($bdd)
{
   if($_SERVER['REQUEST_METHOD'] === 'POST')
   {
      if (isset($_POST['username']) && isset($_POST['passwd']))
      {
         require 'models/utilisateurs_model.php';
         $user = connect($_POST, $bdd);
         if($_POST['username'] == $user['username'] && $_POST['passwd'] == $user['passwd'])
         {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['role'];

            if($_SESSION['username'] == 'h_core57')
            {
               $_SESSION['role'] == 'admin';
            }

            header('Location: home');
         }
         else
         {
            echo "le nom d'utilisateur ou le mot de passe est incorrect";
         }
      }
   }

   require 'views/login.phtml';
}

function disconnectAction()
{
   // Détruit toutes les variables de session
   $_SESSION = array();

   // Si vous voulez détruire complètement la session, effacez également
   // le cookie de session.
   // Note : cela détruira la session et pas seulement les données de session !
   if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
         $params["path"], $params["domain"],
         $params["secure"], $params["httponly"]
      );
   }

   // Finalement, on détruit la session.
   session_destroy();
   header('Location: home');
}

function registerAction($bdd)
{
   if($_SERVER['REQUEST_METHOD'] === 'POST')
   {
      require 'models/utilisateurs_model.php';

      createUser($_POST, $bdd);
      
      header('Location: login');
      exit;
   }


   require 'views/register.phtml';
}