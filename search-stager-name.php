<?php
// include files
require_once("includes/check-authorize.php");
require_once("includes/functions.php");

$empire_stager = "";
if(isset($_GET['search_stager']))
{
    $search_stager = urldecode($_GET['search_stager']);
    $arr_result = search_stager_name($sess_ip, $sess_port, $sess_token, $search_stager);
    if(array_key_exists("error", $arr_result))
    {
        $empire_stager = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> ".ucfirst(htmlentities($arr_result["error"]))."</div>";
    }
    else
    {
        if(!empty($arr_result))
        {
            for($i=0; $i<sizeof($arr_result["stagers"]); $i++)
            {
                $empire_stager .= "<div class='panel-group'><div class='panel panel-success'>
                            <div class='panel-heading'>Stager Name: ".htmlentities($arr_result["stagers"][$i]["Name"])."</a></h4></div>
                                <div class='panel-body'>";
                $stager_name = htmlentities($arr_result["stagers"][$i]["Name"]);
                $stager_desc = htmlentities($arr_result["stagers"][$i]["Description"]);
                $stager_author = htmlentities(implode(",", $arr_result["stagers"][$i]["Author"]));
                $stager_comments = htmlentities(implode(",", $arr_result["stagers"][$i]["Comments"]));
                $empire_stager .= "<table class='table table-hover table-striped table-bordered'><tr><th>Name</th><td>$stager_name</td></tr><th>Description</th><td>$stager_desc</td></tr><th>Author</th><td>$stager_author</td></tr><th>Comments</th><td>$stager_comments</td></tr></table>";
                $empire_stager .= "<table class='table table-hover table-striped table-bordered'><thead><tr><th colspan='4'>Stager Options:</th></tr><th>Name</th><th>Description</th><th>Required</th><th>Value</th></tr></thead><tbody>";
                foreach($arr_result["stagers"][$i]["options"] as $key => $value)
                {
                    $key = htmlentities($key);
                    $desc = htmlentities($value["Description"]);
                    $reqd = (htmlentities($value["Required"]) ? "Yes" : "No");
                    $val = htmlentities($value["Value"]);
                    $empire_stager .= "<tr>";
                    $empire_stager .= "<td>$key</td><td>$desc</td><td>$reqd</td><td>$val</td>";
                    $empire_stager .= "</tr>";
                }
                $empire_stager .= '</tbody></table>';
                $empire_stager .= "</div></div></div><br>";
            }
        }
        else
        {
            $empire_stager = "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove'></span> Unexpected response.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>EmPyre: Search Stager</title>
	<?php @require_once("includes/head-section.php"); ?>
</head>
<body>
    <div class="container">
        <?php @require_once("includes/navbar.php"); ?>
        <br>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class='glyphicon glyphicon-search'></span> Search Stager by Name</div>
                <div class="panel-body">
                    <form role="form" method="get" action="search-stager-name.php" class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-starger" placeholder="Stager Name" name="search_stager">
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                    <br>
                    <?php echo $empire_stager; ?>
                </div>
            </div>
        </div>
        <br>
    </div>
    <?php @require_once("includes/footer.php"); ?>
</body>
</html>
