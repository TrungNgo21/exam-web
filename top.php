<?php
function get_teams(){
    $fp = fopen("./data.csv",'r');
    $teams = [];
    $first = fgetcsv($fp);
    while($row = fgetcsv($fp)){
        $team1 = $row[2];
        $team2 = $row[4];
        $scores = explode('-', $row[3]);
        if(!array_key_exists($team1,$teams)){
            $teams[$team1] = ["scores" => 0, "points" => 0];
            
        }

        if(!array_key_exists($team2,$teams)){
            $teams[$team2] = ["scores" => 0, "points" => 0];
        }

        $teams[$team1]["scores"] += (int) $scores[0];
        $teams[$team2]["scores"] += (int) $scores[1];

        if((int) $scores[0] > (int) $scores[1]){
            $teams[$team1]["points"] += 3;
            
        }
        if((int) $scores[0] < (int) $scores[1]){
            $teams[$team2]["points"] += 3;
            
        }
        if((int) $scores[0] == (int) $scores[1]){
            $teams[$team1]["points"] += 1;
            $teams[$team2]["points"] += 1;
        }
        
    }
    fclose($fp);
    return $teams;

}

function points_different($team1, $team2){
    return (int) $team2["points"] - (int) $team1["points"];
}

function scores_different($team1, $team2){
    return (int) $team2["scores"] - (int) $team1["scores"];

}

$teams = get_teams();

if($_GET["page"] == "TopScorers"){
    $column = "Scores";
    $key = "scores";
    uasort($teams,"scores_different");
}

if($_GET["page"] == "Leaders"){
    $column = "Points";
    $key = "points";
    uasort($teams,"points_different");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Team</th>
                <th><?=$column?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $count = 0;
                foreach($teams as $team => $data){
                    echo "<tr>";
                    echo "<td>".$team."</td>";
                    echo "<td>".$data[$key]."</td>";
                    echo "</tr>";    
                    $count ++;
                    if($count == 10){
                        break;
                    }
                }
            ?>
        </tbody>
    </table>
</body>

</html>