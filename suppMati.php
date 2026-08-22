<?php

                                               // $countNote=0;
                                                        require_once "db_connexion.php";
                                                    if (isset($_GET['del'])) {

                                                        $id_matiere = $_GET['del'];

                                                        $sql = "DELETE FROM matieres WHERE id_matiere = :id_matiere";
                                                        $suppression = $PDO->prepare($sql);

                                                        $suppression->execute([
                                                            ':id_matiere' => $id_matiere
                                                        ]);

                                                        header("Location: index.php" );
                                                        //. $_SERVER['PHP_SELF']
                                                        exit();
                                                    }
                                                    ?>
                                                    