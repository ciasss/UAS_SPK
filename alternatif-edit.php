<?php
require "include/conn.php";
$id = $_GET['id'];
$sql = 
"SELECT 
    e.id_alternative,
    a.name, 
    MAX(CASE WHEN e.id_criteria = 1 THEN e.value END) AS C1,
    MAX(CASE WHEN e.id_criteria = 2 THEN e.value END) AS C2,
    MAX(CASE WHEN e.id_criteria = 3 THEN e.value END) AS C3,
    MAX(CASE WHEN e.id_criteria = 4 THEN e.value END) AS C4,
    MAX(CASE WHEN e.id_criteria = 5 THEN e.value END) AS C5 
FROM 
    saw_evaluations e
JOIN 
    saw_alternatives a
USING (id_alternative)
WHERE 
    e.id_alternative = '$id'
GROUP BY 
    e.id_alternative, a.name";

$result = $db->query($sql);
$row = $result->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
    <?php require "layout/head.php";?>

    <body>
        <div id="app">
            <?php require "layout/sidebar.php";?>
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading">
                    <h3>Alternatif Edit</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Data</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <form action="alternatif-edit-act.php" method="POST">
                                    <div class="form-group">
                                        <label for="basicInput">Name</label>
                                        <input type="text" class="form-control" name="id_alternative" value="<?=$row['id_alternative'];?>" hidden>
                                        <input type="text" class="form-control" name="name" value="<?=$row['name'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="basicInput">C1</label>
                                        <input type="text" class="form-control" name="c1" value="<?=$row['C1'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="basicInput">C2</label>
                                        <input type="text" class="form-control" name="c2" value="<?=$row['C2'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="basicInput">C3</label>
                                        <input type="text" class="form-control" name="c3" value="<?=$row['C3'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="basicInput">C4</label>
                                        <input type="text" class="form-control" name="c4" value="<?=$row['C4'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="basicInput">C5</label>
                                        <input type="text" class="form-control" name="c5" value="<?=$row['C5'];?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-info btn-sm">
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>
                </div>
                <?php require "layout/footer.php";?>
            </div>
        </div>
        <?php require "layout/js.php";?>
    </body>

</html>