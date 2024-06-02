<?php
$email = $_GET['email'];
$currentPage = $_GET['currentPage'];

?>
<html>
<a id="mail" href="mailto:<?php echo $email; ?>?subject=&body="></a>
<script>
window.onload = function() {
  document.getElementById("mail").click();
  setTimeout(function() {
    window.location.href = "<?php echo $currentPage; ?>"
  }, 100);
};
</script>
</html>