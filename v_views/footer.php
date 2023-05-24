<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- lien bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  
    <!-- lien css -->
    <link href="stylesheet.css" rel="stylesheet">
    
    <title>Footer</title>
</head>
<body>


<footer class="bg-dark text-center text-white">
  <div class="container p-3 pb-0">
    <section>
        <ul class="nav justify-content-center border-bottom mb-3">
            <li class="nav-item"><a href="https://www.linkedin.com/in/sandra-rocher-376311264/" target="_blank" class="nav-link px-2">Linkedin</a></li>
            <li class="nav-item"><a href="https://github.com/Sandra-Rocher?tab=repositories" target="_blank" class="nav-link px-2">Github</a></li>
            <li class="nav-item"><a href="https://sandra-rocher.github.io/Portfolio-perso/" target="_blank" class="nav-link px-2">Portfolio</a></li>
            <li class="nav-item"><a href="https://cvdesignr.com/p/6405d12b8a89d" target="_blank" class="nav-link px-2">CV</a></li>
            <li class="nav-item"><a href="mentions_legales.php" class="nav-link px-2">Mentions légales</a></li>
            <li class="nav-item <?php if ($_SERVER['SCRIPT_NAME'] === '/Blog_first/informations.php'): ?> active aria-current='page' <?php endif; ?>"><a href="informations.php" class="nav-link px-5">Vous êtes recruteur ?</a></li>
        </ul>
    </section>
  </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">© 2023 Copyright Rocher Sandra</div>
</footer>

<!-- lien bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
 
</body>
</html>