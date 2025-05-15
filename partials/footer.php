<?php
/* Persisit System Settings On Brand */
$ret = "SELECT * FROM `system_settings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
?>
    <footer class="main-footer">
        Copyright &copy; 2025 - <?php echo date('Y'); ?> <?php echo $sys->sys_name;?> by <a href="" target="_blank">Nguyễn Ngọc Tuyền</a>
        
        <div class="float-right d-none d-sm-inline-block">
            <b>EAUT</b> 2025
        </div>
    </footer>

<?php
} ?>