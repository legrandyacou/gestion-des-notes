                            <?php
                                        require_once "db_connexion.php";
                                            
                                            if($_SERVER['REQUEST_METHOD'] =='POST'){
                                                $nom= $_POST['nom']??'';
                                                $prenom= $_POST['prenom']??'';
                                                $tel= $_POST['tel']??'';
                                                $jcours= $_POST['jcours']??'';
                                                $id_matiere= $_POST['id_matiere']??'';
                                               
                                                
                                                $sqlquery = "INSERT INTO professeurs(nom,prenom,tel,jcours,id_matiere) VALUES (:nom ,:prenom,:tel,:jcours,:id_matiere)";
                                                $insertion = $PDO->prepare($sqlquery);
                                                $insertion->execute([
                                                'nom'=>$nom,
                                                'prenom'=>$prenom,
                                                'tel'=>$tel,
                                                'jcours'=>$jcours,
                                                'id_matiere'=>$id_matiere,
                                                
                                                ]);
                                                    

                                                    // Redirection pour "nettoyer" la requête POST et éviter les doublons au F5
                                                    header("Location: index.php" );
                                                   // . $_SERVER['PHP_SELF']
                                                    exit();
                                                    echo "Enregistrement reussi <br>";
                                            }
                                            

                                            
                                        ?>
