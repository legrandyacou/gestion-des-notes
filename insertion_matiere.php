<?php
                                require_once "db_connexion.php";
                                            
                                            if($_SERVER['REQUEST_METHOD'] =='POST'){
                                                $libelle= $_POST['libelle']??'';
                                                $coefficient= $_POST['coefficient']??'';
                                                $Heure= $_POST['Heure']??'';
                                                $id_prof= $_POST['id_prof']??'';
                                                $sqlquery = "INSERT INTO matieres(libelle,coefficient,Heure,id_prof) VALUES (:libelle,:coefficient,:Heure,:id_prof)";
                                                $insertion = $PDO->prepare($sqlquery);
                                                $insertion->execute([
                                                  'libelle'=>$libelle,
                                                'coefficient'=>$coefficient,
                                                'Heure'=>$Heure,
                                                'id_prof'=>$id_prof,
                                                ]);
                                                    

                                                    // Redirection pour "nettoyer" la requête POST et éviter les doublons au F5
                                                    header("Location: index.php" );
                                                   // . $_SERVER['PHP_SELF']
                                                    exit();
                                                    echo "Enregistrement reussi <br>";
                                            }
                                            

                                            
                                        ?>
