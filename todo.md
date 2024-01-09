For the verb `aussehen`, definitions of `Aussehen` are returned. 

`$defnsInterface->matches['source']['pos'] == 'noun'`  

and 

`$defnsInterface->matches['source']['lemma'] == 'Aussehen'`

The way the code can tell that definitions for `Aussehen` were returned for the input word `aussehen` is

*  `ctype_upper(defnsInterface->matches['source']['lemma'][0]) && ctype_lower(($word[0])`
* `strcmp(defnsInterface->matches['source']['lemma'][0], $word) !== 0`
  
Should be recurse in this case and insert the noun or just ignore it?

What about when `gehen` returns definition for `ausgehen`, '`aufgehen`, etc?
