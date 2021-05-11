<h1>Les idées des étudiants</h1>
    <div id="addIdea">
        <h2 style="color:orange">nouvelle idée</h2>
        <form action="index.php?action=timelineidea" method ="POST">
        <table>
            <tr>
                <td>
                    <label for="title_idea"> titre :</label>
                </td>
                <td>
                    <input type="texte"  placeholder="Titre de votre idée" id="title_idea" name="title_idea" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="idea"> ton idée:</label>
                </td>
                <td>
                    <textarea id="idea"  placeholder="Une nouvelle idée à partager?" name="text_idea" rows="5" cols="33"></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="form_publish_idea" value="Publier">
                </td>
            </tr>
        </table>
        </form>
    </div>
    </br>
    <p><?php echo $notificationIdea ?></p>
    <p>______________________________________________________________________________________________________________________________________________</p>
    <div>
        <form action="index.php?action=timelineidea" method="POST">
            <h5>Choisir un type de tri (par défaut: <i>par popularité</i>):</h5>
            <p>Choisisez parmis les propisitions suivantes</p>
            <input type="radio" name="choice" value="popularity" <?php if($sortType == 'popularity') {echo 'checked'; $sortType = "popularity";} ?>>Par popularité
            <input type="radio" name="choice" value="chronological" <?php if($sortType == 'chronological') {echo 'checked'; $sortType = "chronological";} ?>>Par ordre de chronologique (de l'idée la plus récente à  la plus ancienne)<br><br>
            <input type="submit" name="form_sort_type" value="Afficher les idées">
        <!-- <?php var_dump($_POST['choice'])?> -->
        <p>---------</p> 
        <?php $un = 1;?>
        <?php if($sortType == "popularity") {?>
            <h5>Filtrer par popularité</h5>
                <p>Choisisez parmis les propisitions suivantes</p>
                <select name="popularity" id="popularity-select">
                    <option value="" disabled selected>--Choisisez une option s.v.p.--</option>
                    <option value="3">3</option>
                    <option value="10">10</option>
                    <option value="ALL">ALL</option>
                </select></br></br>
                <input type="submit" name="form_popularity" value="Afficher les idées">
         <h5>Filtrer par statut</h5>
            <p>Choisisez parmis les propisitions suivantes</p>
                <select name="status" id="status-select">
                    <option value="" disabled selected >--Choisisez une option s.v.p.--</option>
                    <option value="submitted">submitted</option>
                    <option value="accepted">accepted</option>
                    <option value="refused">refused</option>
                    <option value="closed">closed</option>
                </select></br></br>
                <input type="submit" name="form_status" value="Afficher les idées">
        </form>
        <?php }else{?>
            <h5>Filtrer par ordre chronologique</h5>
                <p>Choisisez parmis les propisitions suivantes</p>
                <select name="chronological" id="chronological-select">
                    <option value="" disabled selected>--Choisisez une option s.v.p.--</option>
                    <option value="3">3</option>
                    <option value="10">10</option>
                    <option value="ALL">ALL</option>
                </select></br></br>
                <input type="submit" name="form_chronological" value="Afficher les idées">
            <h5>Filtrer par statut</h5>
            <p>Choisisez parmis les propisitions suivantes</p>
                <select name="status" id="status-select">
                    <option value="" disabled selected >--Choisisez une option s.v.p.--</option>
                    <option value="submitted">submitted</option>
                    <option value="accepted">accepted</option>
                    <option value="refused">refused</option>
                    <option value="closed">closed</option>
                </select></br></br>
                <input type="submit" name="form_status" value="Afficher les idées">
        </form>
        <?php } ?>
           
        <!-- <?php var_dump($_POST['form_sort_type'])?>
        <?php var_dump($_POST['choice'])?> -->
        <?php //var_dump($_POST['popularity'])?>
        <?php //var_dump($selectionStatus)?>
        <?php //var_dump($_POST['form_popularity'])?>
        <?php //var_dump($_POST['popularity'])?>
        <?php //var_dump($_POST['status'])?> 

    </div>
    <p>______________________________________________________________________________________________________________________________________________</p>
    </br>
        <?php if(isset($alerte)){?>
            <strong style="color:greenyellow;"><?php echo $alerte ?></strong>
            </br> </br>
        <?php }?>
        <?php if(isset($alerteVote)){?>
            <strong style="color:orangered;"><?php echo $alerteVote ?></strong>
            </br> </br>
        <?php }?>
        <h2><?php echo $titleToDisplay?></h2>
    <form action="index.php?action=timelineidea" method="POST">
        <table>
            <thead>
            <tr>
                <th>Auteur</th>
                <th>Titre</th>
                <th>Texte</th>
                <th>Statue</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabIdeas as $i => $ideas) { ?>
                <tr>
                    <td><?php echo $ideas->html_Author() ?></td>
                    <td><?php echo $ideas->html_Title() ?></td>
                    <td><?php echo $ideas->html_Text() ?></td>
                    <td><?php echo $ideas->html_Status() ?></td>		
                </tr>
                </tr>
                <tr>
                <tr style="color:red;">
                    <td colspan = "1"></td>
                    <td colspan = "1"><?php if($ideas->getStatus()=="closed"){}else{?><input type="submit" name="form_vote[<?php echo $tabIdeas[$i]->getId_idea()?>]" value="voter"><?php }?>| nbr de votes : <strong><?php echo $tabIdeas[$i]->getNumber_of_votes()?></strong></td>
                    <td colspan = "1"><input type="submit" name="form_comment[<?php echo $tabIdeas[$i]->getId_idea()?>]" value="commenter"> | nbr de commentaire : <strong><?php echo $tabIdeas[$i]->getNumber_of_comments()?></strong></td>
                </tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr>
                </tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
<p><?php echo $notification ?></p>
<!-- 
<td><input type="submit" name="vote" value="voter"></td>
<td><input type="submit" name="comment" value="commenter"></td> -->
