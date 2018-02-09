<?php

    $options=[
      '--create-file=',
      '--add-user=',
        '--firstname='.
        '--lastname='.
        '--note=',
    ];
    /**
     * ##############################  création de fichier ##################################
     */
    $p=explode("=", $argv[1]);
    $nomDuFile=$p[1].'.csv';
    //var_dump($nomDuFile);

    /**
     * ##############################  Vérification si commande --create-file est correcte  ##############################
     */
    if(strpos($argv[1],'--create-file=')!==false){
        var_dump('test');

        /**
         * on ouvre ou créer le fichier puis on ajoute FIRSTNAME,LASTNAME,NOTE
         */

        $fichierCsv = fopen($nomDuFile, "a+");
            var_dump($fichierCsv);
            file_put_contents($nomDuFile, "FIRSTNAME,LASTNAME,NOTE".PHP_EOL);

        }
    /**
     * ##############################  Vérification ligne de commande ajout d'utilisateur --add-users ##############################
     */
    if((strpos($argv[1],'--add-user='))!==false && (strpos($argv[2],'--firstname='))!==false
        && (strpos($argv[3],'--lastname='))!==false && (strpos($argv[4],'--note='))!==false){
        //var_dump('test multi');
        /**
         * on découpe la commande pour en extraire les donnée importantes
         */
        $pp=explode('=',$argv[1]);
        $pp2=explode('=',$argv[2]);
        $pp3=explode('=',$argv[3]);
        $pp4=explode('=',$argv[4]);
        //var_dump('test affichage explode : '.$pp2[1].' | '.$pp3[1].' | '.$pp4[1]);
        /**
         * le fichier existe il ? Si oui on y ajoute les données extraites.
         */
        if(file_exists($pp[1].'.csv')){
        $fichierCsv = fopen($nomDuFile, "a+");
        fputs($fichierCsv, $pp2[1].' | '.$pp3[1].' | '.$pp4[1].PHP_EOL);
        fclose($fichierCsv);

    }else{
            echo 'Fichier introuvable';
            die;
        }
    }

    /**
     * ##############################  Vérification ligne de commande --get-all-users  ##############################
     */
    if(strpos($argv[1],'--get-all-users=')!==false){

        /**
         * le fichier existe il ?
         */
            if(file_exists($p[1].'.csv')){
                var_dump("test get fichier");

                /**
                 * SI oui on ouvre le fichier
                 */
                $fp=fopen($p[1].'.csv',"r");
                $i=0;

                /**
                 * on défini un tableau de taille de chaine de carac max
                 */
                $maxSize = array(0, 0, 0);
                /**
                 * Premiere boucle pour récupérer les tailles maximum de chaque élément
                 */
                while (($buffer = fgets($fp, 4096)) !== false) {
                    $ex=explode(' | ',$buffer);
                    $size0=strlen($ex[0]);
                    $size1=strlen($ex[1]);
                    $size2=strlen($ex[2]);
                    if($size0>$maxSize[0]){

                        $maxSize[0]=$size0;
                        }
                    if($size1>$maxSize[1]){

                        $maxSize[1]=$size1;
                        }
                    if($size2>$maxSize[2]){

                        $maxSize[2]=$size2;
                        }
                    }
                fclose($fp);

                /**
                 * seconde boucle pour comparer la taille max avec la taille actuelle des éléments
                 * ainsi on sait comment compléter les chaines avec des espaces.
                 */
                $fp=fopen($p[1].'.csv',"r");
                while(($buffer = fgets($fp, 4096)) !== false){
                    $resultat='';
                    $ex=explode(' | ',$buffer);
                    $size0=strlen($ex[0]);
                    $size1=strlen($ex[1]);
                    $size2=strlen($ex[2]);
                    $resultat= $ex[0];
                    if($size0<$maxSize[0]){
                        $nbrSpace=$maxSize[0]-$size0;
                        for($i=0;$i<$nbrSpace;$i++){

                            $resultat=$resultat.' ';
                            }
                        }
                    $resultat=$resultat.' | '.$ex[1];
                    if($size1<$maxSize[1]){
                        $nbrSpace=$maxSize[1]-$size1;
                        for($i=0;$i<$nbrSpace;$i++){

                            $resultat=$resultat.' ';
                        }
                    }
                    $resultat=$resultat.' | '.$ex[2];
                    if($size2<$maxSize[2]){
                        $nbrSpace=$maxSize[2]-$size2;
                        for($i=0;$i<$nbrSpace;$i++){

                            $resultat=$resultat.' ';
                        }
                    }
                    echo $resultat;
                }
                fclose($fp);
            }else{
                echo 'Fichier introuvable';
                die;
            }
    }


