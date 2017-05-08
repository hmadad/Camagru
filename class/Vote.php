<?php

class Vote
{
    private $pdo;
    private $former_vote;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    private function recordExist($ref, $ref_id) {
        $req = $this->pdo->prepare("SELECT * FROM $ref WHERE id = ?");
        $req->execute([$ref_id]);
        if ($req->rowCount() == 0)
            throw new Exception('Impossible de voter pour un enregistrement qui n\'existe pas');
    }

    public function like($ref, $ref_id, $user_id) {
        if ($this->vote($ref, $ref_id, $user_id, 1)) {
            $sql_part = "";
            if ($this->former_vote) {
                $sql_part = ", dislike_count = dislike_count - 1";
            }
            $this->pdo->query("UPDATE $ref SET like_count = like_count + 1 $sql_part WHERE id = $ref_id");
        }
    }

    public function dislike($ref, $ref_id, $user_id) {
        if ($this->vote($ref, $ref_id, $user_id, -1)) {
            $sql_part = "";
            if ($this->former_vote) {
                $sql_part = ", like_count = like_count - 1";
            }
            $this->pdo->query("UPDATE $ref SET dislike_count = dislike_count + 1 $sql_part WHERE id = $ref_id");
        }
    }

    private function vote($ref, $ref_id, $user_id, $vote) {
        $this->recordExist($ref, $ref_id);
        $req = $this->pdo->prepare("SELECT id, vote FROM votes WHERE ref = ? AND ref_id = ? AND user_id = ?");
        $req->execute([$ref, $ref_id, $user_id]);
        $vote_row = $req->fetch();
        if ($vote_row) {
            if ($vote_row->vote == $vote) {
                return false;
            }
            $this->former_vote = $vote_row;
            $this->pdo->prepare("UPDATE votes SET vote = ?, created_at = ? WHERE id = {$vote_row->id}")->execute([$vote, date('Y-m-d H:i:s')]);
            return true;
        }
        $req = $this->pdo->prepare("INSERT INTO votes SET ref = ?, ref_id = ?, user_id = ?, created_at = ?, vote = $vote");
        $req->execute([$ref, $ref_id, $user_id, date('Y-m-d H:i:s')]);
        return true;
    }

    public function updateCount($ref, $ref_id) {
        $req = $this->pdo->prepare("SELECT COUNT(id) as count FROM votes WHERE ref = ? AND ref_id = ? GROUP BY vote");
        $req->execute([$ref, $ref_id]);
        $votes = $req->fetchAll();
        $count = [
            '-1' => 0,
            '1' => 0
        ];
        $like = 0;
        $dislike = 0;
        foreach ($votes as $vote) {
            $count[$vote->vote] = $vote->count;
        }
        $req = $this->pdo->query("UPDATE $ref SET like_count = {$count[1]}, dislike_count = {$count[-1]} WHERE id = $ref_id");
        return true;
    }

}