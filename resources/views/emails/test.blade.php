<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>document</title>
</head>

<body>

    <p>Bonjour {{$data['nom']}},</p>
    <p>Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter à l'application.</p>
    <p>Veuillez utiliser les informations de connexion suivantes pour accéder à votre compte :</p>
    <ul>
        <li>Email : {{$data['email']}}</li>
        <li>Mot de passe : {{$data['password']}}</li>
    </ul>
    <p>Nous vous recommandons de changer votre mot de passe dès que possible pour assurer la sécurité de votre compte. Pour changer votre mot de passe, veuillez suivre le lien ci-dessous :</p>
    <ul>
        <li><a href="http://localhost:3000/change-password">Changer mon mot de passe</a></li>
    </ul>
    <p>Si vous avez des questions ou des problèmes, n'hésitez pas à nous contacter.</p>
</body>

</html>