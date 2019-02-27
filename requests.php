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
.wrapper {
  border : 0px dotted #ccc; padding: 0px;
}


#sidebar {  }
#tree { background-color: white;

    background-size: cover;
    background-image: url(https://i.imgur.com/dEqI5GG.png);
	    height: 100vh;
		}

@media screen and (min-width: 600px) {
   .wrapper {
      height: auto; overflow: hidden; // clearing
   }
   #sidebar { padding: 20px;width: 400px; float: left;height: 100vh; }
   #tree { margin-left: 400px; }
}


.input-color {
    position: relative;
}

.input-color input {
    padding-left: 20px;
    margin-bottom: 10px;
}

.input-color .color-box {
    width: 30px;
    height: 30px;
    background-color: #ccc;
    left: 5px;
    top: 5px;

}



.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  width: 100%;
  padding: 8px 14px;
  text-align: left;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}









</style>
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

#requests_table th, #requests_table td {
    border-bottom: 1px solid #ddd;
}

</style>

<div class="wrapper">
    <?php include_once "sidebar.php"; ?>

    <div id="tree">
      <div class="pt-box" style="    width: 574px;
    border-radius: 3px;
    margin: 20px 0px 0px 50px;    background: #fff0;box-shadow: 0 0px 0px rgba(0, 0, 0, 0.13);">


            <form class="pt-form" style="background-color: #ffffffba;">
 <h4>Tree Requests</h4><br>
                <?php

                $get_requests = "
                    SELECT r.idrequests, r.accepted, a.username
                      FROM ".prefix."requests r
                      JOIN ".prefix."accounts a ON r.from_id = a.id
                      JOIN ".prefix."bubbles b  ON a.id = b.account_id
                     WHERE r.to_id=$lg";

                $requests = $db->query($get_requests);

                if ( $requests->num_rows > 0 ) {
                    echo '<table id="requests_received_table">';
                    echo '<tr><th>User</th><th>Status</th><th></th><th></th></tr>';
                    while ( $req = $requests->fetch_assoc() ) {
                        $accept = ( $req['accepted'] )
                            ? '<em>Accepted</em>'
                            : '<button class="btn btn-primary request-action" data-action="accept" data-id="'.$req['idrequests'].'">Accept</button>';
                        $revoke = ( $req['accepted'] )
                            ? '<button class="btn btn-danger request-action" data-action="revoke" data-id="'.$req['idrequests'].'">Revoke</button>'
                            : '';
                        echo '<tr>';
                        echo "<td>{$req['username']}</td>";
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
                <?php
                $get_sent_requests = "
                    SELECT r.idrequests, r.accepted, a.username
                      FROM ".prefix."requests r
                      JOIN ".prefix."accounts a ON r.to_id = a.id
                     WHERE r.from_id=$lg";

                $requests_sent = $db->query($get_sent_requests);

                if ( $requests_sent->num_rows > 0 ) {
                    echo '<hr><h4>Sent Requests</h4><br>';
                    echo '<table id="requests_sent_table">';
                    echo '<tr><th>User</th><th>Status</th><th></th><th></th></tr>';
                    while ( $req = $requests_sent->fetch_assoc() ) {
                        $accept = ( $req['accepted'] ) ? '<em>Accepted</em>' : '<em>Not Yet Accepted</em>';
                        $cancel = '<button class="btn btn-warn request-action" data-action="cancel" data-id="'.$req['idrequests'].'">Cancel</button>';
                        echo '<tr>';
                        echo "<td>{$req['username']}</td>";
                        echo "<td>$accept</td>";
                        echo "<td>$cancel</td>";
                        echo '</tr>';
                    }
                    echo '</table><br>';
                }
                $requests_sent->close();
                ?>
                <span></span>
                <table id="make_request_table">
                    <tr><td>Make a Request</td><td></td></tr>
                    <tr>
                        <td><input type="text" id="request_username" placeholder="Username" size="30"></td>
                        <td><button id="request_send_btn" class="btn btn-primary">Send Request</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>


<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/custom.js"></script>
