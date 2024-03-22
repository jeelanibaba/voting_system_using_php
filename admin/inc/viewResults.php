<?php 
    $election_id = $_GET['viewResult'];
?>

<div class="row my-3">
    <div class="col-12">
        <div style="text-align: center;">
            <div style="background-color: #f0f0f0; border: 1px solid #000; padding: 10px; width: auto; margin: 0 auto;">
                <h3 style="font-weight: bold; margin: 0;">Election Results</h3>
            </div>
        </div>

        <?php 
        $fetchingActiveElections = mysqli_query($db, "SELECT * FROM elections WHERE id = '". $election_id ."'") or die(mysqli_error($db));
        if ($totalActiveElections = mysqli_num_rows($fetchingActiveElections) > 0) {
            while ($data = mysqli_fetch_assoc($fetchingActiveElections)) {
                $election_id = $data['id'];
                $election_topic = $data['election_topic'];
                $status = $data['status'];

                if ($status === 'Expired') {
                    $fetchWinnerQuery = mysqli_query($db, "SELECT candidate_id, COUNT(voters_id) as vote_count FROM votings WHERE election_id = $election_id GROUP BY candidate_id ORDER BY vote_count DESC LIMIT 1") or die(mysqli_error($db));
                    $winnerData = mysqli_fetch_assoc($fetchWinnerQuery);
                    $winner_candidate_id = $winnerData['candidate_id'];
                
                    $fetchWinnerDetailsQuery = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = $winner_candidate_id") or die(mysqli_error($db));
                    $winnerDetails = mysqli_fetch_assoc($fetchWinnerDetailsQuery);
                    $winnerName = $winnerDetails['candidate_name'];                
                    echo "<h4 style='text-align: center;'>$winnerName has been elected as $election_topic </h4>";
                    echo "<h4 style='text-align: center;'>Congratulations $winnerName 🎉👏🥳</h4>";
                }
        ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="3" class="bg-green text-white"><h5 style="text-align: center;">ELECTION TOPIC: <?php echo strtoupper($election_topic); ?></h5></th>
                    </tr>
                    <tr>
                        <th>Photo</th>
                        <th>Candidate Details</th>
                        <th># of Votes</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id = '". $election_id ."'") or die(mysqli_error($db));
                    while ($candidateData = mysqli_fetch_assoc($fetchingCandidates)) {
                        $candidate_photo = $candidateData['candidate_photo'];
                        $fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '". $candidateData['id'] . "'") or die(mysqli_error($db));
                        $totalVotes = mysqli_num_rows($fetchingVotes);
                ?>
                        <tr>
                            <td><img src="<?php echo $candidate_photo; ?>" class="img-fluid" style="max-width: 100px; height: auto;"></td>
                            <td><?php echo "<b>" . $candidateData['candidate_name'] . "</b><br />" . $candidateData['candidate_details']; ?></td>
                            <td><?php echo $totalVotes; ?></td>
                        </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        <?php
            }
        } else {
            echo "<p style='text-align: center;'>No such active election.</p>";
        }
        ?>

        <hr>
        <h3 style="text-align: center;">Voting Details</h3>
         <?php 
                $fetchingVoteDetails = mysqli_query($db, "SELECT * FROM votings WHERE election_id = '". $election_id ."'");
                $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

                if($number_of_votes > 0)
                {
                    $sno = 1;
            ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Voter Name</th>
                        <th>Voted To</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>

            <?php
                    while($data = mysqli_fetch_assoc($fetchingVoteDetails))
                        {
                            $voters_id = $data['voters_id'];
                            $candidate_id = $data['candidate_id'];
                            $fetchingUsername = mysqli_query($db, "SELECT * FROM users WHERE id = '". $voters_id ."'") or die(mysqli_error($db));
                            $isDataAvailable = mysqli_num_rows($fetchingUsername);
                            $userData = mysqli_fetch_assoc($fetchingUsername);
                            if($isDataAvailable > 0)
                            {
                                $username = $userData['username'];
                            }else {
                                $username = "No_Data";

                            }


                            $fetchingCandidateName = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = '". $candidate_id ."'") or die(mysqli_error($db));
                            $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                            $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                            if($isDataAvailable > 0)
                            {
                                $candidate_name = $candidateData['candidate_name'];
                            }else {
                                $candidate_name = "No_Data";
                            }
                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $candidate_name; ?></td>
                                <td><?php echo $data['vote_date']; ?></td>
                                <td><?php echo $data['vote_time']; ?></td>
                            </tr>
                <?php
                        }
                        echo "</table>";
                    }else {
                        echo "No one voted yet!";
                    }







                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
