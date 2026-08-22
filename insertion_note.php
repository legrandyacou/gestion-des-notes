<?php 

                                            
                                        
                                            require_once "db_connexion.php";
                                            
                                            if($_SERVER['REQUEST_METHOD'] =='POST'){
                                                $libelle= $_POST['libelle']??'';
                                                $date_note= $_POST['date_note']??'';
                                                $note= $_POST['note']??'';
                                                $sqlquery = "INSERT INTO note(libelle,date_note,note) VALUES (:libelle,:date_note,:note)";
                                                $insertion = $PDO->prepare($sqlquery);
                                                $insertion->execute([
                                                'libelle'=>$libelle,
                                                'date_note'=>$date_note,
                                                'note'=>$note,
                                                ]);
                                                    

                                                    // Redirection pour "nettoyer" la requête POST et éviter les doublons au F5
                                                    header("Location: index.php");
                                                    exit();
                                                    echo "Enregistrement reussi <br>";
                                                     //. $_SERVER['PHP_SELF']
                                            }
                                            

                                            
                                        ?>
                                       
                            