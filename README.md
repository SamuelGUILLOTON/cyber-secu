# Les failles

## Injection XSS : 
  Du côté front-end (dans blog/templates/**), aucun HTML n'est échappé. Cela signifie que lorsqu'un utilisateur poste un commentaire, il peut inclure une balise <script> qui sera interprétée par le navigateur à chaque chargement de page. Cette vulnérabilité peut être exploitée pour récupérer des cookies et les envoyer à un tiers.

  pour corriger cette faille : il faut échapper la donnée dynamique avec htmlspecialchars, exemple : 
  ````php
  htmlspecialchars($post->content, ENT_QUOTES, 'UTF-8')
````
  
## Injection SQL : 
  Dans blog/model/comment.php, les méthodes createComment et updateComment n'utilisent pas de requêtes SQL préparées. Autrement dit, les données reçues du client sont directement intégrées à la requête SQL, créant ainsi une importante faille de sécurité SQL.

  pour corriger cette faille 
```php
public function createComment(string $post, string $author, string $comment): bool
{
    $statement = $this->connection->getConnection()->prepare(
        'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())'
    );
    $affectedLines = $statement->execute([$post, $author, $comment]);

    return ($affectedLines > 0);
}

public function updateComment(string $identifier, string $author, string $comment): bool
{
    $statement = $this->connection->getConnection()->prepare(
        'UPDATE comments SET author = ?, comment = ? WHERE id = ?'
    );
    $affectedLines = $statement->execute([$author, $comment, $identifier]);

    return ($affectedLines > 0);
}

