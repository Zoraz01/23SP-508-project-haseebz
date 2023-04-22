<?php
require_once ('connection.php');

global $conn;

function listGames()
{
    global $conn;
    
    $sqlQuery = "SELECT g.Game_id as 'ID',
                    g.Date_played as 'Date Played',
                    h.Club_name as 'Home Team',
                    h.Home_score as 'Home Score',
                    l.image as 'Home Image',
                    f.image as 'Away Image',
                    a.Club_name as 'Away Team',
                    a.Away_score as 'Away Score'
                    From Game g 
                    INNER JOIN Home_game h on (g.Game_id = h.Game_id)
                    INNER JOIN Away_game a on (g.Game_id = a.Game_id)
                    INNER JOIN Club l on (h.Club_name = l.Club_name)
                    INNER JOIN Club f on (a.Club_name = f.Club_name)";
                    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();
    
    $dataTable = array();
    
    while ($sqlRow = $stmt->fetch()) {
        $dataRow = array();
        
        $dataRow[] = $sqlRow['ID'];
        $dataRow[] = $sqlRow['Home Team'];
        $dataRow[] = $sqlRow['Home Score'];
        $dataRow[] = $sqlRow['Away Team'];
        $dataRow[] = $sqlRow['Away Score'];
        $dataRow[] = $sqlRow['Date Played'];
        $dataRow[] = $sqlRow['Home Image'];
        $dataRow[] = $sqlRow['Away Image'];
        
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "data" => $dataTable
    );
    
    echo json_encode($output);
}
if(!empty($_POST['action']) && $_POST['action'] == 'listGames') {
    listGames();
}
?>
