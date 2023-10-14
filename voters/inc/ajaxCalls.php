<?php 
    require_once("../../admin/inc/config.php");
    

    if (isset($_POST['e_id']) && isset($_POST['c_id']) && isset($_POST['v_id']) && isset($_POST['vote_date'])) {
        $election_id = mysqli_real_escape_string($db, $_POST['e_id']);
        $candidate_id = mysqli_real_escape_string($db, $_POST['c_id']);
        $voters_id = mysqli_real_escape_string($db, $_POST['v_id']);
        $vote_date = mysqli_real_escape_string($db, $_POST['vote_date']);
        $vote_time = mysqli_real_escape_string($db, $_POST['vote_time']);
    
        $insert_query = "INSERT INTO votings (election_id, candidate_id, voters_id, vote_date, vote_time) VALUES ('$election_id', '$candidate_id', '$voters_id', '$vote_date', '$vote_time')";
    
        if (mysqli_query($db, $insert_query)) {
            echo "Success";
        } else {
            echo "Failed to insert vote.";
        }
    } else {
        echo "Incomplete data.";
    }

?>