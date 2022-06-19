<?php
    require 'engine.php';

    $images = array();
    if(isset($_POST) && !empty($_POST)){
        // la recherche est lancée
        extract($_POST);
        $imageBySearchEngine = new ImageBySearchEngine();
        $images = $imageBySearchEngine->search( $query, $limit, $searchengine );
        // echo "<pre>";
        // print_r($images);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel='preload' as='image' href="icon.png">
    <link rel="icon" href="icon.png" sizes="32x32" />
    <link rel="icon" href="icon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="icon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application de recherche d'images</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../css/expoframeworkcss.css">
</head>
<body>
    <div class="row x_aligncenter x_c-blue x_mb-3">
        <div class="x_pt-1 ">
            <img src="engine.jpg" class="x_w-5">
            <span class="x_t-white">
                Obtenez facilement des URLs des images 
                sur le web en quelques clics, de plusieurs 
                moteurs d'images !
            </span>
        </div>
    </div>
    <div class="x_ml-25 x_vw-40">
        <form action="" method="post">
            <div class="form-group">
                <label>Titre ou intitulé</label>
                <input name="query" required placeholder="Titre ou intitulé de l'image recherchée" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Combien de résultat attendez-vous ?</label>
                <input name="limit" required type="number" class="form-control">
            </div>
            <div class="form-group">
                <label>Choisissez le moteur de recherche</label>
                <select name="searchengine" class="form-control" required>
                    <option value="bing">Bing Images</option>
                    <option value="google">Google Images</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary x_mt-5 x_aligncenter x_ml-25 x_w-40">
                <i class="fa fa-search x_pr-2"></i>
                Lancer la recherche
            </button>
        </form>
    </div>

    <div class="">
        <div class="row">
            <div class="x_mt-1 x_aligncenter">
                <?php 
                    if(isset($_POST['query']) && !empty($_POST['query'])){
                        ?>
                        Résultat de la recherche :  
                        <b>
                            <?= $_POST['query']; ?>
                        </b> 
                        <?php
                    } 
                ?>
            </div>

            <div class="col-12 x_mt-2 x_ml-5 x_mr-5">
                <?php 
                    if(isset($images) && count($images) > 0){
                        foreach($images as $key=>$val){
                            ?>
                                <span class="x_mb-2">
                                    <a href="<?= $val['uri']; ?>" target="_blank" title="<?= $_POST['query']; ?>"> 
                                        <img src="<?= $val['uri']; ?>">
                                    </a>
                                </span>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>

</body>
</html>