<?php 
                                            $countNote=0;
                                            try {      //etape 1
                                            $PDO  = new PDO("mysql:host=localhost;dbname=lesnotes;charset=utf8","root","");
                                            } catch (Exception $e){
                                            die("Erreur ".$e->getMessage());
                                            } 
                                            
                                            if($_SERVER['REQUEST_METHOD'] =='POST' && isset($_POST['Enregistre'])) {
                                                $libelle= $_POST['libelle'];
                                                $date_note= $_POST['date_note'];
                                                $note= $_POST['note'];
                                                if (!empty($libelle) && !empty($date_note) && $note !== ''){
                                                    
                                                }
                                                $sqlquery = "INSERT INTO note(libelle,date_note,note) VALUES (:libelle,:date_note,:note)";
                                                $insertion = $PDO->prepare($sqlquery);
                                                $insertion->execute([
                                                'libelle'=>$libelle,
                                                'date_note'=>$date_note,
                                                'note'=>$note,
                                                ]);
                                                header("Location: " . $_SERVER['PHP_SELF']);
                                                    exit;
                                                   
                                            }
                                            

                                            
                                        ?>