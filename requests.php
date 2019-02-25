<?php
include_once "header.php";

$rt = true;
if(!$lg && !$vp){
	$rt = false;
}
if($lg && $lg != $id){
	$rt = false;
}
if($vp && $vp != $id){
	$rt = false;
}
?>

<style>

th, td {
    padding: 10px;
    text-align: left;
}

#tree {
    background-color: white;
    background-size: cover;
    background-image: url(https://i.imgur.com/dEqI5GG.png);
    height: 100vh;
}

#make_request_table {
    margin-top: 24px;
}

#requests_table th, #requests_table td {
    border-bottom: 1px solid #ddd;
}

</style>

<div class="wrapper">
    <?php include_once "sidebar.php"; ?>

    <div id="tree">
        <div class="pt-box" style="width: 574px; border-radius: 3px; margin: 20px 0px 0px 50px; background: #fff0; box-shadow: 0 0px 10px rgba(0, 0, 0, 0.13);">
           

            <form class="pt-form" style="background-color: #ffffffba;">
 <h4>Tree Requests</h4><br>
                <?php

                $get_requests = "
                    SELECT r.idrequests, r.accepted, b.name, b.status
                      FROM mvt_requests r
                      JOIN mvt_accounts a ON r.from_id = a.id
                      JOIN mvt_bubbles b  ON a.id = b.account_id
                     WHERE r.to_id=$lg;";

                $requests = $db->query($get_requests);

                if ( $requests->num_rows > 0 ) {
                    echo '<table id="requests_table">';
                    echo '<tr><th>Name</th><th>Status</th><th></th><th></th></tr>';
                    while ( $req = $requests->fetch_assoc() ) {
                        $accept = ( $req['accepted'] )
                            ? '<em>Accepted</em>'
                            : '<button class="btn btn-primary request-action" data-action="accept" data-id="'.$req['idrequests'].'">Accept</button>';
                        $revoke = ( $req['accepted'] )
                            ? '<button class="btn btn-danger request-action" data-action="revoke" data-id="'.$req['idrequests'].'">Revoke</button>'
                            : '';
                        echo '<tr>';
                        echo "<td>{$req['name']}</td>";
                        echo "<td>{$req['status']}</td>";
                        echo "<td>$accept</td>";
                        echo "<td>$revoke</td>";
                        echo '</tr>';
                    }
                    echo '</table><br>';
                }
                else {
                    echo '<p>No requests to review. Invite friends to <a href="/">myvegantree.org</a>!</p><br>';
                }
                $requests->close();

                ?>

                <table id="make_request_table">
                    <tr><td>Make a Request</td><td></td></tr>
                    <tr>
                        <td><input type="text" id="user_id" placeholder="User ID" size="30"></td>
                        <td><button id="request_send_btn" class="btn btn-primary">Send Request</button></td>
                    </tr>
                </table>
                <hr />
            </form>
        </div>
    </div>
</div>


<!-- Latest compiled and minified JavaScript -->
<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>
