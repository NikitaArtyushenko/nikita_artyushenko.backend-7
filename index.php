<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  $errors = array();

  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limb_error']);
  $errors['abilities'] = !empty($_COOKIE['ab_error']);
  $errors['biography'] = !empty($_COOKIE['bio_error']);
  $errors['check'] = !empty($_COOKIE['check_error']);

  if ($errors['fio']) {
    setcookie('fio_error', '', 100000);
    $messages[] = '<div class="error">Заполните имя.</div>';
  }

  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните email.</div>';
  }

  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Заполните год.</div>';
  }

  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }

  if ($errors['limbs']) {
    setcookie('limb_error', '', 100000);
    $messages[] = '<div class="error">Выберите кол-во конечностей.</div>';
  }

  if ($errors['abilities']) {
    setcookie('ab_error', '', 100000);
    $messages[] = '<div class="error">Заполните абилки.</div>';
  }

  if ($errors['biography']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }

  if ($errors['check']) {
    setcookie('check_error', '', 100000);
    $messages[] = '<div class="error">Примите условия контракта.</div>';
  }

  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limbs'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['abilities'] = empty($_COOKIE['ab_value']) ? '' : $_COOKIE['ab_value'];
  $values['biography'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['check'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];

  include('form.php');
}

else {

  $errors = FALSE;

  if (empty($_POST['fio']) || preg_match("/^[А-ЯЁ][а-яё]*$/", $_POST['fio'])) {
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('fio_value', $_POST['fio'], time() + 365 * 24 * 60 * 60);
  }

  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 365 * 24 * 60 * 60);
  }

  if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('year_value', $_POST['year'], time() + 365 * 24 * 60 * 60);
  }

  if (empty($_POST['gender'])){
    if($_POST['gender'] != "Мужской" && $_POST['gender'] != "Женский"){
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
    }
  }
  else {
    setcookie('gender_value', $_POST['gender'], time() + 365 * 24 * 60 * 60);
  }

  if (empty($_POST['limbs']) || !is_numeric($_POST['limbs']) || $_POST['limbs'] < 0 || $_POST['limbs'] > 4) {
    setcookie('limb_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('limb_value', $_POST['limbs'], time() + 365 * 24 * 60 * 60);
  }

  $ids = array();
  foreach ($_POST['abilities'] as $ability){
    if ($ability != "1" && $ability != "2" && $ability != "3"){
      setcookie('ab_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{
      $ids[] = $ability;
    }
  }
  setcookie('ab_value', serialize($ids), time() + 365 * 24 * 60 * 60);

  if (strlen($_POST['biography'])==0) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['biography'], time() + 365 * 24 * 60 * 60);
  }

  if (!isset($_POST['check'])) {
    setcookie('check_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('check_value', $_POST['check'], time() + 365 * 24 * 60 * 60);
  }


  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limb_error', '', 100000);
    setcookie('ab_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('check_error', '', 100000);
  }

  $user = 'u52858'; 
  $pass = '6454527'; 
  $db = new PDO('mysql:host=localhost;dbname=u52858', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
  
  
  try {
    $stmt = $db->prepare("INSERT INTO req (name, year, email, gender, limbs, biography) VALUES (:name, :year, :email, :gender, :limbs, :biography)");
    $stmt->bindParam(':name', $_POST['fio']);
    $stmt->bindParam(':year', $_POST['year']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':limbs', $_POST['limbs']);
    $stmt->bindParam(':biography', $_POST['biography']);
    echo('запись1<br/>');
    $stmt->execute();
  
    $temp = $db->lastInsertId();
  
    foreach ($_POST['abilities'] as $ability){
      $stmt1 = $db->prepare("INSERT INTO conn (reqID, abId) VALUES (:reqID, :abId)");
      $stmt1->bindParam(':reqID', $temp);
      $stmt1->bindParam(':abId', $ability);
      
      $stmt1->execute();
      echo('запись2<br/>');
    }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }

  setcookie('save', '1');

  header('Location: index.php');
}