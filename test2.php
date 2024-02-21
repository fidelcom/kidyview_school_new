<script>
var timestamp = 1621407041956
var date = new Date(timestamp);
console.log(date.getTime())
console.log(date)
</script>
<?php
date_default_timezone_set("America/New_York");
echo date('m/d/Y H:i:s', 1621407041956);
unlink('http://chawtechsolutions.ch/kidyview/test2.php');
?>