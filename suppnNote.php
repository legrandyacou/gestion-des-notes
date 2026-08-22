<?php

                                               // $countNote=0;
                                                        require_once "db_connexion.php";
                                                    if (isset($_GET['del'])) {

                                                        $id_Prof = $_GET['del'];

                                                        $sql = "DELETE FROM proffesseurs WHERE id_Prof = :id_Prof";
                                                        $suppression = $PDO->prepare($sql);

                                                        $suppression->execute([
                                                            ':id_Prof' => $id_Prof
                                                        ]);

                                                        header("Location: index.php" );
                                                        //. $_SERVER['PHP_SELF']
                                                        exit();
                                                    }
                                                    ?>
                                                    