<?php
if (!isset($_GET['playlist'])) {
    header('Location: index.php');
    exit();
  }
$pdo = new PDO('sqlite:chinook.db');
$sql = 'SELECT playlists.Name as PlaylistName, tracks.Name as TrackName,albums.Title as Title, artists.Name as ArtistName, invoice_items.UnitPrice as Price,
media_types.Name as MediaName, genres.Name as GenreName
FROM playlists 
INNER JOIN playlist_track on playlists.PlaylistId = playlist_track.PlaylistId
INNER JOIN tracks on playlist_track.TrackId = tracks.TrackId
INNER JOIN albums on tracks.AlbumId = albums.AlbumId
INNER JOIN artists on albums.ArtistId = artists.ArtistId
INNER JOIN invoice_items on invoice_items.TrackId = tracks.TrackId
INNER JOIN media_types on media_types.MediaTypeId = tracks.MediaTypeId
INNER JOIN genres on genres.GenreId = tracks.GenreId
WHERE PlaylistName = ?
';

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $_GET['playlist']);
$statement->execute();
$trackInfos = $statement->fetchAll(PDO::FETCH_OBJ);
// var_dump($trackInfos);
// die;

?>

<table>
  <thead>
        <th>PlaylistName</th>
        <th>TrackName</th>
        <th>AlbumTitle</th>
        <th>ArtistName</th>
        <th>Price</th>
        <th>MediaName</th>
        <th>GenreName</th>
  </thead>
  <tbody>
    <?php foreach($trackInfos as $trackInfo) : ?>
      <tr>
        <td><?php echo $trackInfo->PlaylistName ?></td>
        <td><?php echo $trackInfo->TrackName ?></td>
        <td><?php echo $trackInfo->Title ?></td>
        <td><?php echo $trackInfo->ArtistName ?></td>
        <td><?php echo $trackInfo->Price ?></td>
        <td><?php echo $trackInfo->MediaName ?></td>
        <td><?php echo $trackInfo->GenreName ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?php if (count($trackInfos) === 0) : ?>
      <tr>
        <td colspan="4">
        No tracks found for <?php echo $_GET['playlist']?>
        </td>
      </tr>
    <?php endif ?>
