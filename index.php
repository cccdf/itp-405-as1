<?php
$pdo = new PDO('sqlite:chinook.db');
$sql = 'SELECT * FROM playlists';
$statement = $pdo->prepare($sql);
$statement->execute();
$playlists = $statement->fetchAll(PDO::FETCH_OBJ);

// var_dump($name);
?>

<h1>Playlists</h1>
<table>
    <tr>
        <th>Name</th>
    </tr>
    <?php foreach($playlists as $playlist) : ?>
    <tr>
        <td>
        <a href="tracks.php?playlist=<?php echo $playlist->Name ?>"><?php echo $playlist->Name?></a>
            
        </td>
    </tr>
    <?php endforeach?>
</table>


