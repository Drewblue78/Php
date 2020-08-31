<ul class="card-list">
    <?php

    define("UPLOAD_DIR", "uploads/");

    require 'db.php';

    $query = <<<JOINEDUPLOADS
  SELECT 
    session_user.username,
    uploaded_newjoke.title,
    uploaded_newjoke.stored_name,
    uploaded_newjoke.uploaded_on
  FROM uploaded_image
  INNER JOIN session_user
    ON uploaded_newjoke.user_id=session_user.id
  ORDER BY uploaded_newjoke.uploaded_on DESC
  JOINEDUPLOADS;

    $stm = $con->prepare($query);

    $stm->execute();

    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
        $uploadPath = UPLOAD_DIR . $row['stored_name'];
        echo <<<EACHPOST
    <li>
      <img src="$uploadPath" />
      <h3>{$row['title']}</h3>
      <div>
        {$row['username']}
        <span>{$row['uploaded_on']}</span>
      </div>
    </li>
    EACHPOST;
    }

    ?>
</ul>