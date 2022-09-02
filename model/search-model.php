<?php 
/*
 * Search Model 
 */

    // Search
    function search($str, $ids){
        $db = phpmotorsConnect();
        $sql = 'SELECT invId, invYear, invMake, invModel, invDescription FROM inventory WHERE (invMake LIKE :str OR invModel LIKE :str OR invDescription LIKE :str OR invColor LIKE :str)';
        if (count($ids)){
            $sql .= 'AND invId NOT IN (';
            for ($i=0; $i <count($ids); $i++){
                $sql .= ':id'.$i;
                if ($i != count($ids)-1){
                    $sql .= ', ';
                }
            }
            $sql .= ')';
        }
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':str', $str, PDO::PARAM_STR);
        if (count($ids)){
            for ($i=0; $i <count($ids); $i++){
                $stmt->bindValue(':id'.$i, $ids[$i], PDO::PARAM_INT);
            }
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }

?>